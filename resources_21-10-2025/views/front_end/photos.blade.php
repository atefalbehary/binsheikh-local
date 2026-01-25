@extends('front_end.template.layout')
@section('header')
    <style>
        /* Custom styles specific to this page */
        
        /* Mobile Tabs Styles */
        .mobile-tabs {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 10px;
            margin-bottom: 20px;
        }
        
        .mobile-tabs-container {
            display: flex;
            justify-content: space-between;
            gap: 5px;
        }
        
        .mobile-tab-btn {
            flex: 1;
            padding: 12px 8px;
            text-align: center;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .mobile-tab-btn:hover {
            background: #e9ecef;
            color: #495057;
            text-decoration: none;
        }
        
        .mobile-tab-btn.active {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        
        /* Gallery item corner fix */
        .gallery-item .grid-item-holder {
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        
        .gallery-item .grid-item-holder a {
            display: block;
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        
        .gallery-item .grid-item-holder img {
            display: block !important;
            border-radius: 0 !important;
        }
        
        .gallery-item .folder-title {
            border-radius: 0 0 8px 8px !important;
        }
        
        /* Additional fix for hover effects */
        .gallery-item .grid-item-holder.hovzoom {
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        
        .gallery-item .grid-item-holder.hovzoom a {
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        
        /* Gallery item corner fix */
        .      .mobile-tab-btn {
                padding: 10px 6px;
                font-size: 13px;
            }
        }
    </style>
@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <!--header-end-->
            <!--warpper-->
            <div class="wrapper">
                <!--content-->
                <div class="content">
                    <!--section-->
                     <div class="section hero-section ">
                        <div class="hero-section-wrap inner-head">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">

                                        <div class="hero-section-title_container">

                                            <div class="hero-section-title">
                                                <h2 style="text-transform: uppercase;">{{ __('messages.news_media') }}</h2>
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
                            <a href="#">Home</a><span>NEWS & MEDIA</span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div> -->
                        <!--breadcrumbs-list end-->
                    </div>
                    <!--container end-->
                    <!--main-content-->
                    <div class="main-content  ms_vir_height">
                        <!--boxed-container-->
                        <div class="container">
                            <!-- Mobile Tabs - Visible on small screens -->
                            <div class="row d-lg-none mb-4">
                                <div class="col-12">
                                    <div class="mobile-tabs">
                                        <div class="mobile-tabs-container">
                                            <a href="#" class="mobile-tab-btn {{ request()->get('filter') == 'photos' || !request()->has('filter') ? 'active' : '' }}" data-target="photos">{{ __('messages.photos') }}</a>
                                            <a href="#" class="mobile-tab-btn {{ request()->get('filter') == 'videos' ? 'active' : '' }}" data-target="videos">{{ __('messages.videos') }}</a>
                                            <a href="#" class="mobile-tab-btn {{ request()->get('filter') == 'blogs' ? 'active' : '' }}" data-target="blogs">{{ __('messages.blog') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- user-dasboard-menu_wrap - Hidden on mobile -->
                                <div class="col-lg-3 d-none d-lg-block">
                                    <div class="boxed-content btf_init">
                                        <div class="user-dasboard-menu_wrap">
                                            <div class="user-dasboard-menu faq-nav">
                                                <ul>
                                                    <li><a href="#" class="{{ request()->get('filter') == 'photos' || !request()->has('filter') ? 'tab-btn  act-scrlink': 'tab-btn'}}" data-target="photos">{{ __('messages.photos') }}</a></li>
                                                    <li><a href="#" class="{{ request()->get('filter') == 'videos' ? 'tab-btn  act-scrlink' : 'tab-btn' }}" data-target="videos">{{ __('messages.videos') }}</a></li>
                                                    <li><a href="#" class="{{ request()->get('filter') == 'blogs' ? 'tab-btn  act-scrlink' : 'tab-btn' }}" data-target="blogs">{{ __('messages.blog') }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- user-dasboard-menu_wrap end-->

                                <!-- Photos Folders Section -->
                                <div class="col-12 col-lg-9 section-content" id="photos-section" style="{{ request()->get('filter') == 'photos' || !request()->has('filter') ? 'display:block;' : 'display:none;' }}">
                                    <div class="dashboard-title">
                                        <h4>{{ __('messages.photos') }}</h4>
                                    </div>
                                    <div class="db-container">
                                        <div class="gallery-items grid-small-pad list-single-gallery three-coulms no-js-layout">
                                            @foreach ($folders as $folder)
                                                @if($folder->has_photos)
                                                <div class="gallery-item">
                                                    <div class="grid-item-holder hovzoom" style="position: relative; width: 100%;">
                                                        <a href="{{ url('folder/'.$folder->id) }}?filter=photos">
                                                            <img src="{{ aws_asset_path($folder->cover_image) }}" alt="{{ $folder->title }}" style="width: 100%;">
                                                            <div class="folder-title" style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0, 0, 0, 0.6); color: #fff; text-align: center; padding: 8px; z-index: 2;">
                                                                <h4 class="mt-1">{{ $folder->title }}</h4>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Videos Folders Section -->
                                <div class="col-12 col-lg-9 section-content" id="videos-section" style="{{ request()->get('filter') == 'videos' ? 'display:block;' : 'display:none;' }}">
                                    <div class="dashboard-title">
                                        <h4>{{ __('messages.videos') }}</h4>
                                    </div>
                                    <div class="db-container">
                                        <div class="gallery-items grid-small-pad list-single-gallery three-coulms no-js-layout">
                                            @foreach ($folders as $folder)
                                                @if($folder->has_videos)
                                                <div class="gallery-item">
                                                    <div class="grid-item-holder hovzoom" style="position: relative; width: 100%;">
                                                        <a href="{{ url('folder/'.$folder->id) }}?filter=videos">
                                                            <img src="{{ aws_asset_path($folder->cover_image) }}" alt="{{ $folder->title }}" style="width: 100%;">
                                                            <div class="folder-title" style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0, 0, 0, 0.6); color: #fff; text-align: center; padding: 8px; z-index: 2;">
                                                                <h4 class="mt-1">{{ $folder->title }}</h4>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Blogs Folders Section -->
                                <div class="col-12 col-lg-9 section-content" id="blogs-section" style="{{ request()->get('filter') == 'blogs' ? 'display:block;' : 'display:none;' }}">
                                    <div class="dashboard-title">
                                        <h4>{{ __('messages.blog') }}</h4>
                                    </div>
                                    <div class="db-container">
                                        <div class="gallery-items grid-small-pad list-single-gallery three-coulms no-js-layout">
                                            @foreach ($folders as $folder)
                                                @if($folder->has_blogs)
                                                <div class="gallery-item">
                                                    <div class="grid-item-holder hovzoom" style="position: relative; width: 100%;">
                                                        <a href="{{ url('folder/'.$folder->id) }}?filter=blogs">
                                                            <img src="{{ aws_asset_path($folder->cover_image) }}" alt="{{ $folder->title }}" style="width: 100%;">
                                                            <div class="folder-title" style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0, 0, 0, 0.6); color: #fff; text-align: center; padding: 8px; z-index: 2;">
                                                                <h4 class="mt-1">{{ $folder->title }}</h4>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="limit-box"></div>
                        </div>

                        <!--boxed-container end-->
                    </div>
                    <!--main-content end-->

@stop

@section('script')
<script>
    $(document).ready(function(){
        // Function to switch tabs (works for both desktop and mobile)
        function switchTab(target) {
            console.log("Switching to tab:", target);

            // Hide all sections
            $('.section-content').hide();

            // Show the selected section
            $('#'+target+'-section').css('display', 'block');

            // Update active tab for desktop
            $('.tab-btn').removeClass('act-scrlink');
            $('.tab-btn[data-target="' + target + '"]').addClass('act-scrlink');

            // Update active tab for mobile
            $('.mobile-tab-btn').removeClass('active');
            $('.mobile-tab-btn[data-target="' + target + '"]').addClass('active');
        }

        // Desktop tab switching
        $('.tab-btn').on('click', function(e){
            e.preventDefault();
            let target = $(this).data('target');
            switchTab(target);
        });

        // Mobile tab switching
        $('.mobile-tab-btn').on('click', function(e){
            e.preventDefault();
            let target = $(this).data('target');
            switchTab(target);
        });
    });
</script>
@stop
