@extends('layouts.admin')
@section('title', 'App Notice')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">App Notice List</h3>
                    <div class="card-tools">
                        <a href="{{ route('appnotice.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-10">
                            <div class="btn-group">
                                <a href="{{ route('appnotice.index') }}" class="btn btn-primary btn-flat btn-sm">
                                    <i class="fas fa-sync-alt fa-sm"></i> Refresh
                                </a>
                            </div>
                        </div>
                        {{-- <div class="p-1 col-lg-7">
                            <form action="" class="">
                                <div class="row">
                                    <div class="p-1 col-lg-4 col-md-4 col-sm-4">
                                        {!! Form::select('keyword', $notices , @request()->keyword, ['class' => 'form-control select2', 'placeholder' =>
                                        'Search Title']) !!}
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <button class="btn btn-primary btn-flat"><i class="fa fa fa-search"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <div class="p-1 col-lg-2 float-right">
                            <div class="card-tools">
                                @can('rider-create')
                                <a href="{{ route('appnotice.create') }}" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-plus"></i> Add New App Notice</a>
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
                                <th>Title</th>
                                <th>Image</th>
                                <th>URL / Link</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                              <td>{{$key+1}}.</td>
                              <td>{{ $value->title }}</td>
                              <td>
                                <img src="{{ asset('uploads/appnotices/'.@$value->image)}}" alt="{{ @$value->title}}" class="img img-thumbail" style="width:60px">    
                            </td>
                            <td>{{ $value->url }}</td>
                            <td>{{ $value->from_date }}</td>
                            <td>{{ $value->to_date }}</td>
                            <td>{{ $value->from_time }}</td>
                            <td>{{ $value->to_time }}</td>
                              <td>
                                <span class="badge badge-{{ $value->publish_status=='1' ?'success':'danger' }}">
                                {{ $value->publish_status=='1'?'Active':'Inactive' }}
                                </span>
                              </td>
                              <td>
                                <div class="btn-group">
                                  @can('rider-edit')
                                  <a href="{{route('appnotice.edit',$value->id)}}" title="Edit appnotice" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('rider-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['appnotice.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this appnotice?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete appnotice '])}}
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
