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
                                @endif Blog
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/save_blog') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <input type="hidden" name="id" id="cid" value="{{ $id }}">
                                @csrf()

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name" class="form-control" required
                                                data-parsley-required-message="Enter Title" value="{{ $name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name_ar" class="form-control" required
                                                data-parsley-required-message="Enter Arabic Title" value="{{ $name_ar }}">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <div class="col-md-10">
                                                <label>Image<?php if(!$id) { echo '<b class="text-danger">&nbsp;</b>';} ?> (gif,jpg,png,jpeg) </label>
                                                <input type="file" name="image" class="form-control"
                                                    data-role="file-image" data-preview="image-preview"
                                                    data-parsley-trigger="change"
                                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                    data-parsley-max-file-size="5120"
                                                    data-parsley-max-file-size-message="Max file size should be 5MB"
                                                    data-parsley-imagedimensionss="300x300" accept="image/*"  @if(!$id) required data-parsley-required-message="Select Image" @endif>
                                                <span class="text-danger">Upload image with dimensions 800 x 467 Or it's proportions</span>
                                            </div>
                                            <img id="image-preview" class="img-thumbnail w-50"
                                                style="margin-left: 5px; height:75px; width:75px !important;"
                                                @if ($image) src="{{ aws_asset_path($image) }}" @endif>
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Short Description<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="short_description" class="form-control" required data-parsley-required-message="Enter Short Description"> {{ $short_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Short Description Ar<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="short_description_ar" class="form-control" required data-parsley-required-message="Enter Arabic Short Description"> {{ $short_description_ar }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label>Folder<b class="text-danger">&nbsp;</b></label>
                                            <select name="folder_id" class="form-control select2" required
                                                    data-parsley-required-message="Select Folder">
                                                <option  value="">Select</option>
                                                @foreach($folders as $val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>
                                                @endforeach
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
                                            <textarea name="description_ar" class="form-control editor" required data-parsley-required-message="Enter Arabic Description"> {{ $description_ar }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <h4>SEO Configuration</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Slug</label>
                                            <input type="text" name="slug" class="form-control" value="{{ $slug }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Canonical URL</label>
                                            <input type="text" name="canonical_url" class="form-control" value="{{ $canonical_url }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control" value="{{ $meta_title }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Keywords</label>
                                            <input type="text" name="keywords" class="form-control" value="{{ $keywords }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea name="meta_description" class="form-control" rows="3">{{ $meta_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tags</label>
                                            <input type="text" name="tags" class="form-control" value="{{ $tags }}">
                                            <small class="text-muted">Separate tags with commas</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>OG Title</label>
                                            <input type="text" name="og_title" class="form-control" value="{{ $og_title }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No Index</label>
                                            <select name="no_index" class="form-control">
                                                <option value="0" @if($no_index == 0) selected @endif>Index</option>
                                                <option value="1" @if($no_index == 1) selected @endif>No Index</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="3">{{ $og_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group d-flex align-items-center">
                                            <div class="col-md-10">
                                                <label>OG Image (gif,jpg,png,jpeg)</label>
                                                <input type="file" name="og_image" class="form-control"
                                                    data-role="file-image" data-preview="og-image-preview"
                                                    data-parsley-trigger="change"
                                                    data-parsley-fileextension="jpg,png,gif,jpeg"
                                                    data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                    data-parsley-max-file-size="5120"
                                                    data-parsley-max-file-size-message="Max file size should be 5MB"
                                                    accept="image/*">
                                            </div>
                                            <img id="og-image-preview" class="img-thumbnail w-50"
                                                style="margin-left: 5px; height:75px; width:75px !important;"
                                                @if ($og_image) src="{{ aws_asset_path($og_image) }}" @endif>
                                        </div>
                                    </div>


                                    <div class="col-md-12 mt-4">
                                        <hr>
                                        <h4>SEO Preview</h4>
                                        <div class="row">
                                            <!-- Google Search Preview -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-light">Google Search Result Preview</div>
                                                    <div class="card-body">
                                                        <div class="google-preview">
                                                            <div class="google-title" style="color: #1a0dab; font-family: arial,sans-serif; font-size: 18px; line-height: 1.2; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="preview-meta-title">{{ $meta_title ?: 'Meta Title' }}</div>
                                                            <div class="google-url" style="color: #006621; font-family: arial,sans-serif; font-size: 14px; line-height: 1.3;" id="preview-url">{{ url('/blog-details/') }}/{{ $slug ?: 'slug' }}</div>
                                                            <div class="google-desc" style="color: #545454; font-family: arial,sans-serif; font-size: 13px; line-height: 1.4; word-wrap: break-word;" id="preview-meta-desc">{{ $meta_description ?: 'Meta description will appear here...' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Social Media Preview -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-light">Social Media Share Preview</div>
                                                    <div class="card-body">
                                                        <div class="social-preview" style="border: 1px solid #e1e8ed; border-radius: 5px; overflow: hidden; max-width: 500px;">
                                                            <div class="social-image" style="height: 260px; background-color: #e1e8ed; background-size: cover; background-position: center;" id="preview-og-image" 
                                                                @if($og_image) style="background-image: url('{{ aws_asset_path($og_image) }}');" @endif>
                                                            </div>
                                                            <div class="social-content" style="padding: 10px; background: #f5f8fa; border-top: 1px solid #e1e8ed;">
                                                                <div class="social-domain" style="text-transform: uppercase; color: #657786; font-size: 12px; font-weight: bold;">{{ request()->getHost() }}</div>
                                                                <div class="social-title" style="font-weight: bold; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px; margin-top: 5px; color: #14171a;" id="preview-og-title">{{ $og_title ?: 'OG Title' }}</div>
                                                                <div class="social-desc" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #657786; margin-top: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" id="preview-og-desc">{{ $og_description ?: 'OG Description will appear here...' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{url('admin/blog')}}" class="btn btn-secondary"  data-bs-dismiss="modal">{{__('Back')}}  </a>
                                            <a href="{{ url('/blog-details/') }}/{{ $slug }}" target="_blank" class="btn btn-info text-white" id="view-blog-btn" style="{{ $slug ? '' : 'display:none;' }}">View Blog</a>
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
        // SEO Preview Real-time Updates
        $(document).ready(function() {
            var urlBase = "{{ url('/blog-details/') }}/";

            function updatePreview() {
                // Get values
                var slug = $('input[name="slug"]').val();
                var metaTitle = $('input[name="meta_title"]').val();
                var metaDesc = $('textarea[name="meta_description"]').val();
                var ogTitle = $('input[name="og_title"]').val();
                var ogDesc = $('textarea[name="og_description"]').val();
                
                // Update Google Preview
                $('#preview-meta-title').text(metaTitle || 'Meta Title');
                $('#preview-url').text(urlBase + (slug || 'slug'));
                $('#preview-meta-desc').text(metaDesc || 'Meta description will appear here...');

                // Update Social Preview
                $('#preview-og-title').text(ogTitle || 'OG Title');
                $('#preview-og-desc').text(ogDesc || 'OG Description will appear here...');

                // Update View Blog Link
                if(slug) {
                    $('#view-blog-btn').attr('href', urlBase + slug).show();
                } else {
                    $('#view-blog-btn').hide();
                }
            }

            // Bind events
            $('input[name="slug"], input[name="meta_title"], input[name="og_title"]').on('keyup change', updatePreview);
            $('textarea[name="meta_description"], textarea[name="og_description"]').on('keyup change', updatePreview);

            // Image Preview for OG Image
            $('input[name="og_image"]').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-og-image').css('background-image', 'url(' + e.target.result + ')');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            
            // Auto-generate fields if empty specific to English
            $('input[name="name"]').on('blur', function() {
                var title = $(this).val();
                if(title) {
                    // Update SEO fields if they are empty
                    if(!$('input[name="meta_title"]').val()) {
                         $('input[name="meta_title"]').val(title).trigger('change');
                    }
                    if(!$('input[name="og_title"]').val()) {
                         $('input[name="og_title"]').val(title).trigger('change');
                    }
                    // Auto-generate slug if empty
                    if(!$('input[name="slug"]').val()) {
                        var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
                        $('input[name="slug"]').val(slug).trigger('change');
                    }
                }
            });

            // Floating Widget Logic
            var isMinimized = false;
            $('#seo-preview-header, #seo-preview-toggle').click(function() {
                if(isMinimized) {
                    $('#seo-preview-body').slideDown();
                    $('#seo-preview-toggle').removeClass('fa-plus').addClass('fa-minus');
                } else {
                    $('#seo-preview-body').slideUp();
                    $('#seo-preview-toggle').removeClass('fa-minus').addClass('fa-plus');
                }
                isMinimized = !isMinimized;
            });

             // Auto-fill descriptions from main description (stripped tags) - optional, might be tricky with TinyMCE
             
             // Ensure tabs work correctly with validation
             $('#admin-form').parsley().on('field:error', function() {
                var tabId = this.$element.closest('.tab-pane').attr('id');
                // activate the tab with error
                 $('a[href="#' + tabId + '"]').tab('show');
            });
        });


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
                                'Unable to save blog. Please try again later.';
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.href = "{{ url('/admin/blog') }}";
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
