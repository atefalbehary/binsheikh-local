@extends('admin.template.layout')

@section('header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Career Applications</div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Name/Email/Phone</label>
                                            <input class="form-control filter_1" name="search_text" value="{{$search_text}}">
                                        </div>
                                    </div>


                                    <div class="col-md-3" style="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                            <a href="{{ url('admin/job_application') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>
                                    </div>
                                </div>
                            </form>
                          

                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>CV</th>
                                        <th>Applied On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $applications->perPage() * ($applications->currentPage() - 1); ?>
                                    @foreach ($applications as $app)
                                        <?php
                                        $i++;
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">{{ $app->name }}</td>
                                            <td class="trVOE">{{ $app->email }}</td>
                                            <td class="trVOE">{{ $app->phone }}</td>
                                            <td class="trVOE">{{ $app->career->name }}</td>
                                            <td class="trVOE"><a href="{{ aws_asset_path($app->cv) }}" target="_blank" rel="noopener noreferrer">View CV</a></td>
                                            <td class="trVOE">
                                                {{ web_date_in_timezone($app->created_at, 'd-M-Y h:i A') }}</td>

                                            <td>
                                                <a href="{{ url('admin/career/delete_application/' . $app->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this property?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $applications->appends(request()->input())->links('admin.template.pagination') !!}
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
