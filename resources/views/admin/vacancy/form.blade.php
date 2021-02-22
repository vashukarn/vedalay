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
<script src="{{ asset('/custom/vacancy.js') }}"></script> 
    <script>
    $('#lfm').filemanager('image');
    </script>
@endpush
@section('content')
@include('admin.section.ckeditor')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('vacancy.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($vacancy_info))
                        {{ Form::open(['url' => route('vacancy.update', $vacancy_info->id), 'files' => true, 'class' => 'form', 'name' => 'vacancy_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('vacancy.store'), 'files' => true, 'class' => 'form', 'name' => 'vacancy_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('job_role') ? 'has-error' : '' }}">
                                {{ Form::label('job_role', 'Position :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('job_role', @$vacancy_info->job_role, ['class' => 'form-control', 'id' => 'job_role', 'placeholder' => 'Position','style' => 'width:80%']) }}
                                    @error('job_role')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('required_no') ? 'has-error' : '' }}">
                                {{ Form::label('required_no', 'Required Number:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('required_no', @$vacancy_info->required_no, ['class' => 'form-control', 'id' => 'required_no', 'placeholder' => 'Requirement','style' => 'width:80%']) }}
                                    @error('required_no')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('salary') ? 'has-error' : '' }}">
                                {{ Form::label('salary', 'Expected Salary :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('salary', @$vacancy_info->salary, ['class' => 'form-control', 'id' => 'salary', 'placeholder' => 'Expected Salary','style' => 'width:80%']) }}
                                    @error('salary')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Job Description:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$vacancy_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$vacancy_info->publish_status, ['id' => 'publish_status','class' => 'form-control', 'style' => 'width:80%']) }}
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
