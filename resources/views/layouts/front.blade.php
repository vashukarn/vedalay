<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    @yield('meta')
    <meta charset="utf-8">
    <meta name="author" content="Vashu Karn">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ========== Page Title ========== -->
    <title>{{ @$sitesetting->name ? @$sitesetting->name : 'Vedyalay School Management' }} | @yield('page_title')</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ $sitesetting ? $sitesetting->favicon : asset('assets/img/favicon.png') }}"
        type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/flaticon-set.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootsnav.css') }}" rel="stylesheet" />
    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800" rel="stylesheet">
    @stack('styles')
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YTTRWDC75W"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-YTTRWDC75W');
    </script>

</head>

<body>
    {{-- <div class="se-pre-con"></div> --}}
    <header id="home">
        <nav class="navbar navbar-default active-border navbar-fixed navbar-transparent white bootsnav">
            <div class="container">
                <div class="attr-nav button theme">
                    <ul>
                        <li>
                            <a href="{{ url('/login') }}">
                                @auth Dashboard @else Login @endauth</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ $sitesetting ? $sitesetting->logo_light : asset('assets/img/logo-light.png') }}"
                            class="logo logo-display" style="height: 50px !important;" alt="Vedyalay">
                        <img src="{{ $sitesetting ? $sitesetting->logo : asset('assets/img/logo.png') }}"
                            class="logo logo-scrolled" style="height: 50px !important;" alt="Vedyalay">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                        <li class="dropdown dropdown-right">
                            <a href="{{ url('/') }}" class="smooth-menu">Home</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#about">About</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#features">Features</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#overview">Overview</a>
                        </li>
                        {{-- <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#pricing">Pricing</a>
                        </li> --}}
                        <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#team">Team</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="{{ request()->is('/') ? '' : url('/') }}#contact">contact</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>

        </nav>
        <!-- End Navigation -->

    </header>
    @yield('content')
    <!-- footer -->

    <!-- Start Footer 
    ============================================= -->
    <footer class="default-padding-top bg-light">
        <div class="container">
            <div class="row">
                <div class="f-items">
                    <div class="col-md-4 col-sm-6 equal-height item">
                        <div class="f-item about">
                            <img src="{{ $sitesetting ? $sitesetting->logo : asset('assets/img/logo.png') }}" style="height: 100px !important;"
                                alt="Company Logo">
                            <p>
                                {{ @$page->footer_company_subtitle ? $page->footer_company_subtitle : 'This is a fully operational ERP websites that contain multi functionality modules of different departments i.e Hostel, Attendance, Result Management etc.' }}
                            </p>
                            <h5>Follow Us</h5>
                            <ul>
                                @if (@$sitesetting->facebook)
                                    <li class="facebook">
                                        <a href="{{ $sitesetting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                @endif
                                @if (@$sitesetting->linkedin)
                                    <li class="twitter">
                                        <a href="{{ @$sitesetting->linkedin }}"><i class="fab fa-linkedin"></i></a>
                                    </li>
                                @endif
                                @if (@$sitesetting->youtube)
                                    <li class="pinterest">
                                        <a href="{{ @$sitesetting->youtube }}"><i class="fab fa-youtube"></i></a>
                                    </li>
                                @endif
                                @if (@$sitesetting->instagram)
                                    <li class="instagram">
                                        <a href="{{ @$sitesetting->instagram }}"><i class="fab fa-instagram"></i></a>
                                    </li>
                                @endif
                                @if (@$sitesetting->twitter)
                                    <li class="twitter">
                                        <a href="{{ @$sitesetting->twitter }}"><i class="fab fa-twitter"></i></a>
                                    </li>
                                @endif
                                @if (@$sitesetting->skype)
                                    <li class="facebook">
                                        <a href="{{ @$sitesetting->skype }}"><i class="fab fa-skype"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-md-2 col-sm-6 equal-height item">
                        <div class="f-item link">
                            <h4>Company</h4>
                            <ul>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#">About us</a>
                                </li>
                                <li>
                                    <a href="#">Compnay History</a>
                                </li>
                                <li>
                                    <a href="#">Features</a>
                                </li>
                                <li>
                                    <a href="#">Blog Page</a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                    @if(count($blogs) > 0)
                    {{-- col-md-2 col-sm-6 equal-height item --}}
                    <div class="col-md-4 col-sm-6 equal-height item">
                        <div class="f-item link">
                            <h4>Blogs</h4>
                            <ul>
                                @foreach ($blogs as $item)
                                    <li>
                                        <a href="/blog/{{ $item->slug }}">{{ $item->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4 col-sm-6 equal-height item">
                        <div class="f-item twitter-widget">
                            <h4>Contact Info</h4>
                            <p>
                                {{ @$page->footer_contact_subtitle ? $page->footer_contact_subtitle : 'For more information please contact us and do follow all our social media account.' }}
                            </p>
                            <div class="address">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-home"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Website:</h5>
                                            <a href="http://vedyalay.com/">
                                                <span>vedyalay.com</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Email:</h5>
                                            <a
                                                href="mailto:{{ @$sitesetting->email[0] ?? 'jaykarvashu@gmail.com' }}"><span>{{ @$sitesetting->email[0] ?? 'jaykarvashu@gmail.com' }}</span></a><br>
                                            <a
                                                href="mailto:{{ @$sitesetting->email[1] }}"><span>{{ @$sitesetting->email[1] }}</span></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="info">
                                            <h5>Phone:</h5>
                                            <a
                                                href="tel:{{ @$sitesetting->phone[0]['phone_number'] ?? '8630544683' }}"><span>{{ @$sitesetting->phone[0]['phone_number'] ?? '8630544683' }}</span></a><br>
                                            <a
                                                href="tel:{{ @$sitesetting->phone[1]['phone_number'] ?? '7070675425' }}"><span>{{ @$sitesetting->phone[1]['phone_number'] ?? '7070675425' }}</span></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <p>&copy; Copyright 2021. All Rights Reserved by <a href="www.vedyalay.com">Vedyalay</a></p>
                        </div>
                        {{-- <div class="col-md-6 text-right link">
                            <ul>
                                <li>
                                    <a href="#">Terms</a>
                                </li>
                                <li>
                                    <a href="#">Privacy</a>
                                </li>
                                <li>
                                    <a href="#">Support</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!-- End Footer -->

    <!-- jQuery Frameworks
    ============================================= -->
    <script src="{{ asset('assets/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/equal-height.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.custom.13711.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/count-to.js') }}"></script>
    <script src="{{ asset('assets/js/bootsnav.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
