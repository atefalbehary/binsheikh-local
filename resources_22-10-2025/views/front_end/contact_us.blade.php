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
                                                  <h2>Contact Us</h2>

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
        <a href="#">Home</a><span>Contacts</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div> -->
    <!--breadcrumbs-list end-->
    <!--main-content-->
    <div class="main-content ms_vir_height">
        <!--boxed-container-->
        <div class="boxed-container">
            <!-- contacts-cards-wrap -->
            <div class="contacts-cards-wrap">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{ __('messages.contact') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">{{ __('messages.career') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <div class="row">
                                    <!-- contacts-card-item -->
                                    <div class="col-lg-4">
                                        <div class="contacts-card-item">
                                            <i class="fa-regular fa-location-dot"></i>
                                            <span>{{ __('messages.contact_our_location') }}</span>
                                            <p>{{ __('messages.contact_our_location_address') }}</p>
                                        </div>
                                    </div>
                                    <!-- contacts-card-item end-->
                                    <!-- contacts-card-item -->
                                    <div class="col-lg-4">
                                        <div class="contacts-card-item">
                                            <i class="fa-regular fa-phone-rotary"></i>
                                            <span>{{ __('messages.contact_our_phone') }}</span>
                                            <p class="ar-change">+974 5025 8942, +974 3066 6004</p>
                                        </div>
                                    </div>
                                    <!-- contacts-card-item end-->
                                    <!-- contacts-card-item -->
                                    <div class="col-lg-4">
                                        <div class="contacts-card-item">
                                            <i class="fa-regular fa-mailbox"></i>
                                            <span>{{ __('messages.contact_our_mail') }}</span>
                                            <p>info@bsbqa.com</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="contacts-form-wrap">
                                    <div class="row">
                                        <!-- contacts-opt-wrap -->
                                        <div class="col-lg-6">
                                            <div class="boxed-content">
                                                <div class="boxed-content-title">
                                                    <h3>{{ __('messages.get_in_touch') }}</h3>
                                                </div>
                                                <div class="boxed-content-item">
                                                    <div class="comment-form custom-form contactform-wrap">
                                                        <form  class="comment-form" action="https://renstate.kwst.net/site/light/php/contact.php" name="contactform" id="contactform">
                                                            <fieldset>
                                                                <div id="message"></div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="cs-intputwrap">
                                                                            <i class="fa-light fa-user"></i>
                                                                            <input name="name" type="text" id="name" placeholder="{{ __('messages.your_name') }}" onClick="this.select()" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="cs-intputwrap">
                                                                            <i class="fa-light fa-envelope"></i>
                                                                            <input type="text" name="email" id="email" placeholder="{{ __('messages.email_address') }} *" onClick="this.select()" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <textarea name="comments" id="comments" cols="40" rows="3" placeholder="{{ __('messages.your_message') }}"></textarea>
                                                                <button class="commentssubmit" id="submit_cnt" style="margin-top: 20px">{{ __('messages.send_message') }}</button>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- contacts-opt-wrap end-->
                                        <!-- contacts-opt-wrap -->
                                        <div class="col-lg-6">
                                            <div class="map-container mapC_vis3">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.9346727466905!2d51.50706587504502!3d25.272782928635696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e45db415c257fff%3A0x3222514b8441cdb2!2sBin%20Al%20Sheikh%20Towers!5e0!3m2!1sen!2sin!4v1731162658836!5m2!1sen!2sin" width="100%" height="490" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <div class="row">
                                    <!-- contacts-opt-wrap -->
                                    <div class="col-md-8" style="text-align: initial">
                                        <h3 style="font-size: 26px; font-weight: 600; margin-bottom: 20px; ">{{ __('messages.job_openings') }}</h3>
                                        @foreach ($careers as $career)
                                            <div class="pricing-column mb-2 ">
                                                <div class="pricing-header">
                                                    <h3>{{$career->name}}</h3>

                                                    {!!$career->description!!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        <div style="background: #fff; padding: 25px; border-radius: 20px; ;">
                                            <div class="dasboard-content-item">
                                                <h3 style="font-size: 26px; font-weight: 600; margin-bottom: 20px; ">{{ __('messages.career_form') }}</h3>
                                                <form id="user-form" action="{{ url('frontend/apply_career') }}" data-parsley-validate="true">
                                                @csrf()
                                                    <div class="custom-form">
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-user"></i>
                                                            <input type="text" class="" placeholder="{{ __('messages.name') }}" name="name" required
                                                            data-parsley-required-message="{{ __('messages.name_required') }}">
                                                        </div>
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-phone-office"></i>
                                                            <input type="text" placeholder="{{ __('messages.phone') }}" name="phone" required
                                                            data-parsley-required-message="{{ __('messages.phone_required') }}">
                                                        </div>
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-envelope"></i>
                                                            <input type="text" name="email" placeholder="{{ __('messages.email') }}" required
                                                            data-parsley-required-message="{{ __('messages.email_required') }}">
                                                        </div>

                                                        <div class="cs-intputwrap">
                                                            <select name="job_position" data-placeholder="{{ __('messages.job_position') }}" class="chosen-select on-radius no-search-select" required
                                                            data-parsley-required-message="{{ __('messages.job_position_required') }}" data-parsley-errors-container="#jp_err">
                                                            <option value="">{{ __('messages.job_position') }}</option>
                                                                @foreach ($careers as $career)
                                                                    <option value="{{$career->id}}">{{$career->name}}</option>
                                                                @endforeach

                                                            </select>
                                                            <span id="jp_err"></span>
                                                        </div>
                                                        <div class="fuzone">
                                                            <div class="fu-text">
                                                                <span><i class="fa-light fa-cloud-arrow-up"></i> {{ __('messages.upload_cv') }}</span>
                                                                <div class="photoUpload-files fl-wrap"></div>
                                                            </div>
                                                            <input type="file" class="upload" name="cv" required data-parsley-required-message="{{ __('messages.select_cv') }}"
                                                                data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                accept="image/*,application/pdf">
                                                        </div>
                                                        <button class="post-card_link mt-0 " style="min-width: 150px;">{{ __('messages.submit') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button trigger modal -->
                                    <!-- Modal -->

                                    <!-- contacts-card-item end-->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- contacts-cards-wrap end   -->
        </div>
        <!--boxed-container end-->
    </div>
</div>


@stop

@section('script')

@stop
