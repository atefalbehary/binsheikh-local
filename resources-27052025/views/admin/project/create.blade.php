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
                                @endif Project
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/save_project') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <input type="hidden" name="id" id="cid" value="{{ $id }}">
                                @csrf()

                                <div class="row">



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name" class="form-control" required
                                                data-parsley-required-message="Enter Name" value="@if($id){{$project->name}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name_ar" class="form-control" required
                                                data-parsley-required-message="Enter Arabic Name" value="@if($id){{$project->name_ar}}@endif">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="location" class="form-control" required
                                                data-parsley-required-message="Enter Location" value="@if($id){{$project->location}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="location_ar" class="form-control" required
                                                data-parsley-required-message="Enter Location Name" value="@if($id){{$project->location_ar}}@endif">
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
                                                @if($id && $project->image) <a href=" {{aws_asset_path($project->image) }}" target="_blank" rel="noopener noreferrer">View Image</a> @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>App Image<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Image"
                                                type="file" name="app_image" class="form-control" 
                                                accept="image/*" data-parsley-trigger="change"
                                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB">
                                                @if($id && $project->app_image) <a href=" {{aws_asset_path($project->app_image) }}" target="_blank" rel="noopener noreferrer">View Image</a> @endif
                                        </div>
                                    </div>

                                    
                                    
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Banner<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Banner"
                                                type="file" name="banner" class="form-control" 
                                                accept="image/*" data-parsley-trigger="change"
                                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB">
                                                @if($id && $project->banner) <a href=" {{aws_asset_path($project->banner) }}" target="_blank" rel="noopener noreferrer">View Banner</a> @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2"></div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>360 Link</label>
                                            <input type="url" data-parsley-required-message="Enter 360 Link" name="link_360" class="form-control"  value="@if($id){{$project->link_360}}@endif">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country<b class="text-danger">&nbsp;</b></label>
                                            <select name="country" class="form-control select2" required
                                                data-parsley-required-message="Select Project Country">
                                                <option  value="">Select</option>
                                                @foreach($project_countries as $val)
                                                <option <?= ($id && $project->country == $val->id) ? 'selected' : '' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project End Date</label>
                                            <input type="month" required data-parsley-required-message="Enter Project End Date" name="end_date" class="form-control"  value="@if($id){{$project->end_date}}@endif" autocomplete="off">
                                        </div>
                                    </div>

                                   

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="active" class="form-control">
                                                <option <?= ($id && $project->active == 1) ? 'selected' : '' ?> value="1">Active</option>
                                                <option <?= ($id && $project->active == 0) ? 'selected' : '' ?> value="0">Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_recommended">Is Recommended <small class="text-info">To Show In Home Page</small></label> <br>
                                            <input type="checkbox" id="is_recommended" name="is_recommended" @if($id && $project->is_recommended) checked @endif>
                                        </div>
                                    </div>
                                  


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description" class="form-control editor" required data-parsley-required-message="Enter Description">@if($id){{$project->description}}@endif</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description Ar<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description_ar" class="form-control editor" required data-parsley-required-message="Enter Arabic Description">@if($id){{$project->description_ar}}@endif</textarea>
                                        </div>
                                    </div>
                                    

                                
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Video<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Video"
                                                type="file" name="video" class="form-control" 
                                                data-parsley-trigger="change"accept="video/*">
                                                @if($id && $project->video) <a href=" {{aws_asset_path($project->video) }}" target="_blank" rel="noopener noreferrer">View Video</a> @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Video Thumbnail<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Video Thumbnail"
                                                type="file" name="video_thumbnail" class="form-control" 
                                                data-parsley-trigger="change "accept="image/*">
                                                @if($id && $project->video_thumbnail) <a href="{{aws_asset_path($project->video_thumbnail) }}" target="_blank" rel="noopener noreferrer">View Thumbnail </a> @endif
                                        </div>
                                    </div>
                                    
                                    @if (count($images) > 0)
                                        <div class="col-md-12">
                                            <label>
                                                <h5>Uploaded Project Images:</h5>
                                            </label>
                                        </div>

                                        <div class="row col-md-12">

                                            @foreach ($images as $img)
                                                <div class="col-md-2">
                                                    <div style="float: left;margin-top: 30px;">
                                                        <img src="{{aws_asset_path($img->image) }}" style="max-width:75%;">
                                                        <a class="remove deleteListItem" data-role="unlink"
                                                            data-message="Do you want to remove this image?"
                                                            title="Delete"
                                                            href="{{ url('admin/project/delete_image/' . $img->id) }}">
                                                            <i class="fa fa-trash removeThis" style="color: red;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    @endif
                            

                                    <div class=" col-md-12 mt-3">
                                        <h5>Images</h5>
                                    </div>

                                    <div class="itinerary col-md-12 mb-5" style="background-color: lightgray">
                                        <div class="row">    
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Image<b class="text-danger">&nbsp;</b></label>
                                                    <input @if(!$id) required @endif data-parsley-required-message="Select Image"
                                                    type="file" name="prj_image[0]" class="form-control" 
                                                    accept="image/*" data-parsley-trigger="change"
                                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                    data-parsley-max-file-size="5120"
                                                    data-parsley-max-file-size-message="Max file size should be 5MB">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Type<b class="text-danger">&nbsp;</b></label>
                                                    <select name="prj_image_type[0]" class="form-control" @if(!$id) required @endif data-parsley-required-message="Select Type">
                                                        <option value="">Select Type</option>
                                                        <option value="interior">Interior</option>
                                                        <option value="exterior">Exterior</option>
                                                    </select>
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
                                        </div>
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
                                'Unable to save project. Please try again later.';
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.href = "{{ url('/admin/projects') }}";
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
        faq_index = "<?= count([]) ?>";
        $(document).on('click', '.add_new_itinerary', function(e) {
            faq_index++;
            _html =
                `<div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Image<b class="text-danger">&nbsp;</b></label>
                            <input required data-parsley-required-message="Select Image"
                            type="file" name="prj_image[${faq_index }]" class="form-control" 
                            accept="image/*" data-parsley-trigger="change"
                            data-parsley-fileextension="jpg,png,gif,jpeg"
                            data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                            data-parsley-max-file-size="5120"
                            data-parsley-max-file-size-message="Max file size should be 5MB">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type<b class="text-danger">&nbsp;</b></label>
                            <select name="prj_image_type[${faq_index }]" class="form-control" required data-parsley-required-message="Select Type">
                                <option value="">Select Type</option>
                                <option value="interior">Interior</option>
                                <option value="exterior">Exterior</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-md-1">
                    <div class="form-group"><label>Action</label><br><button type="button"
                        class="btn btn-danger remove_itinerary">-</button></div>
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
