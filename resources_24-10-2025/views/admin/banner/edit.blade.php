@extends("admin.template.layout")

@section('header')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong> Edit Banner</strong></div>
                    <form method="post" id="admin-form" action="{{ url('/admin/banner/update') }}"
                        enctype="multipart/form-data" data-parsley-validate="true">
                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="id" value="{{$banner->id}}">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Banner Title</label>
                                        <input type="text" name="banner_title" class="form-control" value="{{$banner->banner_title}}">
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banner Subtitle</label>
                                        <input type="text" name="banner_sub_title" class="form-control" value="{{$banner->banner_sub_title}}">
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Banner Link</label>
                                        <input type="text" name="banner_link" data-parsley-type="url" class="form-control" value="{{$banner->banner_link}}">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Status</label>
                                    <select name="active" class="form-control">
                                        <option <?= $banner->active == 1 ? 'selected' : '' ?> value="1">Active</option>
                                        <option <?= $banner->active == 0 ? 'selected' : '' ?> value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group" >
                                    <img id="image-preview" style="width:192px; height:108px;" class="img-responsive mb-1"  data-image="{{$banner->banner_image}}" src="{{$banner->banner_image}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Upload Banner</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input jqv-input" name="banner"
                                            data-role="file-image"  data-preview="image-preview"  name="upload_image" id="banner" data-parsley-imagedimensionsss="1920X1079" data-parsley-trigger="change" data-parsley-fileextension="jpg,png,gif,jpeg"
                                            data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB" accept="image/*">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                
                             
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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
@stop

@section('script')
<script>
    $('body').off('submit', '#admin-form');
    $('body').on('submit', '#admin-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var formData = new FormData(this);
        $(".invalid-feedback").remove();

        $form.find('button[type="submit"]')
            .text('Saving')
            .attr('disabled', true);


        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: $form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            dataType: 'json',
            success: function(res) {

                if (res['status'] == 0) {
                    if (typeof res['errors'] !== 'undefined' && res['errors']) {
                        var error_def = $.Deferred();
                        var error_index = 0;
                        jQuery.each(res['errors'], function(e_field, e_message) {
                            if (e_message != '') {
                                $('[name="' + e_field + '"]').eq(0).addClass('is-invalid');
                                $('<div class="invalid-feedback">' + e_message + '</div>')
                                    .insertAfter($('[name="' + e_field + '"]').eq(0));
                                if (error_index == 0) {
                                    error_def.resolve();
                                }
                                error_index++;
                            }
                        });
                        error_def.done(function() {
                            var error = $form.find('.is-invalid').eq(0);
                            $('html, body').animate({
                                scrollTop: (error.offset().top - 100),
                            }, 500);
                        });
                    } else {
                        var m = res['message'] ||
                            'Unable to save. Please try again later.';
                        show_msg(0, m)
                    }
                } else {
                    var m = res['message'];
                    show_msg(1, m)
                    setTimeout(function() {
                        window.location.href = "{{ url('/admin/banners') }}";
                    }, 1500);

                }

                $form.find('button[type="submit"]')
                    .text('Save')
                    .attr('disabled', false);
            },
            error: function(e) {

                $form.find('button[type="submit"]')
                    .text('Save')
                    .attr('disabled', false);
                show_msg(0, e.responseText)
            }
        });
    });
</script>
@stop
