@extends('front_end.template.layout')
@section('header')

@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <!--header-end-->
            <!--warpper-->
            <div class="wrapper">
                <!--content-->
                <div class="content">
                    <!--container-->
                    <div class="container">

                        <!--breadcrumbs-list end-->
                        <!--main-content-->
                        <div class="main-content  ms_vir_height mt-5 pt-4">
                            <!--boxed-container-->
                            <div class="boxed-container" style="background: #f9f9f9;">
                                <div class="row">
                                    <!-- user-dasboard-menu_wrap -->
                                    <div class="col-lg-3">
                                        <div class="boxed-content btf_init">
                                            <div class="user-dasboard-menu_wrap">
                                                <div class="user-dasboard-menu-header">
                                                    <div class="user-dasboard-menu_header-avatar">
                                                        <img src="{{ asset('') }}front-assets/images/avatar/profile-icon.png" alt="">
                                                        <span> <strong>{{ \Auth::user()->name }}</strong></span>

                                                        <div class="db-menu_modile_btn"><strong>{{ __('messages.menu') }}</strong><i class="fa-regular fa-bars"></i></div>
                                                    </div>
                                                </div>
                                                <div class="user-dasboard-menu faq-nav">
                                                    <ul>
                                                        <li><a href="{{ url('my-profile') }}">{{ __('messages.profile') }}</a></li>
                                                        <li><a href="{{ url('my-bookings') }}" >{{ __('messages.my_bookings') }}</a></li>
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}" class="act-scrlink">{{ __('messages.favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                    </ul>
                                                    <a href="{{ url('user/logout') }}" class="hum_log-out_btn"><i class="fa-light fa-power-off"></i> {{ __('messages.log_out') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user-dasboard-menu_wrap end-->
                                    <!-- pricing-column -->
                                    <div class="col-lg-9">
                                        <div class="dashboard-title">
                                            <div class="dashboard-title-item"><span>{{ __('messages.favourite_properties') }}</span></div>
                                            <!-- Tariff Plan menu -->
                                            <!-- Tariff Plan menu end -->
                                        </div>
                                        <div class="db-container">
                                            <div class="row">
                                            @foreach($properties as $property)
                                                <div class="col-md-6">
                                                    <div class="listing-item">
                                                        <div class="geodir-category-listing">
                                                            <div class="geodir-category-img">
                                                                <a href="{{ url('property-details/'.$property->slug) }}" class="geodir-category-img_item">
                                                                    <div class="bg" data-bg="@if(isset($property->images[0])) {{aws_asset_path($property->images[0]->image) }} @endif"></div>
                                                                    <div class="overlay"></div>
                                                                </a>
                                                                <div class="geodir-category-location">
                                                                    <a href="javascript:;"><i class="fas fa-map-marker-alt"></i> {{ $property->location }}</a>
                                                                </div>
                                                                <ul class="list-single-opt_header_cat">
                                                                    <li>
                                                                        @if($property->sale_type == 1 || $property->sale_type == 3)
                                                                            <a href="#" class="cat-opt" style="margin-right:15px">{{ __('messages.buy') }}</a>
                                                                        @endif
                                                                        @if($property->sale_type == 2 || $property->sale_type == 3)
                                                                            <a href="#" class="cat-opt" style="margin-right:15px">{{ __('messages.rent') }}</a>
                                                                        @endif
                                                                    </li>
                                                                    <li><a href="#" class="cat-opt">{{ $property->property_type->name }}</a></li>
                                                                    @if($property->is_featured == 1)
                                                                        <li><a href="#" class="cat-opt" style="margin-top: 60px; box-shadow: 0px 0px 0px 4px rgba(255, 74, 82, 0.2); background: rgba(255, 74, 82, 0.8);">{{ __('messages.hot_property') }}</a></li>
                                                                    @endif
                                                                </ul>
                                                                <a href="javascript:;" class="geodir_save-btn tolt fav_prop" data-id="{{ $property->id }}" data-reload="1" data-microtip-position="left" data-tooltip="{{ __('messages.remove_from_favourite') }}"><span><i class="fal fa-heart heart_{{ $property->id }}"></i></span></a>
                                                                <div class="geodir-category-listing_media-list">
                                                                    <span><i class="fas fa-camera"></i> {{ count($property->images) }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-content">
                                                                <h3><a href="#">{{ $property->name }}</a></h3>
                                                                <p>{{ $property->short_description }}</p>
                                                                <div class="geodir-category-content-details">
                                                                    <ul>
                                                                        <li><i class="fa-light fa-bed"></i><span>{{ $property->bedrooms }}</span></li>
                                                                        <li><i class="fa-light fa-bath"></i><span>{{ $property->bathrooms }}</span></li>
                                                                        <li><i class="fa-light fa-chart-area"></i><span>{{ $property->area }} m2</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-footer d-flex">
                                                                <div class="col pe-1">
                                                                    <a href="{{ url('property-details/'.$property->slug) }}" class="post-card_link mt-0 d-block" style="width: 100%;"><span>{{ __('messages.view_details') }}</span></a>
                                                                </div>
                                                                <div class="col ps-1">
                                                                    <a href="{{ url('checkout', $property->id) }}" class="mt-0 d-block post-card_book" style="width: 100%">{{ __('messages.book_now') }}</a>
                                                                </div>
                                                            </div>
                                                            <a href="#" class="d-block text-danger my-3 fav_prop" data-id="{{ $property->id }}" data-reload="1">{{ __('messages.remove') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- pricing-column end-->
                                </div>
                                <div class="limit-box"></div>
                            </div>
                            <!--boxed-container end-->
                        </div>
                        <!--main-content end-->
                        <div class="to_top-btn-wrap">
                            <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                            <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                            <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
                        </div>
                    </div>
                    <!-- container end-->

@stop

@section('script')

@stop
