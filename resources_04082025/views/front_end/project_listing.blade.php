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
                                                   <h2>{{ __('messages.projects') }}</h2>

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
                                <div class="row ">
                                    @foreach($projects as $project)
                                    <div class="col-md-4 mt-4">
                                        <div class="city-carousel-item">
                                            <div class="bg-wrap fs-wrapper">
                                                <div class="bg"  data-bg="{{aws_asset_path($project->image)}}" data-swiper-parallax="10%"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="city-carousel-content">
                                                <h3><a href="{{url('project-details/'.$project->slug)}}">{{$project->name}}</a></h3>
                                                <p>{{$project->location}}</p>
                                                <a href="{{url('project-details/'.$project->slug)}}" class="hc-counter">{{ __('messages.view_project') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--boxed-container end-->
                        </div>
                        <!--container end-->
                    </div>

                    <!--main-content end-->
                <!-- </div> -->

@stop

@section('script')

@stop
