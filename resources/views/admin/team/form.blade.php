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
<script src="{{ asset('/custom/team.js') }}"></script> 
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
                        <a href="{{ route('team.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($team_info))
                        {{ Form::open(['url' => route('team.update', $team_info->id), 'files' => true, 'class' => 'form', 'name' => 'team_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('team.store'), 'files' => true, 'class' => 'form', 'name' => 'team_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{ Form::label('name', 'Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('name', @$team_info->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Team Member Name','style' => 'width:80%']) }}
                                    @error('name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('designation') ? 'has-error' : '' }}">
                                {{ Form::label('designation', 'Designation :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('designation', @$team_info->designation, ['class' => 'form-control', 'id' => 'designation', 'placeholder' => 'Team Member Designation','style' => 'width:80%']) }}
                                    @error('designation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::email('email', @$team_info->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Team Member Email','style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                                {{ Form::label('title', 'Hover Title :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$team_info->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Team Member Hover Title','style' => 'width:80%']) }}
                                    @error('title')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                                {{ Form::label('description', 'Hover Description :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('description', @$team_info->description, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Team Member Hover Description','style' => 'width:80%']) }}
                                    @error('description')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('website_link') ? 'has-error' : '' }}">
                                {{ Form::label('website_link', 'Hover Website Link :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('website_link', @$team_info->website_link, ['class' => 'form-control', 'id' => 'website_link', 'placeholder' => 'Website Link','style' => 'width:80%']) }}
                                    @error('website_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('facebook_link') ? 'has-error' : '' }}">
                                {{ Form::label('facebook_link', 'Hover Facebook Link :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('facebook_link', @$team_info->facebook_link, ['class' => 'form-control', 'id' => 'facebook_link', 'placeholder' => 'Facebook Link','style' => 'width:80%']) }}
                                    @error('facebook_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('instagram_link') ? 'has-error' : '' }}">
                                {{ Form::label('instagram_link', 'Hover Instagram Link :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('instagram_link', @$team_info->instagram_link, ['class' => 'form-control', 'id' => 'instagram_link', 'placeholder' => 'Instagram Link','style' => 'width:80%']) }}
                                    @error('instagram_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('github_link') ? 'has-error' : '' }}">
                                {{ Form::label('github_link', 'Hover Github Link :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('github_link', @$team_info->github_link, ['class' => 'form-control', 'id' => 'github_link', 'placeholder' => 'Github Link','style' => 'width:80%']) }}
                                    @error('github_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('linkedin_link') ? 'has-error' : '' }}">
                                {{ Form::label('linkedin_link', 'Hover LinkedIn Link :', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('linkedin_link', @$team_info->linkedin_link, ['class' => 'form-control', 'id' => 'linkedin_link', 'placeholder' => 'LinkedIn Link','style' => 'width:80%']) }}
                                    @error('linkedin_link')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Profile Image:*', ['class' => 'col-sm-3']) }}
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
                                    
                                    @if (isset($team_info->image))
                                    Old Image: &nbsp; <img src="{{ @$team_info->image }}" alt="Image Not Available" 
                                    class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$team_info->publish_status, ['id' => 'publish_status','class' => 'form-control', 'style' => 'width:80%']) }}
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
