@extends('layouts.front')
@section('page_title', 'About Us')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
{{-- {{ dd($pagedata) }} --}}
        <!-- header -->
        <header class="page-title page-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>About us</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>About us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- page-area-section -->
        <section class="video-section pt-100 pb-70">
            <div class="container">
                <div class="home-facility-content">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-6 order-lg-2">
                            <div class="about-page-item pb-30">
                                <div class="about-img ml-20 overflow-hidden border-radius-5 img-shadow">
                                    <img src="{{ asset('/uploads/contents/'.@$pagedata->featured_img) }}" alt="About Image">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 order-lg-1">
                            <div class="about-page-item pb-30">
                                <div class="home-service-start">
                                    <h2>{{ @$pagedata->title }}</h2>
                                    <p>{!! @$pagedata->short_description !!}</p>
                                    <p>{!! @$pagedata->description !!}</p>
                                    @if(@$pagedata->external_url)
                                    <a class="btn1 orange-gradient btn-with-image video-modal" href="{{ @$pagedata->external_url }}">
                                        More
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- .end page-area-section -->
        <!-- worker-support -->
        <section class="retail-section-bg worker-section">
            <div class="container">
                <div class="home-about-content">
                    <div class="worker-section-shape">
                        <div class="worker-shape-item">
                            <img src="assets/images/worker-vector.png" alt="icon">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- .end worker-section -->
    <!-- home-logo-section -->
    <div class="home-logo-section bg-off-white">
        <div class="container">
            <div class="home-logo-content">
                @foreach ($cities as $city)
                <div class="home-logo-item">
                    <a href="#"><img src="{{ asset('/uploads/cities/'.$city->thumbnail) }}" alt="image"></a>
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

@endsection
@push('scripts')
{{-- scripts here --}}
@endpush