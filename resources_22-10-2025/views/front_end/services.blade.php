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
                                                  <h2>{{ __('messages.services') }}</h2>
                                               
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
                       			
                    </div>
                    <!--container end-->	
                    <!--main-content-->
                    <div class="main-content ms_vir_height">
                        <!--container-->
                        <div class="container">
                          
                            <!--boxed-container-->
                            <div class="boxed-container">
                                <div class="row">
                                @foreach($services as $service)
                                <div class="col-md-3">
                                    <div class="post-banner-widget">
                                        <div class="bg-wrap fs-wrapper bg-parallax-wrap-gradien">
                                            <div class="bg  " data-bg="{{aws_asset_path($service->image)}}" style="background-image: url({{aws_asset_path($service->image)}});"></div>
                                        </div>
                                        <div class="post-banner-widget_content">
                                            <h5>{{$service->name}}
                                            </h5>
                                            <a href="{{ url('service-details/' . $service->slug) }}">{{ __('messages.read_more') }}</a>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                </div>
                            
                          
                            </div>
                            <!--boxed-container end-->					
                        </div>
                        <!--container end-->		
            
                  
                        <!-- section end  -->										
                        <!--container-->
                    
                        <!--container end-->
                    </div>

@stop

@section('script')

@stop
