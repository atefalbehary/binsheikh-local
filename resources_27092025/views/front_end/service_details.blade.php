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
                                                    <h2>{{$service->name}}</h2>
                                               
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
                            <a href="#">Home</a><span>Property Sales and Leasing</span>
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
                                <div class=" ">
                                    <div class="help-item-wrap" id="faq2">
                                    <div class="help-item-title">{{ __('messages.key_service_highlight') }}</div>
                                        <div class="row g-2">
                                            @foreach($service->highlights as $highlight)
                                                <div class="col-md-6">
                                                    <div class="pricing-column h-100">
                                                        <div class="pricing-header">
                                                            <h3>{{$highlight->title}}</h3>
                                                        
                                                            <p>{!!$highlight->description!!}</p>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="post-banner-widget">
                                        <div class="bg-wrap fs-wrapper bg-parallax-wrap-gradien">
                                            <div class="bg  " data-bg="{{ asset('') }}front-assets/images/all/19.jpg"></div>
                                        </div>
                                        <div class="post-banner-widget_content">
                                            <h5>{{ __('messages.signing_contract_with_team') }}</h5>
                                            <a href="{{url('contact-us')}}">{{ __('messages.get_in_touch') }}</a>
                                        </div>
                                    </div>
                                </div>
                          
                            </div>
                 			
                        </div>
                        <!--container end-->		
            
                  
                        <!-- section end  -->										
                        <!--container-->
                    
                        <!--container end-->
                    </div>

@stop

@section('script')

@stop
