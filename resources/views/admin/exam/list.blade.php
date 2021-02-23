@extends('layouts.admin')
@section('title', 'Exam List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Exam List</h3>
                    <div class="card-tools">
                        <a href="{{ route('exam.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('exam-create')
                                <a href="{{ route('exam.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add Exam</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Exam Title</th>
                                <th>Level</th>
                                <th>Session</th>
                                <th>Created By</th>
                                <th>Adding Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            <td>{{ @$value->get_level['standard'] }}{{ @$value->get_level['section'] ? ' - '.@$value->get_level['section'] : '' }}</td>
                            <td>{{ @$value->get_session['title'] }}</td>
                            <td>{{ @$value->creator->name }}</td>
                            <td>{{ ReadableDate(@$value->created_at, 'all') }}</td>
                            <td>{{ $value->publish_status == 0 ? 'Unpublished' : 'Published' }}
                                <div class="btn-group float-right">
                                  @can('staff-edit')
                                  <a href="{{route('publishExam',@$value->id)}}" title="{{ $value->publish_status == 0 ? 'Publish Routine' : 'Unpublish Routine' }}" class="btn {{ $value->publish_status == 0 ? 'btn-success' : 'btn-warning' }} btn-sm btn-flat"><i class="fas {{ $value->publish_status == 0 ? 'fa-eye' : 'fa-eye-slash' }}"></i></a>
                                  @endcan
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
