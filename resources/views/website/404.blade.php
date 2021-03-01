@extends('layouts.front')
@section('page_title', 'Home')
    @push('styles')
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


            <div class="kingster-page-wrapper" id="kingster-page-wrapper">
                <div class="kingster-not-found-wrap" id="kingster-full-no-header-wrap">
                    <div class="kingster-not-found-background"></div>
                    <div class="kingster-not-found-container kingster-container">
                        <div class="kingster-header-transparent-substitute"></div>
                        <div class="kingster-not-found-content kingster-item-pdlr">
                            <h1 class="kingster-not-found-head">404</h1>
                            <h3 class="kingster-not-found-title kingster-content-font">Page Not Found</h3>
                            <div class="kingster-not-found-caption">Sorry, we couldn&#039;t find the page you&#039;re looking for.</div>
                            <form role="search" method="get" class="search-form" action="http://max-themes.net/demos/kingster/kingster/index.html">
                                <input type="text" class="search-field kingster-title-font" placeholder="Type Keywords..." value="" name="s">
                                <div class="kingster-top-search-submit"><i class="fa fa-search"></i></div>
                                <input type="submit" class="search-submit" value="Search">
                            </form>
                            <div class="kingster-not-found-back-to-home"><a href="index.html">Or Back To Homepage</a></div>
                        </div>
                    </div>
                </div>
            </div>


            @endsection
@push('scripts')
    {{-- scripts here --}}
@endpush
