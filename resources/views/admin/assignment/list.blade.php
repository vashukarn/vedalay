@extends('layouts.admin')
@section('title','Assignment List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assignment List</h3>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Deadline</th>
                                <th>References</th>
                                @role('Student')
                                <th>Description</th>
                                @else
                                <th>Added By</th>
                                <th>Adding Date</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            <td>{{ @$subject[$value->subject_id] }}</td>
                            <td>{{ ReadableDate(@$value->deadline, 'ymd') }}</td>
                            <td>
                                @isset($value->references)
                                @foreach ($value->references as $key => $item)
                                    {{ $key }}. &nbsp; <a href="{{ $item }}">{{ $item }}</a><br>
                                @endforeach
                                @endisset
                            </td>
                            @role('Student')
                            <td>{!! @$value->description !!}</td>
                            @else
                            <td>{{ @$value->creator->name }}</td>
                            <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
                            @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                  Showing <strong>{{ $data->firstItem() }}</strong>  to <strong>{{ $data->lastItem() }} </strong>  of <strong> {{$data->total()}}</strong> entries
                                  <span> | Takes <b>{{ round((microtime(true) - LARAVEL_START),2) }}</b> seconds to render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{$data->links()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
