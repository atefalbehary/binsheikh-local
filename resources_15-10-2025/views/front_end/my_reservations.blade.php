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
                        <!--breadcrumbs-list-->

                        <!--breadcrumbs-list end-->
                        <!--main-content-->
                        <div class="main-content  ms_vir_height mt-5 pt-4">
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

                                                        <li><a href="{{ url('my-reservations') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.my_reservations') }}</a></li>
                                                        <li><a href="{{ url('favorite') }}">{{ __('messages.favorite') }}
                                                            <!-- <span>6</span> -->
                                                        </a></li>
                                                        <li><a href="{{ url('visit-schedule') }}">{{ __('messages.visit_schedule') }}</a></li>
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
                                            <div class="dashboard-title-item"><span>{{ __('messages.my_reservations') }}</span></div>
                                            <!-- Tariff Plan menu -->
                                            <!-- Tariff Plan menu end -->
                                        </div>
                                        <!-- Master-Details Table -->
                                        <div class="table-container">
                                            <table class="table table-hover" id="reservationsTable">
                                                <thead>
                                                    <tr>
                                                        <th width="50">
                                                            <input type="checkbox" id="selectAllReservations" onclick="toggleAllReservations(this)">
                                                        </th>
                                                        <th>{{ __('messages.property_name') }}</th>
                                                        <th>{{ __('messages.unit_number') }}</th>
                                                        <th>{{ __('messages.project') }}</th>
                                                        <th>{{ __('messages.reservation_date') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($reservations ?? [] as $index => $reservation)
                                                    <!-- Main Row -->
                                                    <tr class="main-row" data-id="{{ $reservation->id }}">
                                                        <td>
                                                            <input type="checkbox" class="reservation-checkbox" value="{{ $reservation->id }}">
                                                        </td>
                                                        <td>
                                                            <div class="property-info">
                                                                <div class="property-avatar">
                                                                    @if(isset($reservation->property->images[0]))
                                                                        <img src="{{ aws_asset_path($reservation->property->images[0]->image) }}" alt="{{ $reservation->property->name }}" class="property-img-small">
                                                                    @else
                                                                        <i class="fas fa-home"></i>
                                                                    @endif
                                                                </div>
                                                                <span class="property-name">{{ $reservation->property->name ?? 'N/A' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $reservation->property->apartment_no ?? 'N/A' }}</td>
                                                        <td>{{ $reservation->property->project->name ?? 'N/A' }}</td>
                                                        <td>
                                                            <div class="reservation-section">
                                                                <span class="reservation-date" data-date="{{ $reservation->created_at }}">{{ web_date_in_timezone($reservation->created_at, 'd-M-Y') }}</span>
                                                                <button class="btn btn-sm btn-info">View</button>
                                                                <i class="fas fa-chevron-down expand-icon" style="margin-left: 10px; cursor: pointer;"></i>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Detail Row -->
                                                    <tr class="detail-row" data-parent="{{ $reservation->id }}" style="display: none;">
                                                        <td colspan="5">
                                                            <div class="detail-content">
                                                                <div class="reservation-info-header">
                                                                    <h6>{{ __('messages.reservation_details') }}</h6>
                                                                    <div class="header-actions">
                                                                        <div class="form-indicator">
                                                                            <span class="badge badge-info">{{ __('messages.reservation_active') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="reservation-info-grid">
                                                                    <!-- Left Column -->
                                                                    <div class="info-column">
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-home"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.property_name') }}</label>
                                                                                <span>{{ $reservation->property->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-building"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.project') }}</label>
                                                                                <span>{{ $reservation->property->project->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-hashtag"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.unit_number') }}</label>
                                                                                <span>{{ $reservation->property->apartment_no ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-ruler"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.size_net') }}</label>
                                                                                <span>{{ $reservation->property->area ?? 'N/A' }} m²</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Right Column -->
                                                                    <div class="info-column">
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-calendar"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.reservation_date') }}</label>
                                                                                <span>{{ web_date_in_timezone($reservation->created_at, 'd-M-Y h:i A') ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-dollar-sign"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.total_amount') }}</label>
                                                                                <span>{{ moneyFormat($reservation->property->price ?? 0) }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-credit-card"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.paid_amount') }}</label>
                                                                                <span>{{ moneyFormat(0) }}</span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="info-card">
                                                                            <div class="info-icon">
                                                                                <i class="fas fa-user-tie"></i>
                                                                            </div>
                                                                            <div class="info-content">
                                                                                <label>{{ __('messages.agent_name') }}</label>
                                                                                <span>{{ $reservation->agent->name ?? 'N/A' }}</span>
                                                                            </div>
                                                                        </div>
                                                    </div>
                                                </div>

                                                                <!-- Payment Plan Section -->
                                                                <div class="payment-plan-section">
                                                                    <div class="payment-plan-header">
                                                                        <h6>{{ __('messages.payment_plan') }}</h6>
                                                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal_{{ $reservation->id }}">{{ __('messages.view_payment_plan') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Payment Plan Modal -->
                                                    <div class="modal fade" id="paymentModal_{{ $reservation->id }}" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="paymentModalLabel">{{ __('messages.payment_plan') }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>{{ __('messages.unit_number') }}</th>
                                                                                            <th>{{ __('messages.size_net') }}</th>
                                                                                            <th>{{ __('messages.full_price') }}</th>
                                                                                            <th>{{ __('messages.management_fees') }}</th>
                                                                                            <th>{{ __('messages.total') }}</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>{{ $reservation->property->apartment_no ?? 'N/A' }}</td>
                                                                                            <td>{{ $reservation->property->area ?? 'N/A' }} m²</td>
                                                                                            <td>{{ moneyFormat($reservation->property->price ?? 0) }}</td>
                                                                                            <td>{{ moneyFormat(($settings->service_charge_perc / 100) * ($reservation->property->price ?? 0)) }}</td>
                                                                                            <td>{{ moneyFormat(($reservation->property->price ?? 0) + (($settings->service_charge_perc / 100) * ($reservation->property->price ?? 0))) }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table class="payment-table table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>{{ __('messages.payment') }}</th>
                                                                                            <th>{{ __('messages.month') }}</th>
                                                                                            <th>{{ __('messages.amount') }}</th>
                                                                                            <th>{{ __('messages.percentage') }}</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr class="payment-row-highlight">
                                                                                            <td>{{ __('messages.reservation_amount') }}</td>
                                                                                            <td>{{ web_date_in_timezone($reservation->created_at, 'M-y') }}</td>
                                                                                            <td>{{ moneyFormat(0) }}</td>
                                                                                            <td>100%</td>
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
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">{{ __('messages.no_reservations_found') }}</td>
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

    /* Property Info Styles */
    .property-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .property-avatar {
        width: 30px;
        height: 30px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .property-avatar i {
        color: white;
        font-size: 14px;
    }

    .property-img-small {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .property-name {
        font-weight: 500;
        color: #333;
    }

    /* Reservation Section Styles */
    .reservation-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reservation-date {
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

    .reservation-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .reservation-info-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }

    .form-indicator .badge {
        font-size: 11px;
        padding: 4px 8px;
    }

    /* Reservation Info Grid */
    .reservation-info-grid {
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

    /* Payment Plan Section */
    .payment-plan-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
    }

    .payment-plan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .payment-plan-header h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reservation-info-grid {
            grid-template-columns: 1fr;
        }

        .property-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .reservation-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .payment-plan-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
    }
</style>

<script>
    $(document).ready(function() {
        // Toggle all reservations
        function toggleAllReservations(source) {
            document.querySelectorAll('.reservation-checkbox').forEach(checkbox => {
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

    @if (session('success'))
        show_msg(1, "{{ session('success') }}")
    @endif

    @if (session('error'))
        show_msg(0, "{{ session('error') }}")
    @endif
</script>
@stop
