@extends('front_end.template.layout')
@section('header')
<style>
    .main-footer {
        z-index: 1 !important;
    }
</style>
@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
<!--header-end-->
<!--warpper-->
<div class="wrapper">
    <!--content-->
    <div class="content">
        <!--section-->
        <div class="section hero-section inner-head">
            <div class="hero-section-wrap">
                <div class="hero-section-wrap-item">
                    <div class="container">
                        <div class="hero-section-container">
                            
                            <div class="hero-section-title_container">
                                <div class="hero-section-title">
                                    <h2>{{ __('messages.payment_calculator') }} - {{$property->name}}</h2>
                                </div>
                            </div>
                            <div class="hs-scroll-down-wrap">
                                <div class="scroll-down-item">
                                    <div class="mousey">
                                        <div class="scroller"></div>
                                    </div>
                                    <span>{{ __('messages.scroll_down_to_discover') }}</span>
                                </div>
                                <div class="svg-corner svg-corner_white"  style="bottom:0;left:-40px;"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
                        <div class="bg" data-bg="{{ asset('') }}front-assets/images/bg/12.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
                    </div>
                    <div class="svg-corner svg-corner_white"  style="bottom:64px;right: 0;z-index: 100"></div>
                </div>
            </div>
        </div>
        
        <!--section-end-->				
        <!--main-content-->
        <div class="main-content" style="padding-top: 50px;">
            <!--container-->
            <div class="container">
                <div class="boxed-container">
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.unit_number') }}</th>
                                            <th>{{ __('messages.gross_area') }}</th>
                                            <!-- <th>{{ __('messages.size_net') }}</th> -->
                                            <th>{{ __('messages.full_price') }}</th>
                                            <th>{{ __('messages.management_fees') }}</th>
                                            <th>{{ __('messages.total') }}</th>
                                            <th>{{ __('messages.available_rental_duration') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$property->apartment_no}}</td>
                                            <td>{{$property->gross_area}} m2</td>
                                            <!-- <td>{{$property->area}} m2</td> -->
                                            <td>{{moneyFormat($property->price)}}</td>
                                            <td>{{moneyFormat($ser_amt)}}</td>
                                            <td>{{moneyFormat($total)}}</td>
                                            <td>{{$monthCount}} {{ __('messages.months') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card text-start">
                        <div class="card-body">
                            <form id="emiCalculatorForm" data-parsley-validate="true" action="{{ url('calculate_emi') }}" >
                                @csrf()
                                <input type="hidden" name="property_id" value="{{$property->id}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="loanAmount" class="form-label">{{ __('messages.advance_amount') }}</label>
                                        <input type="text" data-parsley-type="integer" class="form-control" id="AdvanceAmount" required max="{{$total}}" data-parsley-type-message="{{ __('messages.this_value_should_be_a_valid_integer') }}" data-parsley-required-message="" name="advance_amount" data-parsley-greater-than-zero="true">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="handoveramount" class="form-label">{{ __('messages.handover_amount') }}</label>
                                        <input type="text" data-parsley-type="integer" class="form-control" id="HandOverAmount" required max="{{$total}}" data-parsley-type-message="{{ __('messages.this_value_should_be_a_valid_integer') }}" data-parsley-required-message="" name="hand_over_amount" data-parsley-greater-than-zero="true">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="interestRate" class="form-label">{{ __('messages.rental_duration') }}</label>
                                        <select data-parsley-type="integer" class="form-control " id="" required max="{{$monthCount}}" data-parsley-max-message="{{ __('messages.month_count_limit', ['monthCount' => $monthCount]) }}" data-parsley-type-message="{{ __('messages.this_value_should_be_a_valid_integer') }}" data-parsley-required-message="" name="rental_duration" data-parsley-greater-than-zero="true">
                                            <option value="">{{ __('messages.rental_duration') }}</option>
                                            @foreach ($months as $key => $val)
                                                <option value="{{$val['val']}}">{{$val['month']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-warning w-100" style="border-radius: 4px; margin-top: 30px">{{ __('messages.calculate_emi') }}</button>
                                    </div>
                                    <div class="col-md-2">
                                        @if(Auth::check() && (Auth::user()->role != '1'))
                                            <a href="#" class="btn btn-warning w-100" style="border-radius: 4px; margin-top: 30px" id="bookNowBtn" onclick="redirectToSpecificCheckout(event)">
                                                {{ __('messages.book_now') }}
                                            </a>
                                        @else
                                            <a href="javascript:;" class="btn btn-warning w-100 modal-open" style="border-radius: 4px; margin-top: 30px">
                                                {{ __('messages.book_now') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive ">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title">{{ __('messages.payment_schedule') }}</h5>
                                    <a href="javascript:void(0)" id="downloadCalculationPdf" class="btn btn-primary">
                                        <i class="fa fa-download"></i> {{ __('messages.download_pdf') }}
                                    </a>
                                </div>
                                <table class="payment-table table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.month') }}</th>
                                            <th>{{ __('messages.percentage') }}</th>
                                            <th>{{ __('messages.payment') }}</th>
                                            <th>{{ __('messages.total_payment') }}</th>
                                            <th>{{ __('messages.total_percentage') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="calculate_em_tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="limit-box"></div>
            </div>
            
             <div class="to_top-btn-wrap">
                <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
            </div>
            
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(document).ready(function() {
        // Ensure content sits above the fixed footer by adding padding to wrapper
        var footerHeight = $('.main-footer').outerHeight(true);
        if (footerHeight) {
            $('.wrapper').css('padding-bottom', footerHeight + 'px');
        }

        // Handle download calculator PDF button click
        $('#downloadCalculationPdf').click(function() {
            var property_id = $('input[name="property_id"]').val();
            var advance_amount = $('#AdvanceAmount').val();
            var hand_over_amount = $('#HandOverAmount').val();
            var rental_duration = $('select[name="rental_duration"]').val();

            if (!advance_amount || !hand_over_amount || !rental_duration) {
                show_msg(0, "{{ __('messages.please_fill_in_all_required_fields_and_calculate_emi_first') }}");
                return;
            }
            // Create a form and submit it
            var form = $('<form>', {
                'method': 'post',
                'action': '{{ url("download-calculator-result") }}',
                'target': '_blank'
            });

            form.append($('<input>', {
                'name': '_token',
                'value': '{{ csrf_token() }}',
                'type': 'hidden'
            }));

            form.append($('<input>', {
                'name': 'property_id',
                'value': property_id,
                'type': 'hidden'
            }));

            form.append($('<input>', {
                'name': 'advance_amount',
                'value': advance_amount,
                'type': 'hidden'
            }));
            form.append($('<input>', {
                'name': 'hand_over_amount',
                'value': hand_over_amount,
                'type': 'hidden'
            }));
            form.append($('<input>', {
                'name': 'rental_duration',
                'value': rental_duration,
                'type': 'hidden'
            }));

            $('body').append(form);
            form.submit();
            form.remove();
        });
    });
</script>
@stop
