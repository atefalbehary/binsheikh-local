@extends('front_end.template.layout')
@section('header')
<style>
    /* Modal should fill the screen */
    .modal-dialog.x {
        margin: 0;
        max-width: 100vw;
        max-height: 100vh;
    }

    /* Body fills available space */
    .cus {
        height: calc(100vh - 60px); /* Adjust for modal header height */
        overflow: hidden;
    }

    /* Center and contain image */
    .floor-plan-img {
        max-width: 100%;
        max-height: 85%;
        object-fit: contain;
        display: block;
    }


    .pp-description {
        font-size: 16px !important;
        color: #333 !important;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }
</style>
@stop

@section('content')

<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <!--header-end-->
            <!--warpper-->
            <div class="wrapper" style="margin-top: 85px;">
                <div class="content">
                    <div class="container">
                        <!-- <div class="breadcrumbs-list bl_flat">
                            <a href="#">Home</a><span>Property details</span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div> -->
                    </div>
                    <!--single-carousle-container-->
                    <div class="fw-carousel-container ">
                        <div class="fw-carousel-wrap ">
                            <!-- fw-carousel  -->
                            <div class="fw-carousel     lightgallery">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <!-- swiper-slide-->
                                         @foreach($property->images as $image)
                                        <div class="swiper-slide hov_zoom">
                                            <img src="{{aws_asset_path($image->image)}}" alt="">
                                            <a href="{{aws_asset_path($image->image)}}" class="box-media-zoom   popup-image"><i class="fal fa-search"></i></a>

                                        </div>
                                        @endforeach
                                        <!-- swiper-slide-->

                                        <!-- swiper-slide end-->
                                    </div>
                                </div>
                            </div>
                            <!-- fw-carousel end -->
                        </div>
                        <!-- fw-carousel-wrap end -->
                        <div class="fw-carousel-button-prev slider-button"><i class="fa-solid fa-caret-left"></i></div>
                        <div class="fw-carousel-button-next slider-button"><i class="fa-solid fa-caret-right"></i></div>
                        <div class="fwc-controls_wrap">
                            <div class="solid-pagination_btns fwc-pagination"></div>
                        </div>
                    </div>
                    <!--single-carousle-container-->
                    <div class="container">
                        <div class="main-content">
                            <div class="boxed-container">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!--boxed-container-->
                                        <div class="scroll-content-wrap">
                                            <div class="share-holder init-fix-column">
                                                <!-- <span class="share-title">  Share   </span> -->
                                                <div class="share-container  isShare">
                                                    <a href="https://wa.me/+97430666004" target="_blank"   title="Share this page on whatsapp" class="pop share-icon fa fa-whatsapp"></a>
                                                    <a href="https://www.facebook.com/BINALSHEIKHQA" target="_blank" title="Share this page on facebook" class="pop share-icon fa share-icon-facebook"></a>
                                                    <a href="https://www.instagram.com/binalsheikhqa/x/" target="_blank" title="Share this page on instagram" class="pop share-icon fa fa-instagram"></a>
                                                    <a href="https://x.com/BinAlSheikhqa" target="_blank" title="Share this page on Twitter" class="pop share-icon fa fa-x-twitter"></a>
                                                    <!-- <a href="https://www.youtube.com/@binalsheikhtowers1457" target="_blank" title="Share this page on Yitube" class="pop share-icon fa fa-youtube"></a> -->
                                                </div>
                                            </div>
                                            <div class="list-single-opt_header hsc_flat_bci">
                                                <!-- <div class="hero-section_categories">
                                                    <a href="#">For Sale</a>
                                                    <a href="#">For Rent</a>
                                                    <a href="#">Houses</a>
                                                </div> -->

                                            </div>
                                            <!--boxed-content-->
                                            <div class="boxed-content">
                                                <!--boxed-content-item-->
                                                <div class="boxed-content-item">
                                                    <div class="hero-section-title_container hsc_flat">
                                                        <div class="hero-section-title text-start">
                                                            <h2>{{$property->name}}</h2>
                                                            <h4 class="d-inline-block"><i class="fa-solid fa-location-dot"></i> <span>{{$property->location}}</span></h4>
                                                            <h4 class="d-inline-block mx-3"><i class="fa-solid fa-apartment"></i> <span>{{ __('messages.unit_number') }}: {{$property->apartment_no}}</span></h4>

                                                            @if($property->floor_no)
                                                            <h4 class="d-inline-block mx-3"><i class="fa-solid fa-apartment"></i> <span>{{ __('messages.floor_number') }}: {{$property->floor_no}}</span></h4>
                                                            @endif

                                                            <div class="property-single-header-price"><strong>{{ __('messages.price') }}:</strong> <span class="pshp_item"><span></span>{{ moneyFormat($property->price) }}</span></div>
                                                        </div>
                                                        <div class="hero-section-opt">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--boxed-content-item end-->
                                            </div>
                                            <!--boxed-content end-->

                                            <!--ps-facts-wrapper-->
                                            <div class="ps-facts-wrapper">
                                                <!--ps-facts-item-->
                                                <div class="ps-facts-item">
                                                    <h4>{{ __('messages.bedroom') }}</h4>
                                                    <h5>{{$property->bedrooms}}</h5>
                                                    <i class="fa-light fa-bed"></i>
                                                </div>
                                                <!--ps-facts-item end-->
                                                <!--ps-facts-item-->
                                                <div class="ps-facts-item">
                                                    <h4>{{ __('messages.bathroom') }}</h4>
                                                    <h5>{{$property->bathrooms}}</h5>
                                                    <i class="fa-light fa-bath"></i>
                                                </div>
                                                <!--ps-facts-item end-->

                                                 <!--ps-facts-item-->
{{--                                                 <div class="ps-facts-item">--}}
{{--                                                    <h4>{{ __('messages.floor_number') }}</h4>--}}
{{--                                                    <h5>{{$property->floor_no ?? '-'}}</h5>--}}
{{--                                                    <i class="fa-light fa-building"></i>--}}
{{--                                                </div>--}}
                                                <!--ps-facts-item end-->
    <!--ps-facts-item-->
                                                <div class="ps-facts-item">
                                                    <h4>{{ __('messages.gross_area') }}</h4>
                                                    <h5>{{$property->gross_area}} m2</h5>
                                                    <i class="fa-light fa-chart-area"></i>
                                                </div>
                                                <!--ps-facts-item end-->

                                                           <!--ps-facts-item-->
                                                 <div class="ps-facts-item">
                                                    <h4>{{ __('messages.net_area') }}</h4>
                                                    <h5>{{$property->area}} m2</h5>
                                                    <i class="fa-light fa-chart-area"></i>
                                                </div>
                                                <!--ps-facts-item end-->



                                            </div>
                                            <div class="ps-facts-wrapper">

                                                           <!--ps-facts-item-->
                                                 @if($property->balcony_size)
                                                 <div class="ps-facts-item">
                                                    <h4>{{ __('messages.balcony_size') }}</h4>
                                                    <h5>{{$property->balcony_size ?? '-'}}</h5>
                                                    <i class="fa-light fa-house-window"></i>
                                                </div>
                                                @endif
                                                <!--ps-facts-item end-->




                                           </div>
                                            <!--ps-facts-wrapper end-->

                                            <div class="geodir-category-button  ">
                                                <div class="row g-3">
                                                    @if($property->unit_layout)
                                                        <div class="col ">
                                                            <!-- <a href="{{$property->unit_layout}}" target="_blank" rel="noopener noreferrer" class="post-card_book mt-0 d-block " style="width: 100%;"><span>{{ __('messages.unit_layout') }}</span></a> -->

                                                            <a href="#" class="post-card_book mt-0 d-block "  data-bs-toggle="modal" data-bs-target="#unit_layout_view" style="width: 100%;"><span>{{ __('messages.unit_layout') }}</span></a>
                                                        </div>
                                                    @endif
                                                    @if($property->link_360)
                                                    <div class="col ">
                                                        <a href="#" class="post-card_book mt-0 d-block "  data-bs-toggle="modal" data-bs-target="#three_d_view" style="width: 100%;"><span>{{ __('messages.three_d_view') }}</span></a>
                                                    </div>
                                                    @endif
                                                    @if($property->floor_plan)
                                                        <div class="col ">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#floorPlan" class="mt-0 d-block post-card_book " style="width: 100%;"><span>{{ __('messages.floor_plan') }}</span></a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="modal fade" id="floorPlan" tabindex="-1" aria-labelledby="floorPlanLabel" aria-hidden="true">
                                                <div class="modal-dialog x modal-fullscreen">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ __('messages.floor_plan') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body cus p-0">
                                                            <div class="d-flex justify-content-center align-items-center w-100 h-100">
                                                                <iframe src="{{$property->unit_layout}}" style="width:70%; height:100%; border:0;" title="Floor Plan"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="three_d_view" tabindex="-1" aria-labelledby="three_d_viewLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ __('messages.three_d_view') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="{{$property->link_360}}" height="500" width="100%" title="Iframe Example"></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="unit_layout_view" tabindex="-1" aria-labelledby="unit_layoutLabel" aria-hidden="true">
                                                <div class="modal-dialog x modal-fullscreen "> <!-- fullscreen modal -->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('messages.unit_layout') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body cus p-0">
                                                            <div class="d-flex justify-content-center align-items-center w-100 h-100">
                                                                <img src="{{ aws_asset_path($property->floor_plan) }}" class="floor-plan-img" alt="Unit Layout">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="boxed-content">
                                                <!--boxed-content-title-->
                                                <div class="boxed-content-title">
                                                    <h3>{{ __('messages.property_amenities') }}</h3>
                                                </div>
                                                <!--boxed-content-title end-->
                                                <!--boxed-content-item-->
                                                <div class="boxed-content-item">
                                                    <div class="pp-single-opt">
                                                        <div class="pp-single-features ">
                                                            <ul>
                                                                @foreach($property->amenities as $amty)
                                                                    <li><a href="#"><i class="{{$amty->amnety->icon}}"></i> {{$amty->amnety->name}}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Description block -->
                                                <div class="pp-description">
                                                    <p>{!! html_entity_decode(trim(strip_tags($property->description))) !!}</p>
                                                </div>
                                                <!--boxed-content-item end-->
                                            </div>


                                            <iframe width="100%" height="400" style="border-radius: 30px;" src="{{$property->video_link}}"></iframe>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <!--boxed-container-->
                                        <div class="sb-container">

                                          <div class="boxed-content">
                                        <!--boxed-content-title-->
                                        <div class="boxed-content-title">
                                        <h3>{{ __('messages.property_location') }}</h3>
                                        </div>
                                        <!--boxed-content-title end-->
                                        <!--boxed-content-item-->
                                        <div class="boxed-content-item">
                                            <div class="map-container mapC_vis2">
                                                <iframe src="{{$property->location_link}}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                        <!--boxed-content-item end-->
                                    </div>

                                            <!--boxed-content end-->
                                            <!--boxed-content-->
                                            <div class="fixed-form-wrap">
                                                <div class="fixed-form">
                                                    <div class="boxed-content">
                                                        <!--boxed-content-title-->

                                                        <!--boxed-content-title end-->
                                                        <!--boxed-content-item-->
                                                        <div class="boxed-content-item pt-0">
                                                            @if($property->sale_type==1)
                                                             <a href="#" class="btn-black commentssubmit_fw mt-2" data-bs-toggle="modal" data-bs-target="#paymentPlan">
                                                                {{ __('messages.request_payment_plan') }}
                                                            </a>
                                                                <a href="#" class="btn-black commentssubmit_fw mt-2" data-bs-toggle="modal" data-bs-target="#paymentCalculator">
                                                                {{ __('messages.payment_calculator') }}
                                                            </a>
                                                            @endif

                                                            <div class="row g-2 mt-1">
                                                                <div class="col-12 col-md-6">
                                                                    @if(Auth::check() && (Auth::user()->role != '1'))
                                                                        <a href="{{url('checkout', $property->id)}}" class="commentssubmit commentssubmit_fw" style="border-radius: 4px;">
                                                                            {{ __('messages.book_now') }}
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:;" class="commentssubmit commentssubmit_fw modal-open" style="border-radius: 4px;">
                                                                            {{ __('messages.book_now') }}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <a href="https://wa.me/+97430666004" class="whatsapp-btn commentssubmit_fw">
                                                                        {{ __('messages.whatsapp') }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--boxed-content-item end-->
                                                        <div class="modal fade" id="paymentPlan" tabindex="-1" aria-labelledby="paymentPlanLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ __('messages.payment_plan') }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php
                                                                        $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
                                                                        $total = $property->price + $ser_amt;
                                                                        $full_price_calc = $property->price;
                                                                        $down_payment = ($settings->advance_perc / 100) * $full_price_calc;
                                                                        $pending_amt = $full_price_calc - $down_payment;
                                                                        ?>

                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="d-flex justify-content-between mb-3">
                                                                                    <h5 class="card-title">{{ __('messages.payment_schedule') }}</h5>
                                                                                    <a href="{{ url('download-payment-plan/' . $property->id) }}" class="btn btn-primary" target="_blank">
                                                                                        <i class="fa fa-download"></i> {{ __('messages.download_pdf') }}
                                                                                    </a>
                                                                                </div>
                                                                                <div class="table-responsive">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>{{ __('messages.unit_number') }}</th>
                                                                                            <th>{{ __('messages.gross_area') }}</th>
                                                                                            <th>{{ __('messages.size_net') }}</th>
                                                                                            <th>{{ __('messages.full_price') }}</th>
                                                                                            <th>{{ __('messages.management_fees') }}</th>
                                                                                            <th>{{ __('messages.total') }}</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td>{{$property->apartment_no}}</td>
                                                                                            <td>{{$property->gross_area}} m2</td>
                                                                                            <td>{{$property->area}} m2</td>
                                                                                            <td>{{moneyFormat($property->price)}}</td>
                                                                                            <td>{{moneyFormat($ser_amt)}}</td>
                                                                                            <td>{{moneyFormat($total)}}</td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="card">
                                                                            <div class="card-body">
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
                                                                                            <td>{{ moneyFormat($down_payment) }}</td>
                                                                                            <td>{{$settings->advance_perc}}%</td>
                                                                                        </tr>
                                                                                        <tr class="payment-row-highlight">
                                                                                            <td>{{ __('messages.management_fees') }}</td>
                                                                                            <td>{{ date('M-y') }}</td>
                                                                                            <td>{{ moneyFormat($ser_amt) }}</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        @foreach($months as $key => $mnth)
                                                                                            <tr>
                                                                                                <td>{{$mnth['ordinal']}} {{ __('messages.installment') }}</td>
                                                                                                <td>{{$mnth['month']}}</td>
                                                                                                <td>{{ moneyFormat($mnth['payment']) }}</td>
                                                                                                <td>{{$mnth['total_percentage']}}%</td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                          <div class="modal fade" id="paymentCalculator" tabindex="-1" aria-labelledby="paymentCalculatorLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title fs-5 fw-bold" id="exampleModalLabel">{{ __('messages.payment_calculator') }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php
                                                                            $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
                                                                            $total = $property->price + $ser_amt;
                                                                            $full_price_calc = $property->price;
                                                                            $down_payment = ($settings->advance_perc / 100) * $full_price_calc;
                                                                            $pending_amt = $full_price_calc - $down_payment;
                                                                        ?>

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
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!--boxed-content end-->
                                        </div>
                                    </div>
                                </div>
                                <div class="limit-box"></div>
                            </div>
                            <?php if ($similar): ?>
                                <div class="boxed-container">
                                <div class="boxed-content-title ">
                                    <h3>{{ __('messages.similar_properties') }}</h3>
                                </div>
                                <div class="single-carousel-wrap">
                                    <div class="single-carousel">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <!-- swiper-slide -->
                                                @foreach($similar as $sim_property)
                                                <div class="swiper-slide">
                                                    <!-- listing-item -->
                                                    <div class="listing-item">
                                                        <div class="geodir-category-listing">
                                                            <div class="geodir-category-img">
                                                                <a href="{{url('property-details/'.$sim_property->slug)}}" class="geodir-category-img_item">
                                                                    <div class="bg" data-bg=" @if(isset($sim_property->images[0])) {{aws_asset_path($sim_property->images[0]->image)}} @endif "></div>
                                                                    <div class="overlay"></div>
                                                                </a>
                                                                <div class="geodir-category-location">
                                                                    <a href="javascript:;"><i class="fas fa-map-marker-alt"></i> {{$sim_property->location}}</a>
                                                                </div>
                                                                <ul class="list-single-opt_header_cat">
                                                                    <li><a href="#" class="cat-opt"><?= ($sim_property->sale_type == 1) ? __('messages.buy') : __('messages.rent') ?></a></li>
                                                                    <li><a href="#" class="cat-opt">{{$sim_property->property_type->name}}</a></li>
                                                                </ul>
                                                                <a href="javascript:;" class="geodir_save-btn tolt @if(Auth::check() && (Auth::user()->role != '1')) fav_prop @else modal-open @endif" data-id="{{$sim_property->id}}" data-microtip-position="left" data-tooltip="@if(!$sim_property->is_fav) {{ __('messages.add_to_favourites') }} @else {{ __('messages.remove_from_favourites') }} @endif"><spasn><i class="fal fa-heart heart_{{$sim_property->id}}"  @if(!$sim_property->is_fav) style="font-weight: 400" @endif></i></spasn></a>
                                                                <div class="geodir-category-listing_media-list">
                                                                    <span><i class="fas fa-camera"></i> {{count($sim_property->images)}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-content">
                                                                <h3><a href="#">{{$sim_property->name}}</a></h3>
                                                                <p class="txt-three-linesss">{!! html_entity_decode($sim_property->short_description) !!}</p>
                                                                <div class="geodir-category-content-details">
                                                                    <ul>
                                                                        <li><i class="fa-light fa-bed"></i><span>{{$sim_property->bedrooms}}</span></li>
                                                                        <li><i class="fa-light fa-bath"></i><span>{{$sim_property->bathrooms}}</span></li>
                                                                        <li><i class="fa-light fa-chart-area"></i><span>{{$sim_property->area.' m2'}}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-footer  ">
                                                                   <div class="row g-2">
                                                                <div class="col">
                                                                    <a href="{{url('property-details/'.$sim_property->slug)}}" class="post-card_link mt-0 d-block " style="width: 100%;"><span>{{ __('messages.view_details') }}</span> </a>
                                                                </div>
                                                                <div class="col">
                                                                    @if(Auth::check() && (Auth::user()->role != '1'))
                                                                        <a href="{{url('checkout',$property->id)}}" class="mt-0 d-block post-card_book" style="width: 100%">{{ __('messages.book_now') }}</a>
                                                                    @else
                                                                        <a href="javascript:;" class="mt-0 d-block post-card_book modal-open" style="width: 100%;">{{ __('messages.book_now') }}</a>
                                                                    @endif
                                                                </div>
                                                                   </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- listing-item end-->
                                                </div>
                                                @endforeach
                                                <!--swiper-slide end -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss-carousel-pagination_wrap">
                                    <div class="solid-pagination_btns ss-carousel-pagination_init"></div>
                                </div>
                                <div class="ss-carousel-button-wrap">
                                    <div class="ss-carousel-button ss-carousel-button-prev"><i class="fas fa-caret-left"></i></div>
                                    <div class="ss-carousel-button ss-carousel-button-next"><i class="fas fa-caret-right"></i></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!--main-content end-->
                         <div class="to_top-btn-wrap">
                            <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                            <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                            <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
                        </div>
                    </div>
                    <!-- container end-->
                <!-- </div> -->
                <!--content  end-->

@stop

@section('script')
<script>
    $(document).ready(function() {
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
