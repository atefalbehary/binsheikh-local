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
                                                        <li><a href="{{ url('my-profile') }}">{{ __('messages.profile') }}</a></li>
                                                        
                                                        @if(\Auth::user()->role == 4)
                                                            <!-- Agency Role (role 4) - Show Employees -->
                                                            <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
                                                        @endif
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.favorite') }}</a></li>
                                                        <li><a href="{{ url('visit-schedule') }}" class="act-scrlink">{{ __('messages.visit_schedule') }}</a></li>
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
                                            <div class="dashboard-title">
                                                <div class="dashboard-title-item"><span>{{ __('messages.visit_schedule') }}</span></div>
                                                <div class="dashboard-title-actions">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitScheduleModal">
                                                        <i class="fas fa-plus"></i> {{ __('messages.add_new_visit_schedule') }}
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Master-Details Table -->
                                            <div class="table-container">
                                            <table class="table table-hover" id="visitScheduleTable">
                                                <thead>
                                                    <tr>
                                                        <th width="50">
                                                            <input type="checkbox" id="selectAllVisits" onclick="toggleAllVisits(this)">
                                                        </th>
                                                        <th>{{ __('messages.client_name') }}</th>
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
                                                                <span class="client-name">{{ $visit->client_name ?? 'N/A' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $visit->property->property_type->name ?? 'N/A' }}</td>
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
                                                                                <span>{{ $visit->property->project->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-id-card"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.client_id') }}</label>
                                                                                <span>{{ $visit->client_id ?? 'N/A' }}</span>
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
                                                                                <label>{{ __('messages.apartment_info') }}</label>
                                                                                <span>{{ $visit->property->name ?? 'N/A' }}</span>
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
                                        
                                        <!-- Add Visit Schedule Modal -->
                                        <div class="modal fade" id="addVisitScheduleModal" tabindex="-1" aria-labelledby="addVisitScheduleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addVisitScheduleModalLabel">
                                                            <i class="fas fa-calendar-plus"></i> {{ __('messages.add_new_visit_schedule') }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form id="addVisitScheduleForm" action="{{ url('visit-schedule/store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Client Information -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="client_name" class="form-label">{{ __('messages.client_name') }} <span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" id="client_name" name="client_name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="client_email" class="form-label">{{ __('messages.client_email_address') }}</label>
                                                                        <input type="email" class="form-control" id="client_email" name="client_email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="client_phone" class="form-label">{{ __('messages.phone_number') }} <span class="text-danger">*</span></label>
                                                                        <input type="tel" class="form-control" id="client_phone" name="client_phone" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="client_id" class="form-label">{{ __('messages.client_id') }}</label>
                                                                        <input type="file" class="form-control" id="client_id" name="client_id" accept=".jpg,.jpeg,.png,.pdf">
                                                                        <small class="form-text text-muted">{{ __('messages.client_id_file_help') }}</small>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Property Information -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="property_id" class="form-label">{{ __('messages.property') }} <span class="text-danger">*</span></label>
                                                                        <select class="form-control" id="property_id" name="property_id" required>
                                                                            <option value="">{{ __('messages.select_property') }}</option>
                                                                            @if(isset($properties))
                                                                                @foreach($properties as $property)
                                                                                    <option value="{{ $property->id }}">{{ $property->name }} - {{ $property->project->name ?? 'N/A' }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Visit Schedule -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="visit_date" class="form-label">{{ __('messages.visit_date') }} <span class="text-danger">*</span></label>
                                                                        <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="visit_time" class="form-label">{{ __('messages.visit_time') }} <span class="text-danger">*</span></label>
                                                                        <input type="time" class="form-control" id="visit_time" name="visit_time" required>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Notes -->
                                                                <div class="col-12">
                                                                    <div class="form-group mb-3">
                                                                        <label for="notes" class="form-label">{{ __('messages.notes') }}</label>
                                                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="{{ __('messages.additional_notes') }}"></textarea>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Visit Purpose -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <label for="visit_purpose" class="form-label">{{ __('messages.visit_purpose') }} <span class="text-danger">*</span></label>
                                                                        <select class="form-control" id="visit_purpose" name="visit_purpose" required>
                                                                            <option value="">{{ __('messages.select_visit_purpose') }}</option>
                                                                            <option value="buy">{{ __('messages.buy') }}</option>
                                                                            <option value="rent">{{ __('messages.rent') }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-save"></i> {{ __('messages.save_visit_schedule') }}
                                                            </button>
                                                        </div>
                                                    </form>
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
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 20px;
        border-bottom: none;
    }
    
    .modal-title {
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    .modal-body {
        padding: 30px;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }
    
    .modal-footer .btn {
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
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
    }
</style>

<script>
    $(document).ready(function() {
        // Toggle all visits
        function toggleAllVisits(source) {
            document.querySelectorAll('.visit-checkbox').forEach(checkbox => {
                checkbox.checked = source.checked;
            });
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
        
        // Notification function
        function showNotification(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
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
