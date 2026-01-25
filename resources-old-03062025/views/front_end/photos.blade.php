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
                     <div class="section hero-section ">
                        <div class="hero-section-wrap inner-head">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">
                                     
                                        <div class="hero-section-title_container">
                                           
                                            <div class="hero-section-title">
                                                <h2 style="text-transform: uppercase;">{{ __('messages.photos') }} </h2>
                                               
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
                            <a href="#">Home</a><span>NEWS & MEDIA</span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div> -->
                        <!--breadcrumbs-list end-->					
                    </div>
                    <!--container end-->	
                    <!--main-content-->
                    <div class="main-content  ms_vir_height">
                        <!--boxed-container-->
                        <div class="container">
                            <div class="row">
                                <!-- user-dasboard-menu_wrap -->  
                                <div class="col-lg-3">
                                    <div class="boxed-content btf_init">
                                        <div class="user-dasboard-menu_wrap">
                                            <div class="user-dasboard-menu faq-nav">
                                                <ul>
                                                    <li><a href="{{url('photos')}}" class="act-scrlink">{{ __('messages.photos') }}</a></li>
                                                    <li><a href="{{url('videos')}}" >{{ __('messages.videos') }} </a></li>
                                                    <li><a href="{{url('blogs')}}" >{{ __('messages.blog') }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- user-dasboard-menu_wrap end-->
                                
                                <!-- pricing-column -->  
                                <div class="col-lg-9">
                                    <div class="dashboard-title">
                                        <!-- Tariff Plan menu-->
                                        <!-- Tariff Plan menu end-->						
                                    </div>
                                    <div class="db-container">
                                        <div class="gallery-items gisp grid-small-pad list-single-gallery three-coulms lightgallery">
                                            <!-- 1 -->
                                            @foreach ($photos as $pht)
                                            <div class="gallery-item ">
                                                <div class="grid-item-holder hovzoom">
                                                    <img  src="{{aws_asset_path($pht->image)}}"   alt="">
                                                    <a href="{{aws_asset_path($pht->image)}}" class="gal-link popup-image"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            @endforeach
                                            <!-- 1 end -->
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

@stop

@section('script')

@stop
