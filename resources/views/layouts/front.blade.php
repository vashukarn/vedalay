<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Nectar Digit">
    <meta property="og:site_name" content="{{ __(env('APP_NAME', 'Shree Vahan')) }}">
    @yield('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <title>
    @if (@$sitesetting->name) {{ @$sitesetting->name }} @else
            {{ __(env('APP_NAME', 'Shree Vahan')) }} @endif | @yield('page_title')
    </title>
    <link rel="icon" href="{{ asset('/uploads/settings/' . @$sitesetting->favicon) }}" type="image/png" sizes="16x16">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css" media="all" />
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" type="text/css" media="all" />
    <!-- owl carousel css -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" type="text/css" media="all" />
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}" type="text/css" media="all" />
    <!-- magnific popup css -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}" type="text/css" media="all" />
    <!-- boxicons css -->
    <link rel='stylesheet' href='{{ asset('assets/css/boxicons.min.css') }}' type="text/css" media="all" />
    <!-- Line Awesome CSS -->
    <link rel='stylesheet' href='{{ asset('assets/css/line-awesome.min.css') }}' type="text/css" media="all" />
    <!-- flaticon css -->
    <link rel='stylesheet' href='{{ asset('assets/css/flaticon.css') }}' type="text/css" media="all" />
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css" media="all" />
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" type="text/css" media="all" />
    {{-- <link rel="stylesheet" href="{{ asset("/css/main.css") }}" type="text/css" media="all" /> --}}
    @stack('styles')

</head>

<body class="overflow-x-hidden">
    <!-- Use overflow-x-hidden class if you use same slider as feature slider -->
    <!-- preloader -->
    {{-- <div class="preloader orange-gradient">
        <div class="preloader-wrapper">
            <div class="preloader-grid">
                <div class="preloader-grid-item preloader-grid-item-1"></div>
                <div class="preloader-grid-item preloader-grid-item-2"></div>
                <div class="preloader-grid-item preloader-grid-item-3"></div>
                <div class="preloader-grid-item preloader-grid-item-4"></div>
                <div class="preloader-grid-item preloader-grid-item-5"></div>
                <div class="preloader-grid-item preloader-grid-item-6"></div>
                <div class="preloader-grid-item preloader-grid-item-7"></div>
                <div class="preloader-grid-item preloader-grid-item-8"></div>
                <div class="preloader-grid-item preloader-grid-item-9"></div>
            </div>
        </div>
    </div> --}}
    <!-- .end preloader -->
    <!-- navbar -->

    <div class="fixed-top">
        <div class="navbar-area">
            <!-- mobile menu -->
            <div class="mobile-nav">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('/uploads/settings/' . @$sitesetting->logo) }}" alt="logo">
                </a>
            </div>
            <!-- desktop menu -->
            <div class="main-nav">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('/uploads/settings/' . @$sitesetting->logo) }}" alt="logo">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}"
                                        class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                                </li>
                                @if(isset($menus) && $menus->count())
                                @foreach ($menus as $menu)
                                    @if ($menu->external_url == null)
                                        <li class="nav-item">
                                            <a href="{{ url($menu->slug) }}" class="nav-link @if (count($menu->child_menu) > 0) dropdown-toggle @endif
                                                {{ request()->is($menu->slug) ? 'active' : '' }}">{{ $menu->title }}</a>
                                            @if ($menu->child_menu != null)
                                                @foreach ($menu->child_menu as $submenu)
                                                    <ul class="dropdown-menu">
                                                        <li class="nav-item">
                                                            <a href="{{ url($submenu->slug) }}"
                                                                class="nav-link">{{ $submenu->title }}</a>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </li>
                                    @else
                                        <li class="nav-item"><a
                                                href="{{ $menu->external_url }}">{{ $menu->title }}</a></li>
                                    @endif
                                @endforeach
                                @endif 
                                {{-- <li class="nav-item">
                                    <a href="#" class="nav-link dropdown-toggle">Pages</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="faqs.html" class="nav-link">FAQ's</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link dropdown-toggle">Services</a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item">
                                                    <a href="services.html" class="nav-link">Services</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="service-details.html" class="nav-link">Service Details</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a href="terms-conditions.html" class="nav-link">Terms & Conditions</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="privacy-policy.html" class="nav-link">Privacy Policy</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="testimonials.html" class="nav-link">Testimonials</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link dropdown-toggle">User</a>
                                            <ul class="dropdown-menu">
                                                <li class="nav-item">
                                                    <a href="{{ '/register' }}" class="nav-link">Authentication</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="forget-password.html" class="nav-link">Forget Password</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a href="404.html" class="nav-link">404 Error Page</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link dropdown-toggle">Features</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="features.html" class="nav-link">Rider</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="feature-details.html" class="nav-link">Customer</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link dropdown-toggle">Blogs</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a href="blogs.html" class="nav-link">Blogs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="blog-details.html" class="nav-link">Blog Details</a>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </div>
                        <!-- navbar option -->
                        <div class="navbar-option">
                            {{-- <div class="navbar-option-item dropdown">
                                <button class="language-option" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="assets/images/flag.png" alt="flag">
                                    Eng
                                    <i class='bx bx-chevron-down'></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">
                                        <img src="assets/images/flag-1.png" alt="flag">
                                        UK
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img src="assets/images/flag-2.png" alt="flag">
                                        Germany
                                    </a>
                                </div>
                            </div> --}}
                            <div class="navbar-option-item">
                                <a href="{{ '/register' }}" class="btn1 blue-gradient btn-with-image">
                                    <i class="flaticon-login"></i>
                                    <i class="flaticon-login"></i>
                                    Register
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- .end navbar -->

    {{-- {{ page content starts from here  }} --}}
    @yield('content')
    {{-- {{ page content ends here  }} --}}
    <!-- .end home-contact-section -->
    <!-- footer -->
    <footer class="footer-bg">
        <div class="container">
            <div class="footer-upper">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="footer-content-item">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img
                                        src="{{ asset('/uploads/settings/' . @$sitesetting->logo) }}"
                                        alt="{{ @$sitesetting->name }} Company Logo"></a>
                            </div>
                            <div class="footer-details">
                                {{-- <p>Lorem ipsum dolor sit amet, consectetur adiisicing elit, sed do eiusmod tempor inc
                                    Neque porro quisquam est qui dolorem aliquam quaerat luptatem. sed do eiusmod tempor
                                    inc </p> --}}
                            </div>
                        </div>
                    </div>
                    @if ( isset($footer_menu) && (count($footer_menu) > 0))
                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <div class="footer-content-list footer-content-item">
                                <div class="footer-content-title">
                                    <h3>Company</h3>
                                </div>
                                <ul class="footer-details footer-list">
                                    @foreach ($footer_menu as $key => $menu)
                                        <li><a href="{{ url($menu) }}">{{ $key }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-6 col-md-4 ">
                        <div class="footer-content-list footer-content-item">
                            <div class="footer-content-title">
                                <h3>Menu</h3>
                            </div>
                            <ul class="footer-details footer-list">
                                @foreach ($menus as $menu)
                                    @if ($menu->external_url != null)
                                        <li><a href="{{ $menu->external_url }}">{{ $menu->title }}</a></li>
                                    @else
                                        <li><a href="{{ url($menu->slug) }}">{{ $menu->title }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4">
                        <div class="footer-content-list footer-content-item">
                            <div class="footer-content-title">
                                <h3>Address</h3>
                            </div>
                            <ul class="footer-details footer-list">
                                <li>Address: <span>{{ @$sitesetting->address }}</span></li>
                                <li>Email: <span><a
                                            href="mailto:{{ @$sitesetting->email }}">{{ @$sitesetting->email }}</a></span>
                                </li>
                                <li>Phone: <span><a
                                            href="tel:{{ @$sitesetting->contact_no[0]['phone_number'] }}">{{ @$sitesetting->contact_no[0]['phone_number'] }}</a></span>
                                    / <span><a
                                            href="tel:{{ @$sitesetting->contact_no[1]['phone_number'] }}">{{ @$sitesetting->contact_no[1]['phone_number'] }}</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-lower">
                <div class="footer-lower-item footer-copyright-text">
                    <p>Copyright ©2021 Design & Developed by <a href="https://www.nectardigit.com/"
                            target="_blank">Nectar Digit</a></p>
                </div>
                <div class="footer-lower-item footer-social-logo">
                    <ul class="footer-social-list">
                        <li class="social-btn social-btn-fb"><a href="{{ @$sitesetting->facebook }}"><i
                                    class='bx bxl-facebook'></i></a></li>
                        <li class="social-btn social-btn-tw"><a href="{{ @$sitesetting->twitter }}"><i
                                    class='bx bxl-twitter'></i></a></li>
                        {{-- <li class="social-btn social-btn-ins"><a href="#"><i class='bx bxl-instagram'></i></a></li> --}}
                        {{-- <li class="social-btn social-btn-pin"><a href="#"><i class='bx bxl-pinterest-alt'></i></a></li> --}}
                        <li class="social-btn social-btn-yt"><a href="{{ @$sitesetting->youtube }}"><i
                                    class='bx bxl-youtube'></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    {{-- <script src="{{ asset("/js/main.js") }}"></script> --}}

    {{-- Contact Form Submission --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"
        integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ=="
        crossorigin="anonymous"></script>


    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- magnific popup js -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- form ajazchimp js -->
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <!-- form validator js  -->
    <script src="{{ asset('assets/js/form-validator.min.js') }}"></script>
    <!-- contact form js -->
    <script src="{{ asset('assets/js/contact-form-script.js') }}"></script>
    <!-- meanmenu js -->
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <!-- waypoints js -->
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <!-- counter js -->
    <script src="{{ asset('assets/js/counter-up.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('scripts')

</body>

</html>
