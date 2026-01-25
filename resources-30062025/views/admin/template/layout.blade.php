<?php
$_current_user = \Request::get('_current_user');
$CurrentUrl = url()->current();
?>
<!DOCTYPE html>
<?php $version = 2; ?>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <title>{{ config('global.site_name') }} | Admin</title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}admin-assets/assets/favicon/favicon.png" />

    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link href="{{ asset('') }}admin-assets/css/style.css?vers=<?= $version ?>" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/css/parsley.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/vendors/fontawesome-5.7.2/css/all.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/vendors/toggle/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/vendors/datepicker/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="{{ asset('') }}admin-assets/fontawesome-iconpicker.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('header')
</head>

<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <img class="c-sidebar-brand-full" width="auto" src="{{ asset('') }}admin-assets/assets/img/logo.png">
            <img class="c-sidebar-brand-minimized " style="max-width: 28px;" src="">

        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link @if (preg_match('/admin\/dashboard/', $CurrentUrl)) c-active @endif"
                    href="{{ url('admin/dashboard') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-home"></i>
                    </div> Dashboard
                </a>
            </li>

           <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/categories/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/categories') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Property Types
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/amenities/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/amenities') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Amenities
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/properties/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/properties') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-building"></i>
                    </div> Properties
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/projects/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/projects') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-building"></i>
                    </div> Projects
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/project_countries/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/project_countries') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Project Countries
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/services/', $CurrentUrl) ? 'c-active' : null }}"
                    href="{{ url('admin/services') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Services
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/blog/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/blog') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Blog
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/photos/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/photos') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-images"></i>
                    </div> Photos
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/videos/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/videos') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-video"></i>
                    </div> Videos
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/folders/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/folders') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-folder"></i>
                    </div> Folders
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/settings/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/settings') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-cog"></i>
                    </div> Settings
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/reviews/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/reviews') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-pen"></i>
                    </div> Reviews
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/career/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/career') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div> Careers
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/job_application/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/job_application') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div> Career Applications
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ (request()->get('role') == 2 || (!request()->has('role') && strpos($CurrentUrl, 'admin/customer') !== false)) ? 'c-active' : null }}"
                    href="{{ url('admin/customer?role=2') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-users"></i>
                    </div> Users
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ request()->get('role') == 3 ? 'c-active' : null }}"
                    href="{{ url('admin/customer?role=3') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-user-tie"></i>
                    </div> Agents
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ request()->get('role') == 4 ? 'c-active' : null }}"
                    href="{{ url('admin/customer?role=4') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-building"></i>
                    </div> Agencies
                </a>
            </li>

            <li class="c-sidebar-nav-item"><a
                class="c-sidebar-nav-link {{ preg_match('/admin\/bookings/', $CurrentUrl)  ? 'c-active' : null }}"
                href="{{ url('admin/bookings') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fas fa-list"></i>
                    </div> Bookings
                </a>
            </li>




            <!-- <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/pages/', $CurrentUrl)  || preg_match('/admin\/page/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/pages') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-list"></i>
                    </div> Pages
                </a>
            </li>

             -->


            <li class="c-sidebar-nav-item"><a
                    class="c-sidebar-nav-link {{ preg_match('/admin\/subscribers/', $CurrentUrl)  ? 'c-active' : null }}"
                    href="{{ url('admin/subscribers') }}">
                    <div class="c-sidebar-nav-icon">
                        <i class="fa fa-envelope"></i>
                    </div> Subscribers
                </a>
            </li>




        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('') }}admin-assets/vendors/@coreui/icons/svg/free.svg#cil-menu">
                    </use>
                </svg>
            </button>
            <!-- <a class="c-header-brand d-lg-none" href="javascript:;">
                <svg width="118" height="46" alt="CoreUI Logo">
                    <use xlink:href="{{ asset('') }}admin-assets/assets/brand/coreui.svg#full"></use>
                </svg></a> -->
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button"
                data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('') }}admin-assets/vendors/@coreui/icons/svg/free.svg#cil-menu">
                    </use>
                </svg>
            </button>

            <ul class="c-header-nav ml-auto mr-4">


                <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="c-avatar"><img class="c-avatar-img" width="32"
                                src="{{ asset('') }}admin-assets/icons/user.png" alt="Cake Studio">

                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>

                        <a class="dropdown-item" href="{{ url('admin/dashboard') }}">
                            Dashboard
                        </a>
                        <a class="dropdown-item" href="{{ url('admin/change_password') }}">
                            Change Password
                        </a>
                        <a class="dropdown-item" href="{{ url('admin/logout') }}">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>

        </header>
        <div class="c-body">
            <main class="c-main">
                @yield('content')
            </main>

        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('') }}admin-assets/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="{{ asset('') }}admin-assets/vendors/@coreui/icons/js/svgxuse.min.js"></script>
    <!-- <script src="{{ asset('') }}admin-assets/js/jquery-2.2.4.min.js"></script> -->

    <script src="{{ asset('') }}admin-assets/js/parsley.min.js"></script>
    <script src="{{ asset('') }}admin-assets/js/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/solid.min.js"
        integrity="sha256-UM1HRu0Wd16k4L5wgrk17BYWzKkjZSe0BYr5T5qw2Ww=" crossorigin="anonymous"></script>
    <script src="{{ asset('') }}admin-assets/vendors/toggle/bootstrap4-toggle.min.js"></script>
    <script src="{{ asset('') }}admin-assets/vendors//datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('') }}admin-assets/fontawesome-iconpicker.min.js"></script>
    <!--<![endif]-->
    <!-- Plugins and scripts required by this view-->

    @yield('script')




    <script>
        window.Parsley.addValidator('lte', {
            validateString: function(value, requirement) {
                return parseFloat(value) <= parseRequirement(requirement);
            },
            priority: 32
        });
        var parseRequirement = function(requirement) {
            if (isNaN(+requirement))
                return parseFloat(jQuery(requirement).val());
            else
                return +requirement;
        };
        window.Parsley.addValidator('fileextension', {
            validateString: function(value, requirement) {
                var fileExtension = value.split('.').pop();
                extns = requirement.split(',');
                if (extns.indexOf(fileExtension.toLowerCase()) == -1) {
                    return fileExtension === requirement;
                }
            },
        });
        window.Parsley.addValidator('maxFileSize', {
            validateString: function(_value, maxSize, parsleyInstance) {
                var files = parsleyInstance.$element[0].files;
                return files.length != 1 || files[0].size <= maxSize * 1024;
            },
            requirementType: 'integer',
        });
        window.Parsley.addValidator('imagedimensions', {
            requirementType: 'string',
            validateString: function(value, requirement, parsleyInstance) {
                let file = parsleyInstance.$element[0].files[0];
                let [width, height] = requirement.split('x');
                let image = new Image();
                let deferred = $.Deferred();

                image.src = window.URL.createObjectURL(file);
                image.onload = function() {
                    if (image.width == width && image.height == height) {
                        deferred.resolve();
                    } else {
                        deferred.reject();
                    }
                };

                return deferred.promise();
            },
            messages: {
                en: 'Image dimensions should be  %spx'
            }
        });

        window.Parsley.addValidator('dategttoday', {
            validateString: function(value) {
                if (value !== '') {
                    return Date.parse(value) >= Date.parse(today);
                }
                return true;
            },
            messages: {
                en: 'Date should be equal or greater than today'
            }
        });
        if ($(".datepicker").length > 0) {
            $('.datepicker').datepicker({
                orientation: "bottom auto",
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
            $(".c-body").on('scroll', function() {
                $('.datepicker').datepicker('hide');
                $('.datepicker').blur();
            });
            $(".c-body").resize(function() {
                $('.datepicker').datepicker('hide');
                $('.datepicker').blur();
            });
        }
        $('body').on('change', '[data-role="file-image"]', function() {
            readURL(this, $(this).data('preview'));
        });
        var readURL = function(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).prop('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".toggle_status").change(function() {
            status = 0;
            if (this.checked) {
                status = 1;
            }

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $(this).data('url'),
                data: {
                    "id": $(this).data('id'),
                    'status': status,
                    "_token": "{{ csrf_token() }}"
                },
                timeout: 600000,
                dataType: 'json',
                success: function(res) {

                    if (res['status'] == 0) {
                        var m = res['message']
                        show_msg(0, m);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        var m = res['message']
                        show_msg(1, m);
                    }
                },
                error: function(e) {
                    show_msg(0, e.responseText);
                }
            });
        });

        $('body').off('click', '[data-role="unlink"]');
        $('body').on('click', '[data-role="unlink"]', function(e) {
            e.preventDefault();
            var msg = $(this).data('message') || 'Are you sure that you want to delete this record?';
            var href = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure to delete this record?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: href,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(res) {
                            if (res['status'] == 1) {

                                show_msg(1, 'Deleted successfully');

                                setTimeout(function() {
                                    window.location.reload();
                                }, 1500);

                            } else {
                                show_msg(0, res['message'] || 'Unable to delete the record.');
                            }
                        },
                        error: function(e) {
                            show_msg(0, e.responseText);
                        }
                    });
                };
            });

        });




        function show_msg(status, msg) {
            icon = "error"
            if (status) {
                icon = "success"
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
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

        if ($(".icon-picker").length > 0) {
            $('.icon-picker').iconpicker();
        }
    </script>

</body>

</html>
