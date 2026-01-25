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
                    <div class="section hero-section inner-head">
                        <div class="hero-section-wrap">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">
                                     
                                        <div class="hero-section-title_container">
                                           
                                            <div class="hero-section-title">
                                                 <h2 style="text-transform: uppercase;">{{ __('messages.blog') }}</h2>
                                               
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
                            <a href="#">Home</a><span>NEWS & MEDIA</span><span>Blog</span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div> -->
                        <!--breadcrumbs-list end-->					
                    </div>
                    <!--container end-->	
                    <!--main-content-->
                    <div class="main-content  ms_vir_height">
                        <!--boxed-container-->
                        <div class="boxed-container">
                            <div class=" ">
                                <div class="about-wrap ">
                                    <div class="row">
                                        <div class="col-lg-6 text-start">
                                            <div class="about-title ab-hero ab-hero2">
                                                <h2 class="mb-3">{{$blog->name}}</h2>
                                             
                                            </div>
                                            <p>
                                            {!!$blog->description!!}
                                            </p>
                                          
                                         
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="about-img ab_i2">
                                                <img src="{{aws_asset_path($blog->image)}}" class="respimg" alt="">
                                             
                                             
                                            </div>
                                        </div>
                                        </div>
                                      
                                </div>
                            </div>
                      
                        </div>
                        <!--boxed-container end-->
                    </div>
                    <!--main-content end-->

@stop

@section('script')

@stop
