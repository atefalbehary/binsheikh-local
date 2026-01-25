<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.0.0
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <title>{{ config('global.site_name') }} | Admin Login</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}admin-assets/assets/favicon/favicon.png" />
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="{{ asset('') }}admin-assets/css/style.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/css/parsley.css" rel="stylesheet">

</head>

<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <form class="gda-forms form-login" data-parsley-validate="true" method="post"
                                action="{{ route('admin.check_login') }}">
                                @csrf
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="{{ asset('') }}admin-assets/vendors/@coreui/icons/svg/free.svg#cil-user">
                                                </use>
                                            </svg></span></div>
                                    <input data-parsley-required="true" data-parsley-required-message="Email required"
                                        data-parsley-errors-container="#uerr" autocomplete="off" class="form-control"
                                        type="email" placeholder="Email" name="email" id="email">
                                </div>
                                <span id="uerr"></span>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="{{ asset('') }}admin-assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                                </use>
                                            </svg></span></div>
                                    <input data-parsley-required="true"
                                        data-parsley-required-message="password required"
                                        data-parsley-errors-container="#perr" autocomplete="off" class="form-control"
                                        type="password" placeholder="Password" name="password" id="password">
                                </div>
                                <span id="perr"></span>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4"
                                            type="button">Login</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('') }}admin-assets/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('') }}admin-assets/vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <script src="{{ asset('') }}admin-assets/js/jquery-2.2.4.min.js"></script>
    <script src="{{ asset('') }}admin-assets/js/parsley.min.js"></script>
    <script src="{{ asset('') }}admin-assets/js/sweetalert2.all.min.js"></script>


    <script>
        $(".form-login").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.check_login') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'email': $("#email").val(),
                    'password': $("#password").val(),
                    'timezone': Intl.DateTimeFormat().resolvedOptions().timeZone
                },
                success: function(response) {
                    if (response.success) {
                        show_msg(1, response.message)
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.dashboard') }}";
                        }, 100);

                    } else {
                        show_msg(0, response.message)
                    }
                }
            });
        });
    </script>
    <script>
        function show_msg(status, msg) {
            icon = "error"
            if (status) {
                icon = "success"
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: icon,
                title: msg
            })
        }
    </script>

</body>

</html>
