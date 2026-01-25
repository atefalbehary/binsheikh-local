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
            <div class="section hero-section ">
                <div class="hero-section-wrap inner-head">
                    <div class="hero-section-wrap-item">
                        <div class="container">
                            <div class="hero-section-container">

                                <div class="hero-section-title_container">
                                    <div class="hero-section-title">
                                        <h2 style="text-transform: uppercase;">{{$folder->title}} </h2>

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

            <div class="main-content  ms_vir_height">
                <!--boxed-container-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="boxed-content btf_init">
                                <div class="user-dasboard-menu_wrap">
                                    <div class="user-dasboard-menu faq-nav">
                                        <ul>
                                            <li><a href="{{ url('photos') }}?filter=photos" class="tab-btn {{ request()->get('filter') == 'photos' || !request()->has('filter') ? 'act-scrlink' : '' }}">{{ __('messages.photos') }}</a></li>
                                            <li><a href="{{ url('photos') }}?filter=videos" class="tab-btn {{ request()->get('filter') == 'videos' ? 'act-scrlink' : '' }}">{{ __('messages.videos') }} </a></li>
                                            <li><a href="{{ url('photos') }}?filter=blogs" class="tab-btn {{ request()->get('filter') == 'blogs' ? 'act-scrlink' : '' }}">{{ __('messages.blog') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- photos -->
                        <div class="col-lg-9 section-content"  id="photos-section">
                            <div class="dashboard-title">
                               {{__('messages.photos')}}
                            </div>
                            <div class="db-container">
                                <div class="gallery-items gisp grid-small-pad list-single-gallery three-coulms lightgallery">
                                    <!-- 1 -->
                                    @foreach ($photos as $pht)
                                        <div class="gallery-item ">
                                            <div class="grid-item-holder hovzoom">
                                                <img  src="{{aws_asset_path($pht->image)}}"   alt="">
                                                <a href="{{aws_asset_path($pht->image)}}" class="gal-link popup-image"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                @endforeach
                                <!-- 1 end -->
                                </div>
                            </div>
                        </div>
                        <!-- videos -->
                        <div class="col-lg-9 section-content"  id="videos-section" style="display: none;">
                            <div class="dashboard-title">
                                {{ __('messages.videos') }}
                            </div>
                            <div class="db-container">
                                <div class="row g-4">
                                    @foreach ($videos as $vd)
                                        <div class="col-md-4">
                                            <iframe width="100%" height="240" style="border-radius: 20px" src="{{$vd->link}}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- bogs -->
                        <div class="col-lg-9 section-content" id="blogs-section" style="display: none;">
                            <div class="dashboard-title">
                                {{__('messages.blog')}}
                            </div>
                            <div class="db-container">
                                <div class="post-container">
                                    <div class="post-items">
                                        <!-- post-item-->
                                        @foreach($blogs as $bl)
                                            <div class="post-item">
                                                <div class="post-item_wrap">
                                                    <div class="post-item_media">
                                                        <a href="#">
                                                            <img src="{{aws_asset_path($bl->image)}}" alt="{{ __('messages.blog_image_alt') }}">
                                                        </a>
                                                    </div>
                                                    <div class="post-item_content">
                                                        <h3><a href="{{url('blog-details/'.$bl->slug)}}">{{$bl->name}}</a></h3>
                                                        <p>{{$bl->short_description}}</p>
                                                        <a href="{{url('blog-details/'.$bl->slug)}}" class="post-card_link">{{ __('messages.view_details') }} <i class="fa-solid fa-caret-right"></i></a>
                                                        <div class="pv-item_wrap"><i class="fa-light fa-calendar-days"></i><span>{{date('F d, Y',strtotime($bl->created_at))}}</span></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                    <!-- post-item end-->
                                    </div>
                                    <!-- pagination-->
                                    <div class="pagination-wrap">
                                        {!! $blogs->appends(request()->input())->links('front_end.template.pagination') !!}
                                    </div>
                                    <!-- pagination end-->
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

@stop

@section('script')
        <script>
            $(document).ready(function(){
                // Check for filter parameter in URL
                function getUrlParameter(name) {
                    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                    var results = regex.exec(location.search);
                    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
                }
                
                // Initialize with filter from URL if present
                var filterParam = getUrlParameter('filter');
                if (filterParam) {
                    switchTab(filterParam);
                }
                
                // Function to switch tabs
                function switchTab(target) {
                    $('.section-content').hide();
                    $('#'+target+'-section').show();
                    
                    $('.tab-btn').removeClass('act-scrlink');
                    $('.tab-btn[data-target="'+target+'"]').addClass('act-scrlink');
                }
            });
        </script>
@stop
