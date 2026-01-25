@extends('front_end.template.layout')
@section('header')

@stop

@section('content')
<div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <!--header-end-->
            <!--warpper-->
            <div class="wrapper">
                <div class="content">
                    <!--section-->
                    <div class="section hero-section inner-head">
                        <div class="hero-section-wrap">
                        <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">

                                        <div class="hero-section-title_container">

                                            <div class="hero-section-title">
                                                <h2>{{$project->name}}</h2>
                                                <h4 class="mt-3"><i class="fa-solid fa-location-dot"></i> <span>{{$project->location}}</span></h4>
                                            </div>

                                        </div>
                                        <div class="hs-scroll-down-wrap">
                                            <div class="scroll-down-item">
                                                <div class="mousey">
                                                    <div class="scroller"></div>
                                                </div>
                                                <span>{{ __('messages.scroll_down_to_discover') }}</span>
                                            </div>
                                            <div class="svg-corner svg-corner_white" style="bottom:0;left:-40px;"></div>
                                        </div>
                                        @if($project->link_360)
                                        <div class="hs-pv_wrap">
                                            <div class="pv-item">
                                                <i class="fa-light fa-glasses"></i>
                                                <a href="{{$project->link_360}}" target="_blank" rel="noopener noreferrer">
                                                <span>{{ __('messages.view_360') }} - <strong>360</strong></span>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="hero-opt-btnns">
                                            <a href="{{url('contact-us')}}" class="custom-scroll-link tolt" data-microtip-position="left" data-tooltip="{{ __('messages.contact_to_view') }}"><i class="fa-light fa-envelope"></i></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
                                    <div class="bg" data-bg="{{aws_asset_path($project->banner)}}" data-scrollax="properties: { translateY: '30%' }"></div>
                                </div>
                                <div class="svg-corner svg-corner_white" style="bottom:64px;right: 0;z-index: 100"></div>
                            </div>

                        </div>
                    </div>
                    <!--section-end-->
                    <div class="container">
                        <div class="main-content">
                            <div class="boxed-container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!--boxed-container-->
                                        <div class="scroll-content-wrap">
                                            <div class="share-holder init-fix-column">
                                                <!-- <span class="share-title">{{ __('messages.share') }}</span> -->
                                                <div class="share-container  isShare">
                                                    <a href="https://wa.me/+97430666004" target="_blank"   title="Share this page on whatsapp" class="pop share-icon fa fa-whatsapp"></a>
                                                    <a href="https://www.facebook.com/BINALSHEIKHQA" target="_blank" title="Share this page on facebook" class="pop share-icon fa share-icon-facebook"></a>
                                                    <a href="https://www.instagram.com/binalsheikhqa/x/" target="_blank" title="Share this page on instagram" class="pop share-icon fa fa-instagram"></a>
                                                    <a href="https://x.com/BinAlSheikhqa" target="_blank" title="Share this page on Twitter" class="pop share-icon fa fa-x-twitter"></a>
                                                    <!-- <a href="https://www.youtube.com/@binalsheikhtowers1457" target="_blank" title="Share this page on Yitube" class="pop share-icon fa fa-youtube"></a> -->
                                                </div>
                                            </div>

                                            <!--ps-facts-wrapper-->
                                            <!--ps-facts-wrapper end-->

                                            <!--boxed-content-->
                                            <div class="boxed-content">
                                                <!--boxed-content-title-->
                                                <div class="boxed-content-title">
                                                    <h3>{{ __('messages.about_this_property') }}</h3>
                                                </div>
                                                <!--boxed-content-title end-->
                                                <!--boxed-content-item-->
                                                <div class="boxed-content-item">
                                                    <p>{!! $project->description !!}</p>
                                                </div>
                                                <!--boxed-content-item end-->
                                            </div>
                                            <!--boxed-content end-->

                                            <!--boxed-content-->
                                            <div class="boxed-content">
                                                <!--boxed-content-title-->
                                                <div class="boxed-content-title">
                                                    <h3>{{ __('messages.property_gallery') }}</h3>
                                                </div>
                                                <!--boxed-content-title end-->
                                                <!--boxed-content-item-->
                                                <div class="boxed-content-item">
                                                    <div class="single-gallery-filters">
                                                        <div class="gallery-filters">
                                                            <a href="#" class="gallery-filter gallery-filter-active" data-filter="*">{{ __('messages.all_media') }}</a>
                                                            <a href="#" class="gallery-filter" data-filter=".interior">{{ __('messages.interior') }}</a>
                                                            <a href="#" class="gallery-filter" data-filter=".exterior">{{ __('messages.outdoor') }}</a>
                                                        </div>
                                                        <div class="gf_counter">
                                                            <div class="num-album"></div>
                                                            <div class="all-album"></div>
                                                        </div>
                                                    </div>
                                                    <!-- gallery-items   -->
                                                    <div class="gallery-items gisp grid-small-pad list-single-gallery three-coulms lightgallery">
                                                        @foreach($project->images as $img)
                                                        <div class="gallery-item {{$img->type}}">
                                                            <div class="grid-item-holder hovzoom">
                                                                <img src="{{aws_asset_path($img->image)}}" alt="">
                                                                <a href="{{aws_asset_path($img->image)}}" class="gal-link popup-image"><i class="fa fa-search"></i></a>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <!-- end gallery items -->
                                                </div>
                                                <!--boxed-content-item end-->
                                            </div>
                                            <!--boxed-content end-->

                                            <!--banner-widget-wrap-->
                                            <div class="banner-widget-wrap">
                                                <div class="bg-wrap bg-parallax-wrap-gradien fs-wrapper">
                                                    <div class="bg" data-bg="@if($project->video_thumbnail){{aws_asset_path($project->video_thumbnail)}} @else {{ asset('') }}front-assets/images/bg/video-bg.jpg @endif"></div>
                                                </div>
                                                <div class="banner-widget_content">
                                                    <div class="video-box-btn" id="html5-videos" data-html="#video1"><i class="fas fa-play"></i></div>
                                                    <h5><span>{{ __('messages.project_video_presentation') }}</span></h5>
                                                </div>
                                                <div style="display:none;" id="video1" class="popup_video" data-videolink="{{aws_asset_path($project->video)}}">
                                                    <video class="lg-video-object lg-html5" controls preload="none">
                                                        <source src="{{aws_asset_path($project->video)}}" type="video/mp4">
                                                    </video>
                                                </div>
                                            </div>
                                            <!--banner-widget-wrap end-->

                                        </div>
                                    </div>
                                </div>
                                <div class="limit-box"></div>
                            </div>
<div class="row">
    <div class="col-md-8">
    <h4 class="fw-bold mt-4 mb-3 fs-4  text-start ar-text-end">Available Apartments</h4>
    </div>
    <div class="col-md-4 custom-form">
    <select class="form-select mt-4" aria-label="Default select example" id="property-type-select">
        <option value="">{{ __("messages.rent_buy") }}</option>
        <option value="1">{{ __("messages.buy") }}</option>
        <option value="2">{{ __("messages.rent") }}</option>
    </select>

    </div>
    <div class="col-md-12 " >

        <hr/>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach($floors as $key => $floor)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(!$key)active @endif" id="pills-{{$floor}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$floor}}" type="button" role="tab" aria-controls="pills-{{$floor}}" aria-selected="@if(!$key) true @else false @endif">{{ __('messages.floor') }} {{$floor}}</button>
            </li>
        @endforeach

</ul>
<div class="tab-content d-block" id="pills-tabContent">
    @foreach($floors_with_properties as $k => $v)
  <div class="tab-pane fade @if(!$k) show active @endif" id="pills-{{$v['floor']}}" role="tabpanel" aria-labelledby="pills-{{$v['floor']}}-tab">
    <div class="tale-responsive">
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
      <th >#</th>
      <th >{{ __("messages.name") }}</th>
      <th >{{ __("messages.unit_number") }}</th>
      <th >{{ __("messages.sale_type") }}</th>
      <th>{{ __("messages.action") }}</th>
    </tr>
    </thead>
    <tbody>
        <?php $i=0;?>
        @foreach($v['prop'] as $prop)
        <?php $i++;?>
    <tr class="prop_list prop_type_{{$prop->sale_type}}">
        <td>{{$i}}</td>
        <td>{{$prop->name}}</td>
        <td>{{$prop->apartment_no}}</td>
        <td>
            @if($prop->sale_type==1)
                {{ __("messages.buy") }}
            @else
                {{ __("messages.rent") }}
            @endif
        </td>
        <td><a href="{{url('property-details/'.$prop->slug)}}" class="post-card_link mt-0" style="display: inline-block;">{{ __("messages.view") }}</a></td>
    </tr>
    @endforeach
</tbody>
</table>
    </div>
  </div>
  @endforeach
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
</div>
    </div>
</div>


                            <!-- Additional section for Apartments -->
                            <div class="boxed-container">
                                <div class="boxed-content-title bcst_ca">
                                    <h3> {{ __('messages.apartments') }}</h3>
                                </div>



                                <div class="single-carousel-wrap">
                                    <div class="single-carousel">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                @foreach($similar as $sim_property)
                                                <div class="swiper-slide">
                                                    <!-- listing-item -->
                                                    <div class="listing-item">
                                                        <div class="geodir-category-listing">
                                                            <div class="geodir-category-img">
                                                                <a href="{{url('property-details/'.$sim_property->slug)}}" class="geodir-category-img_item">
                                                                    <div class="bg" data-bg="@if(isset($sim_property->images[0])) {{aws_asset_path($sim_property->images[0]->image)}} @endif"></div>
                                                                    <div class="overlay"></div>
                                                                </a>
                                                                <div class="geodir-category-location">
                                                                    <a href="javascript:;"><i class="fas fa-map-marker-alt"></i> {{$sim_property->location}}</a>
                                                                </div>
                                                                <ul class="list-single-opt_header_cat">
                                                                    <li><a href="#" class="cat-opt">{{ ($sim_property->sale_type == 1) ? __('messages.buy') : __('messages.rent') }}</a></li>
                                                                    <li><a href="#" class="cat-opt">{{$sim_property->property_type->name}}</a></li>
                                                                </ul>
                                                                <a href="#" class="geodir_save-btn tolt" data-microtip-position="left" data-tooltip="{{ __('messages.save') }}"><span><i class="fal fa-heart"></i></span></a>
                                                                <div class="geodir-category-listing_media-list">
                                                                    <span><i class="fas fa-camera"></i> {{count($sim_property->images)}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-content">
                                                                <h3><a href="#">{{$sim_property->name}}</a></h3>
                                                                <p class="txt-three-linesss">{{$sim_property->short_description}}</p>
                                                                <div class="geodir-category-content-details">
                                                                    <ul>
                                                                        <li><i class="fa-light fa-bed" title="{{__('messages.bedroom')}}"></i><span>{{$sim_property->bedrooms}}</span></li>
                                                                        <li><i class="fa-light fa-bath" title="{{__('messages.bathroom')}}"></i><span>{{$sim_property->bathrooms}}</span></li>
                                                                        <li><i class="fa-light fa-chart-area" title="{{__('messages.area')}}"></i><span>{{$sim_property->area.' m2'}}</span></li>
                                                                        <li><i class="fa-light fa-building" title="{{__('messages.floor_number')}}"></i><span>{{ __('messages.floor_no') }} {{$sim_property->floor_no}}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="geodir-category-footer d-flex">
                                                                <div class="col pe-1">
                                                                    <a href="{{url('property-details/'.$sim_property->slug)}}" class="post-card_link mt-0 d-block" style="width: 100%;"><span>{{ __('messages.view_details') }}</span></a>
                                                                </div>
                                                                <div class="col ps-1">
                                                                    <a href="#" class="mt-0 d-block post-card_book modal-open" style="width: 100%;"><span>{{ __('messages.book_now') }}</span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- listing-item end-->
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ss-carousel-pagination_wrap">
                                    <div class="solid-pagination_btns ss-carousel-pagination_init"></div>
                                </div>
                                <div class="ss-carousel-button-wrap">
                                    <div class="ss-carousel-button ss-carousel-button-prev"><i class="fas fa-caret-left"></i></div>
                                    <div class="ss-carousel-button ss-carousel-button-next"><i class="fas fa-caret-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <!--main-content end-->

                        <!-- Back to top button -->
                        <div class="to_top-btn-wrap">
                            <div class="to-top to-top_btn"><span>{{ __("messages.back_to_top") }}</span> <i class="fa-solid fa-arrow-up"></i></div>
                            <div class="svg-corner svg-corner_white" style="top:0;left: -40px; transform: rotate(-90deg)"></div>
                            <div class="svg-corner svg-corner_white" style="top:0;right: -40px; transform: rotate(-180deg)"></div>
                        </div>
                    </div>


@stop

@section('script')
<script>
    $(document).ready(function() {
    $('#property-type-select').change(function() {
        var selectedValue = $(this).val();
        $(".prop_list").removeClass("d-none");
        if(selectedValue){
            $(".prop_list").addClass("d-none");
            $(".prop_type_"+selectedValue).removeClass("d-none");
        }
    });
});
</script>
@stop
