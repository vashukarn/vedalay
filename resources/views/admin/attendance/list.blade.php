@extends('layouts.admin')
@section('title','Attendance List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance List</h3>
                    <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Subject</th>
                                <th>Present Students</th>
                                <th>Absent Students</th>
                                <th>Total Students</th>
                                <th>Added By</th>
                                <th>Adding Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$subject[$value->subject_id] }}</td>
                            <td>
                                @foreach ($value->students as $key => $item)
                                    @if($item == '1')
                                    - {{ $students[$key] }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($value->students as $key => $item)
                                    @if($item == '0')
                                    - {{ @$students[$key] }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ count(@$value->students) }}</td>
                            <td>{{ @$value->creator->name }}</td>
                            <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
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
