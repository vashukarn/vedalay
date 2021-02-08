@extends('layouts.front')
@section('page_title', 'FAQs')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


        <!-- header -->
        <header class="page-title page-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>FAQ's</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Faq's</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- faq-section -->
        <section class="faq-section pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <h2>What Want To Know?</h2>
                </div>
                <div class="faq-section-content">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-5 pb-30 order-2 order-lg-1">
                            <div class="faq-accordion">
                                <!-- item goes here -->
                                @foreach ($faqs as $faq)
                                <div class="faq-accordion-item"> <!-- Use "faq-accordion-item-active" this class for toggle accordion -->
                                    <div class="faq-accordion-header">
                                        <h3 class="faq-accordion-title">{{ $faq->title }}</h3>
                                        <div class="faq-accordion-header-overlay"></div>
                                    </div>
                                    <div class="faq-accordion-body">
                                        <div class="faq-accordion-body-inner">
                                            <p class="faq-accordion-para">{!! $faq->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 offset-lg-1 pb-30 order-1 order-lg-2">
                            <div class="home-image-content">
                                <img src="assets/images/faq-img.png" alt="facility">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- .end faq-section -->
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
        <!-- .end home-contact-section -->

@endsection
@push('scripts')
{{-- scripts here --}}
@endpush