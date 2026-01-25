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
                                                        
                                                        @if(\Auth::user()->role == 4)
                                                            <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
                                                        @endif
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.my_favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
                                                            <li><a href="{{ url('visit-schedule') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.my_visit_schedule') }}</a></li>
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


                                            <div class="custom-form bg-white p-4 h-100">


                                            <div class="dashboard-title">
                                                <div class="dashboard-title-item"><span>{{ __('messages.visit_schedule') }}</span></div>
                                                <div class="dashboard-title-actions">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitScheduleModal">
                                                        <i class="fas fa-plus"></i> {{ __('messages.add_new_visit_schedule') }}
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Search and Filters -->
                                            <div class="visit-schedule-header">
                                                <div class="search-section">
                                                    <div class="search-bar">
                                                        <input type="text" class="form-control" placeholder="{{ __('messages.search_by_name_email_phone') }}" id="visitScheduleSearch">
                                                    </div>
                                                </div>
                                                
                                                <div class="filters-section">
                                                    <div class="date-filters">
                                                        <div class="date-input">
                                                            <label>{{ __('messages.from') }}</label>
                                                            <input type="date" class="form-control" id="fromDateVisit">
                                                        </div>
                                                        <div class="date-input">
                                                            <label>{{ __('messages.to') }}</label>
                                                            <input type="date" class="form-control" id="toDateVisit">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="selection-info">
                                                        <span id="selectedCountVisit">0 of 0 {{ __('messages.visits_selected') }}</span>
                                                    </div>
                                                    
                                                    <div class="action-buttons">
                                                        <button class="btn btn-primary btn-sm" id="exportVisitSchedulesBtn">{{ __('messages.export') }}</button>
                                                        <button class="btn btn-danger btn-sm" id="deleteVisitSchedulesBtn">{{ __('messages.delete') }}</button>
                                                    </div>
                                                </div>
                                            </div>



                                            <table class="table table-hover" id="visitScheduleTable">
                                                <thead>
                                                    <tr>
                                                        <th width="50">
                                                            <input type="checkbox" id="selectAllVisits">
                                                        </th>
                                                        <th>{{ __('messages.agent_name') }}</th>
                                                        <th>{{ __('messages.unit_type') }}</th>
                                                        <th>{{ __('messages.phone_number') }}</th>
                                                        <th>{{ __('messages.date_of_visit') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($visits ?? [] as $index => $visit)
                                                    <!-- Main Row -->
                                                    <tr class="main-row" data-id="{{ $visit->id }}">
                                                        <td>
                                                            <input type="checkbox" class="visit-checkbox" value="{{ $visit->id }}">
                                                        </td>
                                                        <td>
                                                            <div class="client-info">
                                                                <div class="client-avatar">
                                                                    <i class="fas fa-user"></i>
                                                                    <div class="status-dot"></div>
                                                                </div>
                                                                <span class="client-name">{{ $visit->agent->name ?? 'N/A' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $visit->unit_type ?? 'N/A' }}</td>
                                                        <td>{{ $visit->client_phone_number ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="visit-section">
                                                                <span class="visit-date" data-date="{{ $visit->visit_time }}">{{ web_date_in_timezone($visit->visit_time, 'd-M-Y') }}</span>
                                                                <button class="btn btn-sm btn-info">View</button>
                                                                <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <!-- Detail Row -->
                                                    <tr class="detail-row" data-parent="{{ $visit->id }}" style="display: none;">
                                                        <td colspan="5">
                                                            <div class="detail-content">
                                                                <div class="schedule-info-header">
                                                                    <h6>{{ __('messages.schedule_info') }}</h6>
                                                                    <div class="header-actions">
                                                                        <div class="form-indicator">
                                                                            <span class="badge badge-info">{{ __('messages.visit_scheduled') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="schedule-info-grid">
                                                                    <!-- Left Column -->
                                                                    <div class="info-column">
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-user"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.client_name') }}</label>
                                                                                <span>{{ $visit->client_name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-envelope"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.client_email_address') }}</label>
                                                                                <span>{{ $visit->client_email_address ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-building"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.project') }}</label>
                                                                                <span>{{ $visit->project->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-id-card"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.client_id') }}</label>
                                                                                @if($visit->client_id)
                                                                                    <a href="{{ aws_asset_path($visit->client_id) }}" target="_blank" class="btn btn-sm btn-info">
                                                                                        <i class="fas fa-eye"></i> {{ __('messages.view_client_id') }}
                                                                                    </a>
                                                                                @else
                                                                                    <span>N/A</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Right Column -->
                                                                    <div class="info-column">
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-phone"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.client_phone_number') }}</label>
                                                                                <span>{{ $visit->client_phone_number ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-clock"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.visit_time') }}</label>
                                                                                <span>{{ web_date_in_timezone($visit->visit_time, 'd-M-Y h:i A') ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-home"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.unit_type') }}</label>
                                                                                <span>{{ $visit->unit_type ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-user-tie"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.agent_name') }}</label>
                                                                                <span>{{ $visit->agent->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">{{ __('messages.no_visits_scheduled') }}</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>





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






                                                            <!-- Add Visit Schedule Modal -->
                                                            <div class="modal fade" id="addVisitScheduleModal" tabindex="-1" aria-labelledby="addVisitScheduleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content" style="max-height: 90vh;">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addVisitScheduleModalLabel">
                                                            <i class="fas fa-calendar-plus"></i> {{ __('messages.add_new_visit_schedule') }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form id="addVisitScheduleForm" action="{{ url('visit-schedule/store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="visit-schedule-form">
                                                                <!-- AGENT CONTACT INFO Section -->
                                                                <div class="form-section">
                                                                    <div class="section-header">
                                                                        <h6>{{ __('messages.agent_contact_info') }}</h6>
                                                                    </div>
                                                                    <div class="row">
                                                                        @if(\Auth::user()->role == 4)
                                                                        <!-- Agency: Show agent selection dropdown -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="selected_agent_id" class="form-label">{{ __('messages.select_agent') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                                                    <select class="form-control" id="selected_agent_id" name="selected_agent_id" required>
                                                                                        <option value="">{{ __('messages.select_agent') }}</option>
                                                                                        @if(isset($agents) && $agents->count() > 0)
                                                                                            @foreach($agents as $agent)
                                                                                                <option value="{{ $agent->id }}" data-phone="{{ $agent->phone ?? '' }}">{{ $agent->name }}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="agent_phone" class="form-label">{{ __('messages.phone_number') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                                                    <input type="tel" class="form-control" id="agent_phone" name="agent_phone" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @else
                                                                        <!-- Agent: Show readonly fields -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="agent_name" class="form-label">{{ __('messages.name') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                                    <input type="text" class="form-control" id="agent_name" name="agent_name" value="{{ \Auth::user()->name }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="agent_phone" class="form-label">{{ __('messages.phone_number') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                                                    <input type="tel" class="form-control" id="agent_phone" name="agent_phone" value="{{ \Auth::user()->phone ?? '' }}" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <!-- CLIENT CONTACT INFO Section -->
                                                                <div class="form-section">
                                                                    <div class="section-header">
                                                                        <h6>{{ __('messages.client_contact_info') }}</h6>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="client_name" class="form-label">{{ __('messages.name') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                                                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="{{ __('messages.enter_client_full_name') }}" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="client_phone" class="form-label">{{ __('messages.phone_number') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                                                    <input type="tel" class="form-control" id="client_phone_number" name="client_phone_number" placeholder="{{ __('messages.enter_client_phone_number') }}" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="client_email" class="form-label">{{ __('messages.email') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                                                    <input type="email" class="form-control" id="client_email_address" name="client_email_address" placeholder="{{ __('messages.enter_your_email_address') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="client_id" class="form-label">{{ __('messages.client_id') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                                                    <input type="file" class="form-control" id="client_id" name="client_id" accept=".jpg,.jpeg,.png,.pdf">
                                                                                    <button type="button" class="btn btn-outline-secondary">{{ __('messages.choose_file') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- VISIT PURPOSE & PROJECT Section -->
                                                                <div class="form-section">
                                                                    <div class="row">
                                                                        <!-- VISIT PURPOSE Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="section-header">
                                                                                <h6>{{ __('messages.visit_purpose') }}</h6>
                                                                                <div class="section-header-icons">
                                                                                    <span class="icon-circle dark-grey"></span>
                                                                                    <span class="icon-circle gold"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="purpose-options">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" name="visit_purpose[]" id="visit_purpose_buy" value="buy">
                                                                                        <label class="form-check-label" for="visit_purpose_buy">
                                                                                            {{ __('messages.buy') }}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" type="checkbox" name="visit_purpose[]" id="visit_purpose_rent" value="rent">
                                                                                        <label class="form-check-label" for="visit_purpose_rent">
                                                                                            {{ __('messages.rent') }}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- PROJECT Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="section-header">
                                                                                <h6>{{ __('messages.project') }}</h6>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-chevron-down"></i></span>
                                                                                    <select class="form-control" id="project_id" name="project_id" required>
                                                                                        <option value="">{{ __('messages.select_project') }}</option>
                                                                                        @if(isset($projects))
                                                                                            @foreach($projects as $project)
                                                                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- APARTMENT INFO & PREFERRED DATE & TIME Section -->
                                                                <div class="form-section">
                                                                    <div class="row">
                                                                        <!-- VISIT PURPOSE Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="section-header">
                                                                                <h6>{{ __('messages.apartment_info') }}</h6>
                                                                                <div class="section-header-icons">
                                                                                    <span class="icon-circle dark-grey"></span>
                                                                                    <span class="icon-circle gold"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="unit_type" class="form-label">{{ __('messages.unit_type') }}</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                                    <input type="text" class="form-control" id="unit_type" name="unit_type" placeholder="{{ __('messages.enter_unit_type') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- PROJECT Column -->
                                                                        <div class="col-md-6">
                                                                            <div class="section-header">
                                                                                <h6>{{ __('messages.preferred_date_time') }}</h6>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="visit_date" class="form-label">{{ __('messages.date') }}</label>
                                                                                            <div class="input-group">
                                                                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                                                                <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="visit_time" class="form-label">{{ __('messages.time') }}</label>
                                                                                            <div class="input-group">
                                                                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                                                                <input type="time" class="form-control" id="visit_time" name="visit_time" required>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                     </div>
                                                                 </div>

                                                                <!-- NOTES Section -->
                                                                <div class="form-section">
                                                                    <div class="section-header">
                                                                        <h6>{{ __('messages.notes') }}</h6>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="{{ __('messages.enter_your_main_message_here') }}"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-submit">
                                                                {{ __('messages.submit') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                
@stop





@section('script')
<style>
    /* Dashboard Title Styles */
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
    
    .dashboard-title-actions .btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #007bff;
        border: none;
        color: white;
    }
    
    .dashboard-title-actions .btn:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
    }
    
    .modal-dialog-scrollable {
        max-height: calc(100vh - 2rem);
    }
    
    .modal-dialog-scrollable .modal-content {
        max-height: calc(100vh - 2rem);
        overflow: hidden;
    }
    
    .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
        max-height: calc(100vh - 200px);
    }
    
    .modal-header {
        background: #f9f9f9;
        color: #333;
        border-radius: 12px 12px 0 0;
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        flex-shrink: 0;
    }
    
    .modal-title {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
    }
    
    .btn-close {
        opacity: 0.8;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    .modal-body {
        padding: 30px;
        background: #f9f9f9;
        flex: 1 1 auto;
        overflow-y: auto;
    }
    
    /* Visit Schedule Form Styles */
    .visit-schedule-form {
        background: white;
        border-radius: 8px;
        padding: 20px;
    }
    
    .form-section {
        margin-bottom: 25px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 20px;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .section-header {
        margin-bottom: 15px;
        position: relative;
    }
    
    .section-header h6 {
        font-weight: 600;
        color: #333;
        margin: 0;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .section-header {
        position: relative;
        margin-bottom: 15px;
    }
    
    .section-header-icons {
        position: absolute;
        top: 0;
        right: 0;
        display: flex;
        gap: 4px;
        align-items: center;
    }
    
    .icon-circle {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .icon-circle.dark-grey {
        background-color: #343a40;
    }
    
    .icon-circle.gold {
        background-color: #d4af37;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
        font-size: 13px;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group-text {
        background: #ffd700;
        border: 1px solid #e0e0e0;
        border-right: none;
        color: #333;
        font-size: 14px;
        padding: 10px 12px;
    }
    
    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 0 6px 6px 0;
        padding: 10px 15px;
        transition: all 0.3s ease;
        background: #f9f9f9;
        font-size: 14px;
    }
    
    .form-control:focus {
        border-color: #ffd700;
        box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        background: white;
    }
    
    .form-control[readonly] {
        background: #f0f0f0;
        color: #666;
    }
    
    /* Purpose Options */
    .purpose-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 10px;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-check-input {
        width: 16px;
        height: 16px;
        border: 1px solid #ccc;
        border-radius: 2px;
        background-color: #f5f5f5;
        margin-top: 0;
    }
    
    .form-check-input:checked {
        background-color: #ffd700;
        border-color: #ffd700;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    }
    
    .form-check-label {
        font-weight: 500;
        color: #333;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* File Input Styling */
    .input-group .btn-outline-secondary {
        border: 1px solid #e0e0e0;
        border-left: none;
        background: #f9f9f9;
        color: #333;
        font-size: 12px;
        padding: 10px 15px;
    }
    
    .input-group .btn-outline-secondary:hover {
        background: #e9e9e9;
        border-color: #e0e0e0;
    }
    
    /* Textarea Styling */
    .input-group textarea.form-control {
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        resize: vertical;
        min-height: 80px;
    }
    
    .input-group textarea.form-control:focus {
        border-color: #ffd700;
        box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    }
    
    /* Modal Footer */
    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #e0e0e0;
        background-color: #f9f9f9;
        border-radius: 0 0 12px 12px;
        text-align: center;
        flex-shrink: 0;
        position: sticky;
        bottom: 0;
        z-index: 10;
    }
    
    .btn-submit {
        background: #ffd700;
        border: none;
        color: #333;
        padding: 12px 40px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 150px;
    }
    
    .btn-submit:hover {
        background: #ffed4e;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    /* Table Container Styles */
    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table {
        margin: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #333;
    }
    
    /* Visit Schedule Header Styles */
    .visit-schedule-header {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .search-section {
        margin-bottom: 15px;
    }
    
    .search-bar input {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .filters-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .date-filters {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .date-input {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .date-input label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
    }
    
    .date-input input {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 6px 10px;
        font-size: 12px;
    }
    
    .selection-info {
        font-size: 14px;
        color: #666;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    /* Client Info Styles */
    .client-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .client-avatar {
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .client-avatar i {
        color: white;
        font-size: 14px;
    }
    
    .client-avatar .status-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background: #dc3545;
        border-radius: 50%;
        border: 1px solid white;
    }
    
    .client-name {
        font-weight: 500;
        color: #333;
    }
    
    /* Visit Section Styles */
    .visit-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .visit-date {
        font-weight: 500;
        color: #333;
    }
    
    /* Detail Row Styles */
    .detail-row {
        background-color: #f8f9fa;
    }
    
    .detail-content {
        padding: 20px;
    }
    
    .schedule-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .schedule-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    
    .form-indicator .badge {
        font-size: 11px;
        padding: 4px 8px;
    }
    
    /* Schedule Info Grid */
    .schedule-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .info-card {
        background: white;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-icon i {
        color: #333;
        font-size: 18px;
    }
    
    .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .info-content label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        margin: 0;
    }
    
    .info-content span {
        font-size: 14px;
        color: #333;
        font-weight: 600;
    }
    

    /* Responsive */
    @media (max-width: 768px) {
        .schedule-info-grid {
            grid-template-columns: 1fr;
        }
        
        .client-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .visit-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .filters-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .date-filters {
            justify-content: center;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        /* Modal responsive styles */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }
        
        .modal-dialog-scrollable {
            max-height: calc(100vh - 1rem);
        }
        
        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 1rem);
        }
        
        .modal-dialog-scrollable .modal-body {
            max-height: calc(100vh - 180px);
            padding: 15px;
        }
        
        .modal-header {
            padding: 15px;
        }
        
        .modal-title {
            font-size: 16px;
        }
        
        /* Form responsive styles */
        .visit-schedule-form {
            padding: 15px;
        }
        
        .form-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
        }
        
        .purpose-options {
            gap: 8px;
        }
        
        /* Stack columns on mobile */
        .form-section .row .col-md-6 {
            margin-bottom: 15px;
        }
        
        .form-group {
            margin-bottom: 12px;
        }
        
        .modal-footer {
            padding: 15px;
            position: sticky;
            bottom: 0;
        }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            font-size: 13px;
        }
        
        .input-group-text {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .form-control {
            padding: 8px 12px;
            font-size: 13px;
        }
    }
    
    @media (max-width: 480px) {
        .modal-dialog {
            margin: 0.25rem;
            max-width: calc(100% - 0.5rem);
        }
        
        .modal-dialog-scrollable {
            max-height: calc(100vh - 0.5rem);
        }
        
        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 0.5rem);
        }
        
        .modal-dialog-scrollable .modal-body {
            max-height: calc(100vh - 160px);
            padding: 12px;
        }
        
        .modal-header {
            padding: 12px;
        }
        
        .modal-title {
            font-size: 14px;
        }
        
        .visit-schedule-form {
            padding: 10px;
        }
        
        .form-section {
            margin-bottom: 15px;
            padding-bottom: 12px;
        }
        
        .section-header h6 {
            font-size: 12px;
        }
        
        .modal-footer {
            padding: 12px;
        }
        
        .btn-submit {
            padding: 12px;
            font-size: 12px;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize selected count
        updateSelectedCountVisit();
        
        // Toggle all visits functionality
        $('#selectAllVisits').on('change', function() {
            const isChecked = this.checked;
            $('.visit-checkbox').prop('checked', isChecked);
            updateSelectedCountVisit();
        });
        
        // Individual checkbox change handler
        $('.visit-checkbox').on('change', function() {
            const totalCheckboxes = $('.visit-checkbox').length;
            const checkedCheckboxes = $('.visit-checkbox:checked').length;
            $('#selectAllVisits').prop('checked', totalCheckboxes === checkedCheckboxes);
            updateSelectedCountVisit();
        });
        
        // Update selected count function
        function updateSelectedCountVisit() {
            const selected = $('.visit-checkbox:checked').length;
            const total = $('.visit-checkbox').length;
            $('#selectedCountVisit').text(`${selected} of ${total} {{ __('messages.visits_selected') }}`);
        }
        
        // Expand/collapse functionality
        document.querySelectorAll('.expand-icon').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                const row = this.closest('.main-row');
                const rowId = row.getAttribute('data-id');
                const detailRow = document.querySelector(`.detail-row[data-parent="${rowId}"]`);
                
                if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                    // Close all other detail rows
                    document.querySelectorAll('.detail-row').forEach(detail => {
                        detail.style.display = 'none';
                    });
                    document.querySelectorAll('.expand-icon').forEach(icon => {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    });
                    
                    // Open this detail row
                    detailRow.style.display = 'table-row';
                    this.classList.remove('fa-chevron-down');
                    this.classList.add('fa-chevron-up');
                } else {
                    // Close this detail row
                    detailRow.style.display = 'none';
                    this.classList.remove('fa-chevron-up');
                    this.classList.add('fa-chevron-down');
                }
            });
        });
        
        // View button functionality
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const row = this.closest('.main-row');
                const rowId = row.getAttribute('data-id');
                const detailRow = document.querySelector(`.detail-row[data-parent="${rowId}"]`);
                const expandIcon = row.querySelector('.expand-icon');
                
                if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                    // Close all other detail rows
                    document.querySelectorAll('.detail-row').forEach(detail => {
                        detail.style.display = 'none';
                    });
                    document.querySelectorAll('.expand-icon').forEach(icon => {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    });
                    
                    // Open this detail row
                    detailRow.style.display = 'table-row';
                    expandIcon.classList.remove('fa-chevron-down');
                    expandIcon.classList.add('fa-chevron-up');
                } else {
                    // Close this detail row
                    detailRow.style.display = 'none';
                    expandIcon.classList.remove('fa-chevron-up');
                    expandIcon.classList.add('fa-chevron-down');
                }
            });
        });
        
        // Modal form handling
        $('#addVisitScheduleForm').on('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> {{ __("messages.saving") }}...').prop('disabled', true);
            
            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showNotification(response.message || '{{ __("messages.visit_schedule_added_successfully") }}', 'success');
                        
                        // Close modal
                        $('#addVisitScheduleModal').modal('hide');
                        
                        // Reset form
                        $('#addVisitScheduleForm')[0].reset();
                        
                        // Reload page to show new visit schedule
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        // Show error message from response
                        showNotification(response.message || '{{ __("messages.error_occurred") }}', 'error');
                    }
                },
                error: function(xhr) {
                    // Show error message
                    let errorMessage = '{{ __("messages.error_occurred") }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = [];
                        for (let field in errors) {
                            errorMessages.push(errors[field][0]);
                        }
                        errorMessage = errorMessages.join('<br>');
                    }
                    showNotification(errorMessage, 'error');
                },
                complete: function() {
                    // Reset button state
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        $('#visit_date').attr('min', today);
        
        // Agent selection change handler (for agencies)
        $('#selected_agent_id').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const phoneNumber = selectedOption.data('phone') || '';
            $('#agent_phone').val(phoneNumber);
        });
        
        // Visit schedule search functionality
        $('#visitScheduleSearch').on('input', function() {
            filterVisitSchedules();
        });
        
        // Visit schedule date filtering functionality
        $('#fromDateVisit').on('change', function() {
            filterVisitSchedules();
        });
        
        $('#toDateVisit').on('change', function() {
            filterVisitSchedules();
        });
        
        function filterVisitSchedules() {
            const searchTerm = $('#visitScheduleSearch').val().toLowerCase();
            const fromDate = $('#fromDateVisit').val();
            const toDate = $('#toDateVisit').val();
            const rows = $('#visitScheduleTable tbody tr.main-row');
            
            rows.each(function() {
                const row = $(this);
                const agentName = row.find('.client-name').text().toLowerCase();
                const unitType = row.find('td:eq(2)').text().toLowerCase();
                const phoneNumber = row.find('td:eq(3)').text().toLowerCase();
                const visitDateText = row.find('td:eq(4)').text().toLowerCase();
                
                // Extract visit date from the visit date cell
                const visitDateSpan = row.find('.visit-date');
                const visitDateValue = visitDateSpan.attr('data-date');
                
                let showRow = true;
                
                // Apply search filter
                if (searchTerm && !agentName.includes(searchTerm) && !unitType.includes(searchTerm) && !phoneNumber.includes(searchTerm) && !visitDateText.includes(searchTerm)) {
                    showRow = false;
                }
                
                // Apply date filter
                if (showRow && (fromDate || toDate)) {
                    if (visitDateValue) {
                        const visitDate = new Date(visitDateValue);
                        const fromDateObj = fromDate ? new Date(fromDate) : null;
                        const toDateObj = toDate ? new Date(toDate) : null;
                        
                        // Set time to start of day for inclusive comparison
                        if (fromDateObj) {
                            fromDateObj.setHours(0, 0, 0, 0);
                        }
                        if (toDateObj) {
                            toDateObj.setHours(23, 59, 59, 999);
                        }
                        visitDate.setHours(0, 0, 0, 0);
                        
                        if (fromDateObj && visitDate < fromDateObj) {
                            showRow = false;
                        }
                        if (toDateObj && visitDate > toDateObj) {
                            showRow = false;
                        }
                    } else {
                        showRow = false;
                    }
                }
                
                if (showRow) {
                    row.show();
                    // Also show the corresponding detail row
                    const rowId = row.attr('data-id');
                    const detailRow = $(`.detail-row[data-parent="${rowId}"]`);
                    if (detailRow.length) {
                        detailRow.show();
                    }
                } else {
                    row.hide();
                    // Also hide the corresponding detail row
                    const rowId = row.attr('data-id');
                    const detailRow = $(`.detail-row[data-parent="${rowId}"]`);
                    if (detailRow.length) {
                        detailRow.hide();
                    }
                }
            });
        }
        
        // Export functionality
        $('#exportVisitSchedulesBtn').on('click', function() {
            const selectedVisits = $('.visit-checkbox:checked');
            if (selectedVisits.length === 0) {
                showNotification('{{ __("messages.please_select_visits_to_export") }}', 'warning');
                return;
            }
            
            const visitIds = selectedVisits.map(function() {
                return this.value;
            }).get();
            
            // Create CSV export
            exportVisitSchedulesToCSV(visitIds);
            
            showNotification('{{ __("messages.visit_export_started") }}', 'success');
        });
        
        // CSV export function
        function exportVisitSchedulesToCSV(visitIds) {
            const rows = [];
            const headers = ['Agent Name', 'Unit Type', 'Phone Number', 'Visit Date', 'Client Email', 'Project Name'];
            rows.push(headers.join(','));
            
            // Get selected visit schedule data
            visitIds.forEach(id => {
                const row = $(`tr[data-id="${id}"]`);
                
                if (row.length) {
                    const agentName = row.find('.client-name').text().trim();
                    const unitType = row.find('td:eq(2)').text().trim();
                    const phoneNumber = row.find('td:eq(3)').text().trim();
                    const visitDate = row.find('.visit-date').text().trim();
                    
                    // Get additional data from detail row
                    const detailRow = $(`.detail-row[data-parent="${id}"]`);
                    const clientEmail = detailRow.find('.info-content span').eq(1).text().trim() || 'N/A';
                    const projectName = detailRow.find('.info-content span').eq(2).text().trim() || 'N/A';
                    
                    const rowData = [
                        `"${agentName}"`,
                        `"${unitType}"`,
                        `"${phoneNumber}"`,
                        `"${visitDate}"`,
                        `"${clientEmail}"`,
                        `"${projectName}"`
                    ];
                    rows.push(rowData.join(','));
                }
            });
            
            // Create and download CSV
            const csvContent = rows.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'visit_schedules_export.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        // Delete functionality
        $('#deleteVisitSchedulesBtn').on('click', function() {
            const selectedVisits = $('.visit-checkbox:checked');
            if (selectedVisits.length === 0) {
                showNotification('{{ __("messages.please_select_visits_to_delete") }}', 'warning');
                return;
            }
            
            if (confirm(`{{ __("messages.are_you_sure_delete_visits") }} ${selectedVisits.length} {{ __("messages.selected_visits") }}?`)) {
                const visitIds = selectedVisits.map(function() {
                    return this.value;
                }).get();
                
                // Get CSRF token
                const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
                
                // Make AJAX call to delete visit schedules
                $.ajax({
                    url: '/visit-schedule/delete',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        visit_ids: visitIds
                    },
                    success: function(response) {
                        if (response.status === '1') {
                            // Remove deleted rows from the table
                            selectedVisits.each(function() {
                                const row = $(this).closest('.main-row');
                                const rowId = row.attr('data-id');
                                const detailRow = $(`.detail-row[data-parent="${rowId}"]`);
                                
                                row.remove();
                                if (detailRow.length) {
                                    detailRow.remove();
                                }
                            });
                            
                            // Update selection count
                            updateSelectedCountVisit();
                            
                            showNotification(response.message || '{{ __("messages.visits_deleted_successfully") }}', 'success');
                        } else {
                            showNotification(response.message || '{{ __("messages.error_occurred") }}', 'error');
                        }
                    },
                    error: function() {
                        showNotification('{{ __("messages.something_went_wrong") }}', 'error');
                    }
                });
            }
        });
        
        // Notification function
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : type === 'warning' ? 'alert-warning' : 'alert-danger';
            const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'}"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            
            $('body').append(notification);
            
            // Auto remove after 5 seconds
            setTimeout(function() {
                notification.alert('close');
            }, 5000);
        }
    });
</script>
@stop
