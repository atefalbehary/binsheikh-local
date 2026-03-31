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
                                                   <h2>Sales Toolkit</h2>

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
                                                @include('front_end.userMenu')
                                            </div>
                                        </div>
                                    </div>

                                    <!-- user-dasboard-menu_wrap end-->
                                    <!-- pricing-column -->
                                    <div class="col-lg-9">
                                        <div class="db-container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="custom-form bg-white p-4 h-100">
                                                        <div class="dashboard-widget-title-single">Sales Toolkit Documents</div>

                                                        @if(Session::has('success'))
                                                            <div class="alert alert-success mt-2 mb-2">{{ Session::get('success') }}</div>
                                                        @endif
                                                        @if(Session::has('error'))
                                                            <div class="alert alert-danger mt-2 mb-2">{{ Session::get('error') }}</div>
                                                        @endif

                                                        <div class="table-responsive mt-4">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Document Title</th>
                                                                        <th>Uploaded Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($documents as $doc)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $doc->title }}</td>
                                                                            <td>{{ $doc->created_at->format('d M Y') }}</td>
                                                                            <td>
                                                                                <a href="{{ route('frontend.sales_toolkit.download', $doc->id) }}" class="btn btn-sm btn-primary text-white">
                                                                                    <i class="fa fa-download"></i> Download
                                                                                </a>
                                                                                <a href="{{ aws_asset_path($doc->file_path) }}" class="btn btn-sm btn-info text-white" target="_blank">
                                                                                    <i class="fa fa-eye"></i> View
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="4" class="text-center">No documents available in the Sales Toolkit.</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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

@stop