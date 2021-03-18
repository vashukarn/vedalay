@extends('layouts.admin')
@section('title', 'Subject List')
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#keyword').select2({
                placeholder: "Search Name or Phone",
                allowClear: true
            });
        });

    </script>
@endpush
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subject List</h3>
                    <div class="card-tools">
                        <a href="{{ route('subject.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', $levels, @request()->keyword, ['id' => 'keyword','class' => 'form-control select2', 'placeholder' =>
                                        'Search Name or Phone']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('subject-create')
                                <a href="{{ route('subject.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add New Subject</a>
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
                                <th>Subject</th>
                                <th>Level</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Publish Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->title }}</td>
                            <td>{{ @$value->get_level->standard }} {{ @$value->get_level->section ?? '' }}</td>
                            <td>
                                <span class="badge badge-success">
                                    {{ @$value->type }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ @$value->value }}
                                </span>
                            </td>
                            <td>
                                <span class="badge @if(@$value->publish_status  == '1')badge-success @elseif(@$value->publish_status  == '2') badge-danger @else badge-warning @endif">
                                    @if(@$value->publish_status  == '1') Active @elseif(@$value->publish_status  == '2') Banned @else Inactive @endif
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                  @can('subject-edit')
                                  <a href="{{route('subject.edit',@$value->id)}}" title="Edit subject" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('subject-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['subject.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this subject?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete subject '])}}
                                  {{ Form::close() }}
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
