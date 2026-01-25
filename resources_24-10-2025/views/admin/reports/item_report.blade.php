@extends('admin.template.layout')

@section('header')

@stop


@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Item Wise Sales Report</div>
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
                                    
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Sort By</label>
                                            <select name="sort_order" class="form-control">
                                            <option value="">None</option>
                                            
                                            <option value="item_ttl_asc" @if($sort_order == 'item_ttl_asc') selected @endif>Total(Asc)</option>
                                            <option value="item_ttl_desc" @if($sort_order == 'item_ttl_desc') selected @endif>Total(Desc)</option>

                                            <option value="dlvry_amt_asc" @if($sort_order == 'dlvry_amt_asc') selected @endif>Del Charge(Asc)</option>
                                            <option value="dlvry_amt_desc" @if($sort_order == 'dlvry_amt_desc') selected @endif>Del Charge(Desc)</option>

                                            <option value="gttl_asc" @if($sort_order == 'gttl_asc') selected @endif>Grand Total(Asc)</option>
                                            <option value="gttl_desc" @if($sort_order == 'gttl_desc') selected @endif>Grand Total(Desc)</option>

                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3" styles="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                        <input type="submit" name="excel" value="Export" class="btn btn-primary" >
                                            <a href="{{ url('admin/report/item_report') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Sold Count</th>
                                        <th>Total</th>
                                        <th>Del Charge</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
                                    @foreach ($list as $item)
                                        <?php
                                        $i++;
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{ $item->prd_name }}</td>
                                            <td class="trVOE">{{ $item->count_order }}</td>
                                            <td class="trVOE">₹{{ $item->ord_item_ttl }}</td>
                                            <td class="trVOE">₹{{ $item->ord_dlvry_amt }}</td>
                                            <td class="trVOE">₹{{ $item->ord_gttl }}</td>
                                            
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
