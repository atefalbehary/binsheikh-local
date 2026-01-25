@extends('admin.template.layout')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .agency-name {
        cursor: pointer;
        color: #007bff;
    }
    
    .agency-name:hover {
        text-decoration: underline;
    }
    
    .expand-icon {
        transition: transform 0.3s ease;
    }
    
    .detail-row {
        background-color: #f8f9fa;
    }
    
    .detail-content {
        padding: 20px;
        background-color: #f8f9fa;
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
    }
</style>
@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> {{$page_heading}}</div>
                        <div class="card-body">
                            <div class="col-md-8 mb-0" style="top:51px">
                                <form action="{{ url('admin/customer') }}" method="get" >
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
                                            <a href="{{ url('admin/customer') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                               type="button">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="float-right col-md-3  mb-2" >
                                <button id="deleteSelected" class="btn btn-danger">Delete Selected</button>
                            </div>

                            <table class="table table-responsive-sm table-bordered" id="agencyTable">
                                <thead>
                                    <tr>
                                        <th><input  type="checkbox" class="" id="selectAll"
                                                   onclick="toggleAll(this)">
                                        </th>
                                        <th>#</th>
                                        <th>Agency Name</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $customers->perPage() * ($customers->currentPage() - 1); ?>
                                    @foreach ($customers as $cust)
                                        <?php
                                        $i++;
                                        $checked = $cust->active ? 'checked' : '';
                                        ?>
                                        <!-- Main Row -->
                                        <tr role="row" class="main-row" data-id="{{ $cust->id }}">
                                            <td><input type="checkbox" class="box1" value="{{ $cust->id }}"></td>
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">
                                                <span class="agency-name">{{ $cust->name }}</span>
                                                <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                            </td>
                                            <td class="trVOE">{{ web_date_in_timezone($cust->created_at, 'd-M-Y h:i A') }}</td>
                                            <td>
                                                <input class="toggle_status"
                                                    data-url="{{ url('admin/customer/change_status') }}" type="checkbox"
                                                    {{ $checked }} data-id="{{ $cust->id }}" data-toggle="toggle"
                                                    data-on="Active" data-off="Inactive" data-onstyle="success"
                                                    data-offstyle="danger">
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/customer/delete/' . $cust->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this agency?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                                <a href="{{ url('admin/agency/details/' . $cust->id) }}"
                                                    class="btn btn-outline-info active" title="View Details"
                                                    aria-hidden="true"><i class="fas fa-eye fa-1x"></i></a>
                                                @if(!$cust->verified)
                                                <a href="{{ url('admin/customer/approve/' . $cust->id) }}"
                                                    class="btn btn-outline-success active approveCustomer" title="Approve Agency"
                                                    data-message="Do you want to approve this agency?" aria-hidden="true"><i class="fas fa-check fa-1x"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <!-- Detail Row -->
                                        <tr class="detail-row" data-parent="{{ $cust->id }}" style="display: none;">
                                            <td colspan="6">
                                                <div class="detail-content">
                                                    <div class="agency-info-header">
                                                        <h5>AGENCY INFO</h5>
                                                        <div class="header-actions">
                                                            @if(!$cust->verified)
                                                            <a href="{{ url('admin/customer/approve/' . $cust->id) }}"
                                                                class="btn-action btn-success approveCustomer" 
                                                                title="Approve Agency"
                                                                data-message="Do you want to approve this agency?"
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
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agency Name</label>
                                    <span>{{ $cust->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agency Email Address</label>
                                    <span>{{ $cust->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="info-content">
                                    <label>CR</label>
                                    @if(!$cust->cr)
                                      <span>N/A</span>
                                    @endif
                                </div>
                                <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->cr) }}', '_blank')">View</button>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-file-signature"></i>
                                </div>
                                <div class="info-content">
                                    <label>Authorized signatory</label>
                                    @if(!$cust->authorized_signatory)
                                      <span>N/A</span>
                                    @endif
                                </div>
                                <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->authorized_signatory) }}', '_blank')">View</button>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="info-column">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <label>Agency Phone Number</label>
                                    <span>{{ $cust->phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="info-content">
                                    <label>Trade License</label>
                                    @if(!$cust->license)
                                      <span>N/A</span>
                                    @endif
                                </div>
                                <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->license) }}', '_blank')">View</button>
                            </div>
                            
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="info-content">
                                    <label>Professional License</label>
                                    @if(!$cust->professional_practice_certificate)
                                      <span>N/A</span>
                                    @endif
                                </div>
                                <button class="view-btn" onclick="window.open('{{ aws_asset_path($cust->professional_practice_certificate) }}', '_blank')">View</button>
                            </div>
                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $customers->appends(request()->input())->links('admin.template.pagination') !!}
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
        function toggleAll(source) {
            document.querySelectorAll('.box1').forEach(checkbox => checkbox.checked = source.checked);
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

            // Add click event to agency name for expand/collapse
            document.querySelectorAll('.agency-name').forEach(name => {
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
                    
                    Swal.fire({
                        title: 'Reject Agency',
                        text: 'Are you sure you want to reject this agency?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, reject!'
                    }).then((result) => {
                        if (result.value) {
                            // Here you can add the actual rejection logic
                            Swal.fire({
                                title: 'Success!',
                                text: 'Agency has been rejected successfully.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
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
                text: "Selected agencies will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.value) {
                    console.log("dd");
                    // Send the request via AJAX or create a form
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("admin.customer.deleteAll") }}';

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
                const agencyId = url.split('/').pop(); // Extract agency ID from URL

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
                            text: 'Please wait while we approve the agency.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Make AJAX request to approve the agency
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
                                    text: 'Agency has been approved successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Update the UI - hide approve buttons and update status
                                const approveButtons = document.querySelectorAll(`[href*="${agencyId}"]`);
                                approveButtons.forEach(btn => {
                                    if (btn.classList.contains('approveCustomer')) {
                                        btn.style.display = 'none';
                                    }
                                });

                                // Update the toggle status to active if it exists
                                const toggleSwitch = document.querySelector(`input[data-id="${agencyId}"]`);
                                if (toggleSwitch) {
                                    toggleSwitch.checked = true;
                                    toggleSwitch.closest('.toggle').classList.remove('off');
                                    toggleSwitch.closest('.toggle').classList.add('on');
                                }

                                // Update any status indicators
                                const statusCells = document.querySelectorAll(`tr[data-parent="${agencyId}"] .status-indicator`);
                                statusCells.forEach(cell => {
                                    cell.textContent = 'Approved';
                                    cell.className = 'status-indicator approved';
                                });

                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'Failed to approve agency. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while approving the agency. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
            }
        });
    </script>
@stop
