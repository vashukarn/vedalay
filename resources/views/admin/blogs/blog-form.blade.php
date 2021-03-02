@extends('layouts.admin')
@section('title', $title)
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script type="text/javascript" src="{{ asset('/custom/jqueryvalidate.js') }}"></script>
{{-- <script src="{{ asset('/custom/blog.js') }}"></script> --}}
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
                        <a href="{{ route('blog.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($blog_info))
                        {{ Form::open(['url' => route('blog.update', $blog_info->id), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('blog.store'), 'files' => true, 'class' => 'form', 'name' => 'blog_form']) }}
                    @endif
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">

                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Title :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$blog_info->title, [ 'id' => 'title','placeholder' => 'Enter Blog Title','class' => 'form-control','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('short_description') ? 'has-error' : '' }}">
                                {{ Form::label('short_description', 'Short Description :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('short_description', @$blog_info->short_description, [ 'id' => 'my-editor','placeholder' => 'Enter Blog Short Description','class' => 'form-control ckeditor','style' => 'width:80%']) }}
                                    @error('short_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Full Description :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('description', @$blog_info->description, [ 'id' => 'my-editor','placeholder' => 'Enter Blog Full Description','class' => 'form-control ckeditor','style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                {{ Form::label('meta_title', 'Meta Title :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('meta_title', @$blog_info->meta_title, [ 'id' => 'meta_title','placeholder' => 'Enter Blog Meta Title','class' => 'form-control','style' => 'width:80%']) }}
                                    @error('meta_title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                {{ Form::label('meta_keyword', 'Meta Keyword :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('meta_keyword', @$blog_info->meta_keyword, [ 'id' => 'meta_keyword','placeholder' => 'Enter Blog Meta Keyword','class' => 'form-control','style' => 'width:80%']) }}
                                    @error('meta_keyword')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                {{ Form::label('meta_description', 'Meta Description :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('meta_description', @$blog_info->meta_description, [ 'id' => 'meta_description','placeholder' => 'Enter Blog Meta Description','class' => 'form-control','style' => 'width:80%']) }}
                                    @error('meta_description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Blog Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                          <a id="lfm" data-input="image" data-preview="holder" class="btn btn-primary text-white">
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
                                    @if (isset($blog_info->image))
                                    Old Image: &nbsp; <img src="{{ $blog_info->image }}" alt="Couldn't load image" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('external_url') ? 'has-error' : '' }}">
                                {{ Form::label('external_url', 'External URL :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('external_url', @$blog_info->external_url, [ 'id' => 'external_url','placeholder' => 'Ex: https://www.theverge.com/2021/2/22/22296209/elon-musk-starlink-speeds-double-2021','class' => 'form-control','style' => 'width:80%']) }}
                                    <small>Enter any url only if you want to redirect to another website</small>
                                    @error('external_url')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$blog_info->publish_status, ['id' => 'publish_status', 'class' => 'form-control', 'style' => 'width:80%']) }}
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
