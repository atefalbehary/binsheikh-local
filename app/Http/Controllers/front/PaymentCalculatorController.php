<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Models\Properties;
use App\Models\Settings;

class PaymentCalculatorController extends Controller
{
    const MANAGEMENT_FEE_RATE = 0.025;

    /**
     * Show the payment calculator page.
     * Pass a $property array/object to the view.
     */
    public function payment_calculator($slug)
    {
        $property = Properties::with(['property_type', 'images', 'amenities'])->where(['slug' => $slug, 'active' => '1', 'deleted' => 0])->first();
        if (!$property) {
            abort(404);
        }

        $page_heading = $property->name;
        $settings = Settings::find(1);

        $cur_month = Carbon::now();
        $cur_month->startOfMonth();
        if (isset($property->project->end_date) && $property->project->end_date) {
            $targetDate = Carbon::createFromFormat('Y-m', $property->project->end_date)->endOfMonth();
        }

        if (isset($property->project->end_date) && $property->project->end_date) {
            $monthCount = $cur_month->diffInMonths($targetDate);
        } else {
            $monthCount = $settings->month_count;
        }

        return view('front_end.payment_calculator', compact('page_heading', 'property', 'settings', 'monthCount'));
    }

    public function index()
    {
        // Example property — replace with your actual DB query
        $property = [
            'unit_number' => 'A-101',
            'gross_area' => '85.5 m²',
            'full_price' => 1500000,
            'available_installment_duration_months' => 71,
        ];

        return view('payment-calculator', compact('property'));
    }

    /**
     * Handle calculate requests (AJAX POST).
     * Dispatches to custom-input or scenario calculation.
     */
    public function calculate(Request $request): JsonResponse
    {
        $type = $request->input('type'); // 'custom' | 'scenario'

        return $type === 'custom'
            ? $this->handleCustom($request)
            : $this->handleScenario($request);
    }

    // ─────────────────────────────────────────────────────────────
    //  Custom Calculation  (Advance + Handover + Equal Monthly)
    // ─────────────────────────────────────────────────────────────

    private function handleCustom(Request $request): JsonResponse
    {
        $fullPrice = (float) $request->input('full_price');
        $advanceAmount = (float) $request->input('advance_amount', 0);
        $handoverPayment = (float) $request->input('handover_payment', 0);
        $installmentDur = $request->input('installment_duration'); // 'yyyy-MM'
        $handoverDate = $request->input('handover_date');         // 'yyyy-MM' or null

        $managementFees = $fullPrice * self::MANAGEMENT_FEE_RATE;
        $total = $fullPrice + $managementFees;

        // Validation
        $errors = [];
        if ($advanceAmount < 0)
            $errors['advance'] = 'Must be >= 0';
        if ($advanceAmount > $total)
            $errors['advance'] = 'Must be <= ' . $this->formatCurrency($total);
        if ($handoverPayment < 0)
            $errors['handover'] = 'Must be >= 0';
        if ($handoverPayment > $total)
            $errors['handover'] = 'Must be <= ' . $this->formatCurrency($total);
        if ($advanceAmount + $handoverPayment > $total)
            $errors['handover'] = 'Advance + Handover must be <= Total';
        if (!$installmentDur)
            $errors['duration'] = 'Select duration';
        if ($handoverPayment > 0 && !$handoverDate)
            $errors['handover_date'] = 'Select handover date';

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $startDate = Carbon::now()->addMonth()->startOfMonth();

        [$year, $month] = explode('-', $installmentDur);
        $installmentEndDate = Carbon::create((int) $year, (int) $month, 1);

        if ($handoverDate) {
            [$hYear, $hMonth] = explode('-', $handoverDate);
            $resolvedHandoverDate = Carbon::create((int) $hYear, (int) $hMonth, 1);
        } else {
            $resolvedHandoverDate = $installmentEndDate->copy();
        }

        $durationMonths = (int) round(
            ($installmentEndDate->timestamp - $startDate->timestamp) / (60 * 60 * 24 * 30.44)
        );

        $rows = $this->computeUserSchedule([
            'fullPrice' => $fullPrice,
            'managementFeeRate' => self::MANAGEMENT_FEE_RATE,
            'managementFees' => $managementFees,
            'advanceAmount' => $advanceAmount,
            'handoverPaymentAmount' => $handoverPayment,
            'totalDurationMonths' => max($durationMonths, 1),
            'startDate' => $startDate,
            'handoverDate' => $resolvedHandoverDate,
        ]);

        return response()->json(['schedule' => $rows, 'appliedDiscount' => 0]);
    }

    // ─────────────────────────────────────────────────────────────
    //  Scenario Calculation  (Scenarios 1-4 + Balloon)
    // ─────────────────────────────────────────────────────────────

    private function handleScenario(Request $request): JsonResponse
    {
        $fullPrice = (float) $request->input('full_price');
        $scenarioId = $request->input('scenario_id');
        $discountRate = (float) $request->input('discount_rate', 0) / 100;
        $availableDurationMonths = (int) $request->input('available_duration_months', 70);
        $balloonConfig = $request->input('balloon_config');

        $startDate = Carbon::now()->startOfMonth();

        $rows = $this->computeSchedule([
            'scenarioId' => $scenarioId,
            'fullPrice' => $fullPrice,
            'discountRate' => $discountRate,
            'managementFeeRate' => self::MANAGEMENT_FEE_RATE,
            'totalDurationMonths' => $availableDurationMonths,
            'startDate' => $startDate,
            'balloonConfig' => $balloonConfig,
        ]);

        return response()->json([
            'schedule' => $rows,
            'appliedDiscount' => (float) $request->input('discount_rate', 0),
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    //  Core Schedule Engine
    // ─────────────────────────────────────────────────────────────

    private function computeSchedule(array $p): array
    {
        $discountRate = $p['discountRate'] ?? 0;
        $managementFeeRate = $p['managementFeeRate'] ?? 0.025;
        $priceAfterDisc = $p['fullPrice'] - $p['fullPrice'] * $discountRate;

        $rows = match ((string) $p['scenarioId']) {
            '1' => $this->scenario1($p, $priceAfterDisc),
            '2' => $this->scenario2($p, $priceAfterDisc),
            '3' => $this->scenario3($p, $priceAfterDisc),
            '4' => $this->scenario4($p, $priceAfterDisc),
            'balloon' => $this->scenarioBalloon($p, $priceAfterDisc),
            default => [],
        };

        return $this->prependMgmtFeeRow($rows, $p['fullPrice'], $managementFeeRate, $p['startDate']);
    }

    /**
     * Scenario 1 — Equal installments, no down payment.
     */
    private function scenario1(array $p, float $price): array
    {
        $count = $p['totalDurationMonths'] ?: 71;
        $monthly = $price / $count;
        $lastAdj = $price - $monthly * ($count - 1);

        $entries = [];
        for ($i = 0; $i < $count; $i++) {
            $entries[] = [
                'label' => $this->ordinal($i + 1) . ' Installment',
                'month' => $this->formatMonth($p['startDate']->copy()->addMonths($i)),
                'payment' => $i === $count - 1 ? $lastAdj : $monthly,
            ];
        }

        return $this->buildRows($entries, $p['fullPrice']);
    }

    /**
     * Scenario 2 — 300k down payment, then 15k/month with 58k bumps at months 13,25,37,49,61.
     */
    private function scenario2(array $p, float $price): array
    {
        $bumpMonths = [13, 25, 37, 49, 61];
        $entries = [
            [
                'label' => 'Down Payment',
                'month' => $this->formatMonth($p['startDate']),
                'payment' => 300000,
                'isHighlight' => true,
            ]
        ];

        for ($i = 1; $i <= 70; $i++) {
            $label = $i === 8
                ? $this->ordinal($i) . ' Installment (Hand over)'
                : $this->ordinal($i) . ' Installment';
            $entries[] = [
                'label' => $label,
                'month' => $this->formatMonth($p['startDate']->copy()->addMonths($i)),
                'payment' => in_array($i, $bumpMonths) ? 58000 : 15000,
            ];
        }

        return $this->buildRows($entries, $p['fullPrice']);
    }

    /**
     * Scenario 3 — Fixed 250k down payment + equal installments.
     */
    private function scenario3(array $p, float $price): array
    {
        $downPayment = 250000;
        $count = $p['totalDurationMonths'] ?: 70;
        $monthly = ($price - $downPayment) / $count;
        $lastAdj = ($price - $downPayment) - $monthly * ($count - 1);

        $entries = [
            [
                'label' => 'Down Payment',
                'month' => $this->formatMonth($p['startDate']),
                'payment' => $downPayment,
                'isHighlight' => true,
            ]
        ];

        for ($i = 1; $i <= $count; $i++) {
            $entries[] = [
                'label' => $this->ordinal($i) . ' Installment',
                'month' => $this->formatMonth($p['startDate']->copy()->addMonths($i)),
                'payment' => $i === $count ? $lastAdj : $monthly,
            ];
        }

        return $this->buildRows($entries, $p['fullPrice']);
    }

    /**
     * Scenario 4 — 5% down + 5% handover at month 9 + equal installments.
     */
    private function scenario4(array $p, float $price): array
    {
        $down = $price * 0.05;
        $handover = $price * 0.05;
        $totalSlots = $p['totalDurationMonths'] ?: 70;
        $regularCount = $totalSlots - 1;
        $remaining = $price - $down - $handover;
        $monthly = $remaining / $regularCount;
        $lastAdj = $remaining - $monthly * ($regularCount - 1);

        $entries = [
            [
                'label' => '1st Installment',
                'month' => $this->formatMonth($p['startDate']),
                'payment' => $down,
                'isHighlight' => true,
            ]
        ];

        $installmentNum = 2;
        $regularIdx = 0;

        for ($i = 1; $i <= $totalSlots; $i++) {
            $date = $p['startDate']->copy()->addMonths($i);

            if ($i === 8) {
                $entries[] = [
                    'label' => $this->ordinal($installmentNum) . ' Installment',
                    'month' => $this->formatMonth($date),
                    'payment' => $handover,
                    'isHighlight' => true,
                ];
            } else {
                $regularIdx++;
                $isLast = $regularIdx === $regularCount;
                $entries[] = [
                    'label' => $this->ordinal($installmentNum) . ' Installment',
                    'month' => $this->formatMonth($date),
                    'payment' => $isLast ? $lastAdj : $monthly,
                ];
            }
            $installmentNum++;
        }

        return $this->buildRows($entries, $p['fullPrice']);
    }

    /**
     * Balloon scenario — Balloon payments + equal monthly installments.
     */
    private function scenarioBalloon(array $p, float $price): array
    {
        $cfg = $p['balloonConfig'] ?? [];
        $totalMonths = $p['totalDurationMonths'] ?: 60;
        $count = (int) ($cfg['count'] ?? 6);
        $timingMode = $cfg['timing_mode'] ?? 'frequency';
        $amountMode = $cfg['amount_mode'] ?? 'total_percent';

        // 1. Determine balloon month offsets (0-indexed from start)
        $balloonMonths = [];
        if ($timingMode === 'manual' && !empty($cfg['manual_months'])) {
            $raw = $cfg['manual_months'];
            if (is_string($raw)) {
                $raw = array_map('intval', array_map('trim', explode(',', $raw)));
            }
            $balloonMonths = array_slice((array) $raw, 0, $count);
        } else {
            $freq = (int) ($cfg['frequency_months'] ?? 6);
            for ($b = 0; $b < $count; $b++) {
                $balloonMonths[] = ($b + 1) * $freq;
            }
        }

        $balloonMonths = array_values(array_filter($balloonMonths, fn($m) => $m < $totalMonths));

        // 2. Balloon amount per payment
        $balloonAmount = match ($amountMode) {
            'total_percent' => $price * (((float) ($cfg['total_balloon_percent'] ?? 30)) / 100)
            / (count($balloonMonths) ?: 1),
            'each_percent' => $price * (((float) ($cfg['each_balloon_percent'] ?? 7.5)) / 100),
            default => (float) ($cfg['each_balloon_fixed'] ?? 50000),
        };

        $totalBalloon = $balloonAmount * count($balloonMonths);
        $balloonSet = array_flip($balloonMonths);

        // 3. Regular monthly payments for non-balloon months
        $regularMonths = array_values(
            array_filter(range(0, $totalMonths - 1), fn($m) => !isset($balloonSet[$m]))
        );
        $remaining = $price - $totalBalloon;
        $regularPayment = count($regularMonths) > 0 ? $remaining / count($regularMonths) : 0;

        // 4. Build entries in chronological order
        $entries = [];
        $regularCount = 0;

        for ($m = 0; $m < $totalMonths; $m++) {
            $date = $p['startDate']->copy()->addMonths($m);
            $isBalloon = isset($balloonSet[$m]);

            if ($isBalloon) {
                $balloonIdx = array_search($m, $balloonMonths);
                $payment = $balloonAmount;
                $label = 'Balloon ' . ($balloonIdx + 1);
            } else {
                $regularCount++;
                $isLast = $regularCount === count($regularMonths);
                $payment = $isLast
                    ? ($remaining - $regularPayment * (count($regularMonths) - 1))
                    : $regularPayment;
                $label = $this->ordinal($m + 1) . ' Installment';
            }

            $entries[] = [
                'label' => $label,
                'month' => $this->formatMonth($date),
                'payment' => $payment,
                'isHighlight' => $isBalloon,
            ];
        }

        // Rounding fix on last entry
        $currentTotal = array_sum(array_column($entries, 'payment'));
        $diff = $price - $currentTotal;
        if (abs($diff) > 0.001) {
            $entries[count($entries) - 1]['payment'] += $diff;
        }

        return $this->buildRows($entries, $p['fullPrice']);
    }

    /**
     * Generic user-driven schedule: advance + handover + equal monthly.
     */
    private function computeUserSchedule(array $params): array
    {
        $fullPrice = $params['fullPrice'];
        $managementFees = $params['managementFees'];
        $advanceAmount = $params['advanceAmount'];
        $handoverPaymentAmount = $params['handoverPaymentAmount'];
        $totalDurationMonths = $params['totalDurationMonths'];
        $startDate = $params['startDate'];
        $handoverDate = $params['handoverDate'];

        $remaining = $fullPrice - $advanceAmount - $handoverPaymentAmount;
        $monthlyCount = max($totalDurationMonths, 1);
        $monthlyPayment = $remaining / $monthlyCount;

        $handoverMonthOffset = (int) round(
            ($handoverDate->timestamp - $startDate->timestamp) / (60 * 60 * 24 * 30.44)
        );

        $entries = [];

        if ($advanceAmount > 0) {
            $entries[] = [
                'label' => 'Down Payment',
                'month' => $this->formatMonth($startDate),
                'payment' => $advanceAmount,
                'isHighlight' => true,
            ];
        }

        $handoverInserted = false;

        for ($i = 0; $i < $monthlyCount; $i++) {
            $offset = $advanceAmount > 0 ? $i + 1 : $i;
            $date = $startDate->copy()->addMonths($offset);

            if ($handoverPaymentAmount > 0 && !$handoverInserted && $offset >= $handoverMonthOffset) {
                $entries[] = [
                    'label' => 'Handover Payment',
                    'month' => $this->formatMonth($handoverDate),
                    'payment' => $handoverPaymentAmount,
                    'isHighlight' => true,
                ];
                $handoverInserted = true;
            }

            $entries[] = [
                'label' => $this->ordinal($i + 1) . ' Installment',
                'month' => $this->formatMonth($date),
                'payment' => $monthlyPayment,
            ];
        }

        if ($handoverPaymentAmount > 0 && !$handoverInserted) {
            $entries[] = [
                'label' => 'Handover Payment',
                'month' => $this->formatMonth($handoverDate),
                'payment' => $handoverPaymentAmount,
                'isHighlight' => true,
            ];
        }

        $cumulative = 0;
        $scheduleRows = array_map(function ($e) use ($fullPrice, &$cumulative) {
            $cumulative += $e['payment'];
            return [
                'label' => $e['label'],
                'month' => $e['month'],
                'payment' => $e['payment'],
                'percentage' => ($e['payment'] / $fullPrice) * 100,
                'totalPayment' => $cumulative,
                'totalPercentage' => ($cumulative / $fullPrice) * 100,
                'dueAmount' => $fullPrice - $cumulative,
                'isHighlight' => $e['isHighlight'] ?? false,
                'isMgmtFee' => false,
                'isDiscountRow' => false,
            ];
        }, $entries);

        // Prepend management fees row (display-only, not in cumulative)
        $mgmtRow = [
            'label' => 'Management Fees (2.5%)',
            'month' => $this->formatMonth($startDate),
            'payment' => $managementFees,
            'percentage' => ($managementFees / $fullPrice) * 100,
            'totalPayment' => 0,
            'totalPercentage' => 0,
            'dueAmount' => $fullPrice,
            'isHighlight' => false,
            'isMgmtFee' => true,
            'isDiscountRow' => false,
        ];

        return array_merge([$mgmtRow], $scheduleRows);
    }

    // ─────────────────────────────────────────────────────────────
    //  Helpers
    // ─────────────────────────────────────────────────────────────

    private function buildRows(array $entries, float $fullPrice): array
    {
        $cumulative = 0;
        return array_map(function ($e) use ($fullPrice, &$cumulative) {
            $cumulative += $e['payment'];
            return [
                'label' => $e['label'],
                'month' => $e['month'],
                'payment' => $e['payment'],
                'percentage' => ($e['payment'] / $fullPrice) * 100,
                'totalPayment' => $cumulative,
                'totalPercentage' => ($cumulative / $fullPrice) * 100,
                'dueAmount' => $fullPrice - $cumulative,
                'isHighlight' => $e['isHighlight'] ?? false,
                'isMgmtFee' => false,
                'isDiscountRow' => false,
            ];
        }, $entries);
    }

    private function prependMgmtFeeRow(array $rows, float $fullPrice, float $rate, Carbon $startDate): array
    {
        $fees = $fullPrice * $rate;
        $mgmtRow = [
            'label' => 'Management Fees (2.5%)',
            'month' => $this->formatMonth($startDate),
            'payment' => $fees,
            'percentage' => ($fees / $fullPrice) * 100,
            'totalPayment' => 0,
            'totalPercentage' => 0,
            'dueAmount' => $fullPrice,
            'isHighlight' => false,
            'isMgmtFee' => true,
            'isDiscountRow' => false,
        ];

        return array_merge([$mgmtRow], $rows);
    }

    private function formatMonth(Carbon $date): string
    {
        return $date->format('M-y'); // e.g. "Mar-25"
    }

    private function ordinal(int $n): string
    {
        if ($n >= 11 && $n <= 13) {
            return $n . 'th';
        }
        return match ($n % 10) {
            1 => $n . 'st',
            2 => $n . 'nd',
            3 => $n . 'rd',
            default => $n . 'th',
        };
    }

    private function formatCurrency(float $amount): string
    {
        $prefix = $amount < 0 ? '-' : '';
        $abs = abs($amount);
        return 'QAR ' . $prefix . number_format($abs, 0);
    }
}
