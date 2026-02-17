@extends('front_end.template.layout')

@section('header')
<style>
    .agent-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0; /* Light border similar to screenshot */
        display: flex;
        flex-direction: row; /* Horizontal layout */
        height: 180px; /* Fixed height for consistency */
        overflow: hidden;
    }
    .agent-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .agent-card-img-wrap {
        width: 35%; /* Left side width */
        background-color: #fff; /* White background for logo */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-right: 1px solid #f0f0f0;
    }
    .agent-logo-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .agent-card-content {
        width: 65%; /* Right side width */
        padding: 15px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .agent-details-top {
        /* Head area */
    }
    .agent-name {
        font-size: 16px;
        font-weight: 700;
        color: #222;
        margin-bottom: 2px;
        display: block;
        text-decoration: none !important;
        line-height: 1.2;
    }
    .agent-name:hover {
        color: #222; /* Title keeps dark color usually */
    }
    .agent-head-office {
        font-size: 12px;
        color: #888;
        display: block;
        margin-bottom: 8px;
    }
    .agent-stat-line {
        font-size: 13px;
        color: #555;
        margin-bottom: 5px;
    }
    .agent-stat-line i {
        color: #888;
        margin-right: 5px;
    }
    .superagent-star {
        color: #888;
        margin-left: 10px;
        font-size: 12px;
    }
    
    .agent-footer-stats {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }
    .stat-badge {
        background-color: #f5f6f7; /* Light gray pill background */
        color: #333;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 4px;
        display: inline-block;
    }
    .stat-badge-label {
        color: #5d369f; /* Purple text for "For Sale" label part? Screenshot looks purple/dark blue */
        color: #4b4b4b;
    }
    .stat-badge-value {
        color: #555;
    }
    /* Specific Property Finder colors */
    .pf-text-purple { color: #5A489B; } /* Example purple */
    .pf-bg-light { background-color: #F7F8F9; }

    /* Search Bar Tweaks */
    .filter-bar {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 40px;
    }
    .form-control-custom {
        border: 1px solid #ddd;
        border-radius: 6px;
        height: 48px;
        padding: 0 15px;
        width: 100%;
        transition: border-color 0.3s;
    }
    .form-control-custom:focus {
        border-color: #EF5E4E;
        outline: none;
    }
    .btn-search {
        background: #EF5E4E;
        color: #fff;
        border: none;
        height: 48px;
        border-radius: 6px;
        width: 100%;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-search:hover {
        background: #d94e3f;
    }
</style>
@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
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
                                <div class="hero-section-title text-start">
                                    <h2>{{ __('messages.find_agent_agency') }}</h2>
                                    <h5>{{ __('messages.connect_with_professionals') }}</h5>
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

        <div class="main-content ms_vir_height">
            <div class="container">
                <!-- Search Form -->
                <div class="filter-bar">
                    <form action="{{ route('frontend.find_agent_agency') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="position-relative">
                                    <input type="text" class="form-control-custom" name="keywords" placeholder="{{ __('messages.search_agent_placeholder') }}" value="{{ request('keywords') }}">
                                    <i class="fa-light fa-search position-absolute" style="top: 15px; right: 15px; color: #999;"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control-custom" name="type">
                                    <option value="">{{ __('messages.all_types') }}</option>
                                    <option value="agent" {{ request('type') == 'agent' ? 'selected' : '' }}>{{ __('messages.agent') }}</option>
                                    <option value="agency" {{ request('type') == 'agency' ? 'selected' : '' }}>{{ __('messages.agency') }}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn-search">{{ __('messages.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Grid Layout (Row of cards) -->
                <div class="row">
                    @forelse($agents_agencies as $user)
                    <div class="col-lg-6 col-md-12"> <!-- Two cards per row on desktop -->
                        <div class="agent-card">
                            <!-- Left: Logo Area -->
                            <div class="agent-card-img-wrap">
                                @php
                                    $logo_image = $user->logo_image ?? ($user->user_image ?? asset('front-assets/images/avatar/1.jpg'));
                                @endphp
                                <a href="#">
                                    <img src="{{ $logo_image }}" alt="{{ $user->name }}" class="agent-logo-img">
                                </a>
                            </div>
                            
                            <!-- Right: Content Area -->
                            <div class="agent-card-content">
                                <div class="agent-details-top">
                                    <a href="#" class="agent-name">
                                        {{ $user->name }}
                                    </a>
                                    <span class="agent-head-office">
                                        @if($user->role == 4)
                                            {{ __('messages.agency') }}
                                        @else
                                            {{ __('messages.agent') }}
                                            @if($user->agency)
                                                — {{ $user->agency->name }}
                                            @endif
                                        @endif
                                    </span>
                                    
                                    @if($user->role == 4)
                                    <div class="agent-stat-line">
                                        <span>{{ __('messages.agents') }}: {{ $user->agents_count ?? 0 }}</span>
                                        <span class="superagent-star"><i class="fa-solid fa-star"></i> {{ __('messages.superagents') }}: {{ $user->super_agents_count ?? 0 }}</span>
                                    </div>
                                    @else
                                        @if($user->super_agent)
                                        <div class="agent-stat-line">
                                            <span class="superagent-star"><i class="fa-solid fa-star" style="color: gold;"></i> {{ __('messages.super_agent') }}</span>
                                        </div>
                                        @endif
                                    @endif
                                </div>

                                <div class="agent-footer-stats">
                                    <span class="stat-badge pf-bg-light">
                                        <span class="pf-text-purple">{{ __('messages.for_sale') }}:</span> {{ $user->for_sale_count ?? 0 }}
                                    </span>
                                    <span class="stat-badge pf-bg-light">
                                        <span class="pf-text-purple">{{ __('messages.for_rent') }}:</span> {{ $user->for_rent_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="text-muted">{{ __('messages.no_results_found') }}</h4>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pagination-wrap">
                    {!! $agents_agencies->appends(request()->input())->links('front_end.template.pagination') !!}
                </div>
                
                <div class="to_top-btn-wrap">
                    <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                    <div class="svg-corner svg-corner_white footer-corner-left" style="top:0;left: -45px; transform: rotate(-90deg)"></div>
                    <div class="svg-corner svg-corner_white footer-corner-right" style="top:6px;right: -39px; transform: rotate(-180deg)"></div>
                </div>
            </div>
        </div>
@stop
