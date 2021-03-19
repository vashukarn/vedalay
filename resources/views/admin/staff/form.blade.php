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
        <script src="{{ asset('/custom/staff.js') }}"></script>
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
                        <a href="{{ route('staff.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($staff_info))
                        {{ Form::open(['url' => route('staff.update', $staff_info->id), 'files' => true, 'class' => 'form', 'name' => 'staff_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('staff.store'), 'files' => true, 'class' => 'form', 'name' => 'staff_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{ Form::label('name', 'Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('name', @$staff_info->get_user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'style' => 'width:80%']) }}
                                    @error('name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (isset($staff_info))
                                <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('email', @$staff_info->get_user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'style' => 'width:80%', 'disabled']) }}
                                        @error('email')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('email', @$staff_info->get_user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'style' => 'width:80%']) }}
                                        @error('email')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('phone', @$staff_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone', 'style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('position') ? 'has-error' : '' }}">
                                {{ Form::label('position', 'Designation :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('position', @$staff_info->position, ['class' => 'form-control', 'id' => 'position', 'placeholder' => 'Position', 'style' => 'width:80%']) }}
                                    @error('position')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('dob') ? 'has-error' : '' }}">
                                {{ Form::label('dob', 'Date of Birth:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('dob', @$staff_info->dob, ['class' => 'form-control', 'id' => 'dob', 'placeholder' => 'dob', 'style' => 'width:80%']) }}
                                    @error('dob')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('gender') ? 'has-error' : '' }}">
                                {{ Form::label('gender', 'Gender :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('gender', ['male' => 'Male', 'female' => 'Female', 'others' => 'Others'], @$staff_info->gender, ['class' => 'form-control', 'id' => 'gender', 'style' => 'width:80%']) }}
                                    @error('gender')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (!isset($staff_info))
                                <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {{ Form::label('password', 'Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('password', @$staff_info->password, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'style' => 'width:80%']) }}
                                        @error('password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{ Form::label('confirm_password', 'Confirm Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('confirm_password', @$staff_info->confirm_password, ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password', 'style' => 'width:80%']) }}
                                        @error('confirm_password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            @endif

                            <div class="form-group row {{ $errors->has('aadhar_number') ? 'has-error' : '' }}">
                                {{ Form::label('aadhar_number', 'Aadhar Number :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('aadhar_number', @$staff_info->aadhar_number, ['class' => 'form-control', 'id' => 'aadhar_number', 'placeholder' => 'Permanent Address', 'style' => 'width:80%']) }}
                                    @error('aadhar_number')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('current_address') ? 'has-error' : '' }}">
                                {{ Form::label('current_address', 'Current Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('current_address', @$staff_info->current_address, ['class' => 'form-control', 'id' => 'current_address', 'placeholder' => 'Current Address', 'style' => 'width:80%']) }}
                                    @error('current_address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('permanent_address') ? 'has-error' : '' }}">
                                {{ Form::label('permanent_address', 'Permanent Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('permanent_address', @$staff_info->permanent_address, ['class' => 'form-control', 'id' => 'permanent_address', 'placeholder' => 'Permanent Address', 'style' => 'width:80%']) }}
                                    @error('permanent_address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Profile Image:*', ['class' => 'col-sm-3']) }}
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

                                    @if (isset($staff_info->image))
                                        Old Image: &nbsp; <img src="{{ @$staff_info->image }}" alt="Image Not Available"
                                            class="img img-thumbail mt-2" style="width: 100px">
                                    @endif
                                    @error('image')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('joining_date') ? 'has-error' : '' }}">
                                {{ Form::label('joining_date', 'Joining Date:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('joining_date', @$staff_info->joining_date, ['class' => 'form-control', 'id' => 'joining_date', 'placeholder' => 'joining_date', 'style' => 'width:80%']) }}
                                    @error('joining_date')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('salary') ? 'has-error' : '' }}">
                                {{ Form::label('salary', 'Salary :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('salary', @$staff_info->salary, ['id' => 'salary', 'placeholder' => 'Enter Current Monthly Salary', 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('salary')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$staff_info->get_user->publish_status, ['id' => 'publish_status', 'class' => 'form-control', 'style' => 'width:80%']) }}
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
