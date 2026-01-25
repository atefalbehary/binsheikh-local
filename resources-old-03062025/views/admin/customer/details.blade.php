@extends('admin.template.layout')

@section('header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Customer Details
                            <a href="{{ url('admin/customer') }}@if(request()->has('role'))?role={{ request()->get('role') }}@endif" class="btn btn-primary float-right">Back to List</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Name:</label>
                                        <p>{{ $customer->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Email:</label>
                                        <p>{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Phone:</label>
                                        <p>{{ $customer->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Type:</label>
                                        <p>
                                            @if($customer->role==2)
                                                User
                                            @elseif($customer->role==3)
                                                Agent
                                            @elseif($customer->role==4)
                                                Agency
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status:</label>
                                        <p>{{ $customer->active ? 'Active' : 'Inactive' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Created On:</label>
                                        <p>{{ web_date_in_timezone($customer->created_at, 'd-M-Y h:i A') }}</p>
                                    </div>
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