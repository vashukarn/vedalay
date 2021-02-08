@extends('layouts.front')
@section('page_title', 'Download our app')
    @push('styles')
    <style>
        .app-download-img img{
            object-fit: cover;
        }
        .section-title {
            margin-top:150px;
        }
    </style>
    @endpush
@section('meta')
    @include('website.shared.meta')
@endsection
@section('content')


<section class="shreevahan" style="margin-top:150px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center" style="padding:0px 0px 30px;">
                    <h2 class="mb60">Download The Shreevahan App</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="app-download-box">
                    <div class="app-download-img">
                        <img width="100%" height="100%" src="{{asset('/uploads/settings/'.@$setting->customer_app_image)}}" title="download_user">                    </div>
                    <div class="app-download-info" style="text-align: center;padding:10px 0px 20px;">
                        <h5>User App</h5>
                        <ul>
                            <li><a href="{{ @$setting->customer_app_url }}" target="_blank"><img src="{{ asset('/assets/playstore.png') }}" height="80px" alt="google play store"></a></li>
                        </ul>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-md-6">
                <div class="app-download-box">
                    <div class="app-download-img">
                        <img width="100%" height="100%" src="{{asset('/uploads/settings/'.@$setting->driver_app_image)}}" title="download-rider">                    </div>
                    <div class="app-download-info" style="text-align:center;padding:10px 0px 20px;">
                        <h5>Driver App</h5>
                        <ul>
                            <li><a href="{{ @$setting->driver_app_url }}" target="_blank"><img src="{{ asset('/assets/playstore.png') }}" height="80px"  alt="google play store"></a></li>
                        </ul>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')

@endpush