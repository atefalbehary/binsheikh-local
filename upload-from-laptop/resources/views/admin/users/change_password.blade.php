@extends('admin.template.layout')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>Change Password</strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/change_password') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                @csrf()
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" name="cur_pswd" class="form-control jqv-input"
                                            required data-parsley-required-message="Current Password required">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="new_pswd" class="form-control jqv-input"
                                            required data-parsley-required-message="New Password required">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control jqv-input">
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Change</button>
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
    <script>
        $(document).off('submit', '#admin-form');
        $(document).on('submit', '#admin-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            $(".invalid-feedback").remove();
            $form.find('button[type="submit"]')
                .text('Changing')
                .attr('disabled', true);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                timeout: 600000,
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
                            var m = res['message'];
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }

                    $form.find('button[type="submit"]')
                        .text('Change')
                        .attr('disabled', false);
                },
                error: function(e) {
                    $form.find('button[type="submit"]')
                        .text('Change')
                        .attr('disabled', false);
                    show_msg(0, e.responseText)
                }
            });
        });
    </script>

@stop
