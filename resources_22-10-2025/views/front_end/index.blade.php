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


    .unzoom {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    /* Responsive styles for api-img */
    @media screen and (min-width: 1367px) {
        .api-img {
            height: 71.6%; !important;
        }
    }

    @media screen and (max-width: 1366px) and (min-width: 800px) {
        .api-img {
            height: 29.4%; !important;
        }
    }

    /* Project carousel mobile fixes */
    @media screen and (max-width: 768px) {
        .city-carousel-item {
            margin: 0 10px !important;
            min-height: 300px;
        }
        
        .city-carousel-content {
            padding: 15px !important;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
        }
        
        .city-carousel-content h3 {
            font-size: 18px !important;
            margin-bottom: 8px !important;
            line-height: 1.2 !important;
        }
        
        .city-carousel-content p {
            font-size: 14px !important;
            margin-bottom: 10px !important;
        }
        
        .d-flex.justify-content-between.mb-2 {
            margin-bottom: 10px !important;
        }
        
        .units-left-box, .buy-units, .rent-units {
            width: 30% !important;
            padding: 5px !important;
        }
        
        .units-left-box span, .buy-units span, .rent-units span {
            font-size: 10px !important;
        }
        
        .units-left-box div, .buy-units div, .rent-units div {
            font-size: 14px !important;
        }
        
        .hc-counter {
            font-size: 12px !important;
            padding: 8px 15px !important;
        }
        
        .swiper-slide {
            width: 280px !important;
        }
    }
    
    @media screen and (max-width: 480px) {
        .city-carousel-item {
            margin: 0 5px !important;
            min-height: 280px;
        }
        
        .swiper-slide {
            width: 260px !important;
        }
        
        .city-carousel-content h3 {
            font-size: 16px !important;
        }
        
        .units-left-box, .buy-units, .rent-units {
            width: 28% !important;
            padding: 3px !important;
        }
        
        .units-left-box span, .buy-units span, .rent-units span {
            font-size: 9px !important;
        }
        
        .units-left-box div, .buy-units div, .rent-units div {
            font-size: 12px !important;
        }
    }
    
    /* Additional project carousel fixes */
    .project-stats-container {
        gap: 2px !important;
    }
    
    .city-carousel-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .city-carousel-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 2;
    }
    
    @media screen and (max-width: 768px) {
        .project-stats-container {
            gap: 1px !important;
            margin-bottom: 8px !important;
        }
        
        .city-carousel-item {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    }

    /* Popup Modal Styles */
    .popup-modal-dialog {
        max-width: 800px;
        margin: 1.75rem auto;
        display: flex;
        align-items: center;
        min-height: calc(100vh - 3.5rem);
    }
    
    .popup-modal-content {
        background-color: #f8f5f0;
        max-width: 800px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        width: 100%;
    }
    
    .popup-image-col {
        min-height: 400px;
        position: relative;
        border-radius: 8px 0 0 8px;
        overflow: hidden;
    }
    
    .popup-image-col img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .popup-content-col {
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #f8f5f0;
        min-height: 400px;
    }
    
    .popup-title {
        font-size: 2.5rem;
        font-weight: 300;
        letter-spacing: 1px;
        line-height: 1.3;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .popup-title-bold {
        font-weight: 700;
        color: #2c3e50;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .popup-subtitle {
        font-size: 1.2rem;
        font-weight: 400;
        color: #666;
        display: block;
        line-height: 1.4;
    }
    
    .popup-button {
        letter-spacing: 1px;
        padding: 14px 24px;
        font-size: 15px;
        font-weight: 600;
        background-color: #2c3e50;
        border: none;
        color: white !important;
        text-decoration: none;
        display: block;
        transition: all 0.3s ease;
        border-radius: 4px;
        min-height: 48px;
        line-height: 1.4;
        text-align: center;
        width: 100%;
    }
    
    .popup-button:hover {
        background-color: #34495e;
        color: white !important;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
    }
    
    .popup-text-content {
        flex: 0 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-bottom: 1rem;
    }
    
    .popup-button-container {
        width: 100%;
        margin-top: auto;
        padding-top: 1rem;
    }
    
    /* Mobile Responsive Styles */
    @media screen and (max-width: 768px) {
        .popup-modal-dialog {
            max-width: 95%;
            margin: 0.5rem auto;
            min-height: calc(100vh - 1rem);
            align-items: center;
        }
        
        .popup-modal-content {
            max-width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 8px;
        }
        
        .popup-image-col {
            min-height: 180px;
            max-height: 220px;
            border-radius: 8px 8px 0 0;
        }
        
        .popup-content-col {
            padding: 1.5rem 1.2rem;
            min-height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .popup-text-content {
            flex: 0 1 auto;
            padding-bottom: 1rem;
        }
        
        .popup-title {
            font-size: 1.6rem;
            margin-bottom: 0.5rem !important;
            line-height: 1.3;
        }
        
        .popup-subtitle {
            font-size: 0.95rem;
            margin-bottom: 0 !important;
            line-height: 1.4;
        }
        
        .popup-button-container {
            margin-top: 1.5rem;
            padding-top: 0;
        }
        
        .popup-button {
            padding: 12px 20px;
            font-size: 14px;
            min-height: 44px;
            width: 100%;
            display: block;
            line-height: 1.4;
        }
    }
    
    @media screen and (max-width: 480px) {
        .popup-modal-dialog {
            max-width: 96%;
            margin: 0.25rem auto;
            min-height: calc(100vh - 0.5rem);
        }
        
        .popup-modal-content {
            max-height: 92vh;
        }
        
        .popup-image-col {
            min-height: 160px;
            max-height: 200px;
        }
        
        .popup-content-col {
            padding: 1.2rem 1rem;
        }
        
        .popup-title {
            font-size: 1.4rem;
            margin-bottom: 0.4rem !important;
        }
        
        .popup-subtitle {
            font-size: 0.85rem;
        }
        
        .popup-button-container {
            margin-top: 1.2rem;
        }
        
        .popup-button {
            padding: 11px 18px;
            font-size: 13px;
            min-height: 42px;
        }
    }
    
    /* Extra small devices */
    @media screen and (max-width: 360px) {
        .popup-modal-dialog {
            max-width: 98%;
            margin: 0.2rem auto;
        }
        
        .popup-modal-content {
            max-height: 94vh;
        }
        
        .popup-image-col {
            min-height: 140px;
            max-height: 180px;
        }
        
        .popup-content-col {
            padding: 1rem 0.8rem;
        }
        
        .popup-title {
            font-size: 1.25rem;
        }
        
        .popup-subtitle {
            font-size: 0.8rem;
        }
        
        .popup-button-container {
            margin-top: 1rem;
        }
        
        .popup-button {
            padding: 10px 16px;
            font-size: 12px;
            min-height: 40px;
        }
    }
    
    /* Landscape mobile orientation */
    @media screen and (max-height: 600px) and (orientation: landscape) {
        .popup-modal-dialog {
            min-height: auto;
            margin: 0.5rem auto;
        }
        
        .popup-modal-content {
            max-height: 95vh;
        }
        
        .popup-image-col {
            min-height: 120px;
            max-height: 150px;
        }
        
        .popup-content-col {
            padding: 1rem;
            min-height: auto;
        }
        
        .popup-title {
            font-size: 1.3rem;
            margin-bottom: 0.3rem !important;
        }
        
        .popup-subtitle {
            font-size: 0.85rem;
        }
        
        .popup-button-container {
            margin-top: 0.8rem;
        }
        
        .popup-button {
            padding: 8px 16px;
            min-height: 36px;
            font-size: 12px;
        }
    }
</style>
@stop

@section('content')

    <div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
    <!--header-end-->

    <!-- Popup Modal -->
    @if(isset($popup) && $popup)
        <div class="modal fade" id="popupModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered popup-modal-dialog">
                <div class="modal-content border-0 rounded-0 popup-modal-content">
                    <!-- Close Button -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 bg-white p-1 rounded-circle shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1030; opacity: 0.9; transform: scale(1.1);"></button>
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <!-- Left Column - Image -->
                            <div class="col-md-6 popup-image-col">
                                <img src="{{ aws_asset_path($popup->image) }}" class="img-fluid h-100 w-100 object-fit-cover" alt="Special Offer">
                            </div>

                            <!-- Right Column - Content -->
                            <div class="col-md-6 popup-content-col">
                                <div class="text-center d-flex flex-column h-100">
                                    <!-- Main Offer Text -->
                                    <div class="popup-text-content">
                                        <h2 class="popup-title">
                                            <span class="popup-title-bold">{{ $popup->title }}</span><br>
                                            <span class="popup-subtitle">{{ $popup->subtitle }}</span>
                                        </h2>
                                    </div>

                                    <!-- Sign Up Button -->
                                    <div class="popup-button-container mt-auto">
                                        <a href="{{ $popup->link }}"
                                           class="popup-button"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            {{ $popup->button_text ?? 'BOOK NOW' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                            <div class="filter-group" id="apartment-filter">
                            <div class="gallery-filters">
                                <a href="#" class="gallery-filter gallery-filter-active " data-filter="*" >{{ __("messages.rent_buy") }}</a>
                                <a href="#" class="gallery-filter" data-filter=".cat-sale" >{{ __("messages.buy") }}</a>
                                <a href="#" class="gallery-filter" data-filter=".cat-rent" >{{ __("messages.rent") }}</a>
                            </div>
                            </div>
                        </div>
                        <!-- listing-grid-->
                        <div class="listing-grid gisp">
                        @foreach($recommended as $property)
                            <!-- listing-grid-item-->
                                <div class="listing-grid-item @if($property->sale_type==1) cat-sale @endif @if($property->sale_type==2) cat-rent @endif">
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
                                                    @if($property->is_featured == 1)
                                                        <li><a href="#" class="cat-opt" style="margin-top: 60px; box-shadow: 0px 0px 0px 4px rgba(255, 74, 82, 0.2); background: rgba(255, 74, 82, 0.8);">{{ __('messages.hot_property') }}</a></li>
                                                    @endif
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
                        <div class="col-md-12 text-center listing-grid_heroheader">
                            <div class="listing-grid_heroheader">
                                <h2 style="font-size: 30px; font-weight: 600;margin: 10px 0px 4px;text-align: center !important;" >{{ __("messages.choose_apartment_type") }}</h2>
                                <div class="gallery-filters" style="top:-9px !important;">
                                    <a href="javascript:void(0)" class="gallery-filter gallery-filter-active gallery-filter-active-apartment-type gallery-filter-apartment-type" data-filter="*">{{ __("messages.rent_buy") }}</a>
                                    <a href="javascript:void(0)" class="gallery-filter gallery-filter-apartment-type" data-filter=".cat-sale-apartment-type">{{ __("messages.buy") }}</a>
                                    <a href="javascript:void(0)" class="gallery-filter gallery-filter-apartment-type"  data-filter=".cat-rent-apartment-type">{{ __("messages.rent") }}</a>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?property_type=5&sale_type=' + getSelectedFilter()" style="cursor:pointer">
                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg); background-size: cover; background-position: center;">
                                <h2>{{ __("messages.studio") }}</h2>
                            </div>
                        </div>

                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=1&sale_type=' + getSelectedFilter()" style="cursor:pointer">
                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg); background-size: cover; background-position: center;">
                                <h2>{{ __("messages.1bhk") }}</h2>
                            </div>
                        </div>


                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=2&sale_type=' + getSelectedFilter()" style="cursor:pointer">
                            <div class="category-box" style="background: url({{ asset('') }}front-assets/images/studio.jpg);background-size: cover; background-position: center; ">
                                <h2>{{ __("messages.2bhk") }}</h2>
                            </div>
                        </div>
                        <div class="col-md-3" onclick="window.location.href='{{url('property-listing')}}?bedrooms=3&sale_type=' + getSelectedFilter()" style="cursor:pointer">
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
                                                <div class="bg unzoom"  data-bg="{{aws_asset_path($project->image)}}" data-swiper-parallax="10%"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="city-carousel-content">
                                                <h3><a href="{{url('project-details/'.$project->slug)}}">{{$project->name}}</a></h3>
                                                <p>{{$project->location}}</p>
                                                <div class="d-flex justify-content-between mb-2 project-stats-container">
                                                    <div class="units-left-box p-1 text-center" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 5px; width: 32%;">
                                                        <span style="font-size: 12px; font-weight: bold; color: white;">{{ __('messages.units_left') }}</span>
                                                        <div style="font-size: 16px; font-weight: bold; color: white;">{{$project->total_units}}</div>
                                                    </div>
                                                    <div class="buy-units p-1 text-center" style="background-color: rgba(0, 123, 255, 0.2); border-radius: 5px; width: 32%;">
                                                        <span style="font-size: 12px; color: white;">{{ __('messages.buy') }}</span>
                                                        <div style="font-size: 16px; font-weight: bold; color: white;">{{$project->buy_units}}</div>
                                                    </div>
                                                    <div class="rent-units p-1 text-center" style="background-color: rgba(40, 167, 69, 0.2); border-radius: 5px; width: 32%;">
                                                        <span style="font-size: 12px; color: white;">{{ __('messages.rent') }}</span>
                                                        <div style="font-size: 16px; font-weight: bold; color: white;">{{$project->rent_units}}</div>
                                                    </div>
                                                </div>
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
                            <img src="{{ asset('') }}front-assets/images/bin-sheikh.png" alt="" class="respimg" style="width:100%">
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
    // Show popup modal on page load
    $(document).ready(function() {
        $("#popupModal").modal("show");
    });

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

    // Add this function to get the selected filter
    function getSelectedFilter() {
        var activeFilter = $('.gallery-filter-active-apartment-type').data('filter');
        if (activeFilter === '.cat-sale-apartment-type') {
            return '1'; // Buy
        } else if (activeFilter === '.cat-rent-apartment-type') {
            return '2'; // Rent
        }
        return ''; // Default/All
    }

    // Add click handler for gallery filters
    $('.gallery-filter-apartment-type').click(function(e) {
        e.preventDefault();
        $('.gallery-filter-apartment-type').removeClass('gallery-filter-active-apartment-type');
        $('.gallery-filter-apartment-type').removeClass('gallery-filter-active');
        $(this).addClass('gallery-filter-active-apartment-type');
        $(this).addClass('gallery-filter-active');
    });
</script>

@stop
