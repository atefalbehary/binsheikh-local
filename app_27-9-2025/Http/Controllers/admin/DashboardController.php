<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Properties;
use App\Models\Settings;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $page_heading = "Dashboard";
        $users = 0;
        $bookings = Booking::where(['type' => 'Down Payment'])->count();
        $properties = Properties::where(['deleted' => 0])->count();
        $rent = Properties::where(['deleted' => 0])->whereIn('sale_type', [2, 3])->count();
        $sale = Properties::where(['deleted' => 0])->whereIn('sale_type', [1, 3])->count();
        $available = Properties::where(['active' => 1])->count() - $bookings;
        $available_rent = Properties::where(['active' => 1])->whereIn('sale_type', [2, 3])->count() - $bookings;
        $available_sale = Properties::where(['active' => 1])->whereIn('sale_type', [1, 3])->count() - $bookings;
        $sold = Properties::where(['deleted' => 0, 'is_sold' => 1])->count();

        $salesData = Booking::selectRaw('
                MONTH(created_at) as month,
                SUM(amount) as total_price
            ')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month', 'asc')
            ->get();

        $monthlyData = [
            'months' => [],
            'buyData' => array_fill(0, 12, 0),
            'rentData' => array_fill(0, 12, 0),
        ];
        $allMonths = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
        ];

        foreach ($salesData as $data) {
            $monthIndex = $data->month - 1;
            $monthlyData['buyData'][$monthIndex] = $data->total_price;
        }
        $monthlyData['months'] = $allMonths;
        $months = $monthlyData['months'];
        $data = $monthlyData['buyData'];

        return view('admin.dashboard', compact('page_heading', 'bookings', 'properties', 'rent', 'sale','available','available_rent','available_sale', 'sold', 'months', 'data'));
    }

    public function getSalesData()
    {
        $salesData = Booking::selectRaw('
                MONTH(created_at) as month,
                type,
                SUM(price) as total_price
            ')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupByRaw('MONTH(created_at), type')
            ->get();
        $monthlyData = [
            'months' => [],
            'buyData' => array_fill(0, 12, 0),
            'rentData' => array_fill(0, 12, 0),
        ];

        foreach ($salesData as $data) {
            if (!in_array($data->month, $monthlyData['months'])) {
                $monthlyData['months'][] = Carbon::create()->month($data->month)->format('M');
            }
            $monthlyData['buyData'][$data->month - 1] = $data->total_price;
            if ($data->type == 'buy') {
                $monthlyData['buyData'][$data->month - 1] = $data->total_price;
            } else {
                $monthlyData['rentData'][$data->month - 1] = $data->total_price;
            }
        }

        // Pass data to the view
        return view('property.chart', [
            'months' => $monthlyData['months'],
            'buyData' => $monthlyData['buyData'],
            'rentData' => $monthlyData['rentData'],
        ]);

    }
    public function bookings()
    {
        $page_heading = "Bookings";
        $search_text  = $_GET['search_text'] ?? '';
        $bookings = Properties::with('project')->select('properties.*','bookings.created_at as booking_date','bookings.user_id','users.name as cust_name','users.email as cust_email','users.phone as cust_phone')->where(['type'=>'Down Payment'])->rightjoin('bookings', 'bookings.property_id', 'properties.id')->join('users','users.id','bookings.user_id')->orderBy('bookings.created_at', 'desc');
        if ($search_text) {
            $bookings = $bookings->whereRaw("(properties.name like '%$search_text%' OR users.name like '%$search_text%')");
        }
        $bookings = $bookings->paginate(10);


        $settings = Settings::find(1);
        $cur_month = Carbon::now();
        $cur_month->startOfMonth();

        foreach($bookings as $key=>$val){
            $paid_mount = Booking::where(['bookings.user_id' => $val->user_id,'property_id'=>$val->id])->sum('amount');
            $ser_amt = ($settings->service_charge_perc / 100) * $val->price;
            $total = $val->price + $ser_amt;
            $down_payment = ($settings->advance_perc / 100) * $total;
            $pending_amt = $total - $down_payment;

            if(isset($val->project->end_date) && $val->project->end_date){
                $targetDate = Carbon::createFromFormat('Y-m', $val->project->end_date)->endOfMonth();;
                $monthsDifference = $cur_month->diffInMonths($targetDate);
            }else{
                $monthsDifference = $settings->month_count;
            }


            $payableEmiAmount = $pending_amt;
            $monthCount = $monthsDifference;//$settings->month_count;
            $monthlyPayment = $payableEmiAmount / $monthCount;
            $percentageRate = (100 - $settings->advance_perc) / $monthCount;

            $months = [];
            $totalPercentage = $settings->advance_perc;
            $remainingAmount = $payableEmiAmount;

            for ($i = 0; $i < $monthCount; $i++) {
                $remainingAmount -= $monthlyPayment;
                $totalPercentage += $percentageRate;
                $months[$i]['month'] = $cur_month->addMonth()->format('M-y');
                $months[$i]['ordinal'] = $this->getOrdinalSuffix($i + 1);
                $months[$i]['payment'] = round($monthlyPayment, 2);
                $months[$i]['remaining_amount'] = round($remainingAmount, 2);
                $months[$i]['total_percentage'] = round($totalPercentage, 2);
            }
            $bookings[$key]['months'] = $months;
            $bookings[$key]['paid_mount'] = $paid_mount;

        }
        return view('admin.bookings.list', compact('page_heading','bookings','settings','search_text'));
    }
    public function getOrdinalSuffix($number)
    {
        if (in_array($number % 100, [11, 12, 13])) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:return $number . 'st';
            case 2:return $number . 'nd';
            case 3:return $number . 'rd';
            default:return $number . 'th';
        }
    }
}
