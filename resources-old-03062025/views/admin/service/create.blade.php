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
                                @endif Service
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/save_service') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <input type="hidden" name="id" id="cid" value="{{ $id }}">
                                @csrf()

                                <div class="row">



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name" class="form-control" required
                                                data-parsley-required-message="Enter Name" value="@if($id){{$service->name}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name_ar" class="form-control" required
                                                data-parsley-required-message="Enter Arabic Name" value="@if($id){{$service->name_ar}}@endif">
                                        </div>
                                    </div>


                                    

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Image<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Image"
                                                type="file" name="image" class="form-control" 
                                                accept="image/*" data-parsley-trigger="change"
                                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB">
                                                @if($id && $service->image) <a href=" {{aws_asset_path($service->image) }}" target="_blank" rel="noopener noreferrer">View Image</a> @endif
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="active" class="form-control">
                                                <option <?= ($id && $service->active == 1) ? 'selected' : '' ?> value="1">Active</option>
                                                <option <?= ($id && $service->active == 0) ? 'selected' : '' ?> value="0">Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_recommended">Is Recommended <small class="text-info">To Show In Home Page</small></label> <br>
                                            <input type="checkbox" id="is_recommended" name="is_recommended" @if($id && $service->is_recommended) checked @endif>
                                        </div>
                                    </div>
                                  


                                    <div class=" col-md-12 mt-3">
                                        <h5>Service Highlights</h5>
                                    </div>

                                    <div class="itinerary col-md-12 mb-5" style="background-color: lightgray">
                                        @if (!count($highlights))
                                            <div class="row">

                                                

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Title<b class="text-danger">&nbsp;</b></label>
                                                        <input type="text" name="highlight_title[0]" class="form-control"
                                                            required data-parsley-required-message="Enter Title"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Title Ar<b class="text-danger">&nbsp;</b></label>
                                                        <input type="text" name="highlight_title_ar[0]" class="form-control"
                                                            required data-parsley-required-message="Enter Arabic Title"
                                                            value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Action</label>
                                                        <br>
                                                        <button type="button"
                                                            class="btn btn-primary add_new_itinerary">+</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Details<b class="text-danger">&nbsp;</b></label>
                                                        <textarea name="highlight_description[0]" rows="3" class="form-control editor" required
                                                            data-parsley-required-message="Enter Details"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details Ar<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="highlight_description_ar[0]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Arabic Details"></textarea>
                                                        </div>
                                                    </div>
                                            </div>
                                        @else
                                            @foreach ($highlights as $key => $val)
                                                <div class="row">
                                                    

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Title<b class="text-danger">&nbsp;</b></label>
                                                            <input type="text" name="highlight_title[{{ $key }}]"
                                                                class="form-control" required
                                                                data-parsley-required-message="Enter Title"
                                                                value="{{ $val->title }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Title Ar<b class="text-danger">&nbsp;</b></label>
                                                            <input type="text" name="highlight_title_ar[{{ $key }}]" class="form-control"
                                                                required data-parsley-required-message="Enter Arabic Title"
                                                                value="{{ $val->title_ar }}">
                                                        </div>
                                                    </div>


                                                   
                                              
                                                    

                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            @if ($key == 0)
                                                                <label>Action</label><br>
                                                                <button type="button"
                                                                    class="btn btn-primary add_new_itinerary">+</button>
                                                            @else
                                                                <label></label>
                                                                <button type="button" style="margin-top: 30px"
                                                                    class="btn btn-danger remove_itinerary">-</button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="highlight_description[{{ $key }}]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Details">{{ $val->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details Ar<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="highlight_description_ar[{{ $key }}]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Arabic Details">{{ $val->description_ar }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
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
        $(".select2").select2();

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

            var parent_tree = $('option:selected', "#parent_id").attr('data-tree');
            formData.append("parent_tree", parent_tree);

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
                                'Unable to save service. Please try again later.';
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.href = "{{ url('/admin/services') }}";
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
        faq_index = "<?= count($highlights) ?>";
        $(document).on('click', '.add_new_itinerary', function(e) {
            faq_index++;
            _html =
                `<div class="row">
                    <div class="col-md-5">
                    <div class="form-group"><label>Title<b class="text-danger">&nbsp;</b></label><input type="text" name="highlight_title[${faq_index }]" class="form-control" required data-parsley-required-message="Enter Title" value=""></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Title Ar<b class="text-danger">&nbsp;</b></label><input type="text" name="highlight_title_ar[${faq_index }]" class="form-control" required data-parsley-required-message="Enter ArabicTitle" value="">
                        </div>
                    </div>
                
                    <div class="col-md-1">
                    <div class="form-group"><label>Action</label><br><button type="button"
                        class="btn btn-danger remove_itinerary">-</button></div>
                    </div>
                
                    <div class="col-md-12">
                    <div class="form-group"><label>Details<b class="text-danger">&nbsp;</b></label><textarea name="highlight_description[${faq_index }]" rows="3" class="form-control editor" required
                        data-parsley-required-message="Enter Details"></textarea></div>
                    </div>
                    <div class="col-md-12">
                    <div class="form-group"><label>Details Ar<b class="text-danger">&nbsp;</b></label><textarea name="highlight_description_ar[${faq_index }]" rows="3" class="form-control editor" required
                        data-parsley-required-message="Enter Arabic Details"></textarea></div>
                    </div>
                </div>`;
            
            $(".itinerary").append(_html);


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

        });
        $(document).on('click', '.remove_itinerary', function(e) {
            $(this).parent().parent().parent().remove();
        });
    </script>

@stop
