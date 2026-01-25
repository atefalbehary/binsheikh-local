@extends('admin.template.layout')

@section('header')
@stop

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>Add Popup</strong></div>
                    <form method="post" id="admin-form" action="{{ route('admin.popups.store') }}"
                        enctype="multipart/form-data" data-parsley-validate="true">
                        <div class="card-body">
                            @csrf()

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subtitle</label>
                                        <input type="text" name="subtitle" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Link</label>
                                        <input type="text" name="link" data-parsley-type="url" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                    <img id="image-preview" style="width:192px; height:108px;" class="img-responsive mb-1">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Upload Image <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input jqv-input" name="image"
                                            data-role="file-image" data-preview="image-preview" required
                                            data-parsley-required-message="Image is required" id="popup-image"
                                            data-parsley-trigger="change" data-parsley-fileextension="jpg,png,gif,jpeg"
                                            data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                            data-parsley-max-file-size="2048" data-parsley-max-file-size-message="Max file size should be 2MB"
                                            accept="image/*" data-parsley-errors-container="#img_err">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <span id="img_err"></span>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    window.location.href = "{{ route('admin.popups.index') }}";
                } else {
                    $form.find('button[type="submit"]')
                        .text('Submit')
                        .attr('disabled', false);
                    show_msg(0, e.responseText)
                  //  toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $form.find('button[type="submit"]')
                    .text('Submit')
                    .attr('disabled', false);

                if (xhr.status == 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var input = $form.find('[name="' + key + '"]');
                        input.after('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                    });
                } else {
                    show_msg(0, 'Something went wrong. Please try again.');
                }
            }
        });
    });
</script>
@stop
