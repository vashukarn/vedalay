@extends('layouts.front')
@section('page_title', 'Home')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <!-- header -->
    {{-- <header class="header-bg" style="background-image: url({{ asset('uploads/sliders/' . @$sliders->image) }});">
        <div class="container-fluid">
            <div class="banner-img">
                
            </div>
            <div class="header-inner">
                <div class="header-content" style="color:#000;">
                    <h1 style="color:#000;">{{ @$sliders->sub_title }}
                        <h1>
                            <p>{!! @$sliders->description !!} </p>
                            <ul class="section-button">
                                <li>
                                    <a href="{{ '/register' }}" class="btn1 orange-gradient btn-with-image">
                                        <i class="flaticon-login"></i>
                                        <i class="flaticon-login"></i>
                                        Earn with ShreeVahan
                                    </a>
                                </li>
                                <li>
                                    <a class="btn1 btn-with-image" href="{{ url('/apps') }}">
                                        <i class="flaticon-android-logo"></i>
                                        <i class="flaticon-android-logo"></i>
                                        Download App
                                    </a>
                                </li>
                            </ul>
                </div>
            </div>

        </div>
    </header> --}}

    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach (@$sliders as $key => $value)
             <li data-target="#carouselIndicators" data-slide-to="{{ $key }}" @if($key == 0) class="active" @endif></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach (@$sliders as $key => $slider)
            <div class="carousel-item @if($key ==0) active @endif">
              <a href="{{ @$slider->external_url }}">
              <img class="d-block w-100" src="{{ asset('uploads/sliders/' . @$slider->image) }}" alt="First slide">
              </a>
              <div class=" carousel-caption">
              <h1>{!! @$slider->title !!} </h1>
              <p>{!! @$slider->sub_title !!} </p>
              <ul class="section-button">
                  <li>
                      <a href="{{ '/register' }}" class="btn1 btn-small orange-gradient btn-with-image">
                          <i class="flaticon-login"></i>
                          <i class="flaticon-login"></i>
                          Earn with ShreeVahan
                      </a>
                  </li>
                  <li>
                      <a class="btn1 btn-small btn-with-image" href="{{ url('/apps') }}">
                          <i class="flaticon-android-logo"></i>
                          <i class="flaticon-android-logo"></i>
                          Download App
                      </a>
                  </li>
              </ul>
              </div>
            </div>
            @endforeach
        </div>
        @if(count(@$sliders) > 1)
        <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
        @endif
      </div>
    <div class="header-suuport">
        <div class="container">
            <div class="header-support-group">
                <div class="row">
                    @if (count($testimonials) > 0)
                        <div class="col-sm-12 col-md-6 col-lg order-md-2 order-lg-4">
                            <div class="support-bank">
                                <div class="support-bank-info">
                                    <ul class="review-star">
                                        <li class="full-star"><i class='bx bxs-star'></i></li>
                                        <li class="full-star"><i class='bx bxs-star'></i></li>
                                        <li class="full-star"><i class='bx bxs-star'></i></li>
                                        <li class="full-star"><i class='bx bxs-star'></i></li>
                                        <li class="full-star"><i class='bx bxs-star'></i></li>
                                    </ul>
                                    <p>{!! $testimonials[0]->description !!}
                                    </p>
                                    <div class="support-logo">
                                        <img src="{{ asset('uploads/testimonials/' . $testimonials[0]->image) }}"
                                            alt="logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-6 col-md-6 col-lg order-md-1 order-lg-1">
                        <div class="support-group-item">
                            <div class="support-thumb">
                                <img src="assets/images/envelop.png" alt="support">
                            </div>
                            <div class="support-details">
                                <h3><a href="mailto:{{ @$result['setting']->email }}">{{ @$result['setting']->email }}</a>
                                </h3>
                                <p>Support 24/7</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-12 col-lg order-md-3 order-lg-2">
                        <div class="support-group-item">
                            <div class="support-thumb">
                                <img src="assets/images/phone.png" alt="support">
                            </div>
                            <div class="support-details">
                                <h3>
                                    <a href="tel:{{ @$result['setting']->contact_no[0]['phone_number'] }}">{{ @$result['setting']->contact_no[0]['phone_number'] }}</a>
                                    <a href="tel:{{ @$result['setting']->contact_no[1]['phone_number'] }}">{{ @$result['setting']->contact_no[1]['phone_number'] }}</a>
                                </h3>
                                <p>Free Consultation</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-12 col-lg order-md-4 order-lg-3">
                        <div class="support-group-item">
                            <div class="support-thumb">
                                <img src="assets/images/map.png" alt="support">
                            </div>
                            <div class="support-details">
                                <h3>{{ @$result['setting']->address }}</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- .end header-support -->
    <!-- feature-section -->
    @if (count($features) > 0)
        <section class="feature-section p-tb-100">
            <div class="container">
                <div class="section-title">
                    <h2>Our valuable features</h2>
                    <p>{{ @$result['setting']->front_feature_description }} </p>
                </div>
                <!-- home-feature -->
                <div class="home-feature">
                    <div class=" home-feature-carousel owl-carousel owl-theme">
                        @foreach ($features as $feature)
                            <div class="item">
                                <div class="feature-carousel-content">
                                    <div class="feature-carousel-thumb status-blue">
                                        <img src="{{ asset('uploads/features/' . $feature->icon) }}" alt="feature">
                                    </div>
                                    <div class="feature-carousel-details">
                                        <h3>{{ $feature->short_title }}</h3>
                                        <p>{!! $feature->short_description !!}</p>
                                        <a href="{{ url('/features/' . $feature->slug) }}" class="btn1"><span>Read More
                                                +</span></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- .end feature-section -->
    <!-- home-about-section -->
    @if (count(@$result['information']) > 0)
        <section class="home-about-section bg-off-white pt-100 pb-70">
            <div class="container">
                <div class="home-about-content">
                    @foreach (@$result['information'] as $key => $information)
                    @if($loop->iteration % 2)
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-6 order-2 order-lg-1">
                                <div class="home-about-item home-about-details pb-30">
                                    <h3 class="home-about-title">{{ @$information->title }}</h3>
                                    <p class="home-about-para">{!! @$information->description !!}</p>
                                    <div class="home-about-list">
                                        @if ($information->features)
                                            @foreach ($information->features as $feature)
                                                <div class="home-about-list-item">
                                                    <img src="assets/images/check.png" alt="check">
                                                    {{ @$feature }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="home-about-animation">
                                        <div class="home-animation-item">
                                            <img src="assets/images/curve-line.png" alt="animated-icon">
                                        </div>
                                        <div class="home-animation-item">
                                            <img src="assets/images/triangle.png" alt="animated-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 order-1 order-lg-2">
                                <div class="home-about-item home-about-image pb-30 about-image-ellipsis">
                                    <div class="home-image-content">
                                        <img src="{{ asset('/uploads/informations/' . @$information->image) }}" alt="about"
                                            class="scale-one-zero-one">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="home-about-item home-about-image pb-30 about-image-ellipsis">
                                <div class="home-image-content">
                                    <img src="{{ asset('/uploads/informations/' . @$information->image) }}" alt="about"
                                        class="scale-one-zero-one">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="home-about-item home-about-details pb-30">
                                <h3 class="home-about-title">{{ @$information->title }}</h3>
                                <p class="home-about-para">{!! @$information->description !!}</p>
                                <div class="home-about-list">
                                    @if ($information->features)
                                        @foreach ($information->features as $feature)
                                            <div class="home-about-list-item">
                                                <img src="assets/images/check.png" alt="check">
                                                {{ @$feature }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="home-about-animation">
                                    <div class="home-animation-item">
                                        <img src="assets/images/curve-line.png" alt="animated-icon">
                                    </div>
                                    <div class="home-animation-item">
                                        <img src="assets/images/triangle.png" alt="animated-icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="section-mtb-40"></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- .end home-about-section -->
    <!-- counter-section -->
    <section class="counter-section pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>{{ @$result['setting']->front_counter_description }}</h2>
            </div>
            <!-- counter-content -->
            <div class="counter-content">
                <div class="counter-item">
                    <h3><span class="counter">{{ $result['customer'] }}</span><span class="counter-text-lg">+</span></h3>
                    <p>Customers</p>
                </div>
                <div class="counter-item">
                    <h3><span class="counter">{{ $result['rider'] }}</span><span class="counter-text-sm">+</span></h3>
                    <p>Riders</p>
                    <div class="counter-loader">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="counter-item">
                    <h3><span class="counter">{{ $result['feedback'] }}</span><span class="counter-text-sm">+</span></h3>
                    <p>Feedbacks</p>
                    <div class="counter-loader">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="counter-item">
                    <h3><span class="counter">{{ $result['rides'] }}</span><span class="counter-text-lg">+</span></h3>
                    <p>Successful Rides</p>
                    <div class="counter-loader">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end counter-section -->
    <!-- home-secvice-section -->
    <section class="home-service-section pt-100 pb-70">
        <div class="container">
            <div class="home-service-content">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="home-service-item fluid-height">
                            <div class="home-service-start full-height">
                                <h2>Blogs</h2>
                                <p>{!! $result['blogdescription'] !!}</p>
                                <a href="{{ url('/blogs') }}" class="btn1 blue-gradient btn-with-image">
                                    <i class="flaticon-login"></i>
                                    <i class="flaticon-login"></i>
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach ($result['blogs'] as $blog)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="home-service-item fluid-height">
                                <div class="home-service-details full-height">
                                    <div class="home-service-image">
                                        <img src="{{ asset('/uploads/blogs/' . $blog->featured_img) }}" alt="service">
                                    </div>
                                    <div class="home-service-text">
                                        <h3>{{ $blog->title }}</h3>
                                        <p>{{ $blog->excerpt }}</p>
                                        <a href="{{ url('/blog/' . $blog->slug) }}">Read More +</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- .end home-service-section -->
    <!-- home-facility-section -->
    {{-- doneafter --}}
    {{-- <section class="home-facility-section">
        <div class="home-facility-animation">
            <div class="home-animation-item">
                <img src="assets/images/curve-line.png" alt="animated-icon">
            </div>
            <div class="home-animation-item">
                <img src="assets/images/triangle-light.png" alt="animated-icon">
            </div>
        </div>
        <div class="container-fluid p-0">
            <div class="home-facility-content">
                <div class="row align-items-center m-0">
                    <div class="col-sm-12 col-md-12 col-lg-6 p-0">
                        <div class="home-facility-overview desk-ml-auto pr-20 pl-20">
                            <div class="home-facility-item pb-30">
                                <div class="home-facility-details">
                                    <div class="home-service-start">
                                        <h2>Payment gateway is easy to fill with our system</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod cste et
                                            dolore magnam aliquam quaerat voluptatem.</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim numquam eius modi
                                            tempora incidunt ut labore et dolore magnam </p>
                                        <a href="#" class="btn1 blue-gradient btn-with-image">
                                            <i class="flaticon-login"></i>
                                            <i class="flaticon-login"></i>
                                            Get Started
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 p-0">
                        <div class="home-facility-image pl-20">
                            <div class="home-facility-item pb-30 img-right-res">
                                <img src="assets/images/home-facility-bg.png" alt="facility">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- .end home-facility-section -->
    <!-- home-quick-contact-section -->
    <section class="home-quick-contact-section section-minus-margin">
        <div class="container">
            <div class="home-quick-contact blue-gradient">
                <div class="logo-bg-icon">
                    <div class="logo-bg-item">
                        <img src="assets/images/circle.png" alt="icon">
                    </div>
                    <div class="logo-bg-item">
                        <img src="assets/images/square.png" alt="icon">
                    </div>
                </div>
                <div class="quick-contact-inner">
                    <h2>What’s thinking? <br> don’t worry! get connected us</h2>
                    <p>*We’re willingly is here to answer your question about {{ @$result['setting']->name }}</p>
                    <ul class="section-button">
                        <li>
                            <a href="{{ url('/contact') }}" class="btn1 orange-gradient btn-with-image">
                                <i class="flaticon-agenda"></i>
                                <i class="flaticon-agenda"></i>
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/register') }}" class="btn1 btn-with-image">
                                <i class="flaticon-approval"></i>
                                <i class="flaticon-approval"></i>
                                Free Trial
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- .end home-quick-contact-section -->
    <!-- home-logo-section -->
    <div class="home-logo-section bg-off-white">
        <div class="container">
            <div class="home-logo-content">
                @foreach ($result['cities'] as $city)
                    <div class="home-logo-item">
                        <a href="#"><img src="{{ asset('/uploads/cities/' . $city->thumbnail) }}"
                                alt="available cities"></a>
                        <div class="text-center m-4">{{ $city->name }}</div>
                    </div>
                @endforeach
                {{-- <div class="home-logo-item">
                    <a href="#"><img src="assets/images/logo-2.png" alt="logo"></a>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- .end home-logo-section -->
    <!-- home-client-section -->
    @if (count($testimonials) > 0)
        <section class="home-client-section pt-100 pb-50">
            <div class="container">
                <div class="section-title">
                    <h2>Clients Feedback</h2>
                    <p>{{ @$result['setting']->front_testimonial_description }} </p>
                </div>
                <div class="client-carousel-content">
                    <div class="client-carousel owl-carousel owl-theme">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-5">
                                        <div class="client-carousel-thumb">
                                            <div class="client-carousel-icon">
                                                <div class="carousel-icon-item">
                                                    <img src="assets/images/carousel-sqare.png" alt="icon">
                                                </div>
                                                <div class="carousel-icon-item">
                                                    <img src="assets/images/carousel-curve.png" alt="icon">
                                                </div>
                                                <div class="carousel-icon-item">
                                                    <img src="assets/images/carousel-round.png" alt="icon">
                                                </div>
                                            </div>
                                            <div class="client-carousel-img">
                                                <img src="{{ asset('uploads/testimonials/' . $testimonial->image) }}"
                                                    alt="client">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <div class="client-carousel-caption">
                                            <p class="client-caption-para">{!! $testimonial->description !!}</p>
                                            <h3 class="client-caption-title">{{ $testimonial->title }}</h3>
                                            <h4 class="client-caption-designation">{{ $testimonial->designation }}</h4>
                                        </div>
                                        <div class="client-carousel-control">
                                            <button class="carousel-control-item carousel-control-item-left">
                                                <span><i class="flaticon-right-arrow"></i></span>
                                            </button>
                                            <button class="carousel-control-item carousel-control-item-right">
                                                <span><i class="flaticon-left-arrow"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- .end home-client-section -->
    <!-- home-download-section -->
    @if (@$pagedata->featured_img != null)
        <section class="home-download-section border-top-mob pt-100 pb-70">
            <div class="container">
                <div class="home-download-content">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-6 order-lg-2">
                            <div class="home-download-item pb-30">
                                <div class="home-download-image scale-one-half">
                                    <img src="{{ asset('/uploads/contents/' . @$pagedata->featured_img) }}"
                                        alt=" @if (@$result['setting']->customer_app_url)
                            <li>
                                <a href="{{ $result['setting']->customer_app_url }}" class="orange-gradient">
                                    <img src="assets/images/apple.png" alt="apple">
                                    <img src="assets/images/apple.png" alt="apple">
                                </a>
                            </li>
                        @endif
                        @if (@$result['setting']->driver_app_url)
                            <li>
                                <a href="{{ @$result['setting']->driver_app_url }}" class="blue-gradient">
                                    <img src="assets/images/android.png" alt="android">
                                    <img src="assets/images/android.png" alt="android">
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </section>
    @endif
    <!-- .end home-download-section -->
    <!-- home-contact-section -->
    <section class="home-contact-section overflow-hidden blue-gradient pt-100 pb-80">
        <div class="home-contact-bg-circle">
            <div class="home-contact-circle-item">
                <img src="assets/images/lg-circle-1.png" alt="circle">
            </div>
            <div class="home-contact-circle-item">
                <img src="assets/images/lg-circle-1.png" alt="circle">
            </div>
        </div>
        <div class="container">
            <div class="home-contact-inner">
                <h2>{{ $usercount }} customers! create your account now</h2>
                <p>About Shree Vahan? <a href="{{ url('/about') }}">Learn More</a></p>
                <ul class="section-button">
                    <li>
                        <a href="{{ url('/register') }}" class="btn1 orange-gradient btn-with-image">
                            <i class="flaticon-agenda"></i>
                            <i class="flaticon-agenda"></i>
                            Create Your Account
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>


@endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
