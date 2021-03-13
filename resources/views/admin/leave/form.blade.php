@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/leave.js') }}"></script> --}}
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
                        <a href="{{ route('leave.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($leave_info))
                        {{ Form::open(['url' => route('leave.update', $leave_info->id), 'files' => true, 'class' => 'form', 'name' => 'leave_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('leave.store'), 'files' => true, 'class' => 'form', 'name' => 'leave_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Leave Subject:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$leave_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Enter subject of leave request', 'style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('from_date') ? 'has-error' : '' }}">
                                {{ Form::label('from_date', 'Leave From:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('from_date', @$leave_info->from_date, ['class' => 'form-control', 'id' => 'from_date', 'style' => 'width:80%']) }}
                                    @error('from_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('to_date') ? 'has-error' : '' }}">
                                {{ Form::label('to_date', 'Leave To:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('to_date', @$leave_info->to_date, ['class' => 'form-control', 'id' => 'to_date', 'style' => 'width:80%']) }}
                                    <small>Leave it blank if you want a single day leave</small>
                                    @error('to_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Leave Description:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$leave_info->description, ['class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Image Attachment:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('image', @$leave_info->image, ['class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('image')
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
