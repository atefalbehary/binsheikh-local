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
                        <!--main-content-->
                        <div class="main-content  ms_vir_height mt-5 pt-4">
                            <!--boxed-container-->
                            <div class="boxed-container" style="background: #f9f9f9;">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="boxed-content btf_init">
                                            <div class="user-dasboard-menu_wrap">
                                                <div class="user-dasboard-menu-header">
                                                    <div class="user-dasboard-menu_header-avatar">
                                                        <img src="{{ asset('') }}front-assets/images/avatar/profile-icon.png" alt="">
                                                        <span><strong>{{ \Auth::user()->name }}</strong></span>
                                                        <div class="db-menu_modile_btn"><strong>{{ __('messages.menu') }}</strong><i class="fa-regular fa-bars"></i></div>
                                                    </div>
                                                </div>
                                                @include('front_end.userMenu')
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <div class="dashboard-title">
                                            <div class="dashboard-title-item"><span>Notifications</span></div>
                                            <div class="dashboard-title-actions"></div>
                                        </div>
                                        <div class="db-container">
                                            <div class="custom-form bg-white p-4 h-100">

                                                @if(session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if(session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif

                                                @if(!$tableReady)
                                                    <div class="alert alert-warning mb-0">
                                                        Notifications table not found. Please run migration first:
                                                        <strong>php artisan migrate</strong>
                                                    </div>
                                                @elseif($notifications->isEmpty())
                                                    <div class="notifications-shell">
                                                        <p class="text-muted mb-0">No notifications found.</p>
                                                    </div>
                                                @else
                                                    <div class="notifications-shell">
                                                        <div class="notification-list">
                                                            @foreach($notifications as $notification)
                                                                <div class="notification-item {{ (int) $notification->is_read === 0 ? 'unread' : '' }}">
                                                                    <div class="notification-head">
                                                                        <h6 class="mb-1">{{ $notification->title }}</h6>
                                                                        <small class="text-muted">
                                                                            {{ $notification->created_at ? \Carbon\Carbon::parse($notification->created_at)->format('d M Y, h:i A') : '' }}
                                                                        </small>
                                                                    </div>
                                                                    @if(!empty($notification->body))
                                                                        <p class="mb-2">{{ $notification->body }}</p>
                                                                    @endif
                                                                    <div class="notification-meta">
                                                                        <span class="badge badge-light">Channel: {{ strtoupper($notification->channel ?? 'push') }}</span>
                                                                        @if(!empty($notification->deep_link))
                                                                            <a href="{{ $notification->deep_link }}" target="_blank" rel="noopener noreferrer">Open Link</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
    .dashboard-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px 0;
    }
    .dashboard-title-item {
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }
    .notifications-shell {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .notification-item {
        border: 1px solid #ececec;
        border-radius: 10px;
        padding: 14px 16px;
        background: #fff;
    }
    .notification-item.unread {
        border-left: 4px solid #d7bf78;
        background: #fffdf7;
    }
    .notification-head {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
    }
    .notification-meta {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .notification-item p {
        color: #555;
    }
</style>
@stop
