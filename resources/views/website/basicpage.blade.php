@extends('layouts.front')
@section('page_title', $pagedata->title )
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
<header class="page-title page-bg" style="background-image: url({{ asset('/uploads/contents/'.@$pagedata->parallex_img) }});">
    <div class="container">
        <div class="page-title-inner">
            <div class="section-title">
                <h1>{{ $pagedata->title }}</h1>
                <ul class="page-breadcrumbs">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>{{ $pagedata->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- feature-details-section -->
<section class="feature-details-section pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 order-2 order-lg-1">
                <div class="blog-details-inner pb-30 pr-40">
                    <div class="article-img">
                        <img src="{{ asset('/uploads/contents/'.@$pagedata->featured_img) }}" alt="feature">
                    </div>
                    <div class="blog-details-content">
                        {!! @$pagedata->short_description !!}
                        {!! @$pagedata->description !!}
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