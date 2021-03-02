@extends('layouts.front')
@section('page_title', 'Home')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')
    <div class="breadcrumb-area shadow dark bg-fixed text-center padding-xl text-light"
        style="background-image: url('{{ $blog->image ?? asset('assets/img/banner/7.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $blog->title }}</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/blogs') }}">Blogs</a></li>
                        <li class="active">{{ $blog->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="blog" class="blog-area bg-gray full-width single default-padding">
        <div class="container">
            <div class="row">
                <div class="blog-items">
                    <div class="col-md-12">
                        <div class="item">
                            @isset($blog->image)
                                <div class="thumb">
                                    <a href="{{ $blog->external_url }}">
                                        <img src="{{ $blog->image }}" alt="{{ $blog->title }} Blog">
                                    </a>
                                </div>
                            @endisset
                            <div class="info">
                                <h3>{{ $blog->title }}</h3>
                                <div class="meta">
                                    <ul>
                                        <li><i class="fas fa-feather-alt"></i>{{ $blog->creator->name }}</a></li>
                                        <br>
                                        <li><i
                                                class="fas fa-calendar-alt "></i>{{ @$blog->updated_at ? ReadableDate(@$blog->updated_at, 'all') : ReadableDate(@$blog->created_at, 'all') }}
                                        </li>
                                        <li><i class="fas fa-eye"></i>{{ $blog->view_count }}</a></li>
                                    </ul>
                                </div>
                                <blockquote>
                                    {!! $blog->short_description !!}
                                </blockquote>
                                <p>
                                    {!! $blog->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
