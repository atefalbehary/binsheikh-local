@extends('front_end.template.layout')
@section('header')

@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <!--header-end-->
            <!--warpper-->
            <div class="wrapper">
                <!--content-->
                <div class="content" style=" background: #faf6f2;">
                    <!--section-->
                       <div class="section hero-section inner-head" style=" background: #faf6f2;">
                        <div class="hero-section-wrap">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">

                                        <div class="hero-section-title_container">

                                            <div class="hero-section-title">
                                                <h2 >{{ __('messages.checkout') }}</h2>

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
                    <!--container-->
                    <div class="container">
                        <!--breadcrumbs-list-->
                        <!-- <div class="breadcrumbs-list bl_flat">
                            <a href="#">Home</a><span>About Us</span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div> -->
                        <!--breadcrumbs-list end-->
                    </div>
                    <!--container end-->
                    <!--main-content-->
                    <div class="main-content ms_vir_height">
                            <!--container-->
                                    <div class="container">
                                        <!--boxed-container-->
                                        <div class="boxed-container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card p-2">
                                                        <?php
                                                            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
                                                            $total = $property->price + $ser_amt;
                                                            $down_payment = ($settings->advance_perc / 100) * $total;
                                                            $down_payment_with_ser_amt = (($settings->advance_perc+$settings->service_charge_perc) / 100) * $property->price;
                                                            $down_payment_without_ser_amt = ($settings->advance_perc/100) * $property->price;
                                                            $pending_amt = $total - $down_payment;
                                                        ?>
                                                        <div class="table-responsive">
                                                            <table class="payment-table table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('messages.payment') }}</th>
                                                                        <th>{{ __('messages.month') }}</th>
                                                                        <th>{{ __('messages.amount') }}</th>
                                                                        <th>{{ __('messages.percentage') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="payment-row-highlight">
                                                                        <td>{{ __('messages.down_payment') }}</td>
                                                                        <td>{{ date('M-y') }}</td>
                                                                        <td>{{ moneyFormat($down_payment_without_ser_amt) }}</td>
                                                                        <td>{{ $settings->advance_perc }}%</td>
                                                                    </tr>
                                                                    <tr class="payment-row-highlight">
                                                                        <td>{{ __('messages.management_fees') }}</td>
                                                                        <td>{{ date('M-y') }}</td>
                                                                        <td>{{ moneyFormat($ser_amt) }}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                    @foreach($months as $key => $mnth)
                                                                    <tr>
                                                                        <td>{{ $mnth['ordinal'] }} {{ __('messages.installment') }}</td>
                                                                        <td>{{ $mnth['month'] }}</td>
                                                                        <td>{{ moneyFormat($mnth['payment']) }}</td>
                                                                        <td>{{ $mnth['total_percentage'] }}%</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 text-start">
                                                    <div class="listing-item mb-2">
                                                        <div class="geodir-category-listing border">
                                                            <div class="geodir-category-content border-0">
                                                                <h3 class="mb-1">
                                                                    <a href="{{ url('property-details/'.$property->slug) }}"> {{$property->name}}</a>
                                                                </h3>
                                                                <div class="user-dasboard-menu_header-avatar mt-2">
                                                                    <img style="width: 40px; height: 40px" src="{{ asset('') }}front-assets/images/avatar/profile-icon.png" alt="">
                                                                    <span style="margin-top: 9px;"> <strong>{{ \Auth::user()->name }}</strong></span>
                                                                    <!-- <div class="db-menu_modile_btn"><strong>{{ __('messages.menu') }}</strong><i class="fa-regular fa-bars"></i></div> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ url('book-now', $property->id) }}" method="get" data-parsley-validate="true">
                                                        <ul class="list-group mb-3">
                                                            <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.unit_number') }}</h6>
                                                                </div>
                                                                <span class="text-dark">{{ $property->apartment_no }}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.net_area') }}</h6>
                                                                </div>
                                                                <span class="text-dark">{{ $property->area }} m2</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.full_price') }}</h6>
                                                                </div>
                                                                <span class="text-dark">{{ moneyFormat($property->price) }}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.management_fees') }}</h6>
                                                                </div>
                                                                <span class="text-dark">{{ moneyFormat($ser_amt) }}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.total') }}</h6>
                                                                </div>
                                                                <span class="text-dark" style="font-weight: 600">{{ moneyFormat($total) }}</span>
                                                            </li>

                                                                <li class="list-group-item d-flex justify-content-between lh-condensed py-3">
                                                                <div>
                                                                    <h6 class="my-0">{{ __('messages.proceed_with_management_fee') }}</h6>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input checked class="form-check-input pwmf" type="radio" name="with_management_fee" id="inlineRadio1" value="1">
                                                                    <label class="form-check-label" for="inlineRadio1">{{ __('messages.yes') }}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input pwmf" type="radio" name="with_management_fee" id="inlineRadio2" value="0">
                                                                    <label class="form-check-label" for="inlineRadio2">{{ __('messages.no_') }}</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="card p-3 text-center d-block">

                                                            <h6 class="my-0">{{ __('messages.down_payment') }}</h6>
                                                            <span class="text-dark fs-4 dp_span d-block mb-3" style="font-weight: 600">{{ moneyFormat($down_payment_with_ser_amt) }}</span>
                                                            <div class="form-check form-check-inline me-0">
  <input class="form-check-input " type="checkbox" id="inlineCheckbox1" value="option1" data-parsley-errors-container="#agree_err" required data-parsley-required-message="{{ __('messages.please_accept_terms') }}">
  <label class="form-check-label" for="inlineCheckbox1">{{ __('messages.agree') }}</label>
</div>


<a href="{{ route('frontend.terms_conditions') }}" target="_blank" class="d-inline-block text-decoration-underline">{{ __('messages.terms_conditions') }}</a>
<br>
<span id="agree_err"></span>

{{-- Modal removed as T&C is now a separate page --}}

</div>
</form>
</div>
</div>
</div>
<!--boxed-container end-->
</div>
</div>

@stop

@section('script')
<script>
    $(document).ready(function() {
        // Initial state
        var submitBtn = $('button[name="submit"][value="book"]');
        var checkbox = $('#inlineCheckbox1');
        
        // Disable button initially if checkbox is not checked
        if (!checkbox.is(':checked')) {
            submitBtn.prop('disabled', true);
            submitBtn.css('opacity', '0.5');
            submitBtn.css('cursor', 'not-allowed');
        }

        // Toggle button on checkbox change
        checkbox.change(function() {
            if ($(this).is(':checked')) {
                submitBtn.prop('disabled', false);
                submitBtn.css('opacity', '1');
                submitBtn.css('cursor', 'pointer');
            } else {
                submitBtn.prop('disabled', true);
                submitBtn.css('opacity', '0.5');
                submitBtn.css('cursor', 'not-allowed');
            }
        });

        $(".pwmf").change(function(){
            if($(this).val()==1){
                $(".dp_span").text("{{moneyFormat($down_payment_with_ser_amt)}}");
            }else{
                $(".dp_span").text("{{moneyFormat($down_payment_without_ser_amt)}}");
            }
        });
    });
</script>
@stop
