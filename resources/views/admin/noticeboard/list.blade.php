@extends('layouts.admin')
@section('title', 'Noticeboard List')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notice List</h3>
                    <div class="card-tools">
                        <a href="{{ route('noticeboard.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="float-right col-lg-2">
                            <div class="card-tools">
                                @can('noticeboard-create')
                                    <a href="{{ route('noticeboard.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add New Notice</a>
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
                                <th>Title</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Last Changed By</th>
                                <th>Last Changed At</th>
                                <th>Publish Status</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->title }}</td>
                                    <td><img src="{{ @$value->image }}" height="100px" alt="Image not found"></td>
                                    <td>{{ @$value->date }}</td>
                                    <td>{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}</td>
                                    <td>{{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}
                                    </td>
                                    <td>
                                    <span class="badge @if (@$value->publish_status == '1') badge-success @elseif(@$value->publish_status == '2')
                                        badge-danger @else badge-warning @endif">
                                            @if (@$value->publish_status == '1') Active
                                        @elseif(@$value->publish_status == '2') Banned @else Inactive @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @can('staff-edit')
                                            <a href="{{ route('publishNotice', @$value->id) }}"
                                                title="{{ $value->publish_status == 0 ? 'Publish Routine' : 'Unpublish Routine' }}"
                                                class="btn btn-warning btn-sm btn-flat"><i
                                                    class="fas {{ $value->publish_status == 0 ? 'fa-check' : 'fa-eye-slash' }}"></i></a>
                                        @endcan
                                        @can('noticeboard-list')
                                            <a href="{{ route('noticeboard.show', @$value->id) }}"
                                                title="View Notice Details" class="btn btn-secondary btn-sm btn-flat"><i
                                                    class="fas fa-eye"></i></a>
                                        @endcan
                                        @can('noticeboard-edit')
                                            <a href="{{ route('noticeboard.edit', @$value->id) }}"
                                                title="Edit noticeboard" class="btn btn-success btn-sm btn-flat"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('noticeboard-delete')
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['noticeboard.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this noticeboard?")']) }}
                                            {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete noticeboard ']) }}
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
