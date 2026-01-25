@extends('admin.template.layout')

@section('header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Customers</div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Property/Customer</label>
                                            <input class="form-control filter_1" name="search_text" value="{{$search_text}}">
                                        </div>
                                    </div>


                                    <div class="col-md-3" style="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                            <a href="{{ url('admin/bookings') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>
                                    </div>
                                </div>
                            </form>


                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Property</th>
                                        <th>Amount Details</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $bookings->perPage() * ($bookings->currentPage() - 1); ?>
                                    @foreach ($bookings as $book)
                                        <?php
                                            $i++;
                                            $ser_amt = ($settings->service_charge_perc / 100) * $book->price;
                                            $total = $book->price + $ser_amt;
                                            $down_payment = ($settings->advance_perc / 100) * $total;
                                            $pending_amt = $total - $down_payment;
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">

                                                <p>{{ $book->cust_name }}</p>
                                                <p>{{ $book->cust_email }}</p>
                                                <p>{{ $book->cust_phone }}</p>

                                            </td>
                                            <td class="trVOE">{{ $book->name }}</td>
                                            <td>
                                                <p> Total Amount : <b>{{ moneyFormat($total) }}</b></p>
                                                <p> Paid Amount : <b>{{ moneyFormat($book->paid_mount) }}</b></p>
                                                <p> Remaining Amount : <b>{{ moneyFormat($total - $book->paid_mount) }}</b></p>

                                            </td>
                                            <td class="trVOE">{{ web_date_in_timezone($book->booking_date, "d M Y h:i A") }}</td>

                                            <td>
                                                <button
                                                    class="btn btn-outline-success active" data-toggle="modal" data-target="#detailsModal_{{$i}}"  title="Details"
                                                    aria-hidden="true"><i class="fas fa-eye fa-1x"></i></button>
                                                    <div class="modal fade" id="detailsModal_{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Payment Plan</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">

                                                                    <table class="table table-responsive-sm table-bordered">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Unit Number</th>
                                                                                            <th>Size Net</th>
                                                                                            <th>Full Price</th>
                                                                                            <th>Management Fees</th>
                                                                                            <th>Total</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>{{ $book->apartment_no }}</td>
                                                                                            <td>{{ $book->area }} m2</td>
                                                                                            <td>{{ moneyFormat($book->price) }}</td>
                                                                                            <td>{{ moneyFormat($ser_amt) }}</td>
                                                                                            <td>{{ moneyFormat($total) }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table class="payment-table table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Payment</th>
                                                                                            <th>Month</th>
                                                                                            <th>Amount</th>
                                                                                            <th>Percentage</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr class="payment-row-highlight">
                                                                                            <td>Down Payment</td>
                                                                                            <td>{{ date('M-y') }}</td>
                                                                                            <td>{{ moneyFormat($down_payment) }}</td>
                                                                                            <td>{{ $settings->advance_perc }}%</td>
                                                                                        </tr>
                                                                                        @foreach($book->months as $key => $mnth)
                                                                                        <tr>
                                                                                            <td>{{ $mnth['ordinal'] }} Installment</td>
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
                                            </td>
                                        </tr>





                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $bookings->appends(request()->input())->links('admin.template.pagination') !!}
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

@stop
