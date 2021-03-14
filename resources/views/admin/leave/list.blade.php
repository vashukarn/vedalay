@extends('layouts.admin')
@section('title', 'Leave')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave List</h3>
                    <div class="card-tools">
                        <a href="{{ route('leave.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        @if(Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                        <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::text('keyword', @request()->keyword, ['class' => 'form-control', 'placeholder' => 'Search Title']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Leave Subject</th>
                                <th>Requested By</th>
                                <th>Request Time</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Type</th>
                                @if(Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                                <th style="text-align:center;" width="10%">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->title }}</td>
                                <td><a href="@if(@$value->creator->type == 'student'){{ route('student.show', @$studentid[$value->creator->id]) }}
                                    @elseif(@$value->creator->type == 'teacher'){{ route('teacher.show', @$teacherid[$value->creator->id]) }}
                                    @elseif(@$value->creator->type == 'staff'){{ route('staff.show', @$staffid[$value->creator->id]) }}
                                    @else#
                                    @endif">{{ @$value->creator->name }}</a></td>
                                    <td>From : {{ ReadableDate(@$value->from_date, 'ymd') }}
                                        <br>To : {{ ReadableDate(@$value->to_date, 'ymd') }}
                                        <br>Interval : {{ @$value->days }}
                                    </td>
                                    <td>
                                    <span class="badge @if ($value->status == 'PENDING') badge-warning @elseif($value->status=='ACCEPTED')
                                        badge-success @elseif($value->status=='DECLINED') badge-danger @endif">
                                            {{ $value->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @isset($value->image)
                                            <a href="{{ asset(@$value->image) }}">
                                                <img src="{{ asset(@$value->image) }}" alt="{{ @$value->title }}"
                                                    class="img img-thumbail" style="width:60px">
                                            </a>
                                        @else
                                            No Image Uploaded
                                        @endisset
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $value->type }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if(Auth::user()->type == 'superadmin' || Auth::user()->type == 'admin')
                                            @if ($value->status == 'PENDING')
                                                @can('leave-edit')
                                                    {{ Form::open(['method' => 'PUT', 'route' => ['leave.update', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to approve this leave?")']) }}
                                                    <input type="hidden" name="status" value="confirm">
                                                    {{ Form::button('<i class="fas fa-check"></i>', ['class' => 'btn btn-success btn-sm btn-flat', 'type' => 'submit', 'title' => 'Approve Leave']) }}
                                                    {{ Form::close() }}
                                                    {{ Form::open(['method' => 'PUT', 'route' => ['leave.update', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to decline this leave?")']) }}
                                                    <input type="hidden" name="status" value="reject">
                                                    {{ Form::button('<i class="fas fa-ban"></i>', ['class' => 'btn btn-warning btn-sm btn-flat', 'type' => 'submit', 'title' => 'Decline Leave']) }}
                                                    {{ Form::close() }}
                                                @endcan
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="text-sm">
                                    Showing <strong>{{ $data->firstItem() }}</strong> to
                                    <strong>{{ $data->lastItem() }} </strong> of <strong>
                                        {{ $data->total() }}</strong>
                                    entries
                                    <span> | Takes <b>{{ round(microtime(true) - LARAVEL_START, 2) }}</b> seconds to
                                        render</span>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <span class="pagination-sm m-0 float-right">{{ $data->links() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
