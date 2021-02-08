@extends('layouts.front')
@section('page_title', 'Privacy Policy')
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
                        <h1>Privacy Policy</h1>
                        <ul class="page-breadcrumbs">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Privacy Policy</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <section class="terms-page-section p-tb-100">
            <div class="container">
                <div class="terms-privacy">
                    <h3 class="sub-section-title">Our Privacy Policy</h3>
                    <ul class="terms-privacy-list">
                        <li>
                            <p>{!! @$pagedata->description !!}</p>
                        </li>
                    </ul>
                    <h3 class="sub-section-title">Additional Policy</h3>
                    <p>{!! @$pagedata->short_description !!}</p>

                </div>
            </div>
        </section>
        <!-- .end page-area-section -->
        <!-- .end page-area-section -->

@endsection
@push('scripts')
{{-- scripts here --}}
@endpush