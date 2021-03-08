@extends('layouts.admin')
@section('title', $title)
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#image').change(function() {
                    $('#thumbnail').removeClass('d-none');
                })
                $('#roles').select2({
                    placeholder: "User Role",
                    allowClear: true
                });
            });

        </script>
    @endpush
@section('content')
    @include('admin.shared.image_upload')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ @$title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('profile.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($profile_info))
                        {{ Form::open(['url' => route('profile.update', $profile_info->id), 'files' => true, 'class' => 'form', 'name' => 'profile_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('profile.store'), 'files' => true, 'class' => 'form', 'name' => 'profile_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{ Form::label('name', 'Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('name', @$profile_info->get_user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('email', @$profile_info->get_user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('phone', @$profile_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (!isset($profile_info))
                                <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {{ Form::label('password', 'Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('password', @$profile_info->password, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{ Form::label('confirm_password', 'Confirm Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('confirm_password', @$profile_info->confirm_password, ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password', 'required' => true, 'style' => 'width:80%']) }}
                                        @error('confirm_password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            @endif

                            <div class="form-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                                {{ Form::label('facebook', 'Facebook Link :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('facebook', @$profile_info->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'Facebook link', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('facebook')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('twitter', 'Twitter Link :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('twitter', @$profile_info->twitter, ['class' => 'form-control', 'id' => 'twitter', 'placeholder' => 'Twitter link', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('twitter')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                                {{ Form::label('address', 'Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('address', @$profile_info->address, ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address', 'required' => true, 'style' => 'width:80%']) }}
                                    @error('address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('roles') ? 'has-error' : '' }}">
                                {{ Form::label('roles', 'User Role:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('roles[]', $roles, @$userRole, ['id' => 'roles', 'required' => true, 'class' => 'form-control select2', 'multiple', 'style' => 'width:80%; border-color:none']) }}
                                    @error('roles')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$profile_info->publish_status, ['id' => 'publish_status', 'required' => true, 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('publish_status')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Profile Image:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::file('image', ['id' => 'image', 'class' => 'cropImage', 'name' => 'image', 'style' => 'width:80%', 'accept' => 'image/*', 'onchange' => 'uploadImage(this);']) }}
                                    <input type="hidden" name="image_name" id="image_name"
                                        value="{{ @$profile_info->thumbnail }}">
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror

                                    <div class="col-sm-4">
                                        <img id="thumbnail" name="thumbnail"
                                            src="{{ getImageUrl(@$profile_info->thumbnail, profileimagepath) }}"
                                            alt="image" class="d-none img-fluid img-thumbnail" style="height: 80px" />
                                        @if (isset($profile_info->image))
                                            @if (file_exists(public_path() . '/uploads/profiles/' . @$profile_info->image))
                                                <img src="{{ asset('/uploads/profiles/' . @$profile_info->image) }}"
                                                    alt="{{ $profile_info->image }}" class="img img-fluid img-thumbnail"
                                                    style="height:80px" id=" ">
                                            @endif
                                        @endif
                                    </div>
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
