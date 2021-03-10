@extends('layouts.admin')
@section('title', 'Inventory Item Type')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Item Transactions</h3>
                    <div class="card-tools">
                        <a href="{{ route('inventory.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="p-1 col-lg-3">
                            <div class="card-tools">
                                @can('inventory-create')
                                    <a href="{{ route('inventory.create') }}" class="btn btn-success btn-sm btn-flat mr-2">
                                        <i class="fa fa-plus"></i> Add or Remove Inventory Stock</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div style="overflow-x: scroll" class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered --}}
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Act</th>
                                <th>Total Price</th>
                                <th>Last Changed By</th>
                                <th>Last Changed At</th>
                                <th style="text-align:center;" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>{{ @$value->item->title }}</td>
                                    <td>{{ @$value->quantity }}</td>
                                    <td>
                                    <span class="badge @if (@$value->act == 'ADD') badge-success @elseif(@$value->act
                                        == 'REMOVE') badge-danger @else badge-warning @endif">
                                            @if (@$value->act == 'ADD')
                                        Added @elseif(@$value->act == 'REMOVE') Removed @else
                                            Error @endif
                                    </span>
                                </td>
                                <td>
                                    {{ @$value->quantity }} x {{ @$value->price_per }} = {{ @$value->total_price }}
                                </td>
                                <td>{{ @$value->updated_by ? @$value->updater->name : @$value->creator->name }}</td>
                                <td>{{ @$value->updated_at ? ReadableDate(@$value->updated_at, 'all') : ReadableDate(@$value->created_at, 'all') }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @can('inventory-edit')
                                            <a href="{{ route('inventory.edit', $value->id) }}" title="Edit inventory"
                                                class="btn btn-success btn-sm btn-flat"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('inventory-delete')
                                            {{ Form::open(['method' => 'DELETE', 'route' => ['inventory.destroy', $value->id], 'style' => 'display:inline', 'onsubmit' => 'return confirm("Are you sure you want to delete this inventory?")']) }}
                                            {{ Form::button('<i class="fas fa-trash-alt"></i>', ['class' => 'btn btn-danger btn-sm btn-flat', 'type' => 'submit', 'title' => 'Delete inventory ']) }}
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
                                <strong>{{ $data->lastItem() }} </strong> of <strong> {{ $data->total() }}</strong>
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
