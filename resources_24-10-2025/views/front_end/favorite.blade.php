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
                                                        
                                                        @if(\Auth::user()->role == 4)
                                                            <!-- Agency Role (role 4) - Show Employees -->
                                                            <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
                                                        @endif
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                        @if(\Auth::user()->role == 3 || \Auth::user()->role == 4)
                                                            <!-- Only show visit schedule for agents (role 3) and agencies (role 4) -->
                                                            <li><a href="{{ url('visit-schedule') }}">{{ __('messages.visit_schedule') }}</a></li>
                                                        @endif
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
                                            <div class="w-100 d-flex justify-content-center">
                                                <span class="text-center">{{ __('messages.favourite_properties') }}</span>
                                            </div>
                                            <!-- Tariff Plan menu -->
                                            <!-- Tariff Plan menu end -->
                                        </div>
                                        <div class="db-container w-100" style="width:100%;">
                                            <div class="row">
                                            @foreach($properties as $property)
                                                <div class="col-12 mb-4">
                                                    <div class="property-card-horizontal">
                                                        <!-- Verification Icon -->
                                                        <div class="verification-icon d-flex align-items-center justify-content-center" style="height: 30px; width: 30px; position: absolute; top: 50%; left: 5px; transform: translateY(-50%);">
                                                            <i class="fas fa-check-circle text-success" style="font-size: 16px;"></i>
                                                        </div>
                                                        
                                                        <!-- Property Card Content -->
                                                        <div class="property-card-content">
                                                            <!-- Image Section -->
                                                            <div class="property-image-section">
                                                                <a href="{{ url('property-details/'.$property->slug) }}" class="property-image-link">
                                                                    <div class="property-bg" style="background-image: url('@if(isset($property->images[0])) {{aws_asset_path($property->images[0]->image) }} @endif');"></div>
                                                                    <div class="property-overlay"></div>
                                                                </a>
                                                                <!-- Favorite Heart Icon -->
                                                                <a href="javascript:;" class="favorite-heart fav_prop" data-id="{{ $property->id }}" data-reload="1" data-microtip-position="left" data-tooltip="{{ __('messages.remove_from_favourite') }}">
                                                                    <i class="fas fa-heart heart_{{ $property->id }}"></i>
                                                                </a>
                                                            </div>
                                                            
                                                            <!-- Details Section -->
                                                            <div class="property-details-section">
                                                                <!-- Navigation Arrow -->
                                                                <div class="navigation-arrow">
                                                                    <a href="{{ url('property-details/'.$property->slug) }}">
                                                                        <i class="fas fa-arrow-up-right"></i>
                                                                    </a>
                                                                </div>
                                                                
                                                                <!-- Property Title -->
                                                                <h3 class="property-title">
                                                                    <a href="{{ url('property-details/'.$property->slug) }}">{{ $property->name }}</a>
                                                                </h3>
                                                                
                                                                <!-- Location/Unit Info -->
                                                                
                                                                <!-- Building Name -->
                                                              
                                                                
                                                                <!-- Building Name -->
                                                                <p class="building-name"></p>
                                                                
                                                                <!-- Property Specifications -->
                                                                <div class="property-specs">
                                                                    <div class="spec-row">
                                                                    <div class="spec-item-left">
                                                                            <span class="spec-value">{{ $property->project->name ?? '' }}</span>
                                                                        </div>
                                                                        <div class="spec-item-right">
                                                                            <span class="spec-label">{{ __('messages.unit_price') }}:</span>
                                                                            <span class="spec-value">{{ number_format($property->price) }} QAR</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="spec-row">
                                                                        <div class="spec-item-left">
                                                                            <span class="spec-label">{{ __('messages.floor_no') }} :</span>
                                                                            <span class="spec-value">{{ $property->floor_number ?? '03' }}</span>
                                                                        </div>
                                                                        <div class="spec-item-left">
                                                                            <span class="spec-label">{{ __('messages.unit_size') }}:</span>
                                                                            <span class="spec-value">{{ $property->area }} m²</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
<style>
.property-card-horizontal {
    background: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.verification-icon {
    position: absolute;
    left: -10px;
    top: 20px;
    z-index: 10;
}

.verification-icon i {
    font-size: 24px;
    background: white;
    border-radius: 6px;
    padding: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.property-card-content {
    display: flex;
    width: 100%;
    gap: 20px;
}

.property-image-section {
    flex: 0 0 40%;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.property-image-link {
    display: block;
    width: 100%;
    height: 200px;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}

.property-bg {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 12px;
}

.property-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

.favorite-heart {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    transition: all 0.3s ease;
}

.favorite-heart i {
    color: #ffd700;
    font-size: 18px;
}

.favorite-heart:hover {
    transform: scale(1.1);
}

.property-details-section {
    flex: 1;
    padding: 10px 0;
    position: relative;
}

.navigation-arrow {
    position: absolute;
    top: -10px;
    right: -10px;
}

.navigation-arrow a {
    width: 40px;
    height: 40px;
    background: #ffd700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.navigation-arrow a i {
    color: white;
    font-size: 16px;
}

.navigation-arrow a:hover {
    background: #e6c200;
    transform: scale(1.1);
}

.property-title {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.property-title a {
    color: #333;
    text-decoration: none;
}

.property-title a:hover {
    color: #007bff;
}

.location-unit {
    color: #333;
    font-size: 16px;
    font-weight: bold;
    margin: 0 0 8px 0;
}

.building-name {
    color: #666;
    font-size: 14px;
    margin: 0 0 20px 0;
    font-weight: normal;
}

.property-specs {
    margin-top: 15px;
}

.spec-row {
    display: flex;
    margin-bottom: 8px;
    justify-content: space-between;
}

.spec-item-left {
    flex: 1;
    text-align: center;
}

.spec-item-right {
    flex: 1;
    text-align: center;
}

.spec-label {    
    font-weight: bold;
    color: #333;
    font-size: 14px;
    margin-bottom: 2px;
}

.spec-value {
    color: #333;
    font-size: 14px;
    font-weight: normal;
}

/* Responsive Design */
@media (max-width: 768px) {
    .property-card-content {
        flex-direction: column;
    }
    
    .property-image-section {
        flex: none;
    }
    
    .property-image-link {
        height: 150px;
    }
    
    .spec-row {
        flex-direction: column;
        gap: 10px;
    }
    
    .spec-item-right {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .property-card-horizontal {
        padding: 15px;
    }
    
    .verification-icon {
        left: -5px;
        top: 15px;
    }
    
    .verification-icon i {
        font-size: 20px;
    }
}
</style>
@stop
