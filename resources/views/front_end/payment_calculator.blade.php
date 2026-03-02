@extends('front_end.template.layout')
@section('title', 'Payment Calculator')
@section('header')
    <link rel="stylesheet" href="{{ asset('front-assets/css/payment-calculator.css') }}">
@endsection
@section('content')
    <!-- wrapper -->
    <div class="wrapper" style="margin-top: 85px;">
        <!-- content -->
        <div class="content">
            <!--  section  -->
            <div class="section hero-section inner-head">
                <div class="hero-section-wrap">
                    <div class="hero-section-wrap-item">
                        <div class="container">
                            <div class="hero-section-container">
                                <div class="hero-section-title_container">
                                    <div class="hero-section-title">
                                        <h2>Payment Calculator: {{$property->name}}</h2>
                                        <h4>Calculate customized payment planes easily</h4>
                                    </div>
                                </div>
                                <div class="hs-scroll-down-wrap">
                                    <div class="scroll-down-item">
                                        <div class="mousey">
                                            <div class="scroller"></div>
                                        </div>
                                        <span>{{ __('messages.scroll_down_to_discover') }}</span>
                                    </div>
                                    <div class="svg-corner svg-corner_white" style="bottom:0;left:-40px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
                            @if(isset($property->images) && count($property->images) > 0)
                                <div class="bg par-elem" data-bg="{{aws_asset_path($property->images[0]->image)}}"
                                    data-scrollax="properties: { translateY: '30%' }"></div>
                            @else
                                <div class="bg par-elem" data-bg="{{asset('front-assets/images/bg/1.jpg')}}"
                                    data-scrollax="properties: { translateY: '30%' }"></div>
                            @endif
                        </div>
                        <div class="svg-corner svg-corner_white" style="bottom:64px;right: 0;z-index: 100"></div>
                    </div>
                </div>
            </div>
            <!--  section  end-->

            <!-- main-content -->
            {{--
            Payment Calculator — main-content section
            ──────────────────────────────────────────
            Paste everything between <!-- main-content --> and <!-- main-content end -->.

            Uses:
            • Bootstrap 5 (already in your project)
            • jQuery (already in your project)
            • front-assets/js/payment-calculator.js (already loaded in @section('script'))

            Variables expected from the controller:
            $property – Eloquent model (->price, ->name, ->reference_no, ->size, etc.)
            $settings – settings model (->service_charge_perc, e.g. 2.5 for 2.5%)
            $monthCount – integer, available installment duration in months
            --}}

            @php
                $mgmtFeeRate = $settings->service_charge_perc / 100;
                $mgmtFees = $property->price * $mgmtFeeRate;
                $totalPrice = $property->price + $mgmtFees;

                /*
                 * Month option list
                 * value = integer offset from next month  ← what your JS expects
                 * label = formatted month name shown in the dropdown
                 */
                $start = now()->addMonth()->startOfMonth();
                $monthOpts = [];
                for ($i = 1; $i <= $monthCount; $i++) {
                    $d = $start->copy()->addMonths($i);
                    $monthOpts[] = ['value' => $i, 'label' => $d->format('M-y')];
                }
            @endphp



            <div class="container py-4 pc-wrap">

                {{-- ── 1. Property Info Header ───────────────────────────────── --}}
                <div class="pc-info-grid pc-section mb-3">
                    <div class="pc-info-cell">
                        <p class="pc-info-key mb-1">Unit Number</p>
                        <p class="pc-info-val mb-0">{{ $property->reference_no ?? ($property->name ?? '—') }}</p>
                    </div>
                    <div class="pc-info-cell">
                        <p class="pc-info-key mb-1">Gross Area</p>
                        <p class="pc-info-val mb-0">{{ isset($property->size) ? $property->size . ' m²' : '—' }}</p>
                    </div>
                    <div class="pc-info-cell">
                        <p class="pc-info-key mb-1">Full Price</p>
                        <p class="pc-info-val mb-0">QAR {{ number_format($property->price, 0) }}</p>
                    </div>
                    <div class="pc-info-cell">
                        <p class="pc-info-key mb-1">Management Fees</p>
                        <p class="pc-info-val mb-0">QAR {{ number_format($mgmtFees, 0) }}</p>
                    </div>
                    <div class="pc-info-cell">
                        <p class="pc-info-key mb-1">Total</p>
                        <p class="pc-info-val mb-0">QAR {{ number_format($totalPrice, 0) }}</p>
                    </div>
                </div>

                {{-- ── 2. Duration Badge ─────────────────────────────────────── --}}
                <div class="pc-badge mb-3">
                    <span class="pc-badge-label">Available Installment Duration: </span>
                    <span class="pc-badge-val">{{ $monthCount }} Months</span>
                </div>

                {{-- ── 3. Scenario Selector ──────────────────────────────────── --}}
                <div class="d-flex flex-wrap align-items-end gap-3 pc-section mb-3">

                    <div>
                        <label class="pc-label-muted" for="scenarioSelector">
                            Payment Plan Scenario
                        </label>
                        <select id="scenarioSelector" class="form-select pc-select" style="width:220px;">
                            <option value="1">1 — Equal Installments</option>
                            <option value="2">2 — Custom Schedule</option>
                            <option value="3">3 — Down + Equal</option>
                            <option value="4">4 — 5% Down + Handover</option>
                            <option value="balloon">5 — Balloon + Monthly</option>
                        </select>
                    </div>

                    <div>
                        <label class="pc-label-muted" for="discountSelector">
                            Discount %
                        </label>
                        <select id="discountSelector" class="form-select pc-select" style="width:110px;">
                            @for ($i = 0; $i <= 30; $i++)
                                <option value="{{ $i }}">{{ $i }}%</option>
                            @endfor
                        </select>
                    </div>

                    <button id="btnCalculateScenario" class="btn pc-btn-gold">
                        Calculate Scenario
                    </button>
                </div>

                {{-- ── 4. Balloon Configurator (shown by JS when scenario 5 selected) ── --}}
                <div id="balloonConfigurator" class="pc-section mb-3" style="display:none;">

                    <p class="pc-balloon-title">Balloon Settings</p>

                    <div class="row g-3">

                        {{-- Count --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="pc-label-muted" for="balloonCount">
                                Number of Balloon Payments
                            </label>
                            <select id="balloonCount" class="form-select pc-select w-100">
                                @for ($i = 2; $i <= 12; $i++)
                                    <option value="{{ $i }}" @selected($i === 6)>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Timing mode --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="pc-label-muted" for="balloonTiming">
                                Balloon Timing
                            </label>
                            <select id="balloonTiming" class="form-select pc-select w-100">
                                <option value="frequency">Every N months</option>
                                <option value="manual">Manual months</option>
                            </select>
                        </div>

                        {{-- Frequency (visible by default) --}}
                        <div class="col-12 col-sm-6 col-md-4" id="divBalloonFrequency">
                            <label class="pc-label-muted" for="balloonFrequency">
                                Frequency (months)
                            </label>
                            <select id="balloonFrequency" class="form-select pc-select w-100">
                                <option value="3">Every 3 months</option>
                                <option value="6" selected>Every 6 months</option>
                                <option value="9">Every 9 months</option>
                                <option value="12">Every 12 months</option>
                            </select>
                        </div>

                        {{-- Manual offsets (hidden by default) --}}
                        <div class="col-12 col-sm-6 col-md-4" id="divBalloonManual" style="display:none;">
                            <label class="pc-label-muted" for="balloonManual">
                                Month offsets <span class="text-muted">(comma-separated)</span>
                            </label>
                            <input type="text" id="balloonManual" class="form-control pc-input w-100"
                                placeholder="e.g. 6,12,24,36" />
                        </div>

                        {{-- Amount mode --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="pc-label-muted" for="balloonAmountMode">
                                Balloon Amount
                            </label>
                            <select id="balloonAmountMode" class="form-select pc-select w-100">
                                <option value="total_percent">Total balloon % (split equally)</option>
                                <option value="each_percent">Each balloon %</option>
                                <option value="each_fixed">Each balloon fixed amount</option>
                            </select>
                        </div>

                        {{-- Total % (visible by default) --}}
                        <div class="col-12 col-sm-6 col-md-4" id="divBalloonTotalPct">
                            <label class="pc-label-muted" for="balloonTotalPct">
                                Total Balloon % of Price
                            </label>
                            <select id="balloonTotalPct" class="form-select pc-select w-100">
                                @foreach ([10, 15, 20, 25, 30, 35, 40, 45, 50] as $pct)
                                    <option value="{{ $pct }}" @selected($pct === 30)>{{ $pct }}%</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Each % (hidden) --}}
                        <div class="col-12 col-sm-6 col-md-4" id="divBalloonEachPct" style="display:none;">
                            <label class="pc-label-muted" for="balloonEachPct">
                                Each Balloon % of Price
                            </label>
                            <input type="number" id="balloonEachPct" class="form-control pc-input w-100" value="7.5"
                                placeholder="7.5" step="0.1" />
                        </div>

                        {{-- Each fixed (hidden) --}}
                        <div class="col-12 col-sm-6 col-md-4" id="divBalloonEachFixed" style="display:none;">
                            <label class="pc-label-muted" for="balloonEachFixed">
                                Each Balloon Amount (QAR)
                            </label>
                            <input type="number" id="balloonEachFixed" class="form-control pc-input w-100" value="50000"
                                placeholder="50000" />
                        </div>

                    </div>
                </div>

                <hr class="pc-divider">

                {{-- ── 5. Custom EMI Inputs — Row 1: Advance + Duration ─────── --}}
                <div class="d-flex flex-wrap align-items-end gap-3 pc-section-light mb-3">

                    <div class="flex-fill" style="min-width:160px;">
                        <label class="pc-label-gold" for="AdvAmount">Advance Amount</label>
                        <input type="number" id="AdvAmount" class="form-control pc-input-gold w-100" placeholder="0"
                            min="0" />
                    </div>

                    <div class="flex-fill" style="min-width:160px;">
                        <label class="pc-label-gold" for="userDuration">Installment End Date</label>
                        <select id="userDuration" class="form-select pc-input-gold w-100">
                            <option value="">Select month</option>
                            @foreach ($monthOpts as $opt)
                                <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button id="btnCalculateUser" class="btn pc-btn-outline-gold">
                        Calculate EMI
                    </button>

                    <button class="btn pc-btn-gold">Book NOW</button>
                </div>

                {{-- ── 6. Custom EMI Inputs — Row 2: Handover ──────────────── --}}
                <div class="d-flex flex-wrap align-items-end gap-3 pc-section-light mb-3">

                    <div class="flex-fill" style="min-width:160px;">
                        <label class="pc-label-gold" for="HandAmount">Handover Payment</label>
                        <input type="number" id="HandAmount" class="form-control pc-input-gold w-100" placeholder="0"
                            min="0" />
                    </div>

                    <div class="flex-fill" style="min-width:160px;">
                        <label class="pc-label-gold" for="userHandoverDate">Handover Date</label>
                        <select id="userHandoverDate" class="form-select pc-input-gold w-100">
                            <option value="">Select month</option>
                            @foreach ($monthOpts as $opt)
                                <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ── 7. Payment Schedule Table (populated by displaySchedule() in payment-calculator.js) ── --}}
                <div id="scheduleTableContainer" style="display:none; margin-top:1.5rem;">

                    <div class="pc-schedule-header">
                        <div class="pc-schedule-title-group">
                            <span class="pc-accent-bar"></span>
                            <span class="pc-schedule-title">Payment Schedule</span>
                            <span id="discountTitleLabel" class="pc-discount-badge" style="display:none;"></span>
                        </div>
                        <button id="downloadCalculationPdfNew"
                            class="btn pc-btn-outline-gold d-flex align-items-center gap-2">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF
                        </button>
                    </div>

                    <div class="pc-table-wrap">
                        <table class="table table-bordered mb-0 pc-table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th class="text-center">Percentage</th>
                                    <th class="text-center">Payment</th>
                                    <th class="text-center">Total Payment</th>
                                    <th class="text-center">Due Amount</th>
                                    <th class="text-center">Total %</th>
                                </tr>
                            </thead>
                            <tbody id="calculate_em_tbody_new">
                                {{-- Rows are injected by displaySchedule() in payment-calculator.js --}}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>{{-- /container --}}

            <!-- main-content end -->

@endsection

        @section('script')
            <!-- PDF Generator Libraries -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script
                src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
            <script src="{{ asset('front-assets/js/generatePaymentPDF.js') }}"></script>

            <script src="{{ asset('front-assets/js/payment-calculator.js') }}"></script>
            <script>
                $(document).ready(function () {
                    var fullPrice = {{ $property->price }};
                    var managementFeeRate = {{ $settings->service_charge_perc / 100 }};
                    var durationMonths = {{ $monthCount }};

                    function displaySchedule(scheduleRows) {
                        var tbody = $('#calculate_em_tbody_new');
                        tbody.empty();

                        if (!scheduleRows || scheduleRows.length === 0) {
                            $('#scheduleTableContainer').hide();
                            return;
                        }

                        $('#scheduleTableContainer').show();

                        $.each(scheduleRows, function (i, row) {
                            var isMgmt = row.isMgmtFee;
                            var isDiscount = row.isDiscountRow;
                            var isHighlight = row.isHighlight;

                            var trClass = "";

                            if (isMgmt) { trClass = "pc-row-mgmt"; }
                            else if (isDiscount) { trClass = "pc-row-discount"; }
                            else if (isHighlight) { trClass = "pc-row-highlight"; }
                            else if (i % 2 === 0) { trClass = "pc-row-even"; }
                            else { trClass = "pc-row-odd"; }

                            var labelCol = (isMgmt || isHighlight || isDiscount) ? row.label : row.month;
                            var paymentStr = isDiscount ? "- " + formatCurrency(row.payment) : formatCurrency(row.payment);
                            var totalPaymentStr = isMgmt ? "-" : formatCurrency(row.totalPayment);
                            var dueAmountStr = isMgmt ? "-" : formatCurrency(row.dueAmount);
                            var totalPercentageStr = (isMgmt || isDiscount) ? "-" : formatPercent(row.totalPercentage);

                            var tr = `<tr class="${trClass}">
                                                                                                        <td class="fw-medium">${labelCol}</td>
                                                                                                        <td class="text-center">${formatPercent(row.percentage)}</td>
                                                                                                        <td class="text-center fw-bold">${paymentStr}</td>
                                                                                                        <td class="text-center">${totalPaymentStr}</td>
                                                                                                        <td class="text-center">${dueAmountStr}</td>
                                                                                                        <td class="text-center">${totalPercentageStr}</td>
                                                                                                      </tr>`;
                            tbody.append(tr);
                        });
                    }

                    // Scenario Calculation logic
                    $('#scenarioSelector').change(function () {
                        var val = $(this).val();
                        if (val === 'balloon') {
                            $('#balloonConfigurator').slideDown();
                        } else {
                            $('#balloonConfigurator').slideUp();
                        }
                    });

                    $('#balloonTiming').change(function () {
                        if ($(this).val() === 'frequency') {
                            $('#divBalloonFrequency').show();
                            $('#divBalloonManual').hide();
                        } else {
                            $('#divBalloonFrequency').hide();
                            $('#divBalloonManual').show();
                        }
                    });

                    $('#balloonAmountMode').change(function () {
                        var mode = $(this).val();
                        $('#divBalloonTotalPct, #divBalloonEachPct, #divBalloonEachFixed').hide();
                        if (mode === 'total_percent') $('#divBalloonTotalPct').show();
                        else if (mode === 'each_percent') $('#divBalloonEachPct').show();
                        else if (mode === 'each_fixed') $('#divBalloonEachFixed').show();
                    });

                    $('#btnCalculateScenario').click(function () {
                        var scenarioId = $('#scenarioSelector').val();
                        var discountRate = parseInt($('#discountSelector').val(), 10) || 0;

                        var startDate = addMonths(new Date(), 1);
                        startDate.setDate(1);

                        var balloonCfg = null;
                        if (scenarioId === 'balloon') {
                            var manualMonthsStr = $('#balloonManual').val();
                            var manualMonths = [];
                            if (manualMonthsStr) {
                                manualMonths = manualMonthsStr.split(',').map(function (s) { return parseInt(s.trim(), 10); }).filter(function (n) { return !isNaN(n); });
                            }

                            balloonCfg = {
                                count: parseInt($('#balloonCount').val(), 10) || 6,
                                timingMode: $('#balloonTiming').val() || "frequency",
                                frequencyMonths: parseInt($('#balloonFrequency').val(), 10) || 6,
                                manualMonths: manualMonths,
                                amountMode: $('#balloonAmountMode').val() || "total_percent",
                                totalBalloonPercent: parseInt($('#balloonTotalPct').val(), 10) || 30,
                                eachBalloonPercent: parseFloat($('#balloonEachPct').val()) || 7.5,
                                eachBalloonFixed: parseInt($('#balloonEachFixed').val(), 10) || 50000
                            };
                        }

                        var rows = computeSchedule({
                            scenarioId: scenarioId,
                            fullPrice: fullPrice,
                            discountRate: discountRate / 100,
                            managementFeeRate: managementFeeRate,
                            totalDurationMonths: durationMonths,
                            startDate: startDate,
                            balloonConfig: balloonCfg
                        });

                        if (discountRate > 0) {
                            var discountAmount = fullPrice * (discountRate / 100);
                            var discountRow = {
                                label: "{{ __('messages.discount') }} (" + discountRate + "%)",
                                month: "-",
                                payment: discountAmount,
                                percentage: discountRate,
                                totalPayment: discountAmount,
                                totalPercentage: discountRate,
                                dueAmount: fullPrice - discountAmount,
                                isDiscountRow: true
                            };
                            var insertAt = rows[0] && rows[0].isMgmtFee ? 1 : 0;
                            rows.splice(insertAt, 0, discountRow);

                            $('#discountTitleLabel').text("— " + discountRate + "% {{ __('messages.discount') }}").show();
                        } else {
                            $('#discountTitleLabel').hide();
                        }

                        window.calculatedScheduleData = rows;
                        displaySchedule(rows);
                    });

                    // User calculation logic
                    $('#btnCalculateUser').click(function () {
                        var adv = parseFloat($('#AdvAmount').val()) || 0;
                        var hand = parseFloat($('#HandAmount').val()) || 0;
                        var durationVal = $('#userDuration').val(); // Just single integer
                        var handoverDateVal = $('#userHandoverDate').val(); // Just single integer

                        var managementFees = fullPrice * managementFeeRate;
                        var totalAmount = fullPrice + managementFees;

                        // Basic Validation match
                        var errors = [];
                        if (adv < 0) errors.push("Advance must be greater than or equal to 0.");
                        if (adv > totalAmount) errors.push("Advance cannot be greater than Total.");
                        if (hand < 0) errors.push("Handover must be greater than or equal to 0.");
                        if (hand > totalAmount) errors.push("Handover cannot be greater than Total.");
                        if (adv + hand > totalAmount) errors.push("Advance + Handover cannot exceed the Total price.");
                        if (!durationVal) errors.push("Please select an Installment Duration.");
                        if (hand > 0 && !handoverDateVal) errors.push("Please select a Handover Date when Handover amount is > 0.");

                        if (errors.length > 0) {
                            alert(errors.join("\n"));
                            return;
                        }

                        var calcDurationMonths = parseInt(durationVal, 10);
                        var startDate = addMonths(new Date(), 1);
                        startDate.setDate(1);

                        var installmentEndDate = addMonths(startDate, calcDurationMonths);

                        var resolvedHandoverDate = installmentEndDate;
                        if (handoverDateVal) {
                            resolvedHandoverDate = addMonths(startDate, parseInt(handoverDateVal, 10));
                        }

                        var rows = computeUserSchedule({
                            fullPrice: fullPrice,
                            managementFeeRate: managementFeeRate,
                            managementFees: managementFees,
                            advanceAmount: adv,
                            handoverPaymentAmount: hand,
                            totalDurationMonths: Math.max(calcDurationMonths, 1),
                            startDate: startDate,
                            handoverDate: resolvedHandoverDate
                        });

                        $('#discountTitleLabel').hide();
                        window.calculatedScheduleData = rows;
                        displaySchedule(rows);
                    });

                    // Handle download calculator PDF button click
                    $('#downloadCalculationPdfNew').click(function () {
                        if (!window.calculatedScheduleData) {
                            show_msg(0, "{{ __('messages.please_fill_in_all_required_fields_and_calculate_emi_first') }}");
                            return;
                        }

                        var btn = $(this);
                        var originalBtnHtml = btn.html();
                        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...');
                        btn.prop('disabled', true);

                        var propData = {
                            unitNumber: "{{ $property->reference_no ?? ($property->name ?? '—') }}",
                            grossArea: "{{ isset($property->size) ? $property->size . ' m²' : '—' }}",
                            fullPrice: {{ $property->price ?? 0 }},
                            managementFees: {{ $mgmtFees ?? 0 }},
                            total: {{ $totalPrice ?? 0 }},
                            handoverAmount: parseFloat($('#HandAmount').val()) || 0,
                            installmentCount: {{ $monthCount ?? 0 }},
                            project: "{{ $property->project->name ?? 'Bin Al Sheikh Marina Tower' }}"
                        };

                        var logoUrl = "{{ asset('front-assets/images/logo.png') }}";
                        var bgUrl = "{{ asset('front-assets/images/bg/1.jpg') }}";

                        if (window.generatePDFFromData) {
                            // setTimeout to allow UI to update the button spinner
                            setTimeout(function () {
                                window.generatePDFFromData(propData, window.calculatedScheduleData, logoUrl, bgUrl);
                                btn.html(originalBtnHtml);
                                btn.prop('disabled', false);
                            }, 50);
                        } else {
                            alert("PDF generation logic not loaded yet.");
                            btn.html(originalBtnHtml);
                            btn.prop('disabled', false);
                        }
                    });
                });
            </script>
        @endsection