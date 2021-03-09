@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
        {{-- <script src="{{ asset('/custom/expense.js') }}"></script> --}}
        <script>
            $('#lfm').filemanager('image');

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
                        <a href="{{ route('expense.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($expense_info))
                        {{ Form::open(['url' => route('expense.update', $expense_info->id), 'files' => true, 'class' => 'form', 'name' => 'expense_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('expense.store'), 'files' => true, 'class' => 'form', 'name' => 'expense_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$expense_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Expense Title', 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('paid_to') ? 'has-error' : '' }}">
                                {{ Form::label('paid_to', 'Paid To:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('paid_to', @$expense_info->paid_to, ['class' => 'form-control', 'id' => 'paid_to', 'placeholder' => 'To a company or any person', 'style' => 'width:80%']) }}
                                    @error('paid_to')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('amount') ? 'has-error' : '' }}">
                                {{ Form::label('amount', 'Spent Amount:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('amount', @$expense_info->amount, ['class' => 'form-control', 'id' => 'amount', 'placeholder' => 'Expense Amount', 'style' => 'width:80%']) }}
                                    @error('amount')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Expense Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="image" data-preview="holder"
                                                class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="image" class="form-control" type="text" name="image">
                                    </div>
                                    <div id="holder" style="
                                            border: 1px solid #ddd;
                                            border-radius: 4px;
                                            padding: 5px;
                                            width: 150px;
                                            margin-top:15px;">
                                    </div>
                                    @if (isset($expense_info->image))
                                        Old Image: &nbsp; <img src="{{ $expense_info->image }}" alt="Couldn't load image"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('remarks') ? 'has-error' : '' }}">
                                {{ Form::label('remarks', 'Remarks:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('remarks', @$expense_info->remarks, ['class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('remarks')
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
