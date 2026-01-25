@extends('admin.template.layout')

@section('header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Subscribers</div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Search Text</label>
                                            <input class="form-control filter_1" name="search_text" value="{{$search_text}}">
                                        </div>
                                    </div>



                                    <div class="col-md-4" style="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" name="submit" type="submit">Filter</button>
                                            <a href="{{ url('admin/subscribers') }}" class="btn btn-danger dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>

                                            <button class="btn btn-success" name="submit" value="export" type="submit">Export</button>
                                    </div>
                                </div>
                            </form>
                          
                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="10%">#</th>
                                        <th>Email</th>
                                        <th width="20%">Created Date</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $subscribers->perPage() * ($subscribers->currentPage() - 1); ?>
                                    @foreach ($subscribers as $trip)
                                        <?php
                                        $i++;
                                        $checked = $trip->active ? 'checked' : '';
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">{{ $trip->email }}</td>
                                            <td class="trVOE">
                                                {{ web_date_in_timezone($trip->created_at, 'd-M-Y h:i A') }}</td>

                                            <td>
                                                <a href="{{ url('admin/subscribers/delete/' . $trip->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this subscriber?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $subscribers->links('admin.template.pagination') !!}
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
