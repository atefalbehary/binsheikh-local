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
                                                        <li><a href="{{ url('my-profile') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.profile') }}</a></li>
                                                        
                                                        @if(\Auth::user()->role == 4)
                                                            <!-- Agency Role (role 4) - Show Employees -->
                                                            <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
                                                        @endif
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.my_favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
                                                            <li><a href="{{ url('visit-schedule') }}">{{ __('messages.my_visit_schedule') }}</a></li>
                                                        @endif
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
                                                            @if(\Auth::user()->role == 3)
                                                                <!-- Agent View Fields -->
                                                                <!-- <div class="cs-intsputwrap agent_div">
                                                                    <label for="id_no" style="float:left">{{ __('messages.id_number') }}</label>
                                                                    <input type="text" placeholder="{{ __('messages.id_number') }}" class="form-control agent_inp" name="id_no" required data-parsley-required-message="{{ __('messages.enter_id') }}" value="{{ \Auth::user()->id_no }}">
                                                                </div> -->
                                                                
                                                                <div class="cs-intsputwrap agent_div">
                                                                    <label for="agency_name" style="float:left">{{ __('messages.agency_name') }}</label>
                                                                    <input type="text" placeholder="{{ __('messages.agency_name') }}" class="form-control agent_inp" name="agency_name" value="{{ \Auth::user()->agency ? \Auth::user()->agency->name : '' }}" readonly>
                                                                </div>
                                                                
                                                                <div class="file-view-container">
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-id-card"></i>
                                                                            <span>{{ __('messages.id_card') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->id_card)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->id_card) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-file-certificate"></i>
                                                                            <span>{{ __('messages.professional_license') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->license)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->license) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
{{--                                                                <div class="cs-intsputwrap agent_agency_div mt-4 mb-5">--}}
{{--                                                                    <label for="d" style="float:left">{{ __('messages.professional_practice_certificate') }}</label> <!-- Translated License -->--}}
{{--                                                                    <input type="file" class="form-control agent_agency_inp" name="professional_practice_certificate" data-parsley-required-message="{{ __('messages.select_professional_practice_certificate') }}"--}}
{{--                                                                        data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"--}}
{{--                                                                        data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"--}}
{{--                                                                        data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"--}}
{{--                                                                        accept="image/*,application/pdf">--}}
{{--                                                                        <a style="float: left;" href="{{ aws_asset_path(Auth::user()->professional_practice_certificate) }}" target="_blank" rel="noopener noreferrer">{{ __('messages.view_professional_practice_certificate') }}</a>--}}
{{--                                                                </div>--}}

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
                                                                <!-- Agency View Fields -->
                                                                <!-- <div class="cs-intsputwrap agent_agency_div">
                                                                    <label for="company_number" style="float:left">{{ __('messages.company_number') }}</label>
                                                                    <input type="text" placeholder="{{ __('messages.company_number') }}" class="form-control agent_agency_inp" name="company_number" value="{{ \Auth::user()->company_number }}">
                                                                </div> -->
                                                                
                                                                <div class="file-view-container">
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-certificate"></i>
                                                                            <span>{{ __('messages.trade_license') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->license)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->license) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-building"></i>
                                                                            <span>{{ __('messages.cr') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->cr)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->cr) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-file-certificate"></i>
                                                                            <span>{{ __('messages.professional_license') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->professional_practice_certificate)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->professional_practice_certificate) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="file-view-item">
                                                                        <div class="file-view-label">
                                                                            <i class="fa-light fa-signature"></i>
                                                                            <span>{{ __('messages.authorized_signatory') }}</span>
                                                                        </div>
                                                                        @if(\Auth::user()->authorized_signatory)
                                                                            <button type="button" class="view-file-btn" onclick="window.open('{{ aws_asset_path(\Auth::user()->authorized_signatory) }}', '_blank')">
                                                                                <i class="fa-light fa-eye"></i>
                                                                                {{ __('messages.view') }}
                                                                            </button>
                                                                        @else
                                                                            <span class="no-file-text">{{ __('messages.no_file_uploaded') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
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

                                                            <!-- <div class="cs-intputwrap">
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
 -->
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
                                                            <div class="d-flex gap-2">
                                                                <button class="commentssubmit flex-grow-1">{{ __('messages.update') }}</button>
                                                                <button type="button" class="btn btn-outline-warning" id="forgetPasswordBtn">{{ __('messages.forget_password') }}</button>
                                                            </div>
                                                        </form>

                                                        @if(Auth::user()->role == 4)

                                                                <!-- <form  style="margin-top: 20px"  data-parsley-validate="true">

                                                                    <div class="dashboard-widget-title-single">{{ __('messages.additional_information') }}</div>
                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold" style="font-size: large;font-weight: bold">{{ __('messages.commission_number') }}</label>
                                                                        <p class="mt-2" style="text-align: center">{{ \Auth::user()->commission_number ?? __('messages.not_set') }}</p>
                                                                    </div>

                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold" style="font-size: large;font-weight: bold">{{ __('messages.discount_number') }}</label>
                                                                        <p class="mt-2" style="text-align: center">{{ \Auth::user()->discount_number ?? __('messages.not_set') }}</p>
                                                                    </div>

                                                                    <div class="cs-intputwrap pass-input-wrap">
                                                                        <label class="font-weight-bold" style="font-size: large;font-weight: bold">{{ __('messages.apartments_for_sale') }}</label>
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
                                                                </form> -->

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

                    <!-- Forget Password Modal -->
                    <div class="modal fade" id="forgetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgetPasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content custom-modal-content">
                                <div class="modal-header custom-modal-header">
                                    <button type="button" class="close custom-close-btn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <div class="modal-icon-section">
                                        <div class="lock-icon-container">
                                            <i class="fa-light fa-lock lock-icon"></i>
                                        </div>
                                        <div class="sparkle-icons">
                                            <i class="fa-solid fa-star sparkle-1"></i>
                                            <i class="fa-solid fa-star sparkle-2"></i>
                                        </div>
                                    </div>
                                    
                                    <h4 class="modal-title custom-modal-title">{{ __('messages.please_enter_your_email') }}</h4>
                                    
                                    <form id="forgetPasswordForm" action="{{ url('forget_password') }}" method="POST">
                                        @csrf
                                        <div class="email-input-container">
                                            <input type="email" class="custom-email-input" name="email" placeholder="Email@gmail.com" required>
                                        </div>
                                        <button type="submit" class="custom-send-otp-btn">{{ __('messages.send_otp') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OTP Verification Modal -->
                    <div class="modal fade" id="otpVerificationModal" tabindex="-1" role="dialog" aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content custom-modal-content">
                                <div class="modal-header custom-modal-header">
                                    <button type="button" class="close custom-close-btn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <div class="modal-icon-section">
                                        <div class="lock-icon-container">
                                            <i class="fa-light fa-lock lock-icon"></i>
                                        </div>
                                        <div class="sparkle-icons">
                                            <i class="fa-solid fa-star sparkle-1"></i>
                                            <i class="fa-solid fa-star sparkle-2"></i>
                                        </div>
                                    </div>
                                    
                                    <h4 class="modal-title custom-modal-title">{{ __('messages.please_enter_your_otp') }}</h4>
                                    <p class="otp-instruction">{{ __('messages.otp_instruction') }}</p>
                                    
                                    <form id="otpVerificationForm" action="{{ url('verify_forget_password_otp') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="otp_email">
                                        <div class="otp-input-container">
                                            <input type="text" class="otp-input" maxlength="1" data-index="0" required>
                                            <input type="text" class="otp-input" maxlength="1" data-index="1" required>
                                            <input type="text" class="otp-input" maxlength="1" data-index="2" required>
                                            <input type="text" class="otp-input" maxlength="1" data-index="3" required>
                                            <input type="text" class="otp-input" maxlength="1" data-index="4" required>
                                            <input type="text" class="otp-input" maxlength="1" data-index="5" required>
                                        </div>
                                        <button type="submit" class="custom-verify-btn">{{ __('messages.verify') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Password Modal -->
                    <div class="modal fade" id="newPasswordModal" tabindex="-1" role="dialog" aria-labelledby="newPasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content custom-modal-content">
                                <div class="modal-header custom-modal-header">
                                    <button type="button" class="close custom-close-btn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body custom-modal-body">
                                    <div class="modal-icon-section">
                                        <div class="check-icon-container">
                                            <i class="fa-light fa-check check-icon"></i>
                                        </div>
                                        <div class="sparkle-icons">
                                            <i class="fa-solid fa-star sparkle-1"></i>
                                            <i class="fa-solid fa-star sparkle-2"></i>
                                        </div>
                                    </div>
                                    
                                    <h4 class="modal-title custom-modal-title">{{ __('messages.verified_please_enter_new_password') }}</h4>
                                    
                                    <form id="newPasswordForm" action="{{ url('update_forget_password') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="new_password_email">
                                        <div class="new-password-input-container">
                                            <input type="password" class="custom-new-password-input" name="new_password" placeholder="{{ __('messages.new_password') }}" required>
                                        </div>
                                        <button type="submit" class="custom-update-btn">{{ __('messages.update') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@stop

@section('script')
<script>
$(document).ready(function() {
    // Open forget password modal
    $('#forgetPasswordBtn').click(function() {
        $('#forgetPasswordModal').modal('show');
    });
    
    // Close modal functionality for all modals
    $('.custom-close-btn').click(function() {
        $(this).closest('.modal').modal('hide');
    });
    
    // Close modal when clicking outside
    $('.modal').on('click', function(e) {
        if (e.target === this) {
            $(this).modal('hide');
        }
    });
    
    // Close modal with escape key
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // Escape key
            $('.modal.show').modal('hide');
        }
    });
    
    // Handle forget password form submission
    $('#forgetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.text();
        var email = $(this).find('input[name="email"]').val();
        
        // Show loading state
        submitBtn.prop('disabled', true).text('{{ __("messages.sending") }}...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    alert('{{ __("messages.otp_sent_successfully") }}');
                    $('#forgetPasswordModal').modal('hide');
                    // Set email for OTP verification
                    $('#otp_email').val(email);
                    // Open OTP verification modal
                    $('#otpVerificationModal').modal('show');
                    // Reset form
                    $('#forgetPasswordForm')[0].reset();
                } else {
                    alert(response.message || '{{ __("messages.something_went_wrong") }}');
                }
            },
            error: function(xhr) {
                var errorMessage = '{{ __("messages.something_went_wrong") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
    
    // OTP Input handling
    $('.otp-input').on('input', function() {
        var currentIndex = parseInt($(this).data('index'));
        var value = $(this).val();
        
        // Move to next input if current input has value
        if (value.length === 1 && currentIndex < 5) {
            $('.otp-input[data-index="' + (currentIndex + 1) + '"]').focus();
        }
    });
    
    // Handle backspace in OTP inputs
    $('.otp-input').on('keydown', function(e) {
        var currentIndex = parseInt($(this).data('index'));
        
        if (e.keyCode === 8 && $(this).val() === '' && currentIndex > 0) {
            $('.otp-input[data-index="' + (currentIndex - 1) + '"]').focus();
        }
    });
    
    // Handle OTP verification form submission
    $('#otpVerificationForm').on('submit', function(e) {
        e.preventDefault();
        
        var otp = '';
        $('.otp-input').each(function() {
            otp += $(this).val();
        });
        
        if (otp.length !== 6) {
            alert('{{ __("messages.please_enter_complete_otp") }}');
            return;
        }
        
        var formData = {
            email: $('#otp_email').val(),
            otp: otp,
            _token: $('input[name="_token"]').val()
        };
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.text();
        
        // Show loading state
        submitBtn.prop('disabled', true).text('{{ __("messages.verifying") }}...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('{{ __("messages.otp_verified_successfully") }}');
                    $('#otpVerificationModal').modal('hide');
                    // Set email for new password form
                    $('#new_password_email').val($('#otp_email').val());
                    // Open new password modal
                    $('#newPasswordModal').modal('show');
                    // Reset OTP inputs
                    $('.otp-input').val('');
                } else {
                    alert(response.message || '{{ __("messages.invalid_otp") }}');
                }
            },
            error: function(xhr) {
                var errorMessage = '{{ __("messages.something_went_wrong") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
    
    // Handle new password form submission
    $('#newPasswordForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.text();
        
        // Show loading state
        submitBtn.prop('disabled', true).text('{{ __("messages.updating") }}...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('{{ __("messages.password_updated_successfully") }}');
                    $('#newPasswordModal').modal('hide');
                    // Reset form
                    $('#newPasswordForm')[0].reset();
                    // Redirect to login or reload page
                    window.location.reload();
                } else {
                    alert(response.message || '{{ __("messages.something_went_wrong") }}');
                }
            },
            error: function(xhr) {
                var errorMessage = '{{ __("messages.something_went_wrong") }}';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
});
</script>

<style>
/* Modal Container */
.custom-modal-content {
    background: white;
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    max-width: 400px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}

/* Modal Header */
.custom-modal-header {
    border: none;
    padding: 0;
    position: relative;
    height: 50px;
}

.custom-close-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #f5f5f5;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #666;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
}

.custom-close-btn:hover {
    background: #e0e0e0;
    color: #333;
}

.custom-close-btn span {
    font-size: 18px;
    font-weight: 300;
}

/* Modal Body */
.custom-modal-body {
    padding: 40px 30px 30px;
    text-align: center;
}

/* Icon Section */
.modal-icon-section {
    position: relative;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lock-icon-container {
    width: 100px;
    height: 100px;
    background: #f4e4bc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 8px 25px rgba(244, 228, 188, 0.4);
}

.lock-icon {
    font-size: 2.5rem;
    color: white;
    font-weight: 300;
}

.sparkle-icons {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.sparkle-1, .sparkle-2 {
    position: absolute;
    color: #f4e4bc;
    font-size: 1.2rem;
    animation: sparkle 2s ease-in-out infinite;
}

.sparkle-1 {
    top: 15px;
    right: 20px;
    animation-delay: 0s;
}

.sparkle-2 {
    top: 25px;
    right: 35px;
    animation-delay: 1s;
}

@keyframes sparkle {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.2); }
}

/* Modal Title */
.custom-modal-title {
    color: #333;
    font-size: 1.4rem;
    font-weight: 500;
    margin-bottom: 30px;
    line-height: 1.3;
}

/* Email Input */
.email-input-container {
    margin-bottom: 25px;
}

.custom-email-input {
    width: 100%;
    padding: 15px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    font-size: 16px;
    background: white;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.custom-email-input:focus {
    outline: none;
    border-color: #f4e4bc;
    box-shadow: 0 0 0 3px rgba(244, 228, 188, 0.2);
}

.custom-email-input::placeholder {
    color: #999;
    font-style: italic;
}

/* Send OTP Button */
.custom-send-otp-btn {
    width: 100%;
    padding: 15px 20px;
    background: #f4e4bc;
    border: none;
    border-radius: 12px;
    color: #333;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
    letter-spacing: 0.5px;
}

.custom-send-otp-btn:hover {
    background: #e6d4a8;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(244, 228, 188, 0.4);
}

.custom-send-otp-btn:active {
    transform: translateY(0);
}

.custom-send-otp-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* OTP Instruction Text */
.otp-instruction {
    color: #666;
    font-size: 14px;
    margin-bottom: 25px;
    line-height: 1.4;
}

/* OTP Input Container */
.otp-input-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 25px;
}

/* Individual OTP Input */
.otp-input {
    width: 45px;
    height: 45px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    background: white;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.otp-input:focus {
    outline: none;
    border-color: #f4e4bc;
    box-shadow: 0 0 0 3px rgba(244, 228, 188, 0.2);
}

.otp-input:valid {
    border-color: #28a745;
}

/* Verify Button */
.custom-verify-btn {
    width: 100%;
    padding: 15px 20px;
    background: #f4e4bc;
    border: none;
    border-radius: 12px;
    color: #333;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
    letter-spacing: 0.5px;
}

.custom-verify-btn:hover {
    background: #e6d4a8;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(244, 228, 188, 0.4);
}

.custom-verify-btn:active {
    transform: translateY(0);
}

.custom-verify-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Check Icon Container */
.check-icon-container {
    width: 100px;
    height: 100px;
    background: #f4e4bc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    box-shadow: 0 8px 25px rgba(244, 228, 188, 0.4);
}

.check-icon {
    font-size: 2.5rem;
    color: white;
    font-weight: 300;
}

/* New Password Input */
.new-password-input-container {
    margin-bottom: 25px;
}

.custom-new-password-input {
    width: 100%;
    padding: 15px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    font-size: 16px;
    background: white;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.custom-new-password-input:focus {
    outline: none;
    border-color: #f4e4bc;
    box-shadow: 0 0 0 3px rgba(244, 228, 188, 0.2);
}

.custom-new-password-input::placeholder {
    color: #999;
    font-style: italic;
}

/* Update Button */
.custom-update-btn {
    width: 100%;
    padding: 15px 20px;
    background: #f4e4bc;
    border: none;
    border-radius: 12px;
    color: #333;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
    letter-spacing: 0.5px;
}

.custom-update-btn:hover {
    background: #e6d4a8;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(244, 228, 188, 0.4);
}

.custom-update-btn:active {
    transform: translateY(0);
}

.custom-update-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Button Layout */
.d-flex.gap-2 {
    gap: 10px;
}

.btn-outline-warning {
    border-color: #f4e4bc;
    color: #f4e4bc;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    background: transparent;
}

.btn-outline-warning:hover {
    background-color: #f4e4bc;
    border-color: #f4e4bc;
    color: #333;
}

/* File View Container Styling */
.file-view-container {
    margin: 20px 0;
    padding: 0;
}

.file-view-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.file-view-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #f4e4bc 0%, #e6d4a8 100%);
    border-radius: 0 2px 2px 0;
}

.file-view-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-color: #f4e4bc;
}

.file-view-label {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 15px;
}

.file-view-label i {
    color: #f4e4bc;
    font-size: 18px;
    width: 20px;
    text-align: center;
}

.view-file-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #f4e4bc 0%, #e6d4a8 100%);
    border: none;
    border-radius: 8px;
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(244, 228, 188, 0.3);
    text-decoration: none;
}

.view-file-btn:hover {
    background: linear-gradient(135deg, #e6d4a8 0%, #d4c19a 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(244, 228, 188, 0.4);
    color: #2c3e50;
    text-decoration: none;
}

.view-file-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(244, 228, 188, 0.3);
}

.view-file-btn i {
    font-size: 14px;
}

.no-file-text {
    color: #6c757d;
    font-style: italic;
    font-size: 14px;
    padding: 10px 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px dashed #dee2e6;
}

/* Responsive Design */
@media (max-width: 480px) {
    .custom-modal-content {
        margin: 20px;
        max-width: none;
    }
    
    .custom-modal-body {
        padding: 30px 20px 20px;
    }
    
    .lock-icon-container {
        width: 80px;
        height: 80px;
    }
    
    .lock-icon {
        font-size: 2rem;
    }
    
    .custom-modal-title {
        font-size: 1.2rem;
    }
    
    .file-view-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .file-view-label {
        width: 100%;
    }
    
    .view-file-btn {
        align-self: flex-end;
    }
}
</style>
@stop
