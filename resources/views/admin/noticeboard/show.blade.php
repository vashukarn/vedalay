@extends('layouts.admin')
@section('title', @$noticeboard_info->title.' - Notice')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$noticeboard_info->title }}</h3>
                </div>
                <div class="card-body card-format">
                    <div class="text-center">
                        <img src="{{ @$noticeboard_info->image }}" alt="No Image Available">
                    </div>
                    <div class="m-4 float-right">
                       {{ ReadableDate(@$noticeboard_info->date, 'ymd') }}
                    </div>
                    <div class="col-12 m-4">
                        {!! @$noticeboard_info->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
