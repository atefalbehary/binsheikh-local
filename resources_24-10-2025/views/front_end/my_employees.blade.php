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
                                                            <!-- Agency Role (role 4) - Show Employees -->
                                                            <li><a href="{{ url('my-employees') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.employees') }}</a></li>
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


                                            <div class="custom-form bg-white p-4 h-100">


                                            <div class="dashboard-title">
                                                <div class="dashboard-title-item"><span>{{ __('messages.employees') }}</span></div>
                                                <div class="dashboard-title-actions">
                                                    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                                        <i class="fas fa-plus"></i> {{ __('messages.add_employee') }}
                                                    </button> -->
                                                </div>
                                            </div>

                                            <!-- Search and Filters -->
                                            <div class="employees-header">
                                                <div class="search-section">
                                                    <div class="search-bar">
                                                        <input type="text" class="form-control" placeholder="{{ __('messages.search_by_name_email_phone') }}" id="employeeSearch">
                                                    </div>
                                                </div>
                                                
                                                <div class="filters-section">
                                                    <div class="date-filters">
                                                        <div class="date-input">
                                                            <label>{{ __('messages.from') }}</label>
                                                            <input type="date" class="form-control" id="fromDate">
                                                        </div>
                                                        <div class="date-input">
                                                            <label>{{ __('messages.to') }}</label>
                                                            <input type="date" class="form-control" id="toDate">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="selection-info">
                                                        <span id="selectedCount">0 {{ __('messages.items_selected') }}</span>
                                                    </div>
                                                    
                                                    <div class="action-buttons">
                                                        <button class="btn btn-primary btn-sm" id="exportEmployeesBtn">{{ __('messages.export') }}</button>
                                                        <button class="btn btn-danger btn-sm" id="deleteEmployeesBtn">{{ __('messages.delete') }}</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Master-Details Table -->
                                            <div class="table-container">
                                                <table class="table table-hover" id="employeesTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">
                                                                <input type="checkbox" id="selectAllEmployees">
                                                            </th>
                                                            <th>{{ __('messages.agent_name') }}</th>
                                                            <th>{{ __('messages.agency_name') }}</th>
                                                            <th>{{ __('messages.created_on') }}</th>
                                                            <th>{{ __('messages.status') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($employees ?? [] as $index => $employee)
                                                        <!-- Main Row -->
                                                        <tr class="main-row" data-id="{{ $employee->id }}">
                                                            <td>
                                                                <input type="checkbox" class="employee-checkbox" value="{{ $employee->id }}">
                                                            </td>
                                                            <td>
                                                                <div class="agent-info">
                                                                    <div class="agent-avatar">
                                                                        <i class="fas fa-user"></i>
                                                                        <div class="status-dot"></div>
                                                                    </div>
                                                                    <span class="agent-name">{{ $employee->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>{{ \Auth::user()->name }}</td>
                                                            <td><span data-date="{{ $employee->created_at }}">{{ web_date_in_timezone($employee->created_at, 'd-M-Y') }}</span></td>
                                                            <td>
                                                                <div class="status-section">
                                                                    <span class="status-text {{ $employee->active ? 'text-success' : 'text-danger' }}">
                                                                        {{ $employee->active ? __('messages.active') : __('messages.inactive') }}
                                                                    </span>
                                                                    <button class="btn btn-sm btn-info">{{ __('messages.view') }}</button>
                                                                    <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        
                                                        <!-- Detail Row -->
                                                        <tr class="detail-row" data-parent="{{ $employee->id }}" style="display: none;">
                                                            <td colspan="5">
                                                                <div class="detail-content">
                                                                    <div class="agent-info-header">
                                                                        <h6>{{ __('messages.agent_info') }}</h6>
                                                                        <div class="header-actions">
                                                                            <div class="form-indicator">
                                                                                <span class="badge badge-info">1 {{ __('messages.active_form_submitted') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="agent-info-grid">
                                                                        <!-- Left Column -->
                                                                        <div class="info-column">
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-user"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>{{ __('messages.agency_name') }}</label>
                                                                                    <span>{{ \Auth::user()->name ?? __('messages.not_available') }}</span>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-envelope"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>{{ __('messages.agent_email_address') }}</label>
                                                                                    <span>{{ $employee->email ?? __('messages.not_available') }}</span>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-id-card"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>{{ __('messages.id_card') }}</label>
                                                                                    @if($employee->id_no)
                                                                                        <a href="{{ aws_asset_path($employee->id_no) }}" target="_blank" class="btn btn-sm btn-info">
                                                                                            <i class="fas fa-eye"></i> {{ __('messages.view_id_card') }}
                                                                                        </a>
                                                                                    @else
                                                                                        <span>{{ __('messages.not_available') }}</span>
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
                                                                                    <label>{{ __('messages.agent_phone_number') }}</label>
                                                                                    <span>{{ $employee->phone ?? __('messages.not_available') }}</span>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-certificate"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>{{ __('messages.professional_license') }}</label>
                                                                                    @if($employee->discount_number)
                                                                                        <a href="{{ aws_asset_path($employee->discount_number) }}" target="_blank" class="btn btn-sm btn-info">
                                                                                            <i class="fas fa-eye"></i> {{ __('messages.view_license') }}
                                                                                        </a>
                                                                                    @else
                                                                                        <span>{{ __('messages.not_available') }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">{{ __('messages.no_employees_found') }}</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
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
    
    /* Employees Header Styles */
    .employees-header {
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
    
    /* Agent Info Styles */
    .agent-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .agent-avatar {
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .agent-avatar i {
        color: white;
        font-size: 14px;
    }
    
    .agent-avatar .status-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background: #dc3545;
        border-radius: 50%;
        border: 1px solid white;
    }
    
    .agent-name {
        font-weight: 500;
        color: #333;
    }
    
    .status-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .status-text {
        font-weight: 500;
    }
    
    .text-success {
        color: #28a745 !important;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    .agent-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .agent-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    
    .form-indicator .badge {
        font-size: 11px;
        padding: 4px 8px;
    }
    
    /* Agent Info Grid */
    .agent-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
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
        .agent-info-grid {
            grid-template-columns: 1fr;
        }
        
        .agent-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        
        .status-section {
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
    }
</style>

<script>
    // Global functions for HTML onclick events
    
    function updateSelectedCount() {
        const selected = document.querySelectorAll('.employee-checkbox:checked').length;
        const countElement = document.getElementById('selectedCount');
        if (countElement) {
            countElement.textContent = `${selected} {{ __('messages.items_selected') }}`;
        }
        console.log('Selected count updated:', selected);
    }

    $(document).ready(function() {
        
        // Select all employees functionality
        $('#selectAllEmployees').on('change', function() {
            const isChecked = this.checked;
            $('.employee-checkbox').prop('checked', isChecked);
            updateSelectedCount();
        });
        
        // Individual checkbox change handler
        $('.employee-checkbox').on('change', function() {
            const totalCheckboxes = $('.employee-checkbox').length;
            const checkedCheckboxes = $('.employee-checkbox:checked').length;
            $('#selectAllEmployees').prop('checked', totalCheckboxes === checkedCheckboxes);
            updateSelectedCount();
        });
        
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
        
        // Employee search functionality
        document.getElementById('employeeSearch').addEventListener('input', function() {
            filterEmployees();
        });
        
        // Employee date filtering functionality
        document.getElementById('fromDate').addEventListener('change', function() {
            filterEmployees();
        });
        
        document.getElementById('toDate').addEventListener('change', function() {
            filterEmployees();
        });
        
        function filterEmployees() {
            const searchTerm = document.getElementById('employeeSearch').value.toLowerCase();
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;
            const rows = document.querySelectorAll('#employeesTable tbody tr.main-row');
            
            rows.forEach(row => {
                const agentName = row.querySelector('.agent-name').textContent.toLowerCase();
                const agencyName = row.cells[2].textContent.toLowerCase();
                const createdDateText = row.cells[3].textContent.toLowerCase();
                
                // Extract created date from the created date cell
                const createdDateSpan = row.cells[3].querySelector('span[data-date]');
                const createdDateValue = createdDateSpan ? createdDateSpan.getAttribute('data-date') : null;
                
                let showRow = true;
                
                // Apply search filter
                if (searchTerm && !agentName.includes(searchTerm) && !agencyName.includes(searchTerm) && !createdDateText.includes(searchTerm)) {
                    showRow = false;
                }
                
                // Apply date filter
                if (showRow && (fromDate || toDate)) {
                    if (createdDateValue) {
                        const createdDate = new Date(createdDateValue);
                        const fromDateObj = fromDate ? new Date(fromDate) : null;
                        const toDateObj = toDate ? new Date(toDate) : null;
                        
                        // Set time to start of day for inclusive comparison
                        if (fromDateObj) {
                            fromDateObj.setHours(0, 0, 0, 0);
                        }
                        if (toDateObj) {
                            toDateObj.setHours(23, 59, 59, 999);
                        }
                        createdDate.setHours(0, 0, 0, 0);
                        
                        if (fromDateObj && createdDate < fromDateObj) {
                            showRow = false;
                        }
                        if (toDateObj && createdDate > toDateObj) {
                            showRow = false;
                        }
                    } else {
                        // If no data-date attribute, try to parse from the displayed text
                        showRow = false;
                    }
                }
                
                if (showRow) {
                    row.style.display = '';
                    // Also show the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`.detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = '';
                    }
                } else {
                    row.style.display = 'none';
                    // Also hide the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`.detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = 'none';
                    }
                }
            });
        }
        
        // Export functionality
        document.getElementById('exportEmployeesBtn').addEventListener('click', function() {
            console.log('Export button clicked');
            const selectedEmployees = document.querySelectorAll('.employee-checkbox:checked');
            console.log('Selected employees:', selectedEmployees.length);
            
            if (selectedEmployees.length === 0) {
                showNotification('{{ __("messages.please_select_employees_to_export") }}', 'warning');
                return;
            }
            
            const employeeIds = Array.from(selectedEmployees).map(cb => cb.value);
            console.log('Employee IDs to export:', employeeIds);
            
            // For now, create a simple CSV export
            exportEmployeesToCSV(employeeIds);
            
            showNotification('{{ __("messages.employee_export_started") }}', 'success');
        });
        
        // Simple CSV export function
        function exportEmployeesToCSV(employeeIds) {
            console.log('Starting CSV export for IDs:', employeeIds);
            const rows = [];
            const headers = ['Agent Name', 'Agency Name', 'Email', 'Phone', 'Created Date', 'Status'];
            rows.push(headers.join(','));
            
            // Get selected employee data
            employeeIds.forEach(id => {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                console.log('Processing row for ID:', id, row);
                
                if (row) {
                    const agentName = row.querySelector('.agent-name').textContent.trim();
                    const agencyName = row.cells[2].textContent.trim();
                    const createdDate = row.cells[3].textContent.trim();
                    const status = row.querySelector('.status-text').textContent.trim();
                    
                    // Get email and phone from detail row
                    const detailRow = document.querySelector(`tr[data-parent="${id}"]`);
                    const email = detailRow ? detailRow.querySelector('.info-content span').textContent.trim() : '';
                    const phone = detailRow ? detailRow.querySelectorAll('.info-content span')[1]?.textContent.trim() || '' : '';
                    
                    console.log('Employee data:', { agentName, agencyName, email, phone, createdDate, status });
                    
                    const rowData = [
                        `"${agentName}"`,
                        `"${agencyName}"`,
                        `"${email}"`,
                        `"${phone}"`,
                        `"${createdDate}"`,
                        `"${status}"`
                    ];
                    rows.push(rowData.join(','));
                }
            });
            
            console.log('CSV rows:', rows);
            
            // Create and download CSV
            const csvContent = rows.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'employees_export.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            console.log('CSV download initiated');
        }
        
        // Delete functionality
        document.getElementById('deleteEmployeesBtn').addEventListener('click', function() {
            const selectedEmployees = document.querySelectorAll('.employee-checkbox:checked');
            if (selectedEmployees.length === 0) {
                showNotification('{{ __("messages.please_select_employees_to_delete") }}', 'warning');
                return;
            }
            
            if (confirm(`{{ __("messages.are_you_sure_delete_employees") }} ${selectedEmployees.length} {{ __("messages.selected_employees") }}?`)) {
                const employeeIds = Array.from(selectedEmployees).map(cb => cb.value);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                
                // Make AJAX call to delete employees
                fetch('/my-employees/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        employee_ids: employeeIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === '1') {
                        // Remove deleted rows from the table
                        selectedEmployees.forEach(checkbox => {
                            const row = checkbox.closest('.main-row');
                            const rowId = row.getAttribute('data-id');
                            const detailRow = document.querySelector(`.detail-row[data-parent="${rowId}"]`);
                            
                            row.remove();
                            if (detailRow) {
                                detailRow.remove();
                            }
                        });
                        
                        // Update selection count
                        updateSelectedCount();
                        
                        showNotification(data.message || '{{ __("messages.employees_deleted_successfully") }}', 'success');
                    } else {
                        showNotification(data.message || '{{ __("messages.error_occurred") }}', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('{{ __("messages.something_went_wrong") }}', 'error');
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
