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
                                               <h2>{{ __('messages.find_your_dream_house') }}</h2> <!-- Translated "Find Your Dream House" -->
                                        <h5>{{ __('messages.explore_luxurious_properties') }}</h5> <!-- Translated "Explore luxurious properties..." -->

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

                        <div class="main-content">
                            <div class="boxed-container">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-form">
                                        <form action="{{url('property-listing')}}" method="get">
                                            <div class="row g-1">
                                                <!-- listsearch-input-item -->
                                                <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <select data-placeholder="{{ __('messages.statuses') }}" class="chosen-select on-radius no-search-select" name="sale_type">
                                                            <option value="">{{ __('messages.rent_buy') }}</option>
                                                            <option <?=$sale_type==2 ? 'selected':'' ?> value="2">{{ __('messages.rent') }}</option>
                                                            <option <?=$sale_type==1 ? 'selected':'' ?> value="1">{{ __('messages.buy') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <select data-placeholder="{{ __('messages.property_type') }}" class="chosen-select on-radius no-search-select" name="property_type">
                                                            <option value="">{{ __('messages.property_type') }}</option>
                                                            @foreach($categories as $val)
                                                            <option <?=$property_type==$val->id ? 'selected':'' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                            @endforeach
                                                            <option value="">{{ __('messages.all') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="dropdown">
                                                        <button class="btn select-dropdown dropdown-toggle room_bath_btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                                                            {{$bed_bath_text}}
                                                        </button>
                                                        <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                                                            <h6 class="mb-2">{{ __('messages.beds') }}</h6>
                                                            <div class="number-group">
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms=="0"?'checked':'' ?> value="0" class="bedrooms bed_bath"/>
                                                                    <span>{{ __('messages.studio') }}</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms==1?'checked':'' ?> value="1" class="bedrooms bed_bath"/>
                                                                    <span>1</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms==2?'checked':'' ?> value="2" class="bedrooms bed_bath"/>
                                                                    <span>2</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms==3?'checked':'' ?> value="3" class="bedrooms bed_bath"/>
                                                                    <span>3</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms==4?'checked':'' ?> value="4" class="bedrooms bed_bath"/>
                                                                    <span>4</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms==5?'checked':'' ?> value="5" class="bedrooms bed_bath"/>
                                                                    <span>5</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bedrooms" <?=$bedrooms=="6+"?'checked':'' ?> value="6+" class="bedrooms bed_bath"/>
                                                                    <span>6+</span>
                                                                </label>
                                                            </div>
                                                            <h6 class="mb-2 mt-3">{{ __('messages.baths') }}</h6>
                                                            <div class="number-group">
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="1" <?=$bathrooms==1?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>1</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="2" <?=$bathrooms==2?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>2</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="3" <?=$bathrooms==3?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>3</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="4" <?=$bathrooms==4?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>4</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="5" <?=$bathrooms==5?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>5</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="bathrooms" value="6+" <?=$bathrooms=="6+"?'checked':'' ?> class="bathrooms bed_bath"/>
                                                                    <span>6+</span>
                                                                </label>
                                                            </div>
                                                            <button type="button" class="post-card_link mt-3 d-inline-block clear_bath_bed" style="height: 40px; line-height: 0; font-size: 13px"><span>{{ __('messages.clear') }}</span></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="dropdown text-start">
                                                        <button class="btn select-dropdown dropdown-toggle price_button" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
                                                            {{$pr_text}}
                                                        </button>
                                                        <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton2">
                                                            <h6 class="mb-2">{{ __('messages.price_selector') }}</h6>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="cs-intputwrap mb-2">
                                                                        <input name="price_from" type="text" id="price_from" placeholder="{{ __('messages.min') }}" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="cs-intputwrap mb-2">
                                                                        <input name="price_to" type="text" id="price_to" placeholder="{{ __('messages.max') }}" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="cs-intputwrap">
                                                                <div class="price-range-wrap">
                                                                    <label>{{ __('messages.price_range') }}</label>
                                                                    <div class="price-rage-item">
                                                                        <input type="text" class="price-range-double pr_range" data-min="5000" data-max="10000000" data-step="1" value="1" data-prefix="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="post-card_link mt-3 d-inline-block clear_price" style="height: 40px; line-height: 0; font-size: 13px"><span>{{ __('messages.clear') }}</span></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <select name="project" data-placeholder="{{ __('messages.project') }}" class="chosen-select on-radius no-search-select">
                                                            <option value=''>{{ __('messages.project') }}</option>
                                                            @foreach($prj as $val)
                                                            <option <?=$project_id==$val->id ? 'selected':'' ?> value='{{$val->id}}'>{{$val->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <select name="location" data-placeholder="{{ __("messages.county") }}" class="chosen-select on-radius no-search-select location-select">
                                                            <option value=''>{{ __("messages.county") }}</option>
                                                            @foreach($locations as $val)
                                                            <option <?=$location_id==$val->id ? 'selected':'' ?> value='{{$val->id}}'>{{$val->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <select name="project" data-placeholder="{{ __("messages.project") }}" class="chosen-select on-radius no-search-select prj-select">
                                                            <option value=''>{{ __("messages.project") }} </option>
                                                            @foreach($prj as $val)
                                                            <option <?=$project_id==$val->id ? 'selected':'' ?> value='{{$val->id}}'>{{$val->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-lg-2">
                                                    <div class="cs-intputwrap">
                                                        <button class="commentssubmit commentssubmit_fw">{{ __('messages.search') }}</button>
                                                    </div>
                                                </div> -->
                                                <!-- listsearch-input-item -->
                                            </div>
                                            <div class="row mt-3 justify-content-center">
                                                <div class="col-md-3">
                                                    <div class="cs-intputwrap">
                                                        <button class="commentssubmit commentssubmit_fw">{{ __("messages.search") }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- list-searh-input-wrap end-->
                                        <div class="mob-filter-overlay cmf fs-wrapper"></div>
                                        <!-- list-main-wrap-header-->
                                        <div class="list-main-wrap-header box-list-header">

<div class="row align-items-center">
    <div class="col-md-4 ">
    <div class="input-group ">
  <input type="text" class="form-control" id="unit_number" placeholder="{{ __('messages.search_unit_number') }}" value="{{$unit_number}}" style=" height: 56px; ">
  <div class="input-group-append">
    <button class="btn btn-secondary unit_search" type="button" style=" height: 56px;background: #000 ">{{ __('messages.search') }}</button>
  </div>
</div>

    </div>
    <div class="col-md-4 ">



    </div>
    <div class="col-md-4 d-flex align-items-center">
    <span >{{ __('messages.sort_by') }}:</span>
                                                    <div class="cs-intputwrap flex-grow-1 px-3" style="margin-bottom: 0">
                                                        <select data-placeholder="{{ __('messages.latest') }}" class="chosen-select no-search-select" id="sort_sel">
                                                            <option value="latest">{{ __('messages.latest') }}</option>
                                                            <option @if($sort=="price_low_to_high") selected @endif value="price_low_to_high">{{ __('messages.price_low_to_high') }}</option>
                                                            <option @if($sort=="price_high_to_low") selected @endif value="price_high_to_low">{{ __('messages.price_high_to_low') }}</option>
                                                            <option @if($sort=="size_low_to_high") selected @endif value="size_low_to_high">{{ __('messages.size_low_to_high') }}</option>
                                                            <option @if($sort=="size_high_to_low") selected @endif value="size_high_to_low">{{ __('messages.size_high_to_low') }}</option>
                                                            <option @if($sort=="floor_low_to_high") selected @endif value="floor_low_to_high">{{ __('messages.floor_low_to_high') }}</option>
                                                            <option @if($sort=="floor_high_to_low") selected @endif value="floor_high_to_low">{{ __('messages.floor_high_to_low') }}</option>
                                                        </select>

    </div>
</div>


                                                <!-- price-opt end-->
                                            </div>
                                            <!-- list-main-wrap-opt end-->
                                        </div>
                                        <!-- list-main-wrap-header end-->
                                    </div>
                                </div>

                                <!--listing-item-container-->
                                <div class="row">
                                    <div class="col-md-12">
                                <div class="listing-item-container three-columns-grid">

                                    <!-- listing-item -->
                                    @foreach($properties as $property)
                                    <div class="listing-item">
                                        <div class="geodir-category-listing">
                                            <div class="geodir-category-img">
                                                <a href="{{ url('property-details/'.$property->slug) }}" class="geodir-category-img_item">
                                                    <div class="bg" data-bg=" @if(isset($property->images[0])) {{aws_asset_path($property->images[0]->image) }} @endif "></div>
                                                    <div class="overlay"></div>
                                                </a>
                                                <div class="geodir-category-location">
                                                    <a href="javascript:;" ><i class="fas fa-map-marker-alt"></i> {{$property->location}}</a>
                                                </div>
                                                <ul class="list-single-opt_header_cat">
                                                    <li>
                                                        @if($property->sale_type == 1 || $property->sale_type == 3)
                                                            <a href="#" class="cat-opt">{{ __('messages.buy') }}</a>
                                                        @endif
                                                        @if($property->sale_type == 2 || $property->sale_type == 3)
                                                            <a href="#" class="cat-opt" >{{ __('messages.rent') }}</a>
                                                        @endif
                                                    </li>
                                                    <li><a href="#" class="cat-opt">{{$property->property_type->name}}</a></li>
                                                </ul>
                                                <a href="javascript:;" class="geodir_save-btn tolt @if(Auth::check() && (Auth::user()->role != '1')) fav_prop @else modal-open @endif" data-id="{{$property->id}}" data-microtip-position="left" data-tooltip="@if(!$property->is_fav) {{ __('messages.add_to_favourites') }} @else {{ __('messages.remove_from_favourites') }} @endif">
                                                    <span><i class="fal fa-heart heart_{{$property->id}}" @if(!$property->is_fav) style="font-weight: 400" @endif></i></span>
                                                </a>

                                                <div class="geodir-category-listing_media-list">
                                                    <span><i class="fas fa-camera"></i> {{ count($property->images) }}</span>
                                                </div>
                                            </div>

                                            <div class="geodir-category-content">
                                                <h3 class="mb-1"><a href="{{ url('property-details/'.$property->slug) }}">{{$property->name}}</a></h3>
                                                <div class="geodir-category-content_price mb-1">
                                                    <span class="d-iline-block"> {{ moneyFormat($property->price) }}</span>
                                                    <span class="d-iline-block px-2 fw-normal">|</span>
                                                    <span class="d-iline-block  fw-normal"><i class="fa-solid fa-apartment me-2 ms-2 mb-0"></i><span>{{ __("messages.no") }}: {{$property->apartment_no}}</span></span>
                                                </div>
                                                <p class="txt-three-linesss">{{$property->short_description}}</p>
                                                <div class="geodir-category-content-details">
                                                    <ul>
                                                        <li><i class="fa-light fa-bed"></i><span>{{$property->bedrooms}}</span></li>
                                                        <li><i class="fa-light fa-bath"></i><span>{{$property->bathrooms}}</span></li>
                                                        <li><i class="fa-light fa-chart-area"></i><span>{{$property->area}} m2</span></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="geodir-category-footer ">
                                                     <div class="row g-2">
                                                <div class="col">
                                                    <a href="{{ url('property-details/'.$property->slug) }}" class="post-card_link mt-0 d-block " style="width: 100%;"><span>{{ __('messages.view_details') }}</span> </a>
                                                </div>
                                                <div class="col">
                                                    @if(Auth::check() && (Auth::user()->role != '1'))
                                                        <a href="{{ url('checkout', $property->id) }}" class="mt-0 d-block post-card_book" style="width: 100%">{{ __('messages.book_now') }}</a>
                                                    @else
                                                        <a href="javascript:;" class="mt-0 d-block post-card_book modal-open" style="width: 100%">{{ __('messages.book_now') }}</a>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    @endforeach


                                </div>
                                <!--listing-item-container end-->
                                  </div>
                                </div>
                                <div class="pagination-wrap">
                                    <!-- <div class="pagination">
                                        <a href="#" class="prevposts-link"><i class="fa fa-caret-left"></i></a>
                                        <a href="#" >1</a>
                                        <a href="#" class="current-page">2</a>
                                        <a href="#">3</a>
                                        <a href="#">4</a>
                                        <a href="#" class="nextposts-link"><i class="fa fa-caret-right"></i></a>
                                    </div> -->
                                    {!! $properties->appends(request()->input())->links('front_end.template.pagination') !!}
                                </div>
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
<script>
    $('#sort_sel').change(function() {
        var selectedValue = $(this).val();
        var currentUrl = window.location.href.split('?')[0];
        var queryString = window.location.search;
        var newQueryString = new URLSearchParams(queryString);
        newQueryString.delete('page');
        newQueryString.set('sort', selectedValue);
        var newUrl = currentUrl + '?' + newQueryString.toString();
        window.location.href = newUrl;
    });

    $('.unit_search').click(function() {
        var selectedValue = $("#unit_number").val();
        var currentUrl = window.location.href.split('?')[0];
        var queryString = window.location.search;
        var newQueryString = new URLSearchParams(queryString);
        newQueryString.delete('page');
        newQueryString.set('unit_number', selectedValue);
        var newUrl = currentUrl + '?' + newQueryString.toString();
        window.location.href = newUrl;
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
    });
    $(".bed_bath").change(function(){
        var bed_val = $('.bedrooms:checked').val() || '';
        var bath_val = $('.bathrooms:checked').val() || '';
        var text = '  {{ __('messages.room_baths') }}';
        if(bed_val && bath_val){
            var bed_text = bed_val == "0" ? '{{ __('messages.studio') }}' : bed_val + ' {{ __('messages.beds') }}';
            text = bed_text + ' & ' + bath_val + ' {{ __('messages.baths') }}';
        }else if(bed_val){
            text = bed_val == "0" ? '{{ __('messages.studio') }}' : bed_val + ' {{ __('messages.beds') }}';
        }else if(bath_val){
            text = bath_val+'{{ __('messages.baths') }}';
        }
        $(".room_bath_btn").text(text)
    });
    $(".clear_bath_bed").click(function(){
        $(".room_bath_btn").click();
        $(".room_bath_btn").text('Room & Baths');
        $('.bedrooms:checked').prop('checked', false);
        $('.bathrooms:checked').prop('checked', false);
    });
    $(".clear_price").click(function(){
        $(".price_button").click();
        $(".price_button").text('Price');
        $('#price_from').val('');
        $('#price_to').val('');
    });
</script>
@stop
