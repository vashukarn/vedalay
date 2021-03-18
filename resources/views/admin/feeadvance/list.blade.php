@extends('layouts.admin')
@section('title', 'Advance Fee List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Advance Fee List</h3>
                    <div class="card-tools">
                        <a href="{{ route('feeadvance.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Student</th>
                                <th>Amount</th>
                                <th>Last Changed By</th>
                                <th>Last Changed At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$value)
                            <tr>
                            <td>{{ $key+1}}.</td>
                            <td>{{ @$value->student->name }}</td>
                            <td>Rs. {{ @$value->amount }}</td>
                            <td>{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}</td>
                            <td>{{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}</td>
                            <td>
                                
                                <div class="btn-group">
                                    @can('feeadvance-delete')
                                    {{Form::open(['method' => 'DELETE','route' => ['feeadvance.destroy', $value->id],'style'=>'display:inline','onsubmit'=>'return confirm("Are you sure you want to delete this Fee Advance?")']) }}
                                    {{Form::button('<i class="fas fa-trash-alt"></i>',['class'=>'btn btn-danger btn-sm btn-flat','type'=>'submit','title'=>'Delete Advance Fee '])}}
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
