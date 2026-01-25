@extends('admin.template.layout')

@section('header')

@stop
@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Common Settings
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ route('admin.setting_store') }}"
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
                                   
                                    <div class="col-md-6 form-group">
                                        <label>Month Count<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="month_count" class="form-control jqv-input"
                                            data-parsley-type="integer" value="{{ $page->month_count }}" placeholder="Month Count"
                                            required data-parsley-required-message="Enter Month Count" >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Advance %<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="advance_perc" class="form-control jqv-input"
                                            data-parsley-type="number" value="{{ $page->advance_perc }}" placeholder="Advance %"
                                            required data-parsley-required-message="Enter Advance %" >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Management Fees %<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="service_charge_perc" class="form-control jqv-input"
                                            data-parsley-type="number" value="{{ $page->service_charge_perc }}" placeholder="Management Fees %"
                                            required data-parsley-required-message="Enter Management Fees % %" >
                                    </div>



                                    <div class="col-md-6"></div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Title<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="meta_title" class="form-control jqv-input" value="{{ $page->meta_title }}" placeholder="Meta Title">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Title Ar<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="meta_title_ar" class="form-control jqv-input" value="{{ $page->meta_title_ar }}" placeholder="Meta Title Arabic">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Description<b class="text-danger">&nbsp;</b></label>
                                        <textarea name="meta_description" class="form-control jqv-input" placeholder="Meta Description">{{$page->meta_description}}</textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Description Ar<b class="text-danger">&nbsp;</b></label>
                                        <textarea name="meta_description_ar" class="form-control jqv-input" placeholder="Meta Description Arabic">{{$page->meta_description_ar}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3"><h5>Home Settings</h5></div>

                                    <div class="col-md-6 form-group">
                                        <label>Experience<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="experience" class="form-control jqv-input"
                                            data-parsley-type="integer" value="{{ $page->experience }}" placeholder="Experience"
                                            required data-parsley-required-message="Enter Experience" >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Clients<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="clients" class="form-control jqv-input"
                                            data-parsley-type="integer" value="{{ $page->clients }}" placeholder="Clients"
                                            required data-parsley-required-message="Enter Clients" >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Units<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="units" class="form-control jqv-input"
                                            data-parsley-type="integer" value="{{ $page->units }}" placeholder="Units"
                                            required data-parsley-required-message="Enter Units" >
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Branches<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="branches" class="form-control jqv-input"
                                            data-parsley-type="integer" value="{{ $page->branches }}" placeholder="Branches"
                                            required data-parsley-required-message="Enter Branches" >
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <button type="submit" class=" btn btn-primary">Save </button>
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
