@extends('front_end.template.layout')
@section('header')
    <style>
        /*.gallery-item {*/
        /*    position: relative;*/
        /*    overflow: hidden;*/
        /*}*/

        /*.grid-item-holder img {*/
        /*    width: 100%;*/
        /*    height: auto;*/
        /*    display: block;*/
        /*}*/

        /*.folder-title {*/
        /*    position: absolute;*/
        /*    bottom: 0;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*    background: rgba(0, 0, 0, 0.6);*/
        /*    color: #fff;*/
        /*    text-align: center;*/
        /*    padding: 8px;*/
        /*    z-index: 2;*/
        /*}*/
        .gallery-items {
            gap: 24px; /* Increases space between items */
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Ensure proper 3-column layout */
        }

        .gallery-item {
            border-radius: 20px;
            overflow: hidden; /* Ensure child elements respect border radius */
        }

        .gallery-item img {
            border-radius: 20px;
            width: 100%;
            height: auto;
            display: block;
        }

        .grid-item-holder {
            padding: 10px; /* Optional: adds padding inside each item */
        }

        /* Override any JavaScript positioning */
        .no-js-layout {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 24px !important;
            height: auto !important;
        }

        .no-js-layout .gallery-item {
            position: relative !important;
            left: auto !important;
            top: auto !important;
            width: 100% !important;
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
                            <div class="row">
                                <!-- user-dasboard-menu_wrap -->
                                <div class="col-lg-3">
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
                                <div class="col-lg-9 section-content" id="photos-section" style="{{ request()->get('filter') == 'photos' || !request()->has('filter') ? 'display:block;' : 'display:none;' }}">
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
                                <div class="col-lg-9 section-content" id="videos-section" style="{{ request()->get('filter') == 'videos' ? 'display:block;' : 'display:none;' }}">
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
                                <div class="col-lg-9 section-content" id="blogs-section" style="{{ request()->get('filter') == 'blogs' ? 'display:block;' : 'display:none;' }}">
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
        // Fix for tab switching
        $('.tab-btn').on('click', function(e){
            e.preventDefault();
            let target = $(this).data('target');

            // Debug to console
            console.log("Switching to tab:", target);

            // Hide all sections
            $('.section-content').hide();

            // Show the selected section
            $('#'+target+'-section').css('display', 'block');

            // Update active tab
            $('.tab-btn').removeClass('act-scrlink');
            $(this).addClass('act-scrlink');
        });

        // Make sure sections are properly initialized
        // setTimeout(function() {
        //     // Show the active tab section
        //     let activeTab = $('.tab-btn.act-scrlink').data('target');
        //     if (activeTab) {
        //         $('.section-content').hide();
        //         $('#'+activeTab+'-section').css('display', 'block');
        //     }
        //
        //     // Disable any JavaScript layout manipulation for our gallery
        //     $('.no-js-layout').each(function() {
        //         // Force grid layout
        //         $(this).css({
        //             'display': 'grid',
        //             'grid-template-columns': 'repeat(3, 1fr)',
        //             'gap': '24px',
        //             'height': 'auto'
        //         });
        //
        //         // Fix each gallery item
        //         $(this).find('.gallery-item').css({
        //             'position': 'relative',
        //             'left': 'auto',
        //             'top': 'auto',
        //             'width': '100%'
        //         });
        //     });
        // }, 100);
    });
</script>
@stop
