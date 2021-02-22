@extends('layouts.admin')
@section('title', 'Vacancy List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vacancy List</h3>
                    <div class="card-tools">
                        <a href="{{ route('vacancy.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('vacancy-create')
                                <a href="{{ route('vacancy.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add New Vacancy</a>
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
                                <th>Job Role</th>
                                <th>Requirement</th>
                                <th>Salary</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Publish Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->job_role }}</td>
                            <td>{{ @$value->required_no }}</td>
                            <td>{{ @$value->salary }}</td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ @$value->creator->name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    {{ @$value->updator->name }}
                                </span>
                            </td>
                            <td>
                                <span class="badge @if(@$value->publish_status  == '1')badge-success @elseif(@$value->publish_status  == '2') badge-danger @else badge-warning @endif">
                                    @if(@$value->publish_status  == '1') Active @elseif(@$value->publish_status  == '2') Banned @else Inactive @endif
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                  @can('vacancy-edit')
                                  <a href="{{route('vacancy.edit',@$value->id)}}" title="Edit vacancy" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('vacancy-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['vacancy.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this vacancy?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete vacancy '])}}
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
