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
        <!--section-->
         <div class="section hero-section">
                        <div class="hero-section-wrap inner-head">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">
                                     
                                        <div class="hero-section-title_container">
                                           
                                            <div class="hero-section-title">
                                                <h2 >{{ __('messages.about_us') }}</h2>
                                               
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
                    <div class="">
                        <div class="about-wrap">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="about-title ab-hero ab-hero2">
                                        <h2 class="mb-3">{{ __('messages.about_us') }}</h2>
                                    </div>
                                    <p>
                                        {{ __('messages.company_description') }}
                                    </p>
                                    <p>
                                        {{ __('messages.about_us_details') }}
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="about-img ab_i2">
                                        <img src="{{ asset('') }}front-assets/images/about.jpg" class="respimg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-5">
                                    <div>
                                        <div class="help-item-title">{{ __('messages.our_vision') }}</div>
                                        <p>{{ __('messages.our_vision_description') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-5">
                                    <div>
                                        <div class="help-item-title">{{ __('messages.our_mission') }}</div>
                                        <p>{{ __('messages.our_mission_description') }}</p>
                                    </div> 
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div>
                                        <div class="help-item-title">{{ __('messages.why_choose_us') }}</div>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <div class="pricing-column">
                                                    <div class="pricing-header">
                                                        <h3>{{ __('messages.expertise') }}</h3>
                                                        <p>{{ __('messages.about_expertise_description') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="pricing-column">
                                                    <div class="pricing-header">
                                                        <h3>{{ __('messages.reliability') }}</h3>
                                                        <p>{{ __('messages.about_reliability_description') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="pricing-column">
                                                    <div class="pricing-header">
                                                        <h3>{{ __('messages.comprehensive_services') }}</h3>
                                                        <p>{{ __('messages.comprehensive_services_description') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="pricing-column">
                                                    <div class="pricing-header">
                                                        <h3>{{ __('messages.relationships') }}</h3>
                                                        <p>{{ __('messages.relationships_description') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div>
                                        <div class="help-item-title">{{ __('messages.bin_al_sheikh_brokerage') }}</div>
                                        <p>{{ __('messages.bin_al_sheikh_brokerage_description') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--boxed-container end-->	
                  <div class="to_top-btn-wrap">
                            <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                            <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                            <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
                        </div>
            </div>
            
        </div>
@stop

@section('script')

@stop
