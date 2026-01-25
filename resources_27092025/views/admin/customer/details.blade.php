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

                            @if(isset($customer->id_no))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">CONTACT Number:</label>
                                        <p>{{ $customer->id_no }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(isset($customer->role) && ($customer->role == 3 || $customer->role == 4))
                            <!-- Commission Number -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Commission(%)</label>
                                            <form action="{{ url('admin/customer/update-commission') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $customer->id }}">
                                                <div class="input-group">
                                                    <input type="text" name="commission_number" class="form-control" value="{{ $customer->commission_number ?? '' }}" placeholder="%">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Discount Number -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Discount(QAR):</label>
                                            <form action="{{ url('admin/customer/update-discount') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $customer->id }}">
                                                <div class="input-group">
                                                    <input type="text" name="discount_number" class="form-control" value="{{ $customer->discount_number ?? '' }}" placeholder="QAR">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Apartment Sell -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Apartments for Sale:</label>
                                            <form action="{{ url('admin/customer/update-apartments') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $customer->id }}">
                                                <div class="input-group">
                                                    <select name="apartment_sell[]" class="form-control select2" multiple>
                                                        @php
                                                            $selected_apartments = $customer->apartment_sell ? explode(',', $customer->apartment_sell) : [];
                                                        @endphp
                                                        @foreach(\App\Models\Properties::where(['deleted' => 0, 'active' => 1])->orderBy('name', 'asc')->get() as $apartment)
                                                            <option value="{{ $apartment->id }}" @if(in_array($apartment->id, $selected_apartments)) selected @endif>
                                                                {{ $apartment->name }} ({{ $apartment->apartment_no }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- Professional Practice Certificate -->
                            @if(isset($customer->professional_practice_certificate) && $customer->professional_practice_certificate)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Professional Practice Certificate:</label>
                                        <p>
                                            <a href="{{ aws_asset_path($customer->professional_practice_certificate) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View Certificate
                                            </a>
                                            <a href="{{ url('admin/customer/download-document/'.$last) }}" class="btn btn-sm btn-success ml-2">
                                                <i class="fa fa-download"></i> Download Certificate
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Other Certificates -->
                            @if(isset($customer->license) && $customer->license)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">License:</label>
                                        <p>
                                            <a href="{{ aws_asset_path($customer->license) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View License
                                            </a>
                                            <a href="{{ url('admin/customer/download-document/'.$last_license) }}" class="btn btn-sm btn-success ml-2">
                                                <i class="fa fa-download"></i> Download License
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($customer->id_card) && $customer->id_card)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">ID Card:</label>
                                        <p>
                                            <a href="{{ aws_asset_path($customer->id_card) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View ID Card
                                            </a>
                                            <a href="{{ url('admin/customer/download-document/'.$last_id_card) }}" class="btn btn-sm btn-success ml-2">
                                                <i class="fa fa-download"></i> Download ID Card
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($customer->cr) && $customer->cr && ($customer->role == 4))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Commercial Registration (CR):</label>
                                        <p>
                                            <a href="{{ aws_asset_path($customer->cr) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View CR
                                            </a>
                                            <a href="{{ url('admin/customer/download-document/' . urlencode($customer->cr)) }}" class="btn btn-sm btn-success ml-2">
                                                <i class="fa fa-download"></i> Download CR
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(isset($customer->real_estate_license) && $customer->real_estate_license && in_array($customer->role, [3, 4]))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Real Estate License:</label>
                                        <p>
                                            <a href="{{ aws_asset_path($customer->real_estate_license) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View Real Estate License
                                            </a>
                                            <a href="{{ url('admin/customer/download-document/' . urlencode($customer->real_estate_license)) }}" class="btn btn-sm btn-success ml-2">
                                                <i class="fa fa-download"></i> Download Real Estate License
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(".select2").select2();
</script>
@stop
