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
                        <div class="main-content  ms_vir_heigh mt-5 pt-5">
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
                                                        
                                                        @if(\Auth::user()->role == 4)
                                                            <!-- Agency Role (role 4) - Show Employees -->
                                                            <li><a href="{{ url('my-employees') }}" class="act-scrlink">{{ __('messages.employees') }}</a></li>
                                                        @endif
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.favorite') }}</a></li>
                                                        <li><a href="{{ url('visit-schedule') }}">{{ __('messages.visit_schedule') }}</a></li>
                                                    </ul>
                                                    <a href="{{ url('user/logout') }}" class="hum_log-out_btn"><i class="fa-light fa-power-off"></i> {{ __('messages.log_out') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- user-dasboard-menu_wrap end-->
                                    <!-- pricing-column -->
                                    <div class="col-lg-9">
                                        <div class="db-container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="custom-form bg-white p-4 h-100">
                                                        <div class="dashboard-widget-title-single">{{ __('messages.employees') }}</div>
                                                        <div class="text-center py-5">
                                                            <i class="fa-light fa-users" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
                                                            <h4>{{ __('messages.no_employees_found') }}</h4>
                                                            <p>{{ __('messages.employees_coming_soon') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
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
                </div>
            </div>
@stop

@section('script')
<script>
$(document).ready(function() {
    // Add any JavaScript functionality here
});
</script>
@stop
