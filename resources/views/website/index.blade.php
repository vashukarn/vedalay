@extends('layouts.front')
@section('page_title', 'Home')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="banner-area auto-height text-center text-normal text-light shadow dark-hard bg-fixed"
        style="background-image: url('{{ @$page->landing_image ? $page->landing_image : asset('assets/img/main-back.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="content-box video-popup">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="content">
                            <h1>{{ @$page->landing_title1 ? $page->landing_title1 : 'Get your Free' }}<span>
                                    {{ @$page->landing_title2 ? $page->landing_title2 : 'Demo' }}
                                </span>{{ @$page->landing_title3 ? $page->landing_title3 : 'Right Here' }}</h1>
                            <p>{{ @$page->landing_subtitle ? $page->landing_subtitle : 'Use our School Management Software and be delighted to see powerful functions' }}
                            </p>
                            <a class="btn circle btn-light border btn-md" href="{{ url('/login') }}">Get Started</a>
                            {{-- <a href="https://www.youtube.com/watch?v=owhuBrGIOsE" class="popup-youtube light video-play-button video-inline">
                                <i class="fa fa-play"></i>
                            </a> --}}
                        </div>
                    </div>
                    @if (count($sliders) > 0)
                        <div class="col-md-8 col-md-offset-2">
                            <div class="banner banner-carousel owl-carousel owl-theme">
                                @foreach ($sliders as $item)
                                    <img alt="{{ $item->title }}" src="{{ $item->image }}">
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-md-8 col-md-offset-2">
                            <div class="banner banner-carousel owl-carousel owl-theme">
                                <img alt="School Management Example Slider"
                                    src="{{ asset('assets/img/dashboard/1.png') }}">
                                <img alt="School Management Example Slider"
                                    src="{{ asset('assets/img/dashboard/2.png') }}">
                                <img alt="School Management Example Slider"
                                    src="{{ asset('assets/img/dashboard/3.png') }}">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner -->

    <!-- Start Companies Area 
                        ============================================= -->
    @if (isset($page->customers_logo1) || isset($page->customers_logo2) || isset($page->customers_logo3))
        <div class="companies-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 info">
                        <h3>{{ @$page->customers_title1 }} <span>{{ @$page->customers_title2 }}</span>
                            {{ @$page->customers_title3 }}</h3>
                        <p>{{ @$page->customers_subtitle }}</p>
                    </div>

                    <div class="col-md-6 clients">
                        <div class="clients-items owl-carousel owl-theme text-center">
                            <div class="single-item">
                                <a href="#"><img src="{{ $page->customers_logo1 }}" alt="Clients"></a>
                            </div>
                            <div class="single-item">
                                <a href="#"><img src="{{ $page->customers_logo2 }}" alt="Clients"></a>
                            </div>
                            <div class="single-item">
                                <a href="#"><img src="{{ $page->customers_logo3 }}" alt="Clients"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Companies Area -->

    <!-- Start About 
                        ============================================= -->
    <div id="about" class="about-area bg-gray default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-5 promo-video">
                    <a class="popup-youtube light video-play-button"
                        href="{{ @$page->whyus_link ? $page->whyus_link : '#' }}">
                        <img src="{{ @$page->whyus_image ? $page->whyus_image : asset('assets/img/work/4.png') }}"
                            alt="{{ @$page->whyus_title ? $page->whyus_title : 'Vedalay about us image' }}">
                        <i class="fa fa-play"></i>
                    </a>
                </div>
                <div class="col-md-7 default info">
                    <h4>{{ @$page->whyus_title ? $page->whyus_title : 'Why Choose Us' }}</h4>
                    <h2>{{ @$page->whyus_subtitle ? $page->whyus_subtitle : 'Designed for Schools, Colleges & Universities' }}
                    </h2>
                    <p>{{ @$page->whyus_paragraph ? $page->whyus_paragraph : '' }}</p>
                    <ul>
                        @if (isset($page->whyus_features))
                            @foreach ($page->whyus_features as $item)
                                <li>
                                    <h5>{{ $item['title'] }}</h5>
                                    <span>{{ $item['subtitle'] }}</span>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <h5>Not any usual School Management System</h5>
                                <span>This school management system is blazing fast depending upon the server speed</span>
                            </li>
                            <li>
                                <h5>Powerful Roles</h5>
                                <span>We have diffrent roles and permissions specified according to their job role</span>
                            </li>
                            <li>
                                <h5>Email Integration</h5>
                                <span>Sending emails on fee addition and Fee submission along with details</span>
                            </li>
                        @endif
                    </ul>
                    <a href="{{ url('/login') }}" class="btn circle btn-theme effect btn-md">Know more</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End About -->

    <!-- Start Features 
                        ============================================= -->
    <div id="features" class="features-area cell-items default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2><span>{{ @$page->features_title ? $page->features_title : 'Our Features' }}</span></h2>
                        <h4>{{ @$page->features_subtitle ? $page->features_subtitle : 'Check our latest features' }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="features-items icon-solid">
                    <div class="col-md-7">
                        <div class="items-box inc-cell">

                            @if (count($features) > 0)
                                @foreach ($features as $item)
                                    <div class="col-md-6 col-sm-6 equal-height">
                                        <div class="item">
                                            <div class="icon">
                                                <img height="70px" src="{{ $item->icon }}" alt="{{ $item->title }}">
                                            </div>
                                            <div class="info">
                                                <h4>{{ $item->title }}</h4>
                                                <p>{{ $item->short_title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-6 col-sm-6 equal-height">
                                    <div class="item">
                                        <div class="icon">
                                            <i class="flaticon-television"></i>
                                        </div>
                                        <div class="info">
                                            <h4>Monitoring</h4>
                                            <p>
                                                Esteem garden men yet shy course. Consulted up my tolerably
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 equal-height">
                                    <div class="item">
                                        <div class="icon">
                                            <i class="flaticon-customer-service"></i>
                                        </div>
                                        <div class="info">
                                            <h4>Support Chat</h4>
                                            <p>
                                                Affronting everything discretion men now own did. Still round
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 equal-height">
                                    <div class="item">
                                        <div class="icon">
                                            <i class="flaticon-analysis"></i>
                                        </div>
                                        <div class="info">
                                            <h4>System Analysis</h4>
                                            <p>
                                                Delighted prevailed supported remainder perpetual who
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 equal-height">
                                    <div class="item">
                                        <div class="icon">
                                            <i class="flaticon-speedometer"></i>
                                        </div>
                                        <div class="info">
                                            <h4>First Run</h4>
                                            <p>Delighted prevailed supported remainder perpetual who
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="thumb">
                            <img src="{{ @$page->features_image ? $page->features_image : asset('assets/img/illustrations/2.svg') }}"
                                alt="{{ @$page->whyus_title }} Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Features -->

    <!-- Start Fun Factor 
                        ============================================= -->
    <div class="fun-factor-area shadow dark bg-fixed text-light default-padding"
        style="background-image: url('{{ @$page->newsletter_image ? $page->newsletter_image : asset('assets/img/banner/7.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-8 fun-fact-items">
                    <div class="row">
                        @if (isset($page->newsletter_counters))
                            @foreach ($page->newsletter_counters as $item)
                                <div class="col-md-4 col-sm-4 item">
                                    <div class="fun-fact">
                                        <div class="timer" data-to="{{ $item['number'] }}" data-speed="5000"></div>
                                        <span class="medium">{{ $item['title'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        @endif
                    </div>
                </div>
                <div class="col-md-4 subscribe">
                    <h3>{{ @$page->newsletter_title ? $page->newsletter_title : 'Stay Updated with Us' }}</h3>
                    <p>{{ @$page->newsletter_subtitle }}</p>
                    {{ Form::open(['method' => 'POST', 'route' => ['newsletter.store']]) }}
                    <div class="input-group stylish-input-group">
                        <input type="email" placeholder="Enter your E-mail here" class="form-control" name="email">
                        <span class="input-group-addon">
                            {{ Form::button('<i class="fas fa-paper-plane"></i>', ['class' => 'btn btn-success btn-sm btn-flat', 'type' => 'submit', 'title' => 'Submit Newsletter']) }}
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!-- End Fun Factor -->

    <!-- Start Overview 
                        ============================================= -->
    @if (isset($page))
        <div id="overview" class="work-list-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><span>{{ @$page->work_title ? $page->work_title : 'How We Work' }}</span></h2>
                            <h4>{{ @$page->work_subtitle ? $page->work_subtitle : 'Checkout Our Amazing Working Process' }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 overview-items">
                        <!-- Tab Nav -->
                        <div class="tab-navigation text-center">
                            <ul class="nav nav-pills">
                                @foreach ($page->work_detail as $key => $item)
                                    <li class=" {{ $key == 1 ? 'active' : '' }}">
                                        <a data-toggle="tab" href="#tab{{ $key }}" aria-expanded="true">
                                            {{ $item['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Tab Nav -->
                        <!-- Start Tab Content -->
                        <div class="row">
                            <div class="tab-content">

                                <!-- Start Single Item -->

                                @foreach ($page->work_detail as $key => $item)
                                    <div id="tab{{ $key }}" class="tab-pane fade active in">
                                        <div class="col-md-6 thumb">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                        </div>
                                        <div class="col-md-6 info">
                                            <h3>{{ $item['subtitle'] }}</h3>
                                            <p>{{ $item['description'] }}</p>
                                            <ul>
                                                @foreach ($item['bullet'] as $single)
                                                    <li>
                                                        <h4>{{ $single['title'] }}</h4>
                                                        {{ $single['subtitle'] }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- End Single Item -->

                            </div>
                        </div>
                        <!-- End Tab Content -->
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Overview -->

    <!-- Start Pricing Area
                        ============================================= -->
    {{-- <div id="pricing" class="pricing-area bg-gray default-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2>Pricing <span>Plan</span></h2>
                        <h4>List of our pricing packages</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="pricing pricing-simple text-center">
                    <div class="col-md-4">
                        <div class="pricing-item">
                            <ul>
                                <li class="icon">
                                    <i class="flaticon-start"></i>
                                </li>
                                <li class="pricing-header">
                                    <h4>Trial Version</h4>
                                    <h2>Free</h2>
                                </li>
                                <li>Demo file <span data-toggle="tooltip" data-placement="top" title="Available on pro version"><i class="fas fa-info-circle"></i></span></li>
                                <li>Update</li>
                                <li>File compressed</li>
                                <li>Commercial use</li>
                                <li>Support <span data-toggle="tooltip" data-placement="top" title="Available on pro version"><i class="fas fa-info-circle"></i></span></li>
                                <li>2 database</li>
                                <li>Documetation <span data-toggle="tooltip" data-placement="top" title="Available on pro version"><i class="fas fa-info-circle"></i></span></li>
                                <li class="footer">
                                    <a class="btn btn-dark border btn-sm" href="#">Try for free</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pricing-item active">
                            <ul>
                                <li class="icon">
                                    <i class="flaticon-quality-badge"></i>
                                </li>
                                <li class="pricing-header">
                                    <h4>Regular</h4>
                                    <h2><sup>$</sup>29 <sub>/ Year</sub></h2>
                                </li>
                                <li>Demo file</li>
                                <li>Update <span data-toggle="tooltip" data-placement="top" title="Only for extended licence"><i class="fas fa-info-circle"></i></span></li>
                                <li>File compressed</li>
                                <li>Commercial use</li>
                                <li>Support <span data-toggle="tooltip" data-placement="top" title="Only for extended licence"><i class="fas fa-info-circle"></i></span></li>
                                <li>5 database</li>
                                <li>Documetation</li>
                                <li class="footer">
                                    <a class="btn btn-theme effect btn-sm" href="#">Get Started</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pricing-item">
                            <ul>
                                <li class="icon">
                                    <i class="flaticon-value"></i>
                                </li>
                                <li class="pricing-header">
                                    <h4>Extended</h4>
                                    <h2><sup>$</sup>59 <sub>/ Year</sub></h2>
                                </li>
                                <li>Demo file</li>
                                <li>Update</li>
                                <li>File compressed</li>
                                <li>Commercial use</li>
                                <li>Support</li>
                                <li>8 database</li>
                                <li>Documetation</li>
                                <li class="footer">
                                    <a class="btn btn-dark border btn-sm" href="#">Get Started</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Pricing Area -->

    @if (count($team) > 0)

        <div id="team" class="team-area default-padding bottom-less">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><span>{{ @$page->team_title ? $page->team_title : 'Our Team' }}</span></h2>
                            <h4>{{ @$page->team_subtitle ? $page->team_subtitle : 'Meet our innovative team members' }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="team-items">
                        @foreach ($team as $item)

                            <div class="col-md-3 single-item">
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }} Image">
                                        <div class="overlay">
                                            <h4>{{ $item->title }}</h4>
                                            <p>{{ $item->description }}</p>
                                            <div class="social">
                                                <ul>
                                                    @isset($item->website_link)
                                                        <li>
                                                            <a href="{{ $item->website_link }}"><i
                                                                    class="fab fa-superpowers"></i></a>
                                                        </li>
                                                    @endisset
                                                    @isset($item->github_link)
                                                        <li>
                                                            <a href="{{ $item->github_link }}"><i
                                                                    class="fab fa-github"></i></a>
                                                        </li>
                                                    @endisset
                                                    @isset($item->facebook_link)
                                                        <li>
                                                            <a href="{{ $item->facebook_link }}"><i
                                                                    class="fab fa-facebook"></i></a>
                                                        </li>
                                                    @endisset
                                                    @isset($item->instagram_link)
                                                        <li>
                                                            <a href="{{ $item->instagram_link }}"><i
                                                                    class="fab fa-instagram"></i></a>
                                                        </li>
                                                    @endisset
                                                    @isset($item->linkedin_link)
                                                        <li>
                                                            <a href="{{ $item->linkedin_link }}"><i
                                                                    class="fab fa-linkedin"></i></a>
                                                        </li>
                                                    @endisset
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info">
                                        <span class="message">
                                            <a href="mailto:{{ $item->email }}"><i class="fas fa-envelope-open"></i></a>
                                        </span>
                                        <h4>{{ $item->name }}</h4>
                                        <span>{{ $item->designation }}</span>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @else
        <div id="team" class="team-area default-padding bottom-less">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><span>{{ @$page->team_title ? $page->team_title : 'Our Team' }}</span></h2>
                            <h4>{{ @$page->team_subtitle ? $page->team_subtitle : 'Meet our innovative team members' }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="team-items">
                        <div class="col-md-3 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/img/team/7.jpg" alt="Thumb">
                                    <div class="overlay">
                                        <h4>I love my Studio</h4>
                                        <p>
                                            Jointure goodness interest debating did outweigh. Is time from them full my gone
                                            in
                                            went Of no introduced
                                        </p>
                                        <div class="social">
                                            <ul>
                                                <li class="twitter">
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                <li class="pinterest">
                                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                                </li>
                                                <li class="instagram">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                <li class="vimeo">
                                                    <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="message">
                                        <a href="#"><i class="fas fa-envelope-open"></i></a>
                                    </span>
                                    <h4>Ahmed Kamal</h4>
                                    <span>Chairman of Softing</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/img/team/9.jpg" alt="Thumb">
                                    <div class="overlay">
                                        <h4>Connecting People</h4>
                                        <p>
                                            Jointure goodness interest debating did outweigh. Is time from them full my gone
                                            in
                                            went Of no introduced
                                        </p>
                                        <div class="social">
                                            <ul>
                                                <li class="twitter">
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                <li class="pinterest">
                                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                                </li>
                                                <li class="instagram">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                <li class="vimeo">
                                                    <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="message">
                                        <a href="#"><i class="fas fa-envelope-open"></i></a>
                                    </span>
                                    <h4>Drunal Park</h4>
                                    <span>Manager of Softing</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/img/team/8.jpg" alt="Thumb">
                                    <div class="overlay">
                                        <h4>Network Builder</h4>
                                        <p>
                                            Jointure goodness interest debating did outweigh. Is time from them full my gone
                                            in
                                            went Of no introduced
                                        </p>
                                        <div class="social">
                                            <ul>
                                                <li class="twitter">
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                <li class="pinterest">
                                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                                </li>
                                                <li class="instagram">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                <li class="vimeo">
                                                    <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="message">
                                        <a href="#"><i class="fas fa-envelope-open"></i></a>
                                    </span>
                                    <h4>Munia Ankor</h4>
                                    <span>Founder of Softing</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 single-item">
                            <div class="item">
                                <div class="thumb">
                                    <img src="assets/img/team/8.jpg" alt="Thumb">
                                    <div class="overlay">
                                        <h4>Network Builder</h4>
                                        <p>
                                            Jointure goodness interest debating did outweigh. Is time from them full my gone
                                            in
                                            went Of no introduced
                                        </p>
                                        <div class="social">
                                            <ul>
                                                <li class="twitter">
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                <li class="pinterest">
                                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                                </li>
                                                <li class="instagram">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                <li class="vimeo">
                                                    <a href="#"><i class="fab fa-vimeo-v"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="message">
                                        <a href="#"><i class="fas fa-envelope-open"></i></a>
                                    </span>
                                    <h4>Munia Ankor</h4>
                                    <span>Founder of Softing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- End Team -->

    @if (count($testimonials) > 0)
        <div class="testimonials-area bg-gray default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2>{{ @$page->review_title ? $page->review_title : 'Customer Review' }}</span></h2>
                            <h4>{{ @$page->review_subtitle ? $page->review_subtitle : 'What people say about us' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row">
                            <div class="testimonial-items owl-carousel owl-theme">
                                <!-- Single Item -->
                                @foreach ($testimonials as $item)
                                    <div class="testimonial-item">
                                        <div class="thumb col-md-4">
                                            <img src="{{ $item->image }}" alt="Thumb">
                                        </div>
                                        <div class="info col-md-8">
                                            <div class="content">
                                                <p>{{ $item->description }}</p>
                                                <h4>{{ $item->name }}</h4>
                                                <span>{{ $item->designation }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Testimonials -->
    @endif

    @if(count($faqs) > 0)
        <div class="faq-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><span>{{ @$page->faq_title ? $page->faq_title : 'FAQs' }}</span></h2>
                            <h4>{{ @$page->faq_subtitle ? $page->faq_subtitle : 'General questions in your mind' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Star Video Faq -->
                    <div class="col-md-6 video-faq">
                        <div class="video">
                            <img src="{{ @$page->faq_image ? $page->faq_image : asset('assets/img/about/1.jpg') }}"
                                alt="Thumb">
                            @isset($page->faq_link)
                                <a class="popup-youtube light video-play-button" href="{{ @$page->faq_link }}">
                                    <i class="fa fa-play"></i>
                                </a>
                                <h4>Answer with video</h4>
                            @endisset
                        </div>
                    </div>
                    <!-- End Video Faq -->

                    <!-- Star Accordion Items -->
                    <div class="col-md-6 faq-items">
                        <div class="acd-items acd-arrow">
                            <div class="panel-group symb" id="accordion">

                                @foreach ($faqs as $key => $item)

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                    href="#ac{{ $key }}">
                                                    <span>{{ $key + 1 }}</span> {{ $item->title }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="ac{{ $key }}"
                                            class="panel-collapse collapse {{ $key == 0 ? 'in' : '' }}">
                                            <div class="panel-body">
                                                <p>{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Accordion -->
                    </div>
                </div>
            </div>
        </div>

    @endif

    @if (count($blogs) > 0)
        <div id="blog" class="blog-area bg-gray default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="site-heading text-center">
                            <h2><span>{{ @$page->blog_title ? $page->blog_title : 'Latest Blog' }}</span></h2>
                            <h4>{{ @$page->blog_subtitle ? $page->blog_subtitle : 'Have a look at our latest blogs' }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-items blog-carousel owl-carousel owl-theme">
                            @foreach ($blogs as $item)
                                <div class="item">
                                    <div class="thumb">
                                        <a href="/blog/{{ $item->slug }}">
                                            <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <h4>
                                            <a href="/blog/{{ $item->slug }}">{{ $item->title }}</a>
                                        </h4>
                                        <div class="meta">
                                            <ul>
                                                <li><i class="fas fa-feather-alt"></i>{{ $item->creator->name }}</a></li>
                                                <br>
                                                <li><i
                                                        class="fas fa-calendar-alt "></i>{{ @$item->updated_at ? ReadableDate(@$item->updated_at, 'all') : ReadableDate(@$item->created_at, 'all') }}
                                                </li>
                                                <li><i class="fas fa-eye"></i>{{ $item->view_count }}</a></li>
                                            </ul>
                                        </div>
                                        <p>{!! $item->short_description !!}</p>
                                        <div class="read-more">
                                            <a href="/blog/{{ $item->slug }}" class="more-btn">Read More <i
                                                    class="fas fa-angle-double-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="signup-area bg-fixed shadow dark text-light default-padding text-center"
        style="background-image: url('{{ @$page->parallax_image ? $page->parallax_image : asset('assets/img/banner/4.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h3>{{ @$page->parallax_title ? $page->parallax_title : 'Try Today!' }}</h3>
                    <p>{{ @$page->parallax_subtitle ?? '' }}</p>
                    <a href="{{ url('/login') }}" class="btn circle btn-light effect btn-md">Demo</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Signup -->

    <!-- Start Contact Area  
                        ============================================= -->
    <div id="contact" class="contact-us-area default-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-center">
                        <h2><span>{{ @$page->contact_title ? $page->contact_title : 'Contact Us' }}</span></h2>
                        <h4>{{ @$page->contact_subtitle ? $page->contact_subtitle : 'Any Questions?' }}</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 contact-form">
                    <h2>{{ @$page->contact_form_title ? $page->contact_form_title : "Let's talk about your questions" }}</h2>
                    <form action="{{ url('/contact-form') }}" method="POST" class="contact-form">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input class="form-control" id="name" name="name" placeholder="Name" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="email" name="email" placeholder="Email*" type="email">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="phone" name="phone" placeholder="Phone" type="text">
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group message">
                                    <textarea class="form-control" id="comments" name="comments"
                                        placeholder="Tell Us About Faced Issue *"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <button type="submit" name="submit" id="submit">
                                    Send Message <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Alert Message -->
                        <div class="mt-4 col-md-12 alert-notification">
                            <div id="message" class="alert-msg"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 address">
                    <div class="address-items">
                        <ul class="info">
                            <li>
                                <h4>Office Location</h4>
                                <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
                                <span>{{ @$sitesetting->address[0] ?? 'Agra, India' }}<br>{{ @$sitesetting->address[1] }}</span>
                            </li>
                            <li>
                                <h4>Phone</h4>
                                <div class="icon"><i class="fas fa-phone"></i></div>
                                <span><a
                                        href="tel:+91{{ @$sitesetting->phone[0]['phone_number'] ?? '8630544683' }}">{{ @$sitesetting->phone[0]['phone_number'] ?? '8630544683' }}</a><br>
                                    <a
                                        href="tel:+91{{ @$sitesetting->phone[1]['phone_number'] ?? '7070675425' }}">{{ @$sitesetting->phone[1]['phone_number'] ?? '7070675425' }}</a></span>
                            </li>
                            <li>
                                <h4>Email</h4>
                                <div class="icon"><i class="fas fa-envelope-open"></i> </div>
                                <span><a
                                        href="mailto:{{ @$sitesetting->email[0] ?? 'jaykarvashu@gmail.com' }}">{{ @$sitesetting->email[0] ?? 'jaykarvashu@gmail.com' }}</a>
                                    <br><a
                                        href="mailto:{{ @$sitesetting->email[1] }}">{{ @$sitesetting->email[1] }}</a></span>
                            </li>
                        </ul>
                        <h4>Social Address</h4>
                        <ul class="social">
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
            </div>
        </div>
    </div>
    <!-- End Contact -->

    <!-- Start Google Maps 
                        ============================================= -->
    <div class="maps-area">
        <div class="container-full">
            <div class="row">
                <div class="google-maps">
                    <iframe src="{{ @$page->map_link ? $page->map_link : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113579.78745688336!2d77.90997258886208!3d27.176157105990693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39740d857c2f41d9%3A0x784aef38a9523b42!2sAgra%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1614676392697!5m2!1sen!2sin' }}"
                         width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
