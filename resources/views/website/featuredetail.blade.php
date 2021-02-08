@extends('layouts.front')
@section('page_title', 'Feature Detail')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


        <!-- header -->
        <header class="page-title page-bg" style="background-image: url({{ asset('uploads/features/' . @$feature->parallax_image) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>{{ $feature->title }}</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/features/'.$feature->slug) }}">{{ $feature->title }}</a></li>
                            {{-- <li>{{ $feature->title }}</li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- feature-details-section -->
        <section class="feature-details-section pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 order-2 order-lg-1">
                        <div class="blog-details-inner pb-30 pr-40">
                            <div class="article-img">
                                <img src="{{ asset('uploads/features/' . @$feature->feature_image) }}" alt="feature">
                            </div>
                            <div class="blog-details-content">
                                <h2>{{ $feature->title }}</h2>
                                <p>{!! $feature->short_description !!}</p>
                                <p>{!! $feature->full_description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- .end feature-details-section -->
   

@endsection
@push('scripts')
@endpush
