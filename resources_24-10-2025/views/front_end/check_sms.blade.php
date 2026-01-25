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
    <title>{{ config('global.site_name') }} | Check SMS</title>
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
                            <h1>Check SMS </h1>
                            <form class="gda-forms form-login" data-parsley-validate="true" method="post"
                                action="">
                                @csrf
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="{{ asset('') }}admin-assets/vendors/@coreui/icons/svg/free.svg#cil-mobile">
                                                </use>
                                            </svg></span></div>
                                    <input data-parsley-required="true" data-parsley-required-message="Mobile required"
                                        data-parsley-errors-container="#uerr" autocomplete="off" class="form-control"
                                        type="text" placeholder="Mobile with code" name="mobile" id="mobile">
                                </div>
                                <span id="uerr"></span>

                                <span id="perr"></span>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4"
                                            type="submit">Check</button>
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


</body>

</html>
