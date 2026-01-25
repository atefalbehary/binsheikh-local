@extends('admin.template.layout')

@section('header')

@stop


@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Orders Report</div>
                        <div class="card-body">

                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date From</label>
                                            <input class="form-control datepicker" name="from" value="{{$from}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date To</label>
                                            <input class="form-control datepicker" name="to" value="{{$to}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input class="form-control filter_3" name="customer" value="{{$customer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Branch</label>
                                            <select name="branch" class="form-control">
                                            <option value="">Select Branch</option>
                                            @foreach ($branches as $br)
                                                <option <?= $branch == $br->id ? 'selected' : '' ?>
                                                    value="{{ $br->id }}">
                                                    {{ $br->name }}</option>
                                            @endforeach

                                        </select>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4 mb-3" styles="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                        <input type="submit" name="excel" value="Export" class="btn btn-primary" >
                                            <a href="{{ url('admin/report/order') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ord ID</th>
                                        <th>Branch</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Del Charge</th>
                                        <th>Grand Total</th>
                                        <th>Pay Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
                                    @foreach ($list as $item)
                                        <?php
                                        $i++;
                                        $ord_status = order_status($item->ord_status);
                                        $pay_type = $item->ord_pay_type ? 'COD' : 'Online';
                                        $pay_status = order_pay_status($item->ord_pay_status);
                                        $ordernumber = config('global.sale_order_prefix').date(date('Ymd', strtotime($item->created_at))).$item->id;
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{$ordernumber}}</td>
                                            <td class="trVOE">{{ $item->branch_name }}</td>
                                            <td class="trVOE">{{ $item->name }}</td>
                                            <td class="trVOE">₹{{ $item->ord_item_ttl }}</td>
                                            <td class="trVOE">₹{{ $item->ord_dlvry_amt }}</td>
                                            <td class="trVOE">₹{{ $item->ord_gttl }}</td>
                                            <td class="trVOE">{{ $pay_type }} <br>
                                                <small>Pay Status : {{ $pay_status }}</small>
                                            </td>
                                            <td class="trVOE">{{ $ord_status }}</td>
                                            <td class="trVOE">{{ web_date_in_timezone($item->created_at, 'd-M-Y h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                {!! $list->appends(request()->input())->links('admin.template.pagination') !!}
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
