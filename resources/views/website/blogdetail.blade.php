@extends('layouts.front')
@section('page_title',   @$blog->title )
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


        <!-- header -->
        <header class="page-title page-bg" style="background-image: {{ asset('/uploads/blogs/'.@$blog->parallex_img) }});">
            <div class="container">
                <div class="page-title-inner">
                    <div class="section-title">
                        <h1>{{ @$blog->title }}</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>{{ @$blog->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- .end header -->
        <!-- blog-details-section -->
        <section class="blog-details-section p-tb-100">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 order-2 order-lg-1">
                        <div class="blog-details-inner pb-30 pr-40">
                            <div class="article-img">
                                <img src="{{ asset('/uploads/blogs/'.@$blog->featured_img) }}" alt="article">
                            </div>
                            <div class="blog-details-content">
                                <p class="blog-tag-name">{{ @$blog->categories[0]->title }} . {{ @$blog->date }}</p>
                                <h2>{{ @$blog->title }}</h2>
                                <p>{!! @$blog->description !!}</p>
                                <div class="blog-details-tag">
                                    <div class="blog-tag-item">
                                        <h4>Tags:</h4>
                                        <ul class="blog-tag-list">
                                            @foreach ($tags as $tag)
                                            <li><a href="{{ url('/tag/'.$tag->slug) }}">{{ $tag->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="blog-tag-item">
                                        <ul class="blog-tag-social">
                                            <li class="social-btn social-btn-fb"><a href="{{ @$blog->external_url }}"><i class='bx bx-right-top-arrow-circle'></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 order-1 order-lg-2">
                        <div class="blog-sidebar">
                            <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Recent posts</h3>
                                </div>
                                <div class="blog-sidebar-item-details">
                                    @foreach (@$recentblog as $recent)
                                    <div class="blog-recent-item">
                                        <a href="#">
                                            <div class="blog-recent-thumb">
                                                <img src="{{ asset('/uploads/blogs/'.$blog->featured_img) }}" alt="blog">
                                            </div>
                                            <div class="blog-recent-data">
                                                <h4 class="blog-post-date">{{ $recent->date }}</h4>
                                                <h3 class="blog-post-name mt-10">{{ $recent->title }}</h3>
                                                <div class="blog-people-comment-details">
                                                    <p>{!! $recent->description !!}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Categories</h3>
                                </div>
                                <div class="blog-sidebar-item-details blog-category-details">
                                    @foreach ($categories as $category)
                                    <div class="blog-category-item">
                                        <h4 class="blog-category-name"><a href="{{ url('/category/'.$category->slug) }}">{{ $category->title }}</a></h4>
                                        <div class="blog-cateogory-divider"></div>
                                        <h5 class="blog-category-number">{{ count($category->blogs) }}</h5>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="blog-sidebar-item">
                                <div class="blog-sidebar-item-header">
                                    <h3 class="sub-section-title">Tags</h3>
                                </div>
                                <div class="blog-sidebar-item-details blog-sidebar-tag-details">
                                    <ul class="blog-sidebar-tag-list">
                                        @foreach ($tags as $tag)
                                        {{-- {{ dd($tag) }} --}}
                                        <li class="blog-sidebar-tag-lg"><a href="{{ url('/tag/'.$tag->slug) }}">{{ $tag->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- .end blog-details-section -->

@endsection
@push('scripts')
{{-- scripts here --}}
@endpush