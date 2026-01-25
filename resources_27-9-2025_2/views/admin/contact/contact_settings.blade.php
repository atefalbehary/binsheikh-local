@extends('admin.template.layout')

@section('header')

@stop
@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>
                                Contact Details
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ route('admin.contact_us_setting_store') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <div class="row">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissable custom-success-box col-md-12">
                                            <a href="#" class="close" data-dismiss="alert"
                                                aria-label="close">&times;</a>
                                            <strong> {{ session('success') }} </strong>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissable custom-danger-box col-md-12">
                                            <a href="#" class="close" data-dismiss="alert"
                                                aria-label="close">&times;</a>
                                            <strong> {{ session('error') }} </strong>
                                        </div>
                                    @endif
                                </div>
                                @csrf()
                                <input type="hidden" name="id" value=" {{ $page->id }}">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Address</label>
                                        <textarea class="form-control description" id="address" placeholder="Address" name="address" required
                                            data-parsley-required-message="Enter Address">{{ $page->address }}</textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Email </label>
                                        <input type="email" name="email" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->email }}" placeholder="Enter Email"
                                            required data-parsley-required-message="Enter Email">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile </label>
                                        <input type="text" name="mobile" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->mobile }}" placeholder="Enter Mobile "
                                            required data-parsley-required-message="Enter Mobile">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Facebook </label>
                                        <input type="url" name="facebook" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->facebook }}"
                                            placeholder="Enter Facebook link">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Twitter </label>
                                        <input type="url" name="twitter" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->twitter }}"
                                            placeholder="Enter Twitter link ">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Instagram </label>
                                        <input type="url" name="instagram" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->instagram }}"
                                            placeholder="Enter Instagram link ">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Youtube </label>
                                        <input type="url" name="youtube" class="form-control jqv-input"
                                            data-jqv-required="true" value="{{ $page->youtube }}"
                                            placeholder="Enter Youtube link ">
                                    </div>



                                </div>

                                <div class="form-group">
                                    <button type="submit" class="mt-4 btn btn-primary">Save </button>
                                </div>




                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
    </div>

@endsection
@section('script')



@endsection
