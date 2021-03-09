@extends('layouts.admin')
@section('title', 'Inventory Item Type')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Item Type List</h3>
                    <div class="card-tools">
                        <a href="{{ route('inventoryitem.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-3">
                            <div class="card-tools">
                                @can('inventory-create')
                                <a href="{{ route('inventoryitem.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                    <i class="fa fa-plus"></i> Add New Inventory Item</a>
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
                                <th>Quantity</th>
                                <th>Image</th>
                                <th>Last Changed By</th>
                                <th>Last Changed At</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                              <td>{{$key+1}}.</td>
                              <td>{{ @$value->title }}</td>
                              <td>{{ @$value->count }}</td>
                              <td><a href="{{ @$value->image }}"><img src="{{ @$value->image }}" height="100px" alt="Image Not Found"></a></td>
                              <td>{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}</td>
                              <td>{{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}</td>
                              <td>
                                <div class="btn-group">
                                  @can('inventory-edit')
                                  <a href="{{route('inventoryitem.edit',$value->id)}}" title="Edit inventoryitem" class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  @can('inventory-delete')
                                  {{Form::open(['method' => 'DELETE','route' => ['inventoryitem.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this inventoryitem?")']) }}
                                  {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete inventoryitem '])}}
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
