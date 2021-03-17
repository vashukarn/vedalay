@extends('layouts.admin')
@section('title', $title)
@push('styles')
    <style>
        .btn-default.active,
        .btn-default.active:hover {
            background-color: #17a2b8;
            border-color: #138192;
            color: #fff;
        }
    </style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/slider.js') }}"></script> --}}
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
                        <a href="{{ route('subject.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($subject_info))
                        {{ Form::open(['url' => route('subject.update', $subject_info->id), 'files' => true, 'class' => 'form', 'name' => 'subject_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('subject.store'), 'files' => true, 'class' => 'form', 'name' => 'subject_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$subject_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Subject Title','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('level') ? 'has-error' : '' }}">
                                {{ Form::label('level', 'Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('level', @$levels, @$subject_info->level_id, ['class' => 'form-control', 'id' => 'level','style' => 'width:80%']) }}
                                    @error('level')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('type') ? 'has-error' : '' }}">
                                {{ Form::label('type', 'Subject Type :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('type', ['Theory'=> 'Theory','Practical'=> 'Practical'], @$subject_info->type, ['class' => 'form-control', 'id' => 'type','style' => 'width:80%']) }}
                                    @error('type')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('value', 'Subject Value :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('value', ['Compulsory'=> 'Compulsory', 'Optional'=> 'Optional'], @$subject_info->value, ['class' => 'form-control', 'id' => 'value','style' => 'width:80%']) }}
                                    @error('value')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$subject_info->publish_status, ['id' => 'publish_status','class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
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
