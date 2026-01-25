@extends('admin.template.layout')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />

@stop
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>
                                @if ($id)
                                    Edit
                                @else
                                    Add
                                @endif Page
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/save_page') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <input type="hidden" name="id" id="cid" value="{{ $id }}">
                                @csrf()

                                <div class="row">



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name" class="form-control" required
                                                data-parsley-required-message="Enter Name" value="{{ $name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name_es" class="form-control" required
                                                data-parsley-required-message="Enter Arabic Name" value="{{ $name_es }}">
                                        </div>
                                    </div>

                                   

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="active" class="form-control">
                                                <option <?= $active == 1 ? 'selected' : '' ?> value="1">Active</option>
                                                <option <?= $active == 0 ? 'selected' : '' ?> value="0">Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description" class="form-control editor" required data-parsley-required-message="Enter Description"> {{ $description }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description Ar<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description_es" class="form-control editor" required data-parsley-required-message="Enter Arabic Description"> {{ $description_es }}</textarea>
                                        </div>
                                    </div>

                                    @if($slug == "about-us")
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mission<b class="text-danger">&nbsp;</b></label>
                                                <textarea name="mission" class="form-control" required data-parsley-required-message="Enter Mission"> {{ $mission }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mission Ar<b class="text-danger">&nbsp;</b></label>
                                                <textarea name="mission_es" class="form-control" required data-parsley-required-message="Enter Arabic Mission"> {{ $mission_es }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ValuAr<b class="text-danger">&nbsp;</b></label>
                                                <textarea name="values" class="form-control" required data-parsley-required-message="Enter Values"> {{ $values }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Values Ar<b class="text-danger">&nbsp;</b></label>
                                                <textarea name="values_es" class="form-control" required data-parsley-required-message="Enter Arabic Values"> {{ $values_es }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                    @if($slug == "dts-grand" || $slug == "dts-mice" || $slug == "privacy-policy" || $slug == "terms-of-use")
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <div class="col-md-10">
                                                <label>Image<?php if (!$id) {echo '<b class="text-danger">&nbsp;</b>';}?> (gif,jpg,png,jpeg) </label>
                                                <input type="file" name="image" class="form-control"
                                                    data-role="file-image" data-preview="image-preview"
                                                    data-parsley-trigger="change"
                                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                    data-parsley-max-file-size="5120"
                                                    data-parsley-max-file-size-message="Max file size should be 5MB"
                                                    data-parsley-imagedimensionss="300x300" accept="image/*"  @if(!$id) required data-parsley-required-message="Select Image" @endif>
                                                {{-- <span class="text-danger">Upload image with dimension 300x300</span> --}}
                                            </div>
                                            <img id="image-preview" class="img-thumbnail w-50"
                                                style="margin-left: 5px; height:75px; width:75px !important;"
                                                @if ($image) src="{{aws_asset_path($image) }}" @endif>
                                        </div>
                                    </div>
                                    @endif
                                    @if($slug == "dts-grand" || $slug == "dts-mice" )
                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <div class="col-md-10">
                                                <label>Banner Image<?php if (!$id) {echo '<b class="text-danger">&nbsp;</b>';}?> (gif,jpg,png,jpeg) </label>
                                                <input type="file" name="banner_image" class="form-control"
                                                    data-role="file-image" data-preview="banner_image-preview"
                                                    data-parsley-trigger="change"
                                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                    data-parsley-max-file-size="5120"
                                                    data-parsley-max-file-size-message="Max file size should be 5MB"
                                                    data-parsley-imagedimensionss="300x300" accept="image/*"  @if(!$id) required data-parsley-required-message="Select Image" @endif>
                                                {{-- <span class="text-danger">Upload image with dimension 300x300</span> --}}
                                            </div>
                                            <img id="banner_image-preview" class="img-thumbnail w-50"
                                                style="margin-left: 5px; height:75px; width:75px !important;"
                                                @if ($image) src="{{aws_asset_path($image) }}" @endif>
                                        </div>
                                    </div>
                                    @endif


                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
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
    </div>

@stop
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>

    <script>

        var editor_config = {
            selector: '.editor',
            directionality: document.dir,
            path_absolute: "/",
            menubar: 'edit insert view format table image',
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media save table contextmenu directionality",
                "paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | formatselect styleselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen code",
            relative_urls: false,
            language: document.documentElement.lang,
            height: 300,
        }
        tinymce.init(editor_config);
    </script>
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
                                'Unable to save page. Please try again later.';
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.href = "{{ url('/admin/pages') }}";
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
