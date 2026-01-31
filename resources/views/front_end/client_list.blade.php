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
                                                            <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
                                                        @endif

                                                        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
                                                            <li><a href="{{ url('client-list') }}" style="background-color: rgb(242, 233, 224);">Client List</a></li>
                                                        @endif

                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.my_favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
                                                            <li><a href="{{ url('visit-schedule') }}">{{ __('messages.my_visit_schedule') }}</a></li>
                                                        @endif
                                                        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
                                                            <li><a href="javascript:void(0);" id="clientRegistrationBtn">Client Registration</a></li>
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
                                                <div class="dashboard-title-item"><span>Client List</span></div>
                                                <div class="dashboard-title-actions">
                                                    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                                        <i class="fas fa-plus"></i> Add Client
                                                    </button> -->
                                                </div>
                                            </div>

                                            <!-- Search and Filters -->
                                            <div class="clients-header">
                                                <div class="search-section">
                                                    <div class="search-bar">
                                                        <input type="text" class="form-control" placeholder="Search by name, email, or phone" id="clientSearch">
                                                    </div>
                                                </div>

                                                <div class="filters-section">
                                                    <div class="date-filters">
                                                        <div class="date-input">
                                                            <label>From</label>
                                                            <input type="date" class="form-control" id="fromDate">
                                                        </div>
                                                        <div class="date-input">
                                                            <label>To</label>
                                                            <input type="date" class="form-control" id="toDate">
                                                        </div>
                                                    </div>

                                                    <div class="selection-info">
                                                        <span id="selectedCount">0 items selected</span>
                                                    </div>

                                                    <div class="action-buttons">
                                                        <button class="btn btn-primary btn-sm" id="exportClientsBtn">Export</button>
                                                        <button class="btn btn-danger btn-sm" id="deleteClientsBtn">Delete</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Master-Details Table -->
                                            <div class="table-container">
                                                <table class="table table-hover" id="clientsTable">
                                                    <thead>
                                                        <tr>
                                                            <th width="50">
                                                                <input type="checkbox" id="selectAllClients">
                                                            </th>
                                                            <th>Client Name</th>
                                                            <th>Project</th>
                                                            <th>Registration Date</th>
                                                            <th>Next Visit Status</th>
                                                            <th>Last Visit Status</th>
                                                            <th>Contact Info</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($clients ?? [] as $index => $client)
                                                        <!-- Main Row -->
                                                        <tr class="main-row" data-id="{{ $client->id }}">
                                                            <td>
                                                                <input type="checkbox" class="client-checkbox" value="{{ $client->id }}">
                                                            </td>
                                                            <td>
                                                                <div class="client-info">
                                                                    <div class="client-avatar">
                                                                        <i class="fas fa-user"></i>
                                                                        <div class="status-dot"></div>
                                                                    </div>
                                                                    <span class="client-name">{{ $client->client_name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>{{ $client->project ? $client->project->title : 'N/A' }}</td>
                                                            <td><span data-date="{{ $client->created_at }}">{{ web_date_in_timezone($client->created_at, 'd-M-Y') }}</span></td>
                                                            
                                                            <!-- Next Visit Status -->
                                                            <td>
                                                                @if($client->next_visit)
                                                                    <div class="status-cell">
                                                                        @php
                                                                            $status = $client->next_visit->status ?? 'Pending';
                                                                            $badgeClass = match(strtolower($status)) {
                                                                                'visited' => 'success',
                                                                                'cancelled' => 'danger',
                                                                                'rescheduled' => 'warning',
                                                                                default => 'info'
                                                                            };
                                                                            $statusLabel = ucfirst($status);
                                                                            if(strtolower($status) == 'scheduled') $statusLabel = 'Pending';
                                                                        @endphp
                                                                        <span class="badge badge-{{ $badgeClass }}">{{ $statusLabel }}</span>
                                                                        
                                                                        <a href="javascript:void(0);" 
                                                                           class="update-status-link" 
                                                                           data-visit-id="{{ $client->next_visit->id }}"
                                                                           data-current-status="{{ $status }}">
                                                                            <i class="fas fa-edit"></i> Update Status
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>

                                                            <!-- Last Visit Status -->
                                                            <td>
                                                                @if($client->last_visit)
                                                                    <div class="status-cell">
                                                                        @php
                                                                            $lastStatus = $client->last_visit->status ?? 'Visited';
                                                                            $lastBadgeClass = match(strtolower($lastStatus)) {
                                                                                'visited' => 'success',
                                                                                'cancelled' => 'danger',
                                                                                'rescheduled' => 'warning',
                                                                                default => 'secondary'
                                                                            };
                                                                        @endphp
                                                                        <span class="badge badge-{{ $lastBadgeClass }}">{{ ucfirst($lastStatus) }}</span>
                                                                        <div class="locked-history">
                                                                            <i class="fas fa-lock"></i> History Locked
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <div class="contact-section">
                                                                    <span class="contact-text">{{ $client->phone }}</span>
                                                                    <button class="btn btn-sm btn-info">View</button>
                                                                    <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Detail Row -->
                                                        <tr class="detail-row" data-parent="{{ $client->id }}" style="display: none;">
                                                            <td colspan="7">
                                                                <div class="detail-content">
                                                                    <div class="client-info-header">
                                                                        <h6>Client Information</h6>
                                                                        <div class="header-actions">
                                                                            <div class="form-indicator">
                                                                                <span class="badge badge-info">Registered by: {{ $client->agent ? $client->agent->name : 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="client-info-grid">
                                                                        <!-- Left Column -->
                                                                        <div class="info-column">
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-envelope"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Email Address</label>
                                                                                    <span>{{ $client->email ?? 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-phone"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Phone Number</label>
                                                                                    <span>{{ $client->country_code }} {{ $client->phone ?? 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-flag"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Nationality</label>
                                                                                    <span>{{ $client->nationality ?? 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Right Column -->
                                                                        <div class="info-column">
                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-building"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Apartment Number</label>
                                                                                    <span>{{ $client->apartment_no ?? 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-home"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Apartment Type</label>
                                                                                    <span>{{ $client->apartment_type ?? 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="info-card">
                                                                                <div class="info-icon">
                                                                                    <i class="fas fa-user-tie"></i>
                                                                                </div>
                                                                                <div class="info-content">
                                                                                    <label>Registered By</label>
                                                                                    <span>{{ $client->agent ? $client->agent->name : 'Not Available' }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No clients found</td>
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
                                
        <!-- Update Schedule Status Modal -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Visit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateStatusForm">
                            @csrf
                            <input type="hidden" name="visit_id" id="update_visit_id">
                            <div class="form-group">
                                <label for="visit_status" class="form-label">Select New Status</label>
                                <select class="form-control" name="status" id="visit_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Visited">Visited</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Rescheduled">Rescheduled</option>
                                </select>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </div>
                        </form>
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
    
    /* Clients Header Styles */
    .clients-header {
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
        background: #28a745;
        border-radius: 50%;
        border: 1px solid white;
    }

    .client-name {
        font-weight: 500;
        color: #333;
    }

    .contact-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .contact-text {
        font-weight: 500;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .client-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .client-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }

    .form-indicator .badge {
        font-size: 11px;
        padding: 4px 8px;
    }

    /* Client Info Grid */
    .client-info-grid {
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
    /* Status Cell Styles */
    .status-cell {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .update-status-link {
        font-size: 11px;
        color: #007bff;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .update-status-link:hover {
        text-decoration: underline;
    }
    
    .locked-history {
        font-size: 11px;
        color: #6c757d;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>

<script>
    // Global functions for HTML onclick events
    
    function updateSelectedCount() {
        const selected = document.querySelectorAll('.client-checkbox:checked').length;
        const countElement = document.getElementById('selectedCount');
        if (countElement) {
            countElement.textContent = `${selected} items selected`;
        }
        console.log('Selected count updated:', selected);
    }

    $(document).ready(function() {
        
        // Handle "Update Status" click
        $(document).on('click', '.update-status-link', function() {
            const visitId = $(this).data('visit-id');
            const currentStatus = $(this).data('current-status');
            
            $('#update_visit_id').val(visitId);
            // Optionally set current status if needed, but per requirement show dropdown
            $('#updateStatusModal').modal('show');
        });

        // Handle Status Update Submission
        $('#updateStatusForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('frontend.update_visit_status') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        $('#updateStatusModal').modal('hide');
                        // Reload page to reflect changes (simplest way to update UI logic)
                        window.location.reload();
                    } else {
                        alert(response.message || 'Error updating status');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Select all clients functionality
        $('#selectAllClients').on('change', function() {
            const isChecked = this.checked;
            $('.client-checkbox').prop('checked', isChecked);
            updateSelectedCount();
        });
// ... (rest of existing script)

        // Individual checkbox change handler
        $('.client-checkbox').on('change', function() {
            const totalCheckboxes = $('.client-checkbox').length;
            const checkedCheckboxes = $('.client-checkbox:checked').length;
            $('#selectAllClients').prop('checked', totalCheckboxes === checkedCheckboxes);
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
        
        // Client search functionality
        document.getElementById('clientSearch').addEventListener('input', function() {
            filterClients();
        });

        // Client date filtering functionality
        document.getElementById('fromDate').addEventListener('change', function() {
            filterClients();
        });

        document.getElementById('toDate').addEventListener('change', function() {
            filterClients();
        });

        function filterClients() {
            const searchTerm = document.getElementById('clientSearch').value.toLowerCase();
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;
            const rows = document.querySelectorAll('#clientsTable tbody tr.main-row');

            rows.forEach(row => {
                const clientName = row.querySelector('.client-name').textContent.toLowerCase();
                const project = row.cells[2].textContent.toLowerCase();
                const contactText = row.querySelector('.contact-text').textContent.toLowerCase();

                // Extract created date from the created date cell
                const createdDateSpan = row.cells[3].querySelector('span[data-date]');
                const createdDateValue = createdDateSpan ? createdDateSpan.getAttribute('data-date') : null;

                let showRow = true;

                // Apply search filter
                if (searchTerm && !clientName.includes(searchTerm) && !project.includes(searchTerm) && !contactText.includes(searchTerm)) {
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
        document.getElementById('exportClientsBtn').addEventListener('click', function() {
            console.log('Export button clicked');
            const selectedClients = document.querySelectorAll('.client-checkbox:checked');
            console.log('Selected clients:', selectedClients.length);

            if (selectedClients.length === 0) {
                showNotification('Please select clients to export', 'warning');
                return;
            }

            const clientIds = Array.from(selectedClients).map(cb => cb.value);
            console.log('Client IDs to export:', clientIds);

            // Build URL with client IDs and date filters
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;
            const searchTerm = document.getElementById('clientSearch').value;

            let url = '{{ url("export-clients") }}?ids=' + clientIds.join(',');
            if (fromDate) url += '&from=' + fromDate;
            if (toDate) url += '&to=' + toDate;
            if (searchTerm) url += '&search=' + encodeURIComponent(searchTerm);

            // Navigate to export URL
            window.location.href = url;

            showNotification('Client export started', 'success');
        });
        
        // Delete functionality
        document.getElementById('deleteClientsBtn').addEventListener('click', function() {
            const selectedClients = document.querySelectorAll('.client-checkbox:checked');
            if (selectedClients.length === 0) {
                showNotification('Please select clients to delete', 'warning');
                return;
            }

            if (confirm(`Are you sure you want to delete ${selectedClients.length} selected client(s)?`)) {
                const clientIds = Array.from(selectedClients).map(cb => cb.value);

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                // Make AJAX call to delete clients
                fetch('{{ url("delete-clients") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        client_ids: clientIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === '1' || data.success) {
                        // Remove deleted rows from the table
                        selectedClients.forEach(checkbox => {
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

                        showNotification(data.message || 'Clients deleted successfully', 'success');
                    } else {
                        showNotification(data.message || 'Error occurred', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Something went wrong', 'error');
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
