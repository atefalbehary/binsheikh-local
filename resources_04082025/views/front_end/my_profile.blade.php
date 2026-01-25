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
                        <div class="main-content  ms_vir_heigh mt-5 pt-5">
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
                                                        <li><a href="{{ url('my-profile') }}" class="act-scrlink">{{ __('messages.profile') }}</a></li>
                                                        <li><a href="{{ url('my-bookings') }}">{{ __('messages.my_bookings') }}</a></li>
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                    </ul>
                                                    <a href="{{ url('user/logout') }}" class="hum_log-out_btn"><i class="fa-light fa-power-off"></i> {{ __('messages.log_out') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- user-dasboard-menu_wrap end-->
                                    <!-- pricing-column -->
                                    <div class="col-lg-9">
                                        <div class="db-container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="custom-form bg-white p-4 h-100">
                                                        <div class="dashboard-widget-title-single">{{ __('messages.profile') }}</div>
                                                        <form id="user-form" action="{{ url('update_profile') }}" data-parsley-validate="true">
                                                            @csrf()
                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-user"></i>
                                                                <input type="text" placeholder="{{ __('messages.full_name') }}" name="name" required data-parsley-required-message="{{ __('messages.enter_name') }}" value="{{ \Auth::user()->name }}">
                                                            </div>
                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-mobile"></i>
                                                                <input type="text" placeholder="{{ __('messages.phone_number') }}" name="phone" required data-parsley-required-message="{{ __('messages.enter_phone') }}" value="{{ \Auth::user()->phone }}">
                                                            </div>
                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-envelope"></i>
                                                                <input type="email" placeholder="{{ __('messages.email_address') }}" name="email" required data-parsley-required-message="{{ __('messages.enter_email') }}" value="{{ \Auth::user()->email }}">
                                                            </div>
                                                            @if(\Auth::user()->role == 3 || \Auth::user()->role == 4)

                                                                <div class="cs-intsputwrap agent_agency_div">
                                                                    <input type="text" placeholder="ID" class="form-control agent_agency_inp" name="id_no" required data-parsley-required-message="{{ __('messages.enter_id') }}" value="{{ \Auth::user()->id_no }}">
                                                                </div>

                                                                <div class="cs-intsputwrap agent_agency_div mt-4 mb-5">
                                                                    <label for="d" style="float:left">{{ __('messages.professional_practice_certificate') }}</label> <!-- Translated License -->
                                                                    <input type="file" class="form-control agent_agency_inp" name="professional_practice_certificate" data-parsley-required-message="{{ __('messages.select_professional_practice_certificate') }}"
                                                                        data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                        data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                        accept="image/*,application/pdf">
                                                                        <a style="float: left;" href="{{ aws_asset_path(Auth::user()->professional_practice_certificate) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_professional_practice_certificate') }}</a>
                                                                </div>

                                                                {{-- <div class="cs-intsputwrap agent_agency_div">
                                                                    <label for="d" style="float:left" id="license_label">{{ \Auth::user()->role == 4 ? __('messages.trade_license') : '' }}</label>
                                                                    <input type="file" class="form-control agent_agency_inp" name="license" data-parsley-required-message="{{ __('messages.select_license') }}" data-parsley-trigger="change"
                                                                        data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                        data-parsley-max-file-size="5120"
                                                                        data-parsley-max-file-size-message="{{ __('messages.max_file_size') }}" accept="image/*,application/pdf">
                                                                    <a style="float: left;" href="{{ aws_asset_path(Auth::user()->license) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_license') }}</a>
                                                                </div>

                                                                <div class="cs-intsputwrap agent_agency_div">
                                                                    <label for="d" style="float:left">{{ __('messages.id') }}</label>
                                                                    <input type="file" class="form-control agent_agency_inp" name="id_card" data-parsley-required-message="{{ __('messages.select_id') }}" data-parsley-trigger="change"
                                                                        data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                        data-parsley-max-file-size="5120"
                                                                        data-parsley-max-file-size-message="{{ __('messages.max_file_size') }}" accept="image/*,application/pdf">
                                                                    <a style="float: left;" href="{{ aws_asset_path(Auth::user()->id_card) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_id') }}</a>
                                                                </div> --}}
                                                            @endif
                                                            @if(Auth::user()->role == 4)
                                                                {{-- <div class="cs-intsputwrap agency_div">
                                                                    <label for="d" style="float:left">{{ __('messages.cr') }}</label>
                                                                    <input type="file" class="form-control agency_inp" name="cr" data-parsley-required-message="{{ __('messages.select_cr') }}" data-parsley-trigger="change"
                                                                        data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                        data-parsley-max-file-size="5120"
                                                                        data-parsley-max-file-size-message="{{ __('messages.max_file_size') }}" accept="image/*,application/pdf">
                                                                    <a style="float: left;" href="{{ aws_asset_path(Auth::user()->cr) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_cr') }}</a>
                                                                </div>

                                                                <div class="cs-intsputwrap agency_div">
                                                                    <label for="d" style="float:left">{{ __('messages.real_estate_license') }}</label>
                                                                    <input type="file" class="form-control agency_inp" name="real_estate_license" data-parsley-required-message="{{ __('messages.select_real_estate_license') }}" data-parsley-trigger="change"
                                                                        data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                        data-parsley-max-file-size="5120"
                                                                        data-parsley-max-file-size-message="{{ __('messages.max_file_size') }}" accept="image/*,application/pdf">
                                                                    <a style="float: left;" href="{{ aws_asset_path(Auth::user()->real_estate_license) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_real_estate_license') }}</a>
                                                                </div> --}}
                                                            @endif

                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-map"></i>
                                                                <input type="text" maxlength="255" placeholder="{{ __('messages.address') }}" name="address" required data-parsley-required-message="{{ __('messages.enter_address') }}" value="{{ \Auth::user()->address }}">
                                                            </div>

                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-map"></i>
                                                                <input maxlength="32" type="text" placeholder="{{ __('messages.city') }}" name="city" required data-parsley-required-message="{{ __('messages.enter_city') }}" value="{{ \Auth::user()->city }}">
                                                            </div>

                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-map"></i>
                                                                <input maxlength="32" type="text" placeholder="{{ __('messages.state') }}" name="state" required data-parsley-required-message="{{ __('messages.enter_state') }}" value="{{ \Auth::user()->state }}">
                                                            </div>

                                                            <div class="cs-intputwrap">
                                                                <i class="fa-light fa-map"></i>
                                                                <input maxlength="10" type="text" placeholder="{{ __('messages.postal_code') }}" name="postal_code" required data-parsley-required-message="{{ __('messages.enter_postal_code') }}" value="{{ \Auth::user()->postal_code }}">
                                                            </div>

                                                            <div class="cs-intputwrap">
                                                                <select class="form-control" name="country_id" required data-parsley-required-message="{{ __('messages.select_country') }}">
                                                                    <option value="">{{ __('messages.select_country') }}</option>
                                                                    @foreach($countries as $val)
                                                                        <option @if($val->code_iso == Auth::user()->country_id) selected @endif value="{{ $val->code_iso }}">{{ $val->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <br><br>

                                                            <button class="commentssubmit">{{ __('messages.update') }}</button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="custom-form bg-white p-4 h-100">
                                                        <form id="user-form" action="{{ url('change_password') }}" data-parsley-validate="true">
                                                            @csrf()
                                                            <div class="dashboard-widget-title-single">{{ __('messages.change_password') }}</div>
                                                            <div class="cs-intputwrap pass-input-wrap">
                                                                <i class="fa-light fa-lock-open"></i>
                                                                <input type="password" class="pass-input" placeholder="{{ __('messages.current_password') }}" name="cur_password" required data-parsley-required-message="{{ __('messages.enter_current_password') }}">
                                                                <div class="view-pass"></div>
                                                            </div>

                                                            <div class="cs-intputwrap pass-input-wrap">
                                                                <i class="fa-light fa-lock"></i>
                                                                <input type="password" class="pass-input" placeholder="{{ __('messages.new_password') }}" name="password" required data-parsley-required-message="{{ __('messages.enter_new_password') }}" id="new_pswd">
                                                                <div class="view-pass"></div>
                                                            </div>

                                                            <div class="cs-intputwrap pass-input-wrap">
                                                                <i class="fa-light fa-shield-check"></i>
                                                                <input type="password" class="pass-input" placeholder="{{ __('messages.confirm_new_password') }}" name="password_confirmation" required data-parsley-required-message="{{ __('messages.confirm_new_password') }}" data-parsley-equalto="#new_pswd" data-parsley-equalto-message="{{ __('messages.password_mismatch') }}">
                                                                <div class="view-pass"></div>
                                                            </div>
                                                            <button class="commentssubmit">{{ __('messages.update') }}</button>
                                                        </form>

                                                        @if(\Auth::user()->role == 3 || \Auth::user()->role == 4)

                                                                <form  style="margin-top: 20px"  data-parsley-validate="true">

                                                                    <div class="dashboard-widget-title-single">{{ __('messages.additional_information') }}</div>
                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold">{{ __('messages.commission_number') }}</label>
                                                                        <p class="mt-2" style="text-align: center">{{ \Auth::user()->commission_number ?? __('messages.not_set') }}</p>
                                                                    </div>

                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold">{{ __('messages.discount_number') }}</label>
                                                                        <p class="mt-2" style="text-align: center">{{ \Auth::user()->discount_number ?? __('messages.not_set') }}</p>
                                                                    </div>

                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold">{{ __('messages.apartments_for_sale') }}</label>
                                                                        <div class="mt-2">
                                                                            @php
                                                                                $apartment_ids = explode(',', \Auth::user()->apartment_sell);
                                                                                $apartments = \App\Models\Properties::whereIn('id', $apartment_ids)->get();
                                                                            @endphp
                                                                            @foreach($apartments as $apartment)
                                                                                <span style="text-align: left" class="badge badge-info mr-2 mb-2">{{ $apartment->name }} ({{ $apartment->apartment_no }})</span>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                        @endif
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
@stop

@section('script')

@stop
