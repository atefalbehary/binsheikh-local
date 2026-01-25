@extends('admin.template.layout')

@section('header')

@stop


@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Contact Us Queries</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th width="20%">Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
                                    @foreach ($list as $item)
                                        <?php
                                            $i++;
                                        ?>
                                        <tr role="row">
                                        <td>{{$i}}</td>
                                        <td>{{web_date_in_timezone($item->created_at,'d-M-Y h:i A')}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile_number}}</td>
                                        <td>{{$item->message}}</td>
                                        <td>{{$item->subject}}</td>

                                            <td>
                                                <a href="{{url('admin/contact_us/delete/'.$item->id)}}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this branch?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $list->links('admin.template.pagination') !!}
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
