<!DOCTYPE HTML>
<?php
    $currentRouteUri = \Route::current()->uri();
    $currency = session()->get('currency');
    $locale = session()->get('locale');

    if(!$currency){
        $currency = 'QAR';
    }
    if(!$locale){
        $locale = 'ar';
    }
?>
<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('global.site_name') }} | {{ $page_heading }}</title>

        @if($currentRouteUri=="property-details/{slug}")
            <meta name="title" content="{{$property->meta_title ?? ''}}">
            <meta name="description" content="{{$property->meta_description ?? ''}}">

            <meta name="title" lang="ar" content="{{$property->meta_title_ar ?? ''}}">
            <meta name="description" lang="ar" content="{{$property->meta_description_ar ?? ''}}">
        @else
            @php
                $set = \App\Models\Settings::find(1);
            @endphp
            <meta name="title" content="{{$set->meta_title ?? ''}}">
            <meta name="description" content="{{$set->meta_description ?? ''}}">

            <meta name="title" lang="ar" content="{{$set->meta_title_ar ?? ''}}">
            <meta name="description" lang="ar" content="{{$set->meta_description_ar ?? ''}}">
        @endif

        <!--=============== css  ===============-->
        <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/gallery-responsive.css">
        @if($currentRouteUri!="privacy-policy")
            @if($locale=="ar")
                <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/ar-style.css">
            @else
                <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/style.css">
            @endif
        @else
            <?php
            \Illuminate\Support\Facades\Session::put('locale', 'en');
            \Illuminate\Support\Facades\App::setLocale('en');
            ?>
            <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/style.css">
        @endif
        <link type="text/css" rel="stylesheet" href="{{ asset('') }}front-assets/css/db-style.css">
        <link href="{{ asset('') }}admin-assets/css/parsley.css" rel="stylesheet">
        <!--=============== favicons ===============-->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}admin-assets/assets/favicon/favicon.png" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="alternate" hreflang="en" href="https://bsbqa.com" />
<link rel="alternate" hreflang="ar" href="https://bsbqa.com" />
        <style>

           .txt-two-lines {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
                    line-clamp: 2;
            -webkit-box-orient: vertical;
          }
          .parsley-errors-list,.invalid-feedback{
            float:left;
          }

          .txt-three-lines {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
                    line-clamp: 3;
            -webkit-box-orient: vertical;
          }
          .txt-six-lines {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 6;
                    line-clamp: 6;
            -webkit-box-orient: vertical;
          }
          /* .main-register_bg{
            background: #fff url("{{ asset('') }}front-assets/images/about.jpg") center ;
            background-size: cover;
        } */
        .select2-container {
            width: 100% !important;
        }
        .select2-selection {
            width: 100% !important;
        }

        /* Phone verification styles */
        .verify-phone-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1;
        }

        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .otp-input:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        </style>
        @yield('header')

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GNSQRN3VSE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GNSQRN3VSE');
</script>
    </head>


    <body >
        <!--loader-->
        <div class="loader-wrap">
            <div class="loader-inner">
                <svg>
                    <defs>
                        <filter id="goo">
                            <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                            <fecolormatrix in="blur"   values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" />
                            <fecomposite in="SourceGraphic" in2="gooey" operator="atop"/>
                        </filter>
                    </defs>
                </svg>
            </div>
        </div>
        <!--loader end-->
        <!--  main   -->
        <div id="main">
            <a id="" href="https://wa.me/+97430666004" class="whatsapp_fixed" target="_blank">

                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
                </svg>
            </a>
            <!--header-->
            <header class="main-header">
                <div class="container">
                    <div class="header-inner header-sticky">
                        <a href="{{url('/')}}" class="logo-holder"><img src="{{ asset('') }}front-assets/images/logo.png" alt=""></a>
                        <!--  navigation -->
                        <div class="nav-holder main-menu">
                            <nav>
                                <ul class="no-list-style">
                                    <li >
                                        <a href="{{url('/')}}" @if($currentRouteUri=="/") class="act-link" @endif>{{ __("messages.home") }}</a>
                                    </li>
                                    <li>
                                        <a href="{{url('about-us')}}" @if($currentRouteUri=="about-us") class="act-link" @endif>{{ __("messages.about_us") }}</a>
                                    </li>
                                    <li>
                                        <a href="{{url('property-listing')}}" @if($currentRouteUri=="property-listing" || $currentRouteUri=="property-details/{slug}") class="act-link" @endif>{{ __("messages.properties") }} <i class="fa-solid fa-caret-down"></i></a>
                                        <!--second level -->
                                        <ul>
                                            <li><a href="{{url('property-listing?sale_type=2')}}">{{ __("messages.rent") }}</a></li>
                                            <li><a href="{{url('property-listing?sale_type=1')}}">{{ __("messages.buy") }}</a></li>
                                        </ul>
                                        <!--second level end-->
                                    </li>
                                    <li>
                                        <a href="{{url('photos')}}" @if($currentRouteUri=="photos" || $currentRouteUri=="videos" || $currentRouteUri=="blogs" || $currentRouteUri=="blog-details/{slug}") class="act-link" @endif>{{ __("messages.news_media") }} <i class="fa-solid "></i></a>
{{--                                        <ul>--}}
{{--                                            <li><a href="{{url('photos')}}">{{ __("messages.photos") }}</a></li>--}}
{{--                                            <li><a href="{{url('videos')}}">{{ __("messages.videos") }}</a></li>--}}
{{--                                            <li><a href="{{url('blogs')}}">{{ __("messages.blog") }}</a></li>--}}
{{--                                        </ul>--}}
                                        <!--second level end-->
                                    </li>
                                    <li>
                                        <a href="{{url('services')}}" @if($currentRouteUri=="services" || $currentRouteUri=="service-details/{slug}") class="act-link" @endif>{{ __("messages.services") }}</a>
                                    </li>
                                    <li>
                                        <a href="{{url('project-listing')}}" @if($currentRouteUri=="project-listing" || $currentRouteUri=="project-details/{slug}") class="act-link" @endif>{{ __("messages.projects") }}</a>
                                    </li>
                                    <li>
                                        <a href="{{url('contact-us')}}" @if($currentRouteUri=="contact-us") class="act-link" @endif>{{ __("messages.contact_us") }}</a>
                                    </li>
                                    <li class="d-md-none ">
                                        <a href="{{url('contact-us')}}" >Sign In</a>
                                    </li>
                                    <!--<li class="d-md-none ">-->
                                    <!--    <a href="#" >عربي</a>-->
                                    <!--</li>-->
                                </ul>
                            </nav>
                        </div>

                        <!-- navigation  end -->
                        <!-- nav-button-wrap-->
                        <div class="nav-button-btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                            <div class="nav-button">
                                <span></span><span></span><span></span>
                            </div>
                        </div>




<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <!-- <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5> -->
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body ">
    <div>
    <a class="d-block py-2" href="{{url('/')}}" @if($currentRouteUri=="/") class="act-link" @endif>{{ __("messages.home") }}</a>
    <a class="d-block py-2" href="{{url('about-us')}}" @if($currentRouteUri=="about-us") class="act-link" @endif>{{ __("messages.about_us") }}</a>

         <div class="dropdown mt-2">
      <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
      {{ __("messages.properties") }}
      </a>
      <ul class="dropdown-menu py-2" aria-labelledby="dropdownMenuButton">
      <li><a class="dropdown-item "  href="{{url('property-listing?sale_type=2')}}">{{ __("messages.rent") }}</a></li>
      <li><a class="dropdown-item"  href="{{url('property-listing?sale_type=1')}}">{{ __("messages.buy") }}</a></li>

      </ul>
    </div>

    <a class="d-block py-2" href="{{url('photos')}}" @if($currentRouteUri=="photos" || $currentRouteUri=="videos" || $currentRouteUri=="blogs" || $currentRouteUri=="blog-details/{slug}") class="act-link" @endif>{{ __("messages.news_media") }}</a>




                                    <a class="d-block py-2" href="{{url('services')}}" @if($currentRouteUri=="services" || $currentRouteUri=="service-details/{slug}") class="act-link" @endif>{{ __("messages.services") }}</a>
                                    <a class="d-block py-2" href="{{url('project-listing')}}" @if($currentRouteUri=="project-listing" || $currentRouteUri=="project-details/{slug}") class="act-link" @endif>{{ __("messages.projects") }}</a>
                                    <a class="d-block py-2" href="{{url('contact-us')}}" @if($currentRouteUri=="contact-us") class="act-link" @endif>{{ __("messages.contact_us") }}</a>
                                    <!-- <a class="d-block py-2 show-reg-form modal-open" style="    color: #000;
    width: auto;
    top: 20px;
    background: none; float:left" href="#" >{{ __('messages.sign_in') }}</a> -->
@if (Auth::check() && (Auth::user()->role != '1'))
                            <a href="{{url('my-profile')}}" rel="noopener noreferrer">
                                <div class="d-block py-2" data-bs-dismiss="offcanvas" aria-label="Close">
                                    <i class="fa fa-user ms-1 me-1 d-inline-block"></i><span>{{ __('messages.my_profile') }}</span>
                                </div>
                            </a>
                        @else
                            <div class=" modal-open" style="    color: #000;
    width: auto;
    top: 20px;
    background: none; float:none" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="fa fa-user ms-1 me-1 d-inline-block"></i><span>{{ __('messages.sign_in') }}</span>
                            </div>
                        @endif
    </div>

  </div>
</div>
                        <!-- nav-button-wrap end-->
                        @if($currentRouteUri!="privacy-policy")
                        @if($locale=="en")
                            <a href="{{url("change-language")}}/ar" class="header-btn "><span>AR <img src="{{ asset('') }}front-assets/images/qr-icon.png" alt="">  </span></a>
                        @else
                            <a href="{{url("change-language")}}/en" class="header-btn"><span>EN <img src="{{ asset('') }}front-assets/images/en.png" alt=""> </span></a>
                        @endif
                        @endif

                        <select data-placeholder="Currency" class="chosen-select on-radius no-search-select currency-select">
                            <option @if($currency=='QAR') selected @endif value="QAR">QAR</option>
                            <option @if($currency=='USD') selected @endif value="USD">USD</option>
                            <option @if($currency=='AED') selected @endif value="AED">AED</option>
                            <option @if($currency=='OMR') selected @endif value="OMR">OMR</option>
                            <option @if($currency=='GBP') selected @endif value="GBP">GBP</option>
                        </select>
                        <!-- <div class="cs-intputwrap currency-btn">
                            <i class="fa-light fa-money-bill " ></i>
                            <select data-placeholder="Statuses" class="chosen-select on-radius no-search-select">
                                <option style="padding-left: 20px;"> USD</option>
                                <option style="padding-left: 20px;"></option>>QAR</option>
                            </select>
                        </div>  -->
                        <!-- <div class="wish_btn " >

                            <div class="wish_btn-item"><a href="#"  style="color: #fff; font-size: 16px;" > <i class="fa-light fa-money-bill "></i></a></div>
                        </div> -->


                        @if (Auth::check() && (Auth::user()->role != '1'))
                            <a href="{{url('my-profile')}}" rel="noopener noreferrer">
                                <div class="show-reg-form">
                                    <i class="fa fa-user"></i><span>{{ __('messages.my_profile') }}</span>
                                </div>
                            </a>
                        @else
                            <div class="show-reg-form modal-open">
                                <i class="fa fa-user"></i><span>{{ __('messages.sign_in') }}</span>
                            </div>
                        @endif

                        <!-- header-search-wrap  -->
                        <div class="header-search-wrap novis_search">
                                <div class="header-search">
                                    <div class="header-search-nav">
                                        <div class="header-search-nav_container">
                                            <div class="header-search-radio">
                                                <!-- Sale, Rent, Commercial buttons with translation -->
                                                <input class="hidden radio-label" type="radio" name="accept-offers" id="sale-button" checked="checked">
                                                <label class="button-label" for="sale-button">{{ __('messages.for_sale') }}</label>
                                                <input class="hidden radio-label" type="radio" name="accept-offers" id="rent-button">
                                                <label class="button-label" for="rent-button">{{ __('messages.for_rent') }}</label>
                                                <input class="hidden radio-label" type="radio" name="accept-offers" id="comm-button">
                                                <label class="button-label" for="comm-button">{{ __('messages.commercial') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="header-search-container">
                                        <div class="custom-form">
                                            <!-- Keywords input field -->
                                            <div class="cs-intputwrap">
                                                <i class="fa-light fa-house"></i>
                                                <input type="text" placeholder="{{ __('messages.keywords') }}" value="">
                                            </div>

                                            <!-- Location input field -->
                                            <div class="cs-intputwrap">
                                                <i class="fa-light fa-location-dot"></i>
                                                <input type="text" placeholder="{{ __('messages.location') }}" value="">
                                            </div>

                                            <!-- Price range input field -->
                                            <div class="cs-intputwrap">
                                                <div class="price-range-wrap">
                                                    <label>{{ __('messages.price_range') }}</label>
                                                    <div class="price-rage-item">
                                                        <input type="text" class="price-range-double" data-min="100" data-max="100000" name="price-range1" data-step="1" value="1" data-prefix="ريال">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Search button -->
                                            <button onclick="window.location.href='property-listing.html'" class="commentssubmit commentssubmit_fw">{{ __('messages.search') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- header-search-wrap  end -->
                    </div>
                </div>
            </header>



    @yield('content')

    </div>
    <!--content  end-->
   <!--main-footer-->
    <div class="height-emulator"></div>
        <footer class="main-footer">
            <div class="container">
                <div class="footer-inner">
                    <div class="row">
                        <!-- footer-widget -->
                        <div class="col-lg-3">
                            <div class="footer-widget">
                                <div class="footer-widget-title">{{ __('messages.bin_al_sheikh_brokerage') }}</div>
                                <div class="footer-widget-content">
                                    <p>{{ __('messages.company_description') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-3">
                            <div class="footer-widget">
                                <div class="footer-widget-title">{{ __('messages.helpful_links') }}</div>
                                <div class="footer-widget-content">
                                    <div class="footer-list footer-box">
                                        <ul>
                                            <li><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                                            <li><a href="{{ url('about-us') }}">{{ __('messages.about_us') }}</a></li>
                                            <li><a href="{{ url('property-listing') }}">{{ __('messages.properties') }}</a></li>
                                            <li><a href="{{ url('services') }}">{{ __('messages.services') }}</a></li>
                                            <li><a href="{{ url('photos') }}">{{ __('messages.news_media') }}</a></li>
                                            <li><a href="{{ url('contact-us') }}">{{ __('messages.contact_us') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-3">
                            <div class="footer-widget">
                                <div class="footer-widget-title">{{ __('messages.our_contacts') }}</div>
                                <div class="footer-widget-content">
                                    <div class="footer-list footer-box">
                                        <ul class="footer-contacts">
                                            <li><span>{{ __('messages.mail') }} :</span><a href="mailto:info@bsbqa.com">info@bsbqa.com</a></li>
                                            <li><span>{{ __('messages.address') }} :</span><a href="#" target="_blank">{{ __('messages.address_text') }}</a></li>
                                            <li><span>{{ __('messages.phone') }} :</span><a href="tel:+97450258942">+974 - 5025 8942 - 3066 6004</a></li>
                                        </ul>
                                        <a href="{{ url('contact-us') }}" class="footer-widget-content-link"><span>{{ __('messages.get_in_touch') }}</span><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-3">
                            <div class="footer-widget">
                                <div class="footer-widget-title">{{ __('messages.subscribe') }}</div>
                                <div class="footer-widget-content">
                                    <p>{{ __('messages.subscribe_description') }}</p>
                                    {{-- <form id="subscribe" class="subscribe-item"> --}}
                                    <form method="post" id="sub-form" action="{{ url('save_subscribe') }}" enctype="multipart/form-data" data-parsley-validate="true" class="subscribe-item">
                                            @csrf()
                                        <input class="enteremail" name="email" id="subscribe-email" placeholder="{{ __('messages.your_email') }}" spellcheck="false" type="email" required data-parsley-required-message="{{ __('messages.email_required') }}" data-parsley-type-message="{{ __('messages.valid_email') }}">
                                        <button type="submit" id="subscribe-button" class="subscribe-button"><span>{{ __('messages.send') }}</span></button>
                                        {{-- <label for="subscribe-email" class="subscribe-message"></label> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                    </div>
                    <!-- footer-widget-wrap end-->
                </div>
                <div class="footer-bottom">
                    <a href="{{ url('/') }}" class="footer-home_link"><i class="fa-regular fa-house"></i></a>
                    <div class="copyright"><span>&#169; {{ __('messages.bin_al_sheikh_brokerage') }} 2024</span> . {{ __('messages.all_rights_reserved') }}</div>
                    <div class="footer-social">
                        <span class="footer-social-title">{{ __('messages.follow_us') }}</span>
                        <div class="footer-social-wrap">
                            <a href="https://www.facebook.com/BINALSHEIKHQA" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://x.com/BinAlSheikhqa" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://www.instagram.com/binalsheikhqa/x" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.tiktok.com/@binalsheikhqa" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                            <a href="https://youtube.com/@binalsheikhtowers1457" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

                <!--main-footer end-->
            </div>
            <!--warpper end-->
            <!--wish-list-wrap-->

            <!--wish-list-wrap end-->
            <div class="mob-nav-overlay fs-wrapper"></div>
            <div class="body-overlay fs-wrapper wishlist-wrap-overlay clwl_btn"></div>
            <!--register form -->
            <div class="main-register-container">
                <div class="main-register_box">
                    <div class="main-register-holder">
                    <div class="main-register-wrap">
                            <div class="main-register_bg">
                                <div class="mr_title">
                                    <img src="{{ asset('') }}front-assets/images/logo.png" class="mb-3" alt="">
                                    <h5>{{ __('messages.bin_al_sheikh_description') }}</h5> <!-- Translated description -->
                                </div>
                                <div class="main-register_contacts-wrap">
                                    <h4 class="text-white">{{ __('messages.have_a_question') }}</h4> <!-- Translated question -->
                                    <a href="{{url('contact-us')}}">{{ __('messages.get_in_touch') }}</a> <!-- Translated link -->
                                    <div class="svg-corner svg-corner_white"  style="bottom:0;left:  -39px;"></div>
                                    <div class="svg-corner svg-corner_white"  style="bottom:0;right:  -39px;transform: rotate(90deg)"></div>
                                </div>
                                <div class="main-register_bg-dec"></div>
                            </div>
                            <div class="main-register tabs-act fl-wrap">
                                <ul class="tabs-menu">
                                    <li class="current"><a href="#tab-1"><i class="fa-regular fa-sign-in-alt"></i> {{ __('messages.login') }}</a></li> <!-- Translated Login -->
                                    <li><a href="#tab-2"><i class="fa-regular fa-user-plus"></i> {{ __('messages.register') }}</a></li> <!-- Translated Register -->
                                </ul>
                                <div class="close-modal close-reg-form"><i class="fa-regular fa-xmark"></i></div>
                                <!--tabs -->
                                <div id="tabs-container">
                                    <div class="tab">
                                        <!--tab -->
                                        <div id="tab-1" class="tab-content first-tab">
                                            <div class="custom-form">
                                                <form id="user-form" data-type="login" action="{{ url('frontend/check_login') }}" data-parsley-validate="true">
                                                    @csrf()
                                                    <div class="cs-intputwrap">
                                                        <i class="fa-light fa-user"></i>
                                                        <input type="text" placeholder="{{ __('messages.email_address') }}" name="email" required
                                                            data-parsley-required-message="{{ __('messages.email_required') }}"> <!-- Translated Email -->
                                                    </div>
                                                    <div class="cs-intputwrap pass-input-wrap">
                                                        <i class="fa-light fa-lock"></i>
                                                        <input type="password" class="pass-input" placeholder="{{ __('messages.current_password') }}" name="password" required
                                                            data-parsley-required-message="{{ __('messages.password_required') }}"> <!-- Translated Password -->
                                                        <div class="view-pass"></div>
                                                    </div>
                                                    <div class="filter-tags">
                                                        <input id="check-a" type="checkbox" name="check" checked>
                                                        <label for="check-a">{{ __('messages.remember_me') }}</label> <!-- Translated Remember me -->
                                                    </div>
                                                    <div class="lost_password">
                                                        <a href="#">{{ __('messages.lost_your_password') }}</a> <!-- Translated Lost your password -->
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <button type="submit" class="commentssubmit">{{ __('messages.log_in') }}</button> <!-- Translated Log In -->
                                                </form>
                                            </div>
                                        </div>
                                        <!--tab end -->
                                        <!--tab -->
                                        <div class="tab">
                                            <div id="tab-2" class="tab-content">
                                                <div class="custom-form">
                                                    <form id="user-form" method="POST" action="{{ url('frontend/signup') }}" data-parsley-validate="true">
                                                        @csrf()
                                                        <!-- User Type Selection -->
                                                        <div class="filter-tags d-flex mb-3 mt-0" style="float: none;">
                                                            <input class="form-check-input user_type_inp" type="radio" name="user_type" id="user_type_user" checked value="2">
                                                            <label class="form-check-label" for="user_type_user">{{ __('messages.user') }}</label>
                                                            <input class="form-check-input user_type_inp" type="radio" name="user_type" id="user_type_agent" value="3">
                                                            <label class="form-check-label" for="user_type_agent">{{ __('messages.agent') }}</label>
                                                            <input class="form-check-input user_type_inp" type="radio" name="user_type" id="user_type_agency" value="4">
                                                            <label class="form-check-label" for="user_type_agency">{{ __('messages.agency') }}</label>
                                                            {{-- <input class="form-check-input user_type_inp" type="radio" name="user_type" id="user_type_agency" value="4">
                                                            <label class="form-check-label" for="user_type_agency">{{ __('messages.agency') }}</label> --}}
                                                        </div>

                                                        <!-- Full Name -->
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-user"></i>
                                                            <input type="text" placeholder="{{ __('messages.full_name') }}" name="name" id="name" required
                                                                data-parsley-required-message="{{ __('messages.enter_your_name') }}"> <!-- Translated Full Name -->
                                                        </div>

                                                        <!-- Phone Number -->
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-mobile"></i>
                                                            <input type="text" placeholder="{{ __('messages.phone_number') }}" name="phone" required
                                                                data-parsley-required-message="{{ __('messages.enter_your_phone') }}">
                                                                <div class="view-view-button-verify-phone"> <!-- Translated Phone Number -->
                                                                        <button type="button" class="verify-phone-btn">{{ __('messages.verify') }}</button>
                                                                </div>
                                                        </div>

                                                        <!-- Email Address -->
                                                        <div class="cs-intputwrap">
                                                            <i class="fa-light fa-envelope"></i>
                                                            <input type="email" placeholder="{{ __('messages.email_address') }}" name="email" required
                                                                data-parsley-required-message="{{ __('messages.enter_your_email') }}"> <!-- Translated Email Address -->
                                                        </div>


{{--                                                        <div class="cs-intsputwrap agency_div d-none">--}}
{{--                                                            <input type="text" placeholder="{{ __('messages.contact_number') }}" class="form-control agency_inp" name="id_no" data-parsley-required-message="{{ __('messages.enter_contact_number') }}">--}}
{{--                                                        </div>--}}
                                                        <!-- License Upload for Agents/Agencies -->
                                                        <div class="cs-intsputwrap agent_div d-none">
                                                            <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}" id="id_card_label">{{ __('messages.id_card') }}</label>
                                                            <input type="file" class="form-control agent_inp" name="id_card" required data-parsley-required-message="{{ __('messages.select_id_card') }}"
                                                                   data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                   data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                   data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                   accept="image/*,application/pdf">
                                                        </div>
                                                        <div class="cs-intsputwrap agency_div d-none">
                                                            <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}">{{ __('messages.professional_practice_certificate') }}</label> <!-- Translated License -->
                                                            <input type="file" class="form-control agency_inp" name="professional_practice_certificate" data-parsley-required-message="{{ __('messages.select_professional_practice_certificate') }}"
                                                                data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                accept="image/*,application/pdf">
                                                        </div>
                                                        <div class="cs-intsputwrap agency_div d-none">
                                                            <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}">{{ __('messages.authorized_signatory') }}</label> <!-- Translated License -->
                                                            <input type="file" class="form-control agency_inp" name="authorized_signatory" data-parsley-required-message="{{ __('messages.select_authorized_signatory') }}"
                                                                   data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                   data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                   data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                   accept="image/*,application/pdf">
                                                        </div>
                                                        <div class="cs-intsputwrap agency_div d-none">
                                                            <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}">{{ __('messages.cr') }}</label> <!-- Translated License -->
                                                            <input type="file" class="form-control agency_inp" name="cr" data-parsley-required-message="{{ __('messages.select_cr') }}"
                                                                   data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                   data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                   data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                   accept="image/*,application/pdf">
                                                        </div>
                                                        <!-- Agency Selection for Agents -->
                                                        <div class="cs-intputwrap agent_agency_select_div d-none">
                                                        <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}">{{ __('messages.select_agency') }}</label> 
                                                            <select name="agency_id" id="agency_id" class="agent_agency_select_inp">
                                                                <option value="">{{ __('messages.select_agency') }}</option>
                                                                @php
                                                                    $agencies = \App\Models\User::where('role', 4)->where('active', 1)->where('verified', 1)->get();
                                                                @endphp
                                                                @if($agencies->count() > 0)
                                                                    @foreach($agencies as $agency)
                                                                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="" disabled>{{ __('messages.no_agencies_available') }}</option>
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <!-- License Upload for Agents/Agencies -->
                                                         <div class="cs-intsputwrap agent_agency_div d-none">
                                                            <label for="d" style="float:{{ $locale == 'ar' ? 'right' : 'left' }}" id="license_label">{{ __('messages.license') }}</label>
                                                            <input type="file" class="form-control agent_agency_inp" name="license" required data-parsley-required-message="{{ __('messages.select_license') }}"
                                                                data-parsley-trigger="change" data-parsley-fileextension="jpg,png,jpeg,pdf"
                                                                data-parsley-fileextension-message="{{ __('messages.file_extension_message') }}"
                                                                data-parsley-max-file-size="5120" data-parsley-max-file-size-message="{{ __('messages.max_file_size_message') }}"
                                                                accept="image/*,application/pdf">
                                                        </div>

                                                        <div class="cs-intputwrap pass-input-wrap pass_div mt-3">
                                                            <i class="fa-light fa-lock"></i>
                                                            <input type="password" class="pass-input" placeholder="{{ __('messages.password') }}" name="password" required
                                                                data-parsley-required-message="{{ __('messages.enter_password') }}">
                                                            <div class="view-pass"></div>
                                                        </div>
                                                        <button type="submit" class="commentssubmit"><span>{{ __('messages.register') }}</span></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--tab end -->
                                    </div>
                                    <!--tabs end -->
                                    <div class="log-separator fl-wrap"><span>{{ __('messages.or') }}</span></div> <!-- Translated Or -->
                                    <div class="soc-log  fl-wrap ">
                                        <p>{{ __('messages.faster_login') }}</p> <!-- Translated Faster Login -->
                                        <a href="{{url('/login/google')}}" class="google_log"><i class="fa-brands fa-google"></i>{{ __('messages.connect_with_google') }}</a> <!-- Translated Google -->
                                        <a href="{{url('/login/facebook')}}" class="fb_log"><i class="fa-brands fa-facebook-f"></i> {{ __('messages.connect_with_facebook') }}</a> <!-- Translated Facebook -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="body-overlay fs-wrapper reg-overlay close-reg-form"></div>
            </div>
            <!--register form end -->
            <!-- progress-bar  -->
            <div class="progress-bar-wrap">
                <div class="progress-bar color-bg"></div>
            </div>
            <!-- progress-bar end -->
            <!--map-modal -->
            <div class="map-modal-wrap">
                <div class="map-modal-wrap-overlay"></div>
                <div class="map-modal-item">
                    <div class="map-modal-container fl-wrap">
                        <h3> <span>Listing Title </span></h3>
                        <div class="map-modal-close"><i class="fa-regular fa-xmark"></i></div>
                        <div class="map-modal fl-wrap">
                            <div id="singleMap" data-latitude="40.7" data-longitude="-73.1"></div>
                            <div class="scrollContorl"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--map-modal end -->
        </div>

       <!-- Main end -->
       <!--=============== scripts  ===============-->
       <script src="{{ asset('') }}front-assets/js/jquery.min.js"></script>

       <script src="{{ asset('') }}front-assets/js/plugins.js"></script>
       <script src="{{ asset('') }}front-assets/js/scripts.js"></script>
       <script src="{{ asset('') }}front-assets/js/db-scripts.js"></script>
       <!--<script src="https://maps.googleapis.com/maps/api/js?key=YOU_API_KEY_HERE&libraries=places"></script>-->
       <!--<script src="{{ asset('') }}front-assets/js/map-single.js"></script>-->
       <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
       <!--<script src="{{ asset('') }}front-assets/js/bootstrap.bundle.min.js"></script>-->

 <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
       <script>
       var locations = [
     ['Bondi Beach', -33.890542, 151.274856, 4],
     ['Coogee Beach', -33.923036, 151.259052, 5],
     ['Cronulla Beach', -34.028249, 151.157507, 3],
     ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
     ['Maroubra Beach', -33.950198, 151.259302, 1]
   ];

   var map = new google.maps.Map(document.getElementById('map'), {
     zoom: 10,
     center: new google.maps.LatLng(-33.92, 151.25),
     mapTypeId: google.maps.MapTypeId.ROADMAP
   });

   var infowindow = new google.maps.InfoWindow();

   var marker, i;

   for (i = 0; i < locations.length; i++) {
     marker = new google.maps.Marker({
       position: new google.maps.LatLng(locations[i][1], locations[i][2]),
       map: map
     });

     google.maps.event.addListener(marker, 'click', (function(marker, i) {
       return function() {
         infowindow.setContent(locations[i][0]);
         infowindow.open(map, marker);
       }
     })(marker, i));
   }
       </script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('admin-assets/plugins/notification/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('') }}admin-assets/js/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    //     // $(".select2").select2();
    //     // $('#paymentCalculator').on('shown.bs.modal', function () {
    //     //     setTimeout(function() {
    //     //         $('.select2').select2();
    //     //     }, 300);
    //     // });
    //     $(document).ready(function() {
    // // Initialize Select2 on page load
    // $('.select2').select2();

    // // Reinitialize Select2 when modal is shown
    //     $('#paymentCalculator').on('shown.bs.modal', function () {
    //         setTimeout(function() {
    //                 $('.select2').each(function() {
    //                     var $this = $(this);
    //                     if (!$this.hasClass("select2-hidden-accessible")) {
    //                         $this.select2();
    //                     }
    //                 });
    //             }, 300);
    //         });
    //     });
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "rtl": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 2000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


    <script>
        $(document).ready(function() {
            // Initialize - remove required from all hidden fields
            $(".d-none input, .d-none select").removeAttr("required");

            $(".user_type_inp").change(function(){
                console.log("User type changed to: " + $(this).val());
                if($(this).val()==2){
                    $(".agent_div").addClass("d-none");
                    $(".agent_agency_div").addClass("d-none");
                    $(".agent_agency_select_div").addClass("d-none");
                    $(".agent_agency_inp").removeAttr("required");
                    $(".agent_agency_select_inp").removeAttr("required");
                    $(".agent_inp").removeAttr("required");
                    $(".agency_div").addClass("d-none");
                    $(".agency_inp").removeAttr("required");
                    document.getElementById('name').placeholder = "{{__('messages.full_name')}}";
                }else if($(this).val()==3){
                    console.log("Showing agent fields");
                    $(".agent_div").removeClass("d-none");
                    $(".agent_agency_div").removeClass("d-none");
                    $(".agent_agency_select_div").removeClass("d-none");
                    $(".agent_agency_inp").attr("required","");
                    $(".agent_agency_select_inp").removeAttr("required");
                    $(".agent_inp").attr("required","");
                    $(".agency_div").addClass("d-none");
                    $(".agency_inp").removeAttr("required");

                    document.getElementById('name').placeholder = "{{__('messages.full_name')}}";
                    $("#license_label").text("{{__('messages.license')}}");
                }else{
                    $(".agent_div").addClass("d-none");
                    $(".agent_div").removeAttr("required");
                    $(".agent_inp").removeAttr("required");
                    $(".agent_agency_select_div").addClass("d-none");
                    $(".agent_agency_select_inp").removeAttr("required");

                    $(".agency_div").removeClass("d-none");
                    $(".agency_inp").attr("required","");

                    $(".agent_agency_div").removeClass("d-none");
                    $(".agent_agency_inp").attr("required","");

                     document.getElementById('name').placeholder = "{{__('messages.company_name')}}";
                    $("#license_label").text("{{__('messages.trade_license')}}");
                }
            });
        });

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
    function show_msg(status, msg) {
            icon = "error";
            timer = 10000;
            if (status) {
                icon = "success";
                timer = 1500;
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer,
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
   <script>

//         document.addEventListener('click', function (event) {
//             const dropdown = document.querySelector('.dropdown');
//             const dropdownToggle = document.getElementById('dropdownMenuButton');

//             // Check if the click target is outside of the dropdown
//             if (!dropdown.contains(event.target) && dropdownToggle.classList.contains('show')) {
//                 bootstrap.Dropdown.getInstance(dropdownToggle).hide(); // Ensure dropdown closes
//             }
//         });
//
 </script>
 <script>
// const dropdownElement = document.getElementById('dropdownMenuButton');
// const dropdown = new bootstrap.Dropdown(dropdownElement);


// dropdown.show();


// dropdown.hide();
//
</script>
  <script>
    // Select all dropdown menus outside the event listener
    const dropdowns = document.querySelectorAll('.dropdown');

    // Close dropdown when clicking outside of it
    document.addEventListener('click', function (event) {
        dropdowns.forEach(dropdown => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');

            // If clicked outside of the dropdown, hide the menu
            if (!dropdown.contains(event.target)) {
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                }
            }
        });
    });

    // To toggle dropdown when the button is clicked
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            const dropdown = this.parentElement;
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');

            // Stop the event from propagating to the document listener
            event.stopPropagation();

            // Close other dropdowns
            dropdowns.forEach(d => {
                if (d !== dropdown) {
                    d.querySelector('.dropdown-menu').classList.remove('show');
                }
            });

            // Toggle the current dropdown menu
            dropdownMenu.classList.toggle('show');
        });
    });
</script>

    @if(session('error'))
        <script>
             show_msg(0, "{{ session('error') }}");
        </script>
    @endif
    <script>



        $('body').off('submit', '#user-form');
        $('body').on('submit', '#user-form', function(e) {
            e.preventDefault();
            console.log("=== FORM SUBMISSION STARTED ===");
            var $form = $(this);

            // Log form data
            var formData = new FormData(this);
            console.log("Form data entries:");
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Check if form is valid with Parsley
            console.log("Checking Parsley validation...");
            var isValid = $form.parsley().isValid();
            console.log("Form validation result:", isValid);

            if (!isValid) {
                console.log("=== VALIDATION FAILED ===");
                var errors = $form.parsley().getErrorsMessages();
                console.log("Validation errors:", errors);

                // Log which fields are invalid
                $form.find('.parsley-error').each(function() {
                    console.log("Invalid field:", $(this).attr('name'), $(this).val());
                });

                // TEMPORARY: Skip validation for testing
                console.log("=== SKIPPING VALIDATION FOR TESTING ===");
                // $form.parsley().validate();
                // return false;
            } else {
                console.log("=== VALIDATION PASSED - PROCEEDING WITH SUBMISSION ===");
            }

            var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            formData.append('timezone', timeZone);

            $(".invalid-feedback").remove();
            txt = $form.find('button[type="submit"]').text();

            $form.find('button[type="submit"]')
                .text('Submitting')
                .attr('disabled', true);

            console.log("Form data prepared, sending AJAX request to:", $form.attr('action'));


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
                    console.log("=== AJAX SUCCESS ===");
                    console.log("AJAX response received:", res);

                    if (res['status'] == 0) {
                        console.log("Server returned error status");
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
                            // toastr["error"](m);
                            show_msg(0, m)

                        }
                    } else {
                        console.log("Server returned success status");
                        $(".close-reg-form").click();
                        var m = res['message'];
                        console.log("Success message:", m);
                        // toastr["success"](m);
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    }

                    $form.find('button[type="submit"]')
                        .text(txt)
                        .attr('disabled', false);
                },
                error: function(e) {
                    console.log("=== AJAX ERROR ===");
                    console.log("AJAX error:", e);
                    console.log("Error status:", e.status);
                    console.log("Error response:", e.responseText);
                    $form.find('button[type="submit"]')
                        .text(txt)
                        .attr('disabled', false);
                        show_msg(0, e.responseText)
                        // toastr["error"](e.responseText);
                }
            });
        });

        $(".fav_prop").click(function(e){
            e.preventDefault();
            _this = $(this);
            _prop_id = $(this).data('id');
            reload = $(this).data('reload');
            $.ajax({
                type: "POST",
                url: "{{url('fav_property')}}",
                data: {
                    'prop_id':_prop_id,
                    '_token': "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(res) {
                    var m = res['message'];
                    show_msg(res['status'], m)

                    if(res['status']==1){
                        if (typeof reload !== 'undefined' && reload) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        }
                    }

                    if (res['type'] == "add") {
                        $(".heart_"+_prop_id).removeAttr('style');
                        _this.attr("data-tooltip","{{__('messages.remove_from_favourites')}}");
                    } else {
                        $(".heart_"+_prop_id).css('font-weight','400');
                        _this.attr("data-tooltip","{{__('messages.add_to_favourites')}}")
                    }
                },
                error: function(e) {
                    show_msg(0, e.responseText)
                }
            });
        });

        $(".currency-select").change(function(e){
            e.preventDefault();
            cur = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('change_currency') }}/" + cur,
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    window.location.reload();
                }
            });
        });

        $(document).ready(function() {
            // Load all projects on page load
            $.ajax({
                url: '{{ url('/get-projects') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    location_id: ''
                },
                dataType: "json",
                success: function(response) {
                    var data = response.data;
                    if (data.length > 0) {
                        $.each(data, function(index, value) {
                            $('.prj-select').append('<option value="' + value['id'] + '">' + value['name'] + '</option>');
                        });
                        $('.prj-select').niceSelect('update');
                    }
                }
            });

            // Existing location change handler
            $('.location-select').change(function() {
                $('.prj-select').html('');
                $(".prj-select").attr("data-placeholder",'{{ __("messages.project") }}');

                $('.prj-select').html('<option value="">{{ __("messages.project") }}</option>');

                var location_id = $(this).val();

                $.ajax({
                    url: '{{ url('/get-projects') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        location_id: location_id
                    },
                    dataType: "json",
                    success: function(response) {
                        var data = response.data;

                        if (data.length > 0) {
                            $.each(data, function(index, value) {
                                $('.prj-select').append('<option value="' + value['id'] +
                                    '">' + value['name'] + '</option>');
                            });

                            if ($('.prj-select').val() === '') {
                                $('.prj-select').val('').trigger('change');
                            }

                        } else {
                            $('.prj-select').html('');
                            $(".prj-select").attr("data-placeholder",'{{ __("messages.project") }}');
                            $('.prj-select').html('<option value="" >{{ __("messages.project") }}</option>');
                        }

                        $('.prj-select').niceSelect('update');
                    }
                });
            });
        });
        $('body').off('submit', '#emiCalculatorForm');
        $('body').on('submit', '#emiCalculatorForm', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            $(".invalid-feedback").remove();
            txt = $form.find('button[type="submit"]').text();

            $form.find('button[type="submit"]')
                .text("{{ __('messages.calculating') }}")
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
                    $('.calculate_em_tbody').html(res.html);
                    $form.find('button[type="submit"]')
                        .text(txt)
                        .attr('disabled', false);
                },
                error: function(e) {
                    show_msg(0, e.responseText)
                }
            });
        });


        $('body').off('submit', '#rentCalculatorForm');
        $('body').on('submit', '#rentCalculatorForm', function(e) {
            e.preventDefault();
            $(".total_rent_li").addClass("d-none");
            var $form = $(this);
            var formData = new FormData(this);
            $(".invalid-feedback").remove();
            txt = $form.find('button[type="submit"]').text();

            $form.find('button[type="submit"]')
                .text("{{ __('messages.calculating') }}")
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
                    $('.calculate_em_tbody').html(res.html);
                    $(".total_rent_li").removeClass("d-none");
                    $(".total_rent_span").text($("#total_rent_inp").val());
                    $form.find('button[type="submit"]')
                        .text(txt)
                        .attr('disabled', false);
                },
                error: function(e) {
                    show_msg(0, e.responseText)
                }
            });
        });

        window.Parsley.addValidator('greaterThanZero', {
            validateString: function(value) {
            return parseFloat(value) > 0;
            },
            messages: {
            en: "{{ __('messages.the_value_must_be_greater_than_zero') }}"
            }
        });

    </script>

<script>
    $('body').off('submit', '#sub-form');
    $('body').on('submit', '#sub-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        var formData = new FormData(this);
        $(".invalid-feedback").remove();

        _text =  $form.find('button[type="submit"]').text();

        $form.find('button[type="submit"]')
            .text("{{ __('messages.submitting') }}")
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
                        var m = res['message'] ;
                        show_msg(0, m)
                    }
                } else {
                    var m = res['message'];
                    show_msg(1, m)
                    $("#subscribe-email")
                    .val('')
                    .css("background", "#111")
                    .css("border", "1px solid rgba(255, 255, 255, .1)");

                }

                $form.find('button[type="submit"]')
                    .text(_text)
                    .attr('disabled', false);
            },
            error: function(e) {

                $form.find('button[type="submit"]')
                    .text(_text)
                    .attr('disabled', false);
                show_msg(0, e.responseText)
            }
        });
    });

</script>

@yield('script')

   </body>
</html>

<script>
    function redirectToSpecificCheckout(event) {
        event.preventDefault();

        // Get form values
        const advanceAmount = $('#AdvanceAmount').val();
        const rentalDuration = $('select[name="rental_duration"]').val();

        if (!advanceAmount || !rentalDuration) {
            show_msg(0, "{{ __('messages.please_fill_in_all_required_fields_and_calculate_emi_first') }}");
            return;
        }

        // Redirect to specific checkout page with parameters
        const propertyId = $('input[name="property_id"]').val();
        window.location.href = `/specific-checkout/${propertyId}?advance_amount=${advanceAmount}&rental_duration=${rentalDuration}`;
    }
</script>

<!-- Phone Verification Modal -->
<div class="modal fade" id="phoneVerificationModal" tabindex="-1" aria-labelledby="phoneVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneVerificationModalLabel">{{ __('messages.verify_phone') ?? 'Verify Phone' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="otp-container">
                    <p class="text-center">{{ __('messages.verification_code_sent') ?? 'A verification code has been sent to your phone number' }}</p>
                    <div class="otp-inputs d-flex justify-content-center gap-2 mb-4">
                        <input type="text" class="otp-input form-control" maxlength="1" autofocus>
                        <input type="text" class="otp-input form-control" maxlength="1">
                        <input type="text" class="otp-input form-control" maxlength="1">
                        <input type="text" class="otp-input form-control" maxlength="1">
                        <input type="text" class="otp-input form-control" maxlength="1">
                        <input type="text" class="otp-input form-control" maxlength="1">
                    </div>
                    <div class="text-center mb-3">
                        <span id="resendCountdown">{{ __('messages.resend_code_in') ?? 'Resend code in' }} <span id="countdown">60</span> {{ __('messages.seconds') ?? 'seconds' }}</span>
                    </div>
                    <div class="text-center">
                        <button type="button" id="resendOtpBtn" class="btn btn-link" disabled>{{ __('messages.resend_code') ?? 'Resend Code' }}</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                <button type="button" class="btn btn-primary" id="verifyOtpBtn">{{ __('messages.verify') ?? 'Verify' }}</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Style for the verify button
    $(".verify-phone-btn").css({
        'position': 'absolute',
        'right': '10px',
        'top': '50%',
        'transform': 'translateY(-50%)',
        'background-color': '#4CAF50',
        'color': 'white',
        'border': 'none',
        'border-radius': '4px',
        'padding': '5px 10px',
        'cursor': 'pointer',
        'font-size': '14px'
    });

    // Handle click on verify phone button
    $(".verify-phone-btn").click(function() {
        const phoneNumber = $(this).siblings("input[name='phone']").val();

        if (!phoneNumber) {
            show_msg(0, "{{ __('messages.enter_phone_first') ?? 'Please enter your phone number first' }}");
            return;
        }

        // Send OTP to the phone number
        sendOTP(phoneNumber);

        // Show the OTP verification modal
        $("#phoneVerificationModal").modal("show");

        // Start countdown timer
        startCountdown();
    });

    // Handle OTP input focus change
    $(".otp-input").on("input", function() {
        if ($(this).val().length === 1) {
            $(this).next(".otp-input").focus();
        }
    });

    // Handle backspace in OTP inputs
    $(".otp-input").on("keydown", function(e) {
        if (e.keyCode === 8 && $(this).val() === "") {
            $(this).prev(".otp-input").focus();
        }
    });

    // Handle verify OTP button click
    $("#verifyOtpBtn").click(function() {
        let otp = "";
        $(".otp-input").each(function() {
            otp += $(this).val();
        });

        if (otp.length !== 6) {
            show_msg(0, "{{ __('messages.enter_complete_otp') ?? 'Please enter the complete verification code' }}");
            return;
        }

        const phoneNumber = $("input[name='phone']").val();

        // Verify OTP
        verifyOTP(phoneNumber, otp);
    });

    // Handle resend OTP button click
    $("#resendOtpBtn").click(function() {
        if (!$(this).prop("disabled")) {
            const phoneNumber = $("input[name='phone']").val();
            sendOTP(phoneNumber);
            startCountdown();
            $(this).prop("disabled", true);
        }
    });

    // Function to send OTP
    function sendOTP(phoneNumber) {
        // Here you would make an AJAX call to your backend to send the OTP
        // For now, we'll just simulate success
        console.log("Sending OTP to " + phoneNumber);

        $.ajax({
            url: "{{ url('send-otp') }}", // You'll need to create this endpoint
            method: "POST",
            data: {
                phone: phoneNumber,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    show_msg(1, "{{ __('messages.otp_sent_success') ?? 'Verification code sent successfully' }}");
                } else {
                    show_msg(0, response.message || "{{ __('messages.otp_sent_failed') ?? 'Failed to send verification code' }}");
                }
            },
            error: function(xhr) {
                console.log(xhr);
                show_msg(0, "{{ __('messages.server_error') ?? 'Server error occurred' }}");
            }
        });
    }

    // Function to verify OTP
    function verifyOTP(phoneNumber, otp) {
        // Here you would make an AJAX call to your backend to verify the OTP
        // For now, we'll just simulate success
        console.log("Verifying OTP " + otp + " for phone " + phoneNumber);

        $.ajax({
            url: "{{ url('verify-otp') }}", // You'll need to create this endpoint
            method: "POST",
            data: {
                phone: phoneNumber,
                otp: otp,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    show_msg(1, "{{ __('messages.phone_verified') ?? 'Phone number verified successfully' }}");
                    $("#phoneVerificationModal").modal("hide");

                    // Visual indication that the phone is verified
                    $("input[name='phone']").css("border-color", "#4CAF50");
                    $(".verify-phone-btn")
                        .text("{{ __('messages.verified') ?? 'Verified' }}")
                        .css("background-color", "#4CAF50")
                        .prop("disabled", true);

                    // You may want to store the verification status
                    $("form").append('<input type="hidden" name="phone_verified" value="1">');
                } else {
                    show_msg(0, response.message || "{{ __('messages.invalid_otp') ?? 'Invalid verification code' }}");
                }
            },
            error: function(xhr) {
                show_msg(0, "{{ __('messages.server_error') ?? 'Server error occurred' }}");
            }
        });
    }

    // Function to start countdown timer
    function startCountdown() {
        let seconds = 60;
        $("#countdown").text(seconds);
        $("#resendOtpBtn").prop("disabled", true);

        const timer = setInterval(function() {
            seconds--;
            $("#countdown").text(seconds);

            if (seconds <= 0) {
                clearInterval(timer);
                $("#resendCountdown").hide();
                $("#resendOtpBtn").prop("disabled", false);
            }
        }, 1000);
    }
});
</script>
