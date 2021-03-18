@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        {{-- <script src="{{ asset('/custom/inventory.js') }}"></script> --}}
        <script>
            $('#lfm').filemanager('image');
            $(document).ready(function() {
                $('#item_id').select2({
                    placeholder: "Select Item",
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
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('inventory.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($inventory_info))
                        {{ Form::open(['url' => route('inventory.update', $inventory_info->id), 'files' => true, 'class' => 'form', 'name' => 'inventory_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('inventory.store'), 'files' => true, 'class' => 'form', 'name' => 'inventory_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('item_id') ? 'has-error' : '' }}">
                                {{ Form::label('item_id', 'Item:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('item_id', $items, @$inventory_info->item_id, ['class' => 'form-control select2', 'id' => 'item_id', 'placeholder' => 'Select Item', 'style' => 'width:80%']) }}
                                    @error('item_id')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('act') ? 'has-error' : '' }}">
                                {{ Form::label('act', 'Add / Remove:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('act', ['ADD' => 'Add','REMOVE' => 'Remove' ], @$inventory_info->act, ['class' => 'form-control', 'id' => 'act', 'style' => 'width:80%']) }}
                                    @error('act')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('quantity') ? 'has-error' : '' }}">
                                {{ Form::label('quantity', 'Quantity:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('quantity', @$inventory_info->quantity, ['class' => 'form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity', 'style' => 'width:80%']) }}
                                    @error('quantity')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('total_price') ? 'has-error' : '' }}">
                                {{ Form::label('total_price', 'Total Price:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('total_price', @$inventory_info->total_price, ['class' => 'form-control', 'id' => 'total_price', 'placeholder' => 'Total Price', 'style' => 'width:80%']) }}
                                    @error('total_price')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', '', ['class' => 'col-sm-3']) }}
                        <div class="col-sm-9">
                            {{ Form::button("<i class='fa fa-paper-plane'></i> Submit", ['class' => 'btn btn-success btn-flat', 'type' => 'submit']) }}
                            {{ Form::button("<i class='fas fa-sync-alt'></i> Reset", ['class' => 'btn btn-danger btn-flat', 'type' => 'reset']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
@endsection
