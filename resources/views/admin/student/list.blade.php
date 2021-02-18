@extends('layouts.admin')
@section('title', 'Student List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student List</h3>
                    <div class="card-tools">
                        <a href="{{ route('student.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <form action="" class="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', [], @request()->keyword, ['class' => 'form-control select2', 'placeholder' =>
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
                                @can('student-create')
                                <a href="{{ route('student.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add New Student</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered--}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Profile Image</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->get_user->name }}</td>
                            <td>
                                  <img src="{{ $value->image }}" alt="{{ @$value->get_user->name }}" class="img img-thumbail" style="width:60px">    
                                </td>
                            <td>{{ @$value->phone }}</td>
                            <td>{{ @$value->get_user->email }}</td>
                            <td>{{ @$value->current_address }}<br>{{ @$value->permanent_address }}</td>
                            <td>
                                <span class="badge @if(@$value->get_user->publish_status  == '1')badge-success @elseif(@$value->get_user->publish_status  == '2') badge-danger @else badge-warning @endif">
                                    @if(@$value->get_user->publish_status  == '1') Active @elseif(@$value->get_user->publish_status  == '2') Banned @else Inactive @endif
                                </span>
                            </td>

                            <td>
                                <div class="btn-group">
                                  @can('student-edit')
                                  <a href="{{route('student.edit',@$value->id)}}" title="Edit student" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('student-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['student.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this student?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete student '])}}
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
