@extends('front_end.template.layout')
@section('header')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
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
                        <!--main-content-->
                        <div class="main-content  ms_vir_height mt-5 pt-4">
                            <!--boxed-container-->
                            <div class="boxed-container" style="background: #f9f9f9;">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="boxed-content btf_init">
                                            <div class="user-dasboard-menu_wrap">
                                                <div class="user-dasboard-menu-header">
                                                    <div class="user-dasboard-menu_header-avatar">
                                                        <img src="{{ asset('') }}front-assets/images/avatar/profile-icon.png" alt="">
                                                        <span><strong>{{ \Auth::user()->name }}</strong></span>
                                                        <div class="db-menu_modile_btn"><strong>{{ __('messages.menu') }}</strong><i class="fa-regular fa-bars"></i></div>
                                                    </div>
                                                </div>
                                                @include('front_end.userMenu')
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <div class="dashboard-title">
                                            <div class="dashboard-title-item"><span>Notifications</span></div>
                                            <div class="dashboard-title-actions"></div>
                                        </div>
                                        <div class="db-container">
                                            <div class="custom-form bg-white p-4 h-100">

                                                @if(session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if(session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif

                                                @if(!$tableReady)
                                                    <div class="alert alert-warning mb-0">
                                                        Notifications table not found. Please run migration first:
                                                        <strong>php artisan migrate</strong>
                                                    </div>
                                                @elseif($notifications->isEmpty())
                                                    <div class="notifications-shell">
                                                        <p class="text-muted mb-0">No notifications found.</p>
                                                    </div>
                                                @else
                                                    <div class="notifications-shell">
                                                        <div class="table-responsive">
                                                            <table id="notifications-table" class="display notifications-datatable w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Title</th>
                                                                        <th>Message</th>
                                                                        <th>Channel</th>
                                                                        <th>Date</th>
                                                                        <th>Link</th>
                                                                        <th>View</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($notifications as $notification)
                                                                        <tr class="{{ (int) $notification->is_read === 0 ? 'unread-row' : '' }}">
                                                                            <td>{{ $notification->title }}</td>
                                                                            <td>{{ $notification->body ?? '-' }}</td>
                                                                            <td>{{ strtoupper($notification->channel ?? 'PUSH') }}</td>
                                                                            <td data-order="{{ $notification->created_at ? \Carbon\Carbon::parse($notification->created_at)->timestamp : 0 }}">
                                                                                {{ $notification->created_at ? \Carbon\Carbon::parse($notification->created_at)->format('d M Y, h:i A') : '-' }}
                                                                            </td>
                                                                            <td>
                                                                                @if(!empty($notification->deep_link))
                                                                                    <a href="{{ $notification->deep_link }}" target="_blank" rel="noopener noreferrer">Open Link</a>
                                                                                @else
                                                                                    -
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-sm btn-outline-primary btn-view-notification" data-id="{{ $notification->id }}">View</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal fade" id="notificationViewModal" tabindex="-1" aria-labelledby="notificationViewModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="notificationViewModalLabel">Notification</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="mb-2"><strong>Title:</strong> <span id="notif-view-title"></span></p>
                                                                        <p class="mb-2"><strong>Channel:</strong> <span id="notif-view-channel"></span></p>
                                                                        <p class="mb-2"><strong>Date:</strong> <span id="notif-view-date"></span></p>
                                                                        <p class="mb-2"><strong>Message:</strong></p>
                                                                        <div class="notification-email-body mb-3" id="notif-view-body"></div>
                                                                        <div id="notif-view-link-wrap" class="d-none">
                                                                            <a href="#" id="notif-view-link" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Open link</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
                    <!-- container end-->
@stop

@section('script')
<style>
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
    .notifications-shell {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .notifications-datatable th,
    .notifications-datatable td {
        vertical-align: top;
    }
    .notifications-datatable .unread-row {
        background: #fffdf7;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 10px;
    }
    .notification-email-body {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 12px;
        background: #fff;
        min-height: 120px;
        overflow-x: auto;
    }
</style>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script>
    window.showNotificationModalFallbackSafe = function () {
        var modalEl = document.getElementById('notificationViewModal');
        if (!modalEl) {
            return;
        }
        if (window.bootstrap && window.bootstrap.Modal) {
            window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
            return;
        }
        if (window.jQuery && jQuery.fn && jQuery.fn.modal) {
            jQuery('#notificationViewModal').modal('show');
            return;
        }
        jQuery('#notificationViewModal')
            .addClass('show')
            .css('display', 'block')
            .attr('aria-modal', 'true')
            .removeAttr('aria-hidden');
        jQuery('body').addClass('modal-open');
        if (!jQuery('.modal-backdrop').length) {
            jQuery('body').append('<div class="modal-backdrop fade show"></div>');
        }
    };

    window.openNotificationModalFromResponse = function (p) {
        jQuery('#notif-view-title').text((p && p.title) ? p.title : '-');
        jQuery('#notif-view-channel').text((p && p.channel) ? p.channel : '-');
        jQuery('#notif-view-date').text((p && p.date) ? p.date : '-');
        jQuery('#notif-view-body').html((p && p.body) ? p.body : '-');
        if (p && p.deep_link) {
            jQuery('#notif-view-link').attr('href', p.deep_link);
            jQuery('#notif-view-link-wrap').removeClass('d-none');
        } else {
            jQuery('#notif-view-link-wrap').addClass('d-none');
        }
        window.showNotificationModalFallbackSafe();
    };

    $(document).ready(function () {
        var notificationDetailUrlTemplate = @json(route('frontend.notifications.detail', ['id' => '__ID__']));

        function hideNotificationModal() {
            if (window.bootstrap && window.bootstrap.Modal) {
                var modalEl = document.getElementById('notificationViewModal');
                if (modalEl) {
                    window.bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                }
                return;
            }
            if ($.fn.modal) {
                $('#notificationViewModal').modal('hide');
                return;
            }
            $('#notificationViewModal')
                .removeClass('show')
                .css('display', 'none')
                .removeAttr('aria-modal')
                .attr('aria-hidden', 'true');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $('#notifications-table').DataTable({
            pageLength: 10,
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: [4, 5] }
            ],
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_ notifications',
                info: 'Showing _START_ to _END_ of _TOTAL_ notifications',
                emptyTable: 'No notifications found'
            }
        });

        $(document).on('click', '.btn-view-notification', function (e) {
            e.preventDefault();
            var btn = $(this);
            var notificationId = btn.data('id');
            if (!notificationId) {
                return;
            }
            var detailUrl = notificationDetailUrlTemplate.replace('__ID__', notificationId);
            btn.prop('disabled', true).text('Loading...');
            $.ajax({
                url: detailUrl,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res && res.success && res.data) {
                        window.openNotificationModalFromResponse(res.data);
                    } else {
                        alert('Notification detail not found.');
                    }
                },
                error: function () {
                    alert('Failed to fetch notification detail.');
                },
                complete: function () {
                    btn.prop('disabled', false).text('View');
                }
            });
        });

        $(document).on('click', '#notificationViewModal .btn-close, #notificationViewModal [data-bs-dismiss="modal"]', function (e) {
            e.preventDefault();
            hideNotificationModal();
        });

        $(document).on('click', '#notificationViewModal', function (e) {
            if ($(e.target).is('#notificationViewModal')) {
                hideNotificationModal();
            }
        });
    });
</script>
@stop
