@extends('admin.template.layout')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .agent-name {
        cursor: pointer;
        color: #007bff;
    }
    
    .agent-name:hover {
        text-decoration: underline;
    }
    
    .expand-icon {
        transition: transform 0.3s ease;
    }
    
    .detail-row {
        background-color: #f8f9fa;
        width: 100%;
        grid-column: 1 / -1;
    }
    
    .detail-content {
        padding: 20px;
        background-color: #f8f9fa;
        width: 100%;
    }
    
    .main-row:hover {
        background-color: #f5f5f5;
    }
    
    /* Agency Info Header */
    .agency-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .agency-info-header h5 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }
    
    .header-actions {
        display: flex;
        gap: 5px;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }
    
    .btn-action.btn-success {
        background-color: #28a745;
        color: white;
    }
    
    .btn-action.btn-danger {
        background-color: #dc3545;
        color: white;
    }
    
    /* Agency Info Grid */
    .agency-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    /* Info Cards */
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
    
    /* View Button */
    .view-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }
    
    .view-btn:hover {
        background-color: #5a6268;
    }
    
    /* Tab Navigation Styles */
    .tab-navigation {
        display: flex;
        gap: 5px;
        margin-bottom: 20px;
    }
    
    .tab-button {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
    }
    
    .tab-button.active {
        background-color: #28a745;
        color: white;
    }
    
    .tab-button.inactive {
        background-color: #ffd700;
        color: #333;
    }
    
    .tab-button:hover:not(.active) {
        opacity: 0.8;
    }
    
    .tab-content {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        min-height: 400px;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* Search and Filter Section */
    .search-filter-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .search-filter-section h6 {
        margin-bottom: 15px;
        color: #495057;
        font-weight: 600;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .selected-count {
        background: #007bff;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .export-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    
    .delete-btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    
    /* Table Styles */
    .data-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table-header {
        background: #000000;
        color: black;
        font-weight: 600;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-bottom: 2px solid #343a40;
    }
    
    .table-header .table-row {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        gap: 15px;
    }
    
    .table-header .table-cell {
        color: black;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 13px;
        flex: 1;
        padding: 0 10px;
    }
    
    .table-header .table-cell.checkbox {
        flex: 0 0 50px;
    }
    
    .table-header input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #28a745;
    }
    
    .table-row {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s;
        background: white;
        min-height: 60px;
    }
    
    .table-row.detail-row {
        display: block;
        padding: 0;
        border-bottom: none;
    }
    
    .table-row:hover {
        background-color: #f8f9fa;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .table-row:last-child {
        border-bottom: none;
    }
    
    .table-cell {
        flex: 1;
        padding: 0 10px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }
    
    .table-cell.checkbox {
        flex: 0 0 50px;
    }
    
    .table-row input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #28a745;
    }
    
    .table-cell.actions {
        flex: 0 0 120px;
        display: flex;
        gap: 5px;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }
    
    /* Reservation Card Styles */
    .reservation-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        position: relative;
        margin-bottom: 20px;
    }
    
    .card-checkbox {
        margin-top: 10px;
    }
    
    .card-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .property-image {
        width: 250px;
        height: 180px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .property-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        background: #e9ecef;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .no-image i {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .reservation-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .property-title {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        line-height: 1.3;
        margin-bottom: 8px;
    }
    
    .unit-info {
        font-size: 16px;
        color: #666;
        margin-bottom: 12px;
        font-weight: 500;
    }
    
    .project-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 12px;
    }
    
    .details-row {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    
    .detail-field {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 180px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .field-label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }
    
    .field-value {
        font-weight: 700;
        color: #333;
        font-size: 14px;
    }
    
    .status-badge {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: white;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-waitingapproval {
        background-color: #6c757d;
        color: white;
    }
    
    .status-reserved {
        background-color: #28a745;
        color: white;
    }
    
    .status-preparingdocument {
        background-color: #fd7e14;
        color: white;
    }
    
    .status-closeddeal {
        background-color: #dc3545;
        color: white;
    }
    
    .expand-button {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: #ffd700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .expand-button:hover {
        background: #ffed4e;
        transform: scale(1.1);
    }
    
    .expand-button i {
        color: #333;
        font-size: 16px;
    }
    
    /* Visit Schedule Search and Filter Styles */
    .search-section {
        margin-bottom: 15px;
    }
    
    .search-bar input {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        font-size: 14px;
        width: 100%;
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
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
    
    /* Agent Info Display Styles */
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
    
    .visit-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .visit-date {
        font-weight: 500;
        color: #333;
    }
    
    .expand-icon {
        color: #666;
        font-size: 12px;
    }
    
    /* Visit Schedule Master-Detail Styles */
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
    
    .detail-content {
        padding: 20px;
        background-color: #f8f9fa;
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
    
    .schedule-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .schedule-info-grid .info-column {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .schedule-info-grid .info-card {
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
    
    .schedule-info-grid .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .schedule-info-grid .info-icon i {
        color: #333;
        font-size: 18px;
    }
    
    .schedule-info-grid .info-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .schedule-info-grid .info-content label {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        margin: 0;
    }
    
    .schedule-info-grid .info-content span {
        font-size: 14px;
        color: #333;
        font-weight: 600;
    }
    
    .schedule-info-grid .view-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        flex-shrink: 0;
    }
    
    .schedule-info-grid .view-btn:hover {
        background-color: #5a6268;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .agency-info-grid {
            grid-template-columns: 1fr;
        }
        
        .agency-info-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        
        .tab-navigation {
            flex-direction: column;
            gap: 5px;
        }
        
        .tab-button {
            border-radius: 8px;
            margin-right: 0;
            margin-bottom: 2px;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
        
        .table-row {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        
        .table-cell {
            padding: 5px 0;
        }
        
        .schedule-info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="margin: 0; color: #495057;">AGENTS / AGENTS INFO</h4>
                        </div>
                        <div class="card-body">
                            <!-- Search Section -->
                            <div class="search-filter-section">
                                <h6>Search By Name | Email | Phone Number</h6>
                                <form action="{{ url('admin/agent') }}" method="get">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">From</label>
                                                <input class="form-control filter_1" name="from" type="date" value="{{ $from }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">To</label>
                                                <input class="form-control filter_1" name="to" type="date" value="{{ $to }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Name/Email/Phone</label>
                                                <input class="form-control filter_1" name="search_text" value="{{$search_text}}">
                                            </div>
                                            <input type="hidden" name="role" value="{{$role}}">
                                        </div>
                                        <div class="col-md-3" style="margin-top: 1.8rem !important;">
                                            <button class="btn btn-primary" type="submit">Filter</button>
                                            <a href="{{ url('admin/agent') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                               type="button">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab Navigation -->
                            <div class="tab-navigation">
                                <button class="tab-button active" data-tab="agent-info">AGENT INFO</button>
                                <button class="tab-button inactive" data-tab="reservations">RESERVATIONS</button>
                                <button class="tab-button inactive" data-tab="visit-schedule">VISIT SCHEDULE</button>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <div class="selected-count" id="selectedCount">0 items selected</div>
                                <button class="export-btn" id="exportBtn" onclick="exportAgents()">Export</button>
                                <button class="delete-btn" id="deleteSelected">Delete</button>
                            </div>
                            <!-- Tab Content -->
                            <!-- Agent Info Tab -->
                            <div class="tab-content active" id="agent-info">
                                <div class="data-table">
                                    <div class="table-header">
                                        <div class="table-row">
                                            <div class="table-cell checkbox">
                                                <input type="checkbox" id="selectAll" onclick="toggleAll(this)">
                                            </div>
                                            <div class="table-cell">#</div>
                                            <div class="table-cell">Agent Name</div>
                                            <div class="table-cell">Agency Name</div>
                                            <div class="table-cell">Created On</div>
                                            <div class="table-cell">Status</div>
                                            <div class="table-cell actions">Actions</div>
                                        </div>
                                    </div>
                                    <div class="table-body">
                                    <?php $i = $customers->perPage() * ($customers->currentPage() - 1); ?>
                                    @foreach ($customers as $cust)
                                            <?php $i++; ?>
                                            <div class="table-row main-row" data-id="{{ $cust->id }}">
                                                <div class="table-cell checkbox">
                                                    <input type="checkbox" class="box1" value="{{ $cust->id }}" onchange="updateSelectedCount()">
                                                </div>
                                                <div class="table-cell">{{ $i }}</div>
                                                <div class="table-cell">
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <div style="position: relative;">
                                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-user" style="color: #6c757d;"></i>
                                                            </div>
                                                            @if($cust->active)
                                                                <div style="position: absolute; top: -2px; right: -2px; width: 12px; height: 12px; background: #28a745; border-radius: 50%; border: 2px solid white;"></div>
                                                            @endif
                                                        </div>
                                                <span class="agent-name">{{ $cust->name }}</span>
                                                        <i class="fas fa-chevron-down expand-icon" style="cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                                <div class="table-cell">{{ $cust->agency->name ?? 'N/A' }}</div>
                                                <div class="table-cell">{{ web_date_in_timezone($cust->created_at, 'd-M-Y') }}</div>
                                                <div class="table-cell">
                                                    <span class="status-badge {{ $cust->active ? 'status-active' : 'status-inactive' }}">
                                                        {{ $cust->active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <div class="table-cell actions">
                                                <a href="{{ url('admin/agent/details/' . $cust->id . '?role=' . $role) }}"
                                                       class="btn btn-sm btn-primary" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <i class="fas fa-arrows-alt-v" style="cursor: pointer; color: #6c757d;"></i>
                                                </div>
                                            </div>
                                        
                                        <!-- Detail Row -->
                                            <div class="detail-row" data-parent="{{ $cust->id }}" style="display: none;">
                                                <div class="detail-content">
                                                    <div class="agency-info-header">
                                                        <h5>AGENT INFO</h5>
                                                        <div class="header-actions">
                                                            @if(!$cust->verified)
                                                            <a href="{{ url('admin/agent/approve/' . $cust->id) }}"
                                                                class="btn-action btn-success approveCustomer" 
                                                                title="Approve Agent"
                                                                data-message="Do you want to approve this agent?"
                                                                aria-hidden="true">
                                                                <i class="fas fa-check"></i>
                                                            </a>
                                                            @endif
                                                            <button class="btn-action btn-danger" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="agency-info-grid">
                                                        <!-- Left Column -->
                                                        <div class="info-column">
                                                            <div class="info-card">
                                                                <div class="info-icon">
                                                                    <i class="fas fa-building"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <label>Agency Name</label>
                                                                    <span>{{ $cust->agency->name ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="info-card">
                                                                <div class="info-icon">
                                                                    <i class="fas fa-envelope"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <label>Agent Email Address</label>
                                                                    <span>{{ $cust->email ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="info-card">
                                                                <div class="info-icon">
                                                                    <i class="fas fa-id-card"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <label>ID Card</label>
                                                                    @if(!$cust->id_card)
                                                                        <span>N/A</span>
                                                                    @endif
                                                                </div>
                                                                @if($cust->id_card)
                                                                    <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->id_card) }}', '_blank')">View</button>
                                                                @endif
                                                            </div>
                                                        </div>
                        
                                                        <!-- Right Column -->
                                                        <div class="info-column">
                                                            <div class="info-card">
                                                                <div class="info-icon">
                                                                    <i class="fas fa-phone"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <label>Agent Phone Number</label>
                                                                    <span>{{ $cust->phone ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="info-card">
                                                                <div class="info-icon">
                                                                    <i class="fas fa-certificate"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <label>Professional License</label>
                                                                    @if(!$cust->license)
                                                                        <span>N/A</span>
                                                                    @endif
                                                                </div>
                                                                @if($cust->license)
                                                                    <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->license) }}', '_blank')">View</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                    </div>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="col-sm-12 col-md-12 pull-right mt-3">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                    {!! $customers->appends(request()->input())->links('admin.template.pagination') !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Reservations Tab -->
                            <div class="tab-content" id="reservations">
                                <!-- Search and Filters Section -->
                                <div class="search-filter-section">
                                    <div class="search-section">
                                        <div class="search-bar">
                                            <input type="text" class="form-control" placeholder="Search By Name | Email | Phone Number" id="reservationSearch">
                                        </div>
                                    </div>
                                    
                                    <div class="filters-section">
                                        <div class="date-filters">
                                            <div class="date-input">
                                                <label>From</label>
                                                <input type="date" class="form-control" id="fromDateReservation">
                                            </div>
                                            <div class="date-input">
                                                <label>To</label>
                                                <input type="date" class="form-control" id="toDateReservation">
                                            </div>
                                        </div>
                                        
                                        <div class="selection-info">
                                            <span id="selectedCountReservation">0 items selected</span>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-sm" id="exportReservationsBtn">Export</button>
                                            <button class="btn btn-danger btn-sm" id="deleteReservationsBtn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Reservations Table -->
                                <div class="data-table">
                                    <div class="table-header">
                                        <div class="table-row">
                                            <div class="table-cell checkbox">
                                                <input type="checkbox" id="selectAllReservations" onclick="toggleAllReservations(this)">
                                            </div>
                                            <div class="table-cell">Agent Name</div>
                                            <div class="table-cell">Property</div>
                                            <div class="table-cell">Status</div>
                                            <div class="table-cell">Commission</div>
                                            <div class="table-cell">Created On</div>
                                        </div>
                                    </div>
                                    <div class="table-body" id="reservationsTableBody">
                                        <!-- Reservations will be loaded here via AJAX -->
                                        <div class="table-row">
                                            <div class="table-cell" colspan="6" style="text-align: center; padding: 40px;">
                                                <i class="fas fa-spinner fa-spin"></i> Loading reservations...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Visit Schedule Tab -->
                            <div class="tab-content" id="visit-schedule">
                                <!-- Search and Filters Section -->
                                <div class="search-filter-section">
                                    <div class="search-section">
                                        <div class="search-bar">
                                            <input type="text" class="form-control" placeholder="Search By Name | Email | Phone Number" id="visitScheduleSearch">
                                        </div>
                                    </div>
                                    
                                    <div class="filters-section">
                                        <div class="date-filters">
                                            <div class="date-input">
                                                <label>From</label>
                                                <input type="date" class="form-control" id="fromDateVisit">
                                            </div>
                                            <div class="date-input">
                                                <label>To</label>
                                                <input type="date" class="form-control" id="toDateVisit">
                                            </div>
                                        </div>
                                        
                                        <div class="selection-info">
                                            <span id="selectedCountVisit">0 items selected</span>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-warning btn-sm" id="exportVisitsBtn">Export</button>
                                            <button class="btn btn-danger btn-sm" id="deleteVisitsBtn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Visit Schedule Table -->
                                <div class="table-container">
                                    <table class="table table-hover" id="visitScheduleTable">
                                        <thead>
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAllVisits" onclick="toggleAllVisits(this)">
                                                </th>
                                                <th>Agent Name</th>
                                                <th>Project Name</th>
                                                <th>Unit Type</th>
                                                <th>Phone Number</th>
                                                <th>Date Of Visit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="visitsTableBody">
                                            <!-- Visit schedules will be loaded here via AJAX -->
                                            <tr>
                                                <td colspan="6" style="text-align: center; padding: 40px;">
                                                    <i class="fas fa-spinner fa-spin"></i> Loading visit schedules...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')
    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Remove active class from all buttons and add inactive
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.classList.add('inactive');
                    });
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked tab and corresponding content
                    this.classList.remove('inactive');
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                    
                    // Reset all checkboxes when switching tabs
                    resetAllCheckboxes();
                    
                    // Load data for the active tab
                    if (targetTab === 'reservations') {
                        loadReservations();
                    } else if (targetTab === 'visit-schedule') {
                        loadVisitSchedules();
                    }
                });
            });
            
            // Update selected count
            updateSelectedCount();
            
            // Reservation search functionality
            const reservationSearch = document.getElementById('reservationSearch');
            if (reservationSearch) {
                reservationSearch.addEventListener('input', function() {
                    filterReservations();
                });
            }
            
            // Visit schedule search functionality
            const visitScheduleSearch = document.getElementById('visitScheduleSearch');
            if (visitScheduleSearch) {
                visitScheduleSearch.addEventListener('input', function() {
                    filterVisitSchedules();
                });
            }
            
            // Reservation date filtering
            const fromDateReservation = document.getElementById('fromDateReservation');
            const toDateReservation = document.getElementById('toDateReservation');
            
            if (fromDateReservation) {
                fromDateReservation.addEventListener('change', function() {
                    filterReservations();
                });
            }
            
            if (toDateReservation) {
                toDateReservation.addEventListener('change', function() {
                    filterReservations();
                });
            }
            
            // Visit schedule date filtering
            const fromDateVisit = document.getElementById('fromDateVisit');
            const toDateVisit = document.getElementById('toDateVisit');
            
            if (fromDateVisit) {
                fromDateVisit.addEventListener('change', function() {
                    filterVisitSchedules();
                });
            }
            
            if (toDateVisit) {
                toDateVisit.addEventListener('change', function() {
                    filterVisitSchedules();
                });
            }
            
            // Export reservations button
            const exportReservationsBtn = document.getElementById('exportReservationsBtn');
            if (exportReservationsBtn) {
                exportReservationsBtn.addEventListener('click', function() {
                    const selectedReservations = document.querySelectorAll('.reservation-checkbox:checked');
                    if (selectedReservations.length === 0) {
                        alert('Please select reservations to export');
                        return;
                    }
                    
                    const reservationIds = Array.from(selectedReservations).map(cb => cb.value);
                    const exportUrl = `/admin/agent/export-reservations?ids=${reservationIds.join(',')}`;
                    window.open(exportUrl, '_blank');
                });
            }
            
            // Delete reservations button
            const deleteReservationsBtn = document.getElementById('deleteReservationsBtn');
            if (deleteReservationsBtn) {
                deleteReservationsBtn.addEventListener('click', function() {
                    const selectedReservations = document.querySelectorAll('.reservation-checkbox:checked');
                    if (selectedReservations.length === 0) {
                        alert('Please select reservations to delete');
                        return;
                    }
                    
                    if (confirm(`Are you sure you want to delete ${selectedReservations.length} selected reservation(s)?`)) {
                        const reservationIds = Array.from(selectedReservations).map(cb => cb.value);
                        
                        fetch('/admin/agent/delete-reservations', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                reservation_ids: reservationIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove deleted rows
                                selectedReservations.forEach(checkbox => {
                                    const row = checkbox.closest('.table-row');
                                    row.remove();
                                });
                                updateSelectedCount();
                                alert('Reservations deleted successfully');
                            } else {
                                alert('Error deleting reservations: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting reservations');
                        });
                    }
                });
            }
            
            // Export visits button
            const exportVisitsBtn = document.getElementById('exportVisitsBtn');
            if (exportVisitsBtn) {
                exportVisitsBtn.addEventListener('click', function() {
                    const selectedVisits = document.querySelectorAll('.visit-checkbox:checked');
                    if (selectedVisits.length === 0) {
                        alert('Please select visit schedules to export');
                        return;
                    }
                    
                    const visitIds = Array.from(selectedVisits).map(cb => cb.value);
                    const exportUrl = `/admin/agent/export-visit-schedules?ids=${visitIds.join(',')}`;
                    window.open(exportUrl, '_blank');
                });
            }
            
            // Delete visits button
            const deleteVisitsBtn = document.getElementById('deleteVisitsBtn');
            if (deleteVisitsBtn) {
                deleteVisitsBtn.addEventListener('click', function() {
                    const selectedVisits = document.querySelectorAll('.visit-checkbox:checked');
                    if (selectedVisits.length === 0) {
                        alert('Please select visit schedules to delete');
                        return;
                    }
                    
                    if (confirm(`Are you sure you want to delete ${selectedVisits.length} selected visit schedule(s)?`)) {
                        const visitIds = Array.from(selectedVisits).map(cb => cb.value);
                        
                        fetch('/admin/agent/delete-visit-schedules', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                visit_ids: visitIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove deleted rows
                                selectedVisits.forEach(checkbox => {
                                    const row = checkbox.closest('.table-row');
                                    row.remove();
                                });
                                updateSelectedCount();
                                alert('Visit schedules deleted successfully');
                            } else {
                                alert('Error deleting visit schedules: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting visit schedules');
                        });
                    }
                });
            }
        });
        
        // Filter reservations function
        function filterReservations() {
            const searchTerm = document.getElementById('reservationSearch').value.toLowerCase();
            const fromDate = document.getElementById('fromDateReservation').value;
            const toDate = document.getElementById('toDateReservation').value;
            const rows = document.querySelectorAll('#reservationsTableBody .table-row');
            
            rows.forEach(row => {
                const agentName = row.querySelector('.agent-name')?.textContent.toLowerCase() || '';
                const propertyName = row.cells[2]?.textContent.toLowerCase() || '';
                const statusText = row.cells[3]?.textContent.toLowerCase() || '';
                const commissionText = row.cells[4]?.textContent.toLowerCase() || '';
                const createdDateText = row.cells[5]?.textContent.toLowerCase() || '';
                
                let showRow = true;
                
                // Apply search filter
                if (searchTerm && !agentName.includes(searchTerm) && !propertyName.includes(searchTerm) && !statusText.includes(searchTerm) && !commissionText.includes(searchTerm) && !createdDateText.includes(searchTerm)) {
                    showRow = false;
                }
                
                // Apply date filter
                if (showRow && (fromDate || toDate)) {
                    const createdDateValue = row.cells[5]?.textContent;
                    if (createdDateValue && createdDateValue !== 'N/A') {
                        const createdDate = new Date(createdDateValue);
                        const fromDateObj = fromDate ? new Date(fromDate) : null;
                        const toDateObj = toDate ? new Date(toDate) : null;
                        
                        if (fromDateObj && createdDate < fromDateObj) {
                            showRow = false;
                        }
                        if (toDateObj && createdDate > toDateObj) {
                            showRow = false;
                        }
                    }
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        // Filter visit schedules function
        function filterVisitSchedules() {
            const searchTerm = document.getElementById('visitScheduleSearch').value.toLowerCase();
            const fromDate = document.getElementById('fromDateVisit').value;
            const toDate = document.getElementById('toDateVisit').value;
            const rows = document.querySelectorAll('#visitScheduleTable tbody tr.main-row');
            
            rows.forEach(row => {
                const agentName = row.querySelector('.agent-name')?.textContent.toLowerCase() || '';
                const projectName = row.cells[2]?.textContent.toLowerCase() || '';
                const unitType = row.cells[3]?.textContent.toLowerCase() || '';
                const phoneNumber = row.cells[4]?.textContent.toLowerCase() || '';
                const visitDateText = row.cells[5]?.textContent.toLowerCase() || '';
                
                // Get client email from detail row for search
                const rowId = row.getAttribute('data-id');
                const detailRow = document.querySelector(`tr.detail-row[data-parent="${rowId}"]`);
                const clientEmail = detailRow ? detailRow.querySelector('.info-content span')?.textContent.toLowerCase() || '' : '';
                
                // Extract visit date from the visit date cell
                const visitDateSpan = row.querySelector('.visit-date');
                const visitDateValue = visitDateSpan ? visitDateSpan.getAttribute('data-date') : null;
                
                let showRow = true;
                
                // Apply search filter (including client email from detail row)
                if (searchTerm && !agentName.includes(searchTerm) && !projectName.includes(searchTerm) && !unitType.includes(searchTerm) && !phoneNumber.includes(searchTerm) && !visitDateText.includes(searchTerm) && !clientEmail.includes(searchTerm)) {
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
                        // If no data-date attribute, try to parse from the displayed text
                        // This is a fallback for cases where the data-date attribute might not be set
                        showRow = false;
                    }
                }
                
                if (showRow) {
                    row.style.display = '';
                    // Also show the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`tr.detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = '';
                    }
                } else {
                    row.style.display = 'none';
                    // Also hide the corresponding detail row
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`tr.detail-row[data-parent="${rowId}"]`);
                    if (detailRow) {
                        detailRow.style.display = 'none';
                    }
                }
            });
        }
        
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.box1');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
            updateSelectedCount();
        }
        
        function toggleAllReservations(source) {
            const checkboxes = document.querySelectorAll('.reservation-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
            updateSelectedCount();
        }
        
        function toggleAllVisits(source) {
            const checkboxes = document.querySelectorAll('.visit-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
            updateSelectedCount();
        }
        
        function updateSelectedCount() {
            // Update agent info tab selected count
            const agentCheckboxes = document.querySelectorAll('.box1:checked');
            const agentSelectedCount = document.getElementById('selectedCount');
            if (agentSelectedCount) {
                agentSelectedCount.textContent = `${agentCheckboxes.length} items selected`;
            }
            
            // Update reservations tab selected count
            const reservationCheckboxes = document.querySelectorAll('.reservation-checkbox:checked');
            const reservationSelectedCount = document.getElementById('selectedCountReservation');
            if (reservationSelectedCount) {
                reservationSelectedCount.textContent = `${reservationCheckboxes.length} items selected`;
            }
            
            // Update visit schedule tab selected count
            const visitCheckboxes = document.querySelectorAll('.visit-checkbox:checked');
            const visitSelectedCount = document.getElementById('selectedCountVisit');
            if (visitSelectedCount) {
                visitSelectedCount.textContent = `${visitCheckboxes.length} items selected`;
            }
        }
        
        function resetAllCheckboxes() {
            // Reset all select all checkboxes
            const selectAllCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="selectAll"]');
            selectAllCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Reset all individual checkboxes
            const allCheckboxes = document.querySelectorAll('.box1, .reservation-checkbox, .visit-checkbox');
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Update selected count
            updateSelectedCount();
        }
        
        // Load reservations via AJAX
        function loadReservations() {
            const tableBody = document.getElementById('reservationsTableBody');
            tableBody.innerHTML = '<div class="table-row"><div class="table-cell" colspan="6" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Loading reservations...</div></div>';
            
            fetch('{{ url("admin/agent/reservations") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderReservations(data.reservations);
                } else {
                    tableBody.innerHTML = '<div class="table-row"><div class="table-cell" colspan="6" style="text-align: center; padding: 40px;">No reservations found</div></div>';
                }
            })
            .catch(error => {
                console.error('Error loading reservations:', error);
                tableBody.innerHTML = '<div class="table-row"><div class="table-cell" colspan="6" style="text-align: center; padding: 40px;">Error loading reservations</div></div>';
            });
        }
        
        // Load visit schedules via AJAX
        function loadVisitSchedules() {
            const tableBody = document.getElementById('visitsTableBody');
            tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Loading visit schedules...</td></tr>';
            
            fetch('{{ url("admin/agent/visit-schedules") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderVisitSchedules(data.visits);
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;">No visit schedules found</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error loading visit schedules:', error);
                tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;">Error loading visit schedules</td></tr>';
            });
        }
        
        // Render reservations data
        function renderReservations(reservations) {
            const tableBody = document.getElementById('reservationsTableBody');
            let html = '';
            
            if (reservations.length === 0) {
                html = '<div class="table-row"><div class="table-cell" colspan="6" style="text-align: center; padding: 40px;">No reservations found</div></div>';
            } else {
                reservations.forEach((reservation, index) => {
                    // Format the created date to match the image format
                    const createdDate = reservation.created_at ? new Date(reservation.created_at).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }).replace(/\s/g, '-') : 'N/A';
                    
                    html += `
                        <div class="table-row">
                            <div class="table-cell checkbox">
                                <input type="checkbox" class="reservation-checkbox" value="${reservation.id}" onchange="updateSelectedCount()">
                            </div>
                            <div class="table-cell">
                                <div class="agent-info">
                                    <div class="agent-avatar">
                                        <i class="fas fa-user"></i>
                                        <div class="status-dot"></div>
                                    </div>
                                    <span class="agent-name">${reservation.agent_name || 'N/A'}</span>
                                </div>
                            </div>
                            <div class="table-cell">${reservation.property_name || 'N/A'}</div>
                            <div class="table-cell">
                                <span class="status-badge status-${reservation.status.toLowerCase().replace(/\s+/g, '')}">
                                    ${reservation.status_label}
                                </span>
                            </div>
                            <div class="table-cell">${reservation.commission || 0}%</div>
                            <div class="table-cell">${createdDate}</div>
                        </div>
                    `;
                });
            }
            
            tableBody.innerHTML = html;
            updateSelectedCount(); // Update count after rendering
        }
        
        // Render visit schedules data
        function renderVisitSchedules(visits) {
            const tableBody = document.getElementById('visitsTableBody');
            let html = '';
            
            if (visits.length === 0) {
                html = '<tr><td colspan="6" style="text-align: center; padding: 40px;">No visit schedules found</td></tr>';
            } else {
                visits.forEach((visit, index) => {
                    // Format the visit date to match the image format (15-Jan-2028)
                    const visitDate = visit.visit_time ? new Date(visit.visit_time).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }).replace(/\s/g, '-') : 'N/A';
                    
                    // Format visit time for detail view
                    const visitTime = visit.visit_time ? new Date(visit.visit_time).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }) : 'N/A';
                    
                    html += `
                        <!-- Main Row -->
                        <tr class="main-row" data-id="${visit.id}">
                            <td>
                                <input type="checkbox" class="visit-checkbox" value="${visit.id}" onchange="updateSelectedCount()">
                            </td>
                            <td>
                                <div class="agent-info">
                                    <div class="agent-avatar">
                                        <i class="fas fa-user"></i>
                                        <div class="status-dot"></div>
                                    </div>
                                    <span class="agent-name">${visit.agent_name || 'N/A'}</span>
                                </div>
                            </td>
                            <td>${visit.project_name || 'N/A'}</td>
                            <td>${visit.unit_type || 'N/A'}</td>
                            <td>${visit.client_phone_number || 'N/A'}</td>
                            <td>
                                <div class="visit-section">
                                    <span class="visit-date" data-date="${visit.visit_time}">${visitDate}</span>
                                    <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Detail Row -->
                        <tr class="detail-row" data-parent="${visit.id}" style="display: none;">
                            <td colspan="6">
                                <div class="detail-content">
                                    <div class="schedule-info-header">
                                        <h6>SCHEDULE INFO</h6>
                                        <div class="header-actions">
                                            <div class="form-indicator">
                                                <span class="badge badge-info">1 Active Form Submitted</span>
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
                                                    <label>Client Name</label>
                                                    <span>${visit.client_name || 'N/A'}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Client Email Address</label>
                                                    <span>${visit.client_email_address || 'N/A'}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Project</label>
                                                    <span>${visit.project_name || 'N/A'}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-id-card"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Client ID</label>
                                                     <span>${visit.client_id || 'N/A'}</span>
                                                </div>
                                                ${visit.client_id_url ? '<button class="view-btn" onclick="window.open(\'' + visit.client_id_url + '\', \'_blank\')">View</button>' : ''}
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column -->
                                        <div class="info-column">
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Client Phone Number</label>
                                                    <span>${visit.client_phone_number || 'N/A'}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Visit Time</label>
                                                    <span>${visitTime}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Unit Type</label>
                                                    <span>${visit.unit_type || 'N/A'}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="info-card">
                                                <div class="info-icon">
                                                    <i class="fas fa-info-circle"></i>
                                                </div>
                                                <div class="info-content">
                                                    <label>Visit Purpose</label>
                                                    <span>${visit.visit_purpose || 'N/A'}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }
            
            tableBody.innerHTML = html;
            updateSelectedCount(); // Update count after rendering
            
            // Add expand/collapse functionality for visit schedules
            addVisitScheduleExpandFunctionality();
        }
        
        // Add expand/collapse functionality for visit schedules
        function addVisitScheduleExpandFunctionality() {
            // Add click event to expand icons
            document.querySelectorAll('#visitScheduleTable .expand-icon').forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const row = this.closest('.main-row');
                    const rowId = row.getAttribute('data-id');
                    const detailRow = document.querySelector(`tr.detail-row[data-parent="${rowId}"]`);
                    
                    if (detailRow.style.display === 'none' || detailRow.style.display === '') {
                        // Close all other detail rows
                        document.querySelectorAll('#visitScheduleTable .detail-row').forEach(detail => {
                            detail.style.display = 'none';
                        });
                        document.querySelectorAll('#visitScheduleTable .expand-icon').forEach(icon => {
                            icon.classList.remove('fa-chevron-up');
                            icon.classList.add('fa-chevron-down');
                        });
                        
                        // Open this detail row
                        detailRow.style.display = 'block';
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

            // Add click event to agent name for expand/collapse
            document.querySelectorAll('#visitScheduleTable .agent-name').forEach(name => {
                name.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const icon = this.closest('tr').querySelector('.expand-icon');
                    if (icon) {
                        icon.click();
                    }
                });
            });
        }
        
        // View functions
        function viewReservation(id) {
            // Implement view reservation functionality
            console.log('View reservation:', id);
        }
        
        function viewVisitSchedule(id) {
            // Implement view visit schedule functionality
            console.log('View visit schedule:', id);
        }

        // Master-Details Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event to expand icons
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
                        detailRow.style.display = 'block';
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

            // Add click event to agent name for expand/collapse
            document.querySelectorAll('.agent-name').forEach(name => {
                name.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const icon = this.nextElementSibling;
                    icon.click();
                });
            });

            // View button functionality
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const card = this.closest('.info-card');
                    const label = card.querySelector('label').textContent;
                    const value = card.querySelector('span').textContent;
                    
                    if (value !== 'N/A') {
                        Swal.fire({
                            title: label,
                            text: value,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: label,
                            text: 'No information available',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Reject button handler (Approve is handled by the approveCustomer class below)
            document.querySelectorAll('.btn-action.btn-danger').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Get the agent ID from the parent row
                    const row = this.closest('.detail-row');
                    const parentRow = document.querySelector(`.main-row[data-id="${row.getAttribute('data-parent')}"]`);
                    const agentId = parentRow ? parentRow.getAttribute('data-id') : null;
                    
                    if (!agentId) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Could not find agent ID',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    
                    Swal.fire({
                        title: 'Delete Agent',
                        text: 'Are you sure you want to delete this agent? This will set verified to 0 and mark as deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete!'
                    }).then((result) => {
                        if (result.value) {
                            // Get CSRF token
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                            
                            // Make AJAX call to reject agent
                            fetch('/admin/agent/reject', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    agent_id: agentId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === '1') {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        // Reload the page to reflect changes
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong while deleting agent',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }
                    });
                });
            });
        });

        // Delete Selected Handler
        document.getElementById('deleteSelected').addEventListener('click', function () {
            let selected = [];
            document.querySelectorAll('.box1:checked').forEach(cb => {
                selected.push(cb.value);
            });

            if (selected.length === 0) {
                Swal.fire('No Selection', 'Please select at least one record to delete.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Selected agents will be deleted (set as deleted, unverified, and inactive)!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.value) {
                    // Send the request via AJAX or create a form
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("admin/agent/deleteAll") }}';

                    // Add CSRF token
                    let csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Add _method for DELETE
                    let method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    // Add selected IDs
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_all_id';
                    input.value = selected.join(',');
                    form.appendChild(input);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Approval Handler - Using event delegation to handle dynamically shown elements
        document.addEventListener('click', function(e) {
            if (e.target.closest('.approveCustomer')) {
                e.preventDefault();
                e.stopPropagation();
                
                const button = e.target.closest('.approveCustomer');
                const message = button.getAttribute('data-message');
                const url = button.getAttribute('href');
                const agentId = url.split('/').pop(); // Extract agent ID from URL

                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, approve!'
                }).then((result) => {
                    if (result.value) {
                        // Show loading state
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we approve the agent.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Make AJAX request to approve the agent
                        fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hide the loading state
                                Swal.close();
                                
                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Agent has been approved successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Update the UI - hide approve buttons and update status
                                const approveButtons = document.querySelectorAll(`[href*="${agentId}"]`);
                                approveButtons.forEach(btn => {
                                    if (btn.classList.contains('approveCustomer')) {
                                        btn.style.display = 'none';
                                    }
                                });

                                // Update the toggle status to active if it exists
                                const toggleSwitch = document.querySelector(`input[data-id="${agentId}"]`);
                                if (toggleSwitch) {
                                    toggleSwitch.checked = true;
                                    toggleSwitch.closest('.toggle').classList.remove('off');
                                    toggleSwitch.closest('.toggle').classList.add('on');
                                }

                                // Update any status indicators
                                const statusCells = document.querySelectorAll(`tr[data-parent="${agentId}"] .status-indicator`);
                                statusCells.forEach(cell => {
                                    cell.textContent = 'Approved';
                                    cell.className = 'status-indicator approved';
                                });

                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Failed to approve agent. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while approving the agent. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
            }
        });

        // Export Agents Function
        function exportAgents() {
            const selectedAgents = document.querySelectorAll('.box1:checked');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            if (selectedAgents.length === 0) {
                // Ask user if they want to export all agents matching filters or select specific ones
                Swal.fire({
                    title: 'Export Options',
                    text: 'No agents selected. Would you like to export all agents matching your current filters?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Export All Matching Filters',
                    cancelButtonText: 'Select Agents'
                }).then((result) => {
                    if (result.value) {
                        // Export all agents matching current filters (no IDs = all matching)
                        performExport(null);
                    } else {
                        // Show message to select agents
                        Swal.fire({
                            title: 'Please Select Agents',
                            text: 'Please select at least one agent to export, or choose "Export All Matching Filters" to export all agents that match your current filters.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                return;
            }
            
            // Check if "Select All" is checked
            if (selectAllCheckbox && selectAllCheckbox.checked) {
                // Export all agents matching current filters (no IDs = all matching)
                performExport(null);
            } else {
                // Export only selected agents
                performExport(Array.from(selectedAgents).map(cb => cb.value));
            }
        }
        
        // Perform the actual export
        function performExport(agentIds = null) {
            let exportUrl = `{{ url('admin/agent/export-employees') }}`;
            
            // Build query parameters
            const params = new URLSearchParams();
            
            // Add filter parameters from the form
            const searchText = document.querySelector('input[name="search_text"]')?.value;
            const fromDate = document.querySelector('input[name="from"]')?.value;
            const toDate = document.querySelector('input[name="to"]')?.value;
            
            if (searchText) {
                params.append('search_text', searchText);
            }
            if (fromDate) {
                params.append('from', fromDate);
            }
            if (toDate) {
                params.append('to', toDate);
            }
            
            // If specific IDs are provided, add them
            if (agentIds && agentIds.length > 0) {
                params.append('ids', agentIds.join(','));
            }
            
            // Construct final URL
            if (params.toString()) {
                exportUrl += `?${params.toString()}`;
            }
            
            // Determine export message
            const selectAllCheckbox = document.getElementById('selectAll');
            const isSelectAll = selectAllCheckbox && selectAllCheckbox.checked;
            const exportMessage = isSelectAll ? 
                'Please wait while we prepare your export of all agents matching your filters.' : 
                'Please wait while we prepare your export.';
            
            // Show loading message
            Swal.fire({
                title: 'Exporting...',
                text: exportMessage,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Create a temporary link to trigger download
            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Hide loading message after a short delay
            setTimeout(() => {
                Swal.close();
                const successMessage = isSelectAll ? 
                    'All agents matching your filters have been exported successfully.' : 
                    'Your selected agent data has been exported successfully.';
                    
                Swal.fire({
                    title: 'Export Complete',
                    text: successMessage,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 1000);
        }

        // Download Document Function
        function downloadDocument(filename) {
            if (filename && filename !== 'N/A') {
                window.open('{{ url("admin/agent/download-document") }}/' + filename, '_blank');
            } else {
                Swal.fire({
                    title: 'No Document',
                    text: 'No document available for download.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>
@stop
