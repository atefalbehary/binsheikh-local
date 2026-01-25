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
                                                        
                                                        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
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
                                            <div class="dashboard-title-item"><span>{{ __('messages.my_bookings') }}</span></div>
                                            <!-- Tariff Plan menu -->
                                            <!-- Tariff Plan menu end -->
                                        </div>
                                        <div class="db-container">
                                            <div class="row">
                                                <!-- bookings-item -->
                                                @foreach($bookings as $property)

                                                    <?php
                                                        $ser_amt = ($settings->service_charge_perc / 100) * $property->price;
                                                        $total = $property->price + $ser_amt;
                                                        $down_payment = ($settings->advance_perc / 100) * $total;
                                                        $pending_amt = $total - $down_payment;
                                                    ?>
                                                <div class="col-lg-6">
                                                    <div class="bookings-item">
                                                        <div class="bookings-item-header">
                                                            <img src=" @if(isset($property->images[0])) {{aws_asset_path($property->images[0]->image) }} @endif " alt="">
                                                            <h4>{{ __('messages.for') }} <a href="{{ url('property-details/'.$property->slug) }}" target="_blank">{{ $property->name }}</a></h4>
                                                        </div>
                                                        <div class="bookings-item-content">
                                                            <ul>
                                                                <li>{{ __('messages.date') }}: <span>{{ web_date_in_timezone($property->booking_date, "d M Y h:i A") }}</span></li>
                                                                <li>{{ __('messages.total_amount') }}: <span>{{ moneyFormat($total) }}</span></li>
                                                                <li>{{ __('messages.paid_amount') }}: <span>{{ moneyFormat($property->paid_mount) }}</span></li>
                                                                <li>{{ __('messages.remaining_amount') }}: <span>{{ moneyFormat($total - $property->paid_mount) }}</span></li>
                                                                <li class="text-success">{{ __('messages.completed') }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="bookings-item-footer">
                                                            <a href="#" class="mb-3 d-inline-block text-uppercase mt-3" style="font-weight: 600;" data-bs-toggle="modal" data-bs-target="#exampleModal_{{ $property->id }}">{{ __('messages.payment_plan') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="exampleModal_{{ $property->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.payment_plan') }}</h5>
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
                                                                                        <td>{{ $property->apartment_no }}</td>
                                                                                        <td>{{ $property->area }} m2</td>
                                                                                        <td>{{ moneyFormat($property->price) }}</td>
                                                                                        <td>{{ moneyFormat($ser_amt) }}</td>
                                                                                        <td>{{ moneyFormat($total) }}</td>
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
                                                                                        <td>{{ __('messages.down_payment') }}</td>
                                                                                        <td>{{ date('M-y') }}</td>
                                                                                        <td>{{ moneyFormat($down_payment) }}</td>
                                                                                        <td>{{ $settings->advance_perc }}%</td>
                                                                                    </tr>
                                                                                    @foreach($property->months as $key => $mnth)
                                                                                    <tr>
                                                                                        <td>{{ $mnth['ordinal'] }} {{ __('messages.installment') }}</td>
                                                                                        <td>{{ $mnth['month'] }}</td>
                                                                                        <td>{{ moneyFormat($mnth['payment']) }}</td>
                                                                                        <td>{{ $mnth['total_percentage'] }}%</td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
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
<script>
    @if (session('success'))
        show_msg(1, "{{ session('success') }}")
    @endif

    @if (session('error'))
        show_msg(0, "{{ session('error') }}")
    @endif
</script>
@stop
