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
                                        <div class="dashboard-title">
                                            <div class="dashboard-title-item"><span>{{ __('messages.visit_schedule') }}</span></div>
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
    });
</script>
@stop
