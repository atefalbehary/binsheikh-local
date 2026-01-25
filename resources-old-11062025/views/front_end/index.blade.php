@extends('front_end.template.layout')
@section('header')
<style>
    .number-group label:first-child {
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
        min-width: 43px;
        justify-content: center;
    }
    .number-group label:first-child input[type="radio"] {
        margin-right: 5px;
    }
    .number-group label:first-child span {
        display: inline-block;
        vertical-align: middle;
        font-size: 13px;
    }
</style>
@stop

@section('content')

    <div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
    <!--header-end-->
    <!--warpper-->
    <div class="wrapper">
        <div class="content bg-gray">
            <!--section-->
            <div class="section hero-section hero-section_sin ">
                <div class="hero-section-wrap">
                    <div class="hero-section-wrap-item">
                        <div class="container px-md-5">

                            <div class="hero-section-container hsc2">
                                <div class="hero-section-title">
                                    <h2>{{ __("messages.find_your_home") }}</h2>
                                </div>
                                <div class="container">
                                    <form action="{{url('property-listing')}}" method="get">
                                        <!-- list-searh-input-wrap-->
                                        <div class="list-searh-input-wrap list-searh-input-wrap-hero lsiwh_2 lsiw_dec">
                                            <div class="custom-form">

                                                <div class="row g-1">
                                                    <!-- listsearch-input-item -->
                                                    <div class="col-lg-2">
                                                        <div class="cs-intputwrap">
                                                            <select data-placeholder="{{ __("messages.statuses") }}" class="chosen-select on-radius no-search-select" name="sale_type">
                                                                <option value="">{{ __("messages.rent_buy") }}</option>
                                                                <option value="2">{{ __("messages.rent") }}</option>
                                                                <option value="1">{{ __("messages.buy") }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                        <div class="cs-intputwrap">

                                                            <select data-placeholder="{{ __("messages.property_type") }}" class="chosen-select on-radius no-search-select" name="property_type" >
                                                                <option value="">{{ __("messages.property_type") }}</option>
                                                                @foreach($categories as $val)
                                                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                                                @endforeach
                                                                <option value="">{{ __("messages.all") }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                            <div class="dropdown">
                                                                <button class="btn select-dropdown dropdown-toggle room_bath_btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                                                                    {{ __("messages.room_baths") }}
                                                                </button>
                                                                <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton1">
                                                                    <h6 class="mb-2">{{ __("messages.beds") }}</h6>
                                                                    <div class="number-group">
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="0" class="bedrooms bed_bath"/>
                                                                            <span>{{ __("messages.studio") }}</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="1" class="bedrooms bed_bath"/>
                                                                            <span>1</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="2" class="bedrooms bed_bath"/>
                                                                            <span>2</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="3" class="bedrooms bed_bath"/>
                                                                            <span>3</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="4" class="bedrooms bed_bath"/>
                                                                            <span>4</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="5" class="bedrooms bed_bath"/>
                                                                            <span>5</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" name="bedrooms" value="6+" class="bedrooms bed_bath"/>
                                                                            <span>6+</span>
                                                                        </label>
                                                                    </div>

                                                                <h6 class="mb-2 mt-3">{{ __("messages.baths") }}</h6>
                                                                <div class="number-group">
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="1" class="bathrooms bed_bath"/>
                                                                        <span>1</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="2" class="bathrooms bed_bath"/>
                                                                        <span>2</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="3" class="bathrooms bed_bath"/>
                                                                        <span>3</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="4" class="bathrooms bed_bath"/>
                                                                        <span>4</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="5" class="bathrooms bed_bath"/>
                                                                        <span>5</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="bathrooms" value="6+" class="bathrooms bed_bath"/>
                                                                        <span>6+</span>
                                                                    </label>
                                                                </div>

                                                                <button type="button" class="post-card_link mt-3 d-inline-block clear_bath_bed ar-float-end" style="height: 40px; line-height: 0; font-size: 13px"><span>{{ __("messages.clear") }}</span> </button>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="dropdown text-start">
                                                            <button class="btn select-dropdown dropdown-toggle price_button" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                                                                {{ __("messages.price") }}
                                                            </button>
                                                            <div class="dropdown-menu  p-3" aria-labelledby="dropdownMenuButton2">
                                                                <h6 class="mb-2">{{ __("messages.price_selector") }}</h6>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="cs-intputwrap mb-2">
                                                                            <input name="price_from" type="text" id="price_from" placeholder="{{ __("messages.min") }}" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="cs-intputwrap mb-2">
                                                                            <input name="price_to" type="text" id="price_to" placeholder="{{ __("messages.max") }}" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="cs-intputwrap">
                                                                    <div class="price-range-wrap">
                                                                        <label>{{ __("messages.price_range") }}</label>
                                                                        <div class="price-rage-item">
                                                                            <input type="text" class="price-range-double pr_range" data-min="5000" data-max="10000000" data-step="1" value="1" data-prefix="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="post-card_link mt-3 d-inline-block clear_price ar-float-end" style="height: 40px; line-height: 0; font-size: 13px"><span>{{ __("messages.clear") }}</span> </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="cs-intputwrap">
                                                            <select name="location" data-placeholder="{{ __("messages.county") }}" class="chosen-select on-radius no-search-select location-select">
                                                                <option value=''>{{ __("messages.county") }}</option>
                                                                @foreach($locations as $val)
                                                                    <option value='{{$val->id}}'>{{$val->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="cs-intputwrap">
                                                            <select name="project" data-placeholder="{{ __("messages.project") }}" class="chosen-select on-radius no-search-select prj-select">
                                                                <option value=''>{{ __("messages.project") }} </option>
                                                            <!-- @foreach($prj as $val)
                                                                <option value='{{$val->id}}'>{{$val->name}}</option>
                                                                    @endforeach -->
                                                            </select>
                                                        </div>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                        <!-- list-searh-input-wrap end-->
                                        <div class="row mt-4 justify-content-center">
                                            <div class="col-md-3 ">
                                                <div class="cs-intputwrap">
                                                    <input type="hidden" id="total_results" value="0">
                                                    <button class="commentssubmit commentssubmit_fw" id="search_button">{{ __("messages.search") }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="hs-scroll-down-wrap">
                                <div class="scroll-down-item">
                                    <div class="mousey">
                                        <div class="scroller"></div>
                                    </div>
                                    <span>{{ __("messages.scroll_down_to_discover") }}</span>
                                </div>
                                <div class="svg-corner svg-corner_white corner-left" style="bottom:0;right: -39px; transform: rotate( 90deg)"></div>
                                <div class="svg-corner svg-corner_white corner-right" style="bottom:0;left: -39px;"></div>
                            </div>

                        </div>

                        <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                            <div class="video-holder-wrap fs-wrapper">
                                <div class="video-container">
                                    <video autoplay playsinline loop muted  class="bgvid">
                                        <source src="{{ asset('') }}front-assets/video/banner.mp4" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--section-end-->
            <!--container-->
            <div class="container ">
                <!--breadcrumbs-list-->

                <!--breadcrumbs-list end-->
                <!--main-content-->
                <div class="main-content ms_vir_height" id="sec1">
                    <!--boxed-container-->
                    <div class="boxed-container">
                        <div class="listing-grid_heroheader">
                            <h3>{{ __("messages.recommended_properties") }}</h3>
                            <div class="gallery-filters">
                                <a href="#" class="gallery-filter gallery-filter-active" data-filter="*">{{ __("messages.rent_buy") }}</a>
                                <a href="#" class="gallery-filter" data-filter=".cat-sale">{{ __("messages.buy") }}</a>
                                <a href="#" class="gallery-filter" data-filter=".cat-rent">{{ __("messages.rent") }}</a>
                            </div>
                        </div>
                        <!-- listing-grid-->
                        <div class="listing-grid gisp">
                        @foreach($recommended as $property)
                            <!-- listing-grid-item-->
                                <div class="listing-grid-item @if($property->sale_type==1 || $property->sale_type==3) cat-sale @endif @if($property->sale_type==2 || $property->sale_type==3) cat-rent @endif">
                                    <div class="listing-item">
                                        <div class="geodir-category-listing">
                                            <div class="geodir-category-img">
                                                <a href="{{url('property-details/'.$property->slug)}}" class="geodir-category-img_item">
                                                    <div class="bg" data-bg=" @if(isset($property->images[0])) {{aws_asset_path($property->images[0]->image)}} @endif "></div>
                                                    <div class="overlay"></div>
                                                </a>
                                                <div class="geodir-category-location">
                                                    <a href="javascript:;"><i class="fas fa-map-marker-alt"></i> {{$property->location}}</a>
                                                </div>

                                                <ul class="list-single-opt_header_cat">
                                                    <li>
                                                        @if($property->sale_type==1 || $property->sale_type==3)
                                                            <a href="#" class="cat-opt">{{ __("messages.buy") }}</a>
                                                        @endif
                                                        @if($property->sale_type==2 || $property->sale_type==3)
                                                            <a href="#" class="cat-opt">{{ __("messages.rent") }}</a>
                                                        @endif
                                                    </li>
                                                    <li><a href="#" class="cat-opt">{{$property->property_type->name}}</a></li>
                                                </ul>
                                                <a href="javascript:;" class="geodir_save-btn tolt @if(Auth::check() && (Auth::user()->role != '1')) fav_prop @else modal-open @endif" data-id="{{$property->id}}" data-microtip-position="left" data-tooltip="@if(!$property->is_fav) {{ __("messages.add_to_favourite") }} @else {{ __("messages.remove_from_favourite") }} @endif"><spasn><i class="fal fa-heart heart_{{$property->id}}" @if(!$property->is_fav) style="font-weight: 400" @endif></i></spasn></a>
                                                <div class="geodir-category-listing_media-list">
                                                    <span><i class="fas fa-camera"></i> {{count($property->images)}}</span>
                                                </div>
                                            </div>
                                            <div class="geodir-category-content">
                                                <h3 class="mb-1"><a href="{{ url('property-details/'.$property->slug) }}">{{$property->name}}</a></h3>
                                                <div class="geodir-category-content_price mb-1"><span class="d-iline-block">  {{moneyFormat($property->price)}}</span>  <span class="d-iline-block px-2 fw-normal">|</span>
                                                    <span  class="d-iline-block  fw-normal"><i class="fa-solid fa-apartment me-2 ms-2 mb-0"></i><span>{{ __("messages.no") }}: {{$property->apartment_no}}</span></span>
                                                </div>

                                                <p class="txt-three-linesss">{{$property->short_description}}</p>
                                                <div class="geodir-category-content-details">
                                                    <ul>
                                                        <li><i class="fa-light fa-bed" title="{{__('messages.bedroom')}}"></i><span>{{$property->bedrooms}}</span></li>
                                                        <li><i class="fa-light fa-bath" title="{{__('messages.bathroom')}}"></i><span>{{$property->bathrooms}}</span></li>
                                                        <li><i class="fa-light fa-chart-area" title="{{__('messages.area')}}"></i><span>{{$property->area}} m2</span></li>
                                                        <li><i class="fa-light fa-building" title="{{__('messages.floor_number')}}"></i><span>{{__('messages.floor_no')}}{{$property->floor_no}} </span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="geodir-category-footer  ">
                                                <div class="row g-2">
                                                    <div class="col ">
                                                        <a href="{{url('property-details/'.$property->slug)}}" class="post-card_link mt-0 d-block " style="width: 100%;"><span>{{ __("messages.view_details") }}</span> </a>
                                                    </div>
                                                    <div class="col ">
                                                        @if(Auth::check() && (Auth::user()->role != '1'))
                                                            <a href="{{url('checkout',$property->id)}}" class=" mt-0 d-block post-card_book" style="width: 100%">{{ __("messages.book_now") }}</a>
                                                        @else
                                                            <a href="javascript:;" class=" mt-0 d-block post-card_book modal-open" style="width: 100%;">{{ __("messages.book_now") }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- listing-grid-item end-->
                            @endforeach
                        </div>
                        <!-- listing-grid end-->

                        <a href="{{url('property-listing')}}" class="commentssubmit csb-no-align">{{ __("messages.view_all_properties") }} <i class="fa-solid fa-caret-right"></i></a>

                    </div>
                    <!--boxed-container end-->
                </div>

                <!--main-content end-->
            </div>

            <div class="container mb-5">
                <div class="boxed-container">
                    <div class="row g-3">
                        <div class="col-md-12 text-center">
                            <div class="about-title ab-hero mb-3 text-center d-block">
                                <h2 class="text-center">{{ __("messages.choose_apartment_type") }}</h2  >
                            </div>
                        </div>

                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?property_type=5'" style="cursor:pointer">

                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg); background-size: cover; background-position: center;">
                                <h2>{{ __("messages.studio") }}</h2>
                            </div>
                        </div>

                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=1'" style="cursor:pointer">

                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg); background-size: cover; background-position: center;">
                                <h2>{{ __("messages.1bhk") }}</h2>
                            </div>
                        </div>


                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=2'" style="cursor:pointer">

                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg);background-size: cover; background-position: center; ">
                                <h2>{{ __("messages.2bhk") }}</h2>
                            </div>
                        </div>
                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=3'" style="cursor:pointer">

                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg); background-size: cover; background-position: center;">
                                <h2>{{ __("messages.3bhk") }}</h2>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!--container end-->
            <div class="parallax-section-wrap">
                <div class="bg-wrap fs-wrapper" data-scrollax-parent="true">
                    <div class="bg" data-bg="{{ asset('') }}front-assets/images/bg/3.jpg" data-scrollax="properties: { translateY: '20%' }"></div>
                    <div class="overlay"></div>
                </div>
                <div class="container px-5">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="parallax-section-content">
                                <h3>{{ __("messages.services") }}</h3>
                            </div>
                        </div>
                        @foreach($recommended_ser as $service)
                            <div class="col-md-3">
                                <div class="post-banner-widget">
                                    <div class="bg-wrap fs-wrapper bg-parallax-wrap-gradien">
                                        <div class="bg" data-bg="{{aws_asset_path($service->image)}}" style="background-image: url({{aws_asset_path($service->image)}});"></div>
                                    </div>
                                    <div class="post-banner-widget_content">
                                        <h5>{{$service->name}}</h5>
                                        <a href="{{url('service-details/'.$service->slug)}}">{{ __("messages.read_more") }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!--main-content-->
            <div class="main-content ms_vir_height">
                <!--container -->
                <div class="container">
                    <div class="boxed-container">
                        <div class="">
                            <div class="about-wrap boxed-content-item">
                                <div class="row g-5">
                                    <div class="col-lg-6">
                                        <div class="about-title ab-hero mb-3">
                                            <h2>{{ __("messages.why_choose_bin_al_sheikh") }}</h2>
                                        </div>
                                        <div class="services-opions">
                                            <ul>
                                                <li>
                                                    <p>  <b>{{ __("messages.comprehensive_solutions") }}:</b> {{ __("messages.comprehensive_solutions_description") }}</p>
                                                </li>
                                                <li>
                                                    <p> <b>{{ __("messages.reliability") }}:</b> {{ __("messages.reliability_description") }}</p>
                                                </li>
                                                <li>
                                                    <p>  <b>{{ __("messages.accessible_hour") }}:</b> {{ __("messages.accessible_hour_description") }}</p>
                                                </li>
                                                <li>
                                                    <p> <b>{{ __("messages.expertise") }}:</b> {{ __("messages.expertise_description") }}</p>
                                                </li>
                                                <li>
                                                    <p><b>{{ __("messages.customer_support") }}:</b> {{ __("messages.customer_support_description") }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="about-img">
                                            <img src="{{ asset('') }}front-assets/images/about.jpg" class="respimg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $set = \App\Models\Settings::find(1);
                        @endphp
                        <div class="row g-3">
                            <!-- inline-facts -->
                            <div class="col-md-3">
                                <div class="inline-facts">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="{{$set->experience}}">0</div>
                                        </div>
                                    </div>
                                    <h6>{{ __("messages.years_of_experience", ['experience' => $set->experience]) }}</h6>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                            <!-- inline-facts  -->
                            <div class="col-md-3">
                                <div class="inline-facts">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="{{$set->clients}}">0</div>
                                        </div>
                                    </div>
                                    <h6>{{ __("messages.clients",['clients' => $set->clients]) }}</h6>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                            <!-- inline-facts  -->
                            <div class="col-md-3">
                                <div class="inline-facts">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="{{$set->units}}">0</div>
                                        </div>
                                    </div>
                                    <h6>{{ __("messages.units",['units' => $set->units]) }}</h6>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                            <!-- inline-facts  -->
                            <div class="col-md-3">
                                <div class="inline-facts">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="{{$set->branches}}">0</div>
                                        </div>
                                    </div>
                                    <h6>{{ __("messages.branches",['branches' => $set->branches]) }}</h6>
                                </div>
                            </div>
                            <!-- inline-facts end -->
                        </div>

                    </div>

                </div>
                <!--container end-->
            </div>

            <div class="dark-bg half-carousel-container mb-0">
                <div class="city-carousel-wrap">
                    <div class="half-carousel-title-wrap">
                        <div class="half-carousel-title">
                            <h2>{{ __("messages.projects") }}</h2>
                            <p>{{ __("messages.projects_description") }}</p>
                            <a href="{{url('project-listing')}}" class="commentssubmit" style="margin-top: 20px">{{ __("messages.projects") }} <i class="fa-solid fa-caret-right"></i></a>
                        </div>
                        <div class="abs_bg"></div>
                    </div>
                    <div class="city-carousel">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!--city-carousel-item-->
                                @foreach($recommended_prj as $project)
                                    <div class="swiper-slide">
                                        <div class="city-carousel-item">
                                            <div class="bg-wrap fs-wrapper">
                                                <div class="bg"  data-bg="{{aws_asset_path($project->image)}}" data-swiper-parallax="10%"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="city-carousel-content">
                                                <h3><a href="{{url('project-details/'.$project->slug)}}">{{$project->name}}</a></h3>
                                                <p>{{$project->location}}</p>
                                                <a href="{{url('project-details/'.$project->slug)}}" class="hc-counter">{{ __("messages.view_project") }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="sc-controls city-pag-init"></div>
                    </div>
                </div>
                <div class="city-carousel_controls">
                    <div class="csc-button csc-button-prev"><i class="fas fa-caret-left"></i></div>
                    <div class="csc-button csc-button-next"><i class="fas fa-caret-right"></i></div>
                </div>
            </div>


            <div class="section-title mb-0 pb-3 pt-3 text-center" style="background: #000;">
                <!--<h4 style="color: #fff;">Project </h4>-->
                <h2 style="color: #fff;">{{ __("messages.projects") }}</h2>
            </div>
            <div class=" ">
                <iframe src="https://www.google.com/maps/d/u/1/embed?mid=1ex_TzzjJKyd8AFLcSN18j9nME1bG9Rg&ehbc=2E312F&noprof=1" width="100%" height="500px"></iframe>
                <!--<iframe width="100%" height="500px" frameborder="0" allowfullscreen allow="geolocation" src="//umap.openstreetmap.fr/en/map/untitled-map_1148656?scaleControl=false&miniMap=false&scrollWheelZoom=false&zoomControl=true&editMode=disabled&moreControl=true&searchControl=null&tilelayersControl=null&embedControl=null&datalayersControl=true&onLoadPanel=none&captionBar=false&captionMenus=true"></iframe>-->
            </div>
            <!-- <div id="map"></div> -->
            @if(count($reviews)>0)
                <div class="content-section">
                    <div class="container">
                        <div class="section-title">
                            <h4>{{ __("messages.what_said_about_us") }}</h4>
                            <h2>{{ __("messages.testimonials") }}</h2>
                        </div>
                    </div>

                    <div class="testimonilas-carousel-wrap">
                        <div class="testimonilas-carousel">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <!--testi-item-->
                                    @foreach ($reviews as $rev)
                                        <div class="swiper-slide">
                                            <div class="testi-item">
                                                <div class="testimonilas-text pb-4">
                                                    <div class="testi-header">
                                                        <div class="testi-avatar"><img src="{{aws_asset_path($rev->image)}}" alt=""></div>
                                                        <h3>{{$rev->name}}</h3>
                                                    </div>
                                                    <div class="testimonilas-text-item">
                                                        <div class="testimonilas-text-item-wrap">
                                                            <p>{{$rev->description}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                @endforeach
                                <!--testi-item end-->
                                </div>
                            </div>
                            <div class="tc-button tc-button-next"><i class="fas fa-caret-right"></i></div>
                            <div class="tc-button tc-button-prev"><i class="fas fa-caret-left"></i></div>
                        </div>
                        <div class="fwc-controls_wrap">
                            <div class="solid-pagination_btns tcs-pagination_init"></div>
                        </div>
                    </div>
                </div>
            @endif



        <!-- section end  -->
            <!--container-->
            <div class="container">
                <div class="api-wrap">
                    <div class="api-container">
                        <div class="api-img">
                            {{--                                    <img src="{{ asset('') }}front-assets/images/api.png" alt="" class="respimg">--}}
                            <img src="{{ asset('') }}front-assets/images/home-brokerage1.png" alt="" class="respimg">
                        </div>
                        <div class="api-text">
                            <h3>{{ __("messages.home_heading") }}</h3>

                            <p>{{ __("messages.home_description") }} <span class="en-hide ar-change d-inline-block">+97430666004</span></p>
                            <div class="api-text-links">
                                <!-- Any other links can be added here if needed -->
                            </div>
                        </div>
                        <div class="api-wrap-bg" data-run="2">
                            <div class="api-wrap-bg-container">
                                <span class="api-bg-pin"></span><span class="api-bg-pin"></span>
                                <div class="abs_bg"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="to_top-btn-wrap">
                    <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                    <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                    <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
                </div>
            </div>

            <!--main-content end-->



            @stop

@section('script')
<script>
    $(".pr_range").change(function(){
        pr_text = "Price"
        if($(this).val()){
            var val = $(this).val().split(';');
            $('#price_from').val(val[0]);
            $('#price_to').val(val[1]);
            pr_text = val[0]+" - "+val[1];
        }else{
            $('#price_from').val('');
            $('#price_to').val('');
        }
        $(".price_button").text(pr_text)
        updatePropertyCount();
    });
    $(".bed_bath").change(function(){
        var bed_val = $('.bedrooms:checked').val() || '';
        var bath_val = $('.bathrooms:checked').val() || '';
        var text = '  {{ __('messages.room_baths') }}';
        var text = '{{ __('messages.room_baths') }}';
        if(bed_val && bath_val){
            var bed_text = bed_val == "0" ? '{{ __('messages.studio') }}' : bed_val + ' {{ __('messages.beds') }}';
            text = bed_text + ' & ' + bath_val + ' {{ __('messages.baths') }}';
        }else if(bed_val){
            text = bed_val == "0" ? '{{ __('messages.studio') }}' : bed_val + ' {{ __('messages.beds') }}';
        }else if(bath_val){
            text = bath_val+'{{ __('messages.baths') }}';
        }
        $(".room_bath_btn").text(text)
        updatePropertyCount();
    });
    $(".clear_bath_bed").click(function(){
        $(".room_bath_btn").click();
        $(".room_bath_btn").text('  {{ __('messages.room_baths') }}');
        $('.bedrooms:checked').prop('checked', false);
        $('.bathrooms:checked').prop('checked', false);
        updatePropertyCount();
    });
    $(".clear_price").click(function(){
        $(".price_button").click();
        $(".price_button").text('  {{ __('messages.price') }}');
        $(".price_button").text('{{ __('messages.price') }}');
        $('#price_from').val('');
        $('#price_to').val('');
        updatePropertyCount();
    });

    // Function to update search button text
    function updateSearchButtonText() {
        var totalResults = $('#total_results').val();
        if(totalResults > 0) {
            $('#search_button').text('{{ __("messages.show") }} ' + totalResults + ' {{ __("messages.results") }}');
        } else {
            $('#search_button').text('{{ __("messages.show") }} ' + totalResults + ' {{ __("messages.results") }}');
        }
    }

    // Function to update property count
    function updatePropertyCount() {
        $.ajax({
            url: '{{ url("get-property-count") }}',
            type: 'GET',
            data: {
                sale_type: $('select[name="sale_type"]').val(),
                property_type: $('select[name="property_type"]').val(),
                location: $('select[name="location"]').val(),
                project: $('select[name="project"]').val(),
                price_from: $('input[name="price_from"]').val(),
                price_to: $('input[name="price_to"]').val(),
                bedrooms: $('input[name="bedrooms"]:checked').val(),
                bathrooms: $('input[name="bathrooms"]:checked').val()
            },
            success: function(response) {
                $('#total_results').val(response.count);
                updateSearchButtonText();
            }
        });
    }

    // Add change event listeners to all search inputs
    $('select[name="sale_type"], select[name="property_type"], select[name="location"], select[name="project"]').on('change', function() {
        updatePropertyCount();
    });

    // Initial update of button text
    updatePropertyCount();
</script>
@stop
