@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/noticeboard.js') }}"></script> --}}
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
                        <a href="{{ route('noticeboard.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($noticeboard_info))
                        {{ Form::open(['url' => route('noticeboard.update', $noticeboard_info->id), 'files' => true, 'class' => 'form', 'name' => 'noticeboard_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('noticeboard.store'), 'files' => true, 'class' => 'form', 'name' => 'noticeboard_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$noticeboard_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Title','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('date') ? 'has-error' : '' }}">
                                {{ Form::label('date', 'Date :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('date', @$noticeboard_info->date, ['class' => 'form-control', 'id' => 'date', 'placeholder' => 'Date','style' => 'width:80%']) }}
                                    @error('date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Notice Description:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$noticeboard_info->description, ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Image:', ['class' => 'col-sm-3']) }}
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

                                    @if (isset($student_info->image))
                                        Old Image: &nbsp; <img src="{{ @$student_info->image }}"
                                            alt="{{ @$student_info->get_user->name }}" class="img img-thumbail mt-2"
                                            style="width: 100px">
                                    @endif
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
