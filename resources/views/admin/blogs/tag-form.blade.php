@extends('layouts.admin')
@section('title', $title )
@push('scripts')

@include('admin.section.ckeditor')

@endpush
@section('content')
 
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('tag.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($tag_info))
                        {{ Form::open(['url' => route('tag.update', $tag_info->id), 'files' => true, 'class' => 'form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('tag.store'), 'files' => true, 'class' => 'form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        {{-- <input type="hidden" name="roles" value="1" placeholder="dummy"> --}}
                        <div class="col-sm-10 offset-lg-1">
                            @if($_website == 'Nepali' || $_website == 'Both')
                            <div class="form-group row {{ $errors->has('np_title') ? 'has-error' : '' }}">
                                {{ Form::label('np_title', 'Tag Name (In Nepali) :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('np_title', @$tag_info->title['np'], ['class' => 'form-control', 'id' => 'np_title', 'placeholder' => 'Tag Name (In Nepali)', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('np_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif 
                            @if($_website == 'English' || $_website == 'Both')
                            <div class="form-group row {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                {{ Form::label('en_title', 'Tag Name (In English) :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('en_title', @$tag_info->title['en'], ['class' => 'form-control', 'id' => 'en_title', 'placeholder' => 'Tag Name (In English)', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('en_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif 
                            @if($_website == 'Nepali' || $_website == 'Both')
                            <div class="form-group row {{ $errors->has('np_description') ? 'has-error' : '' }}">
                                {{ Form::label('np_description', 'Tag Description (In nepali) :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('np_description', @$tag_info->description['np'], ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Tag Description (In Nepali)', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('np_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif 
                            @if($_website == 'English' || $_website == 'Both')
                            <div class="form-group row {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                {{ Form::label('en_description', 'Tag Description (In English) :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('en_description', @$tag_info->description['np'], ['class' => 'form-control ckeditor', 'id' => 'my-editor', 'placeholder' => 'Tag Description (In English)', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('en_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif 
                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$tag_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
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
