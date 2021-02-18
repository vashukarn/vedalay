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
<script src="{{ asset('/custom/student.js') }}"></script>
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
                        <a href="{{ route('student.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                @include('admin.shared.error-messages')
                <div class="card-body">
                    @if (isset($student_info))
                        {{ Form::open(['url' => route('student.update', $student_info->id), 'files' => true, 'class' => 'form', 'name' => 'student_form']) }}
                        @method('put')
                    @else
                        {{ Form::open(['url' => route('student.store'), 'files' => true, 'class' => 'form', 'name' => 'student_form']) }}
                    @endif
                    <label for="id of input"></label>
                    <div class="row">
                        <div class="col-sm-10 offset-lg-1">
                            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                                {{ Form::label('name', 'Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('name', @$student_info->get_user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name','style' => 'width:80%']) }}
                                    @error('name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('email', @$student_info->get_user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email','style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('phone', @$student_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone','style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('gender') ? 'has-error' : '' }}">
                                {{ Form::label('gender', 'Gender :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('gender', ['male' => 'Male', 'female' => 'Female', 'others' => 'Others'], @$student_info->gender, ['class' => 'form-control', 'id' => 'gender','style' => 'width:80%']) }}
                                    @error('gender')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-4">Specially Abled</label>
                                <div class="btn-group btn-group-toggle col-md-3" data-toggle="buttons">
                                    <label class="btn btn-default active">
                                        <input type="radio" name="disability" autocomplete="off" value="1"
                                            {{ @$student_info->disability == 1 ? 'checked' : '' }}> Yes
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="disability" autocomplete="off" value="0"
                                            {{ @$student_info->disability == 0 ? 'checked' : '' }}> No
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('level') ? 'has-error' : '' }}">
                                {{ Form::label('level', 'Level :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('level', @$levels, @$student_info->level, ['class' => 'form-control', 'id' => 'level','style' => 'width:80%']) }}
                                    @error('level')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('session', 'Session :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('session', @$session, @$student_info->session, ['class' => 'form-control', 'id' => 'session','style' => 'width:80%']) }}
                                    @error('session')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fathername') ? 'has-error' : '' }}">
                                {{ Form::label('fathername', "Father's Name :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fathername',@$student_info->fathername, ['class' => 'form-control', 'placeholder' => 'Father Name', 'id' => 'fathername','style' => 'width:80%']) }}
                                    @error('fathername')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('mothername', "Mother's Name :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('mothername', @$student_info->mothername, ['class' => 'form-control', 'placeholder' => 'Mother Name', 'id' => 'mothername','style' => 'width:80%']) }}
                                    @error('mothername')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fatheroccupation') ? 'has-error' : '' }}">
                                {{ Form::label('fatheroccupation', "Father's Occupation :", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fatheroccupation',@$student_info->fatheroccupation, ['class' => 'form-control', 'placeholder' => 'Father Occupation', 'id' => 'fatheroccupation','style' => 'width:80%']) }}
                                    @error('fatheroccupation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('motheroccupation', "Mother's Occupation :", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('motheroccupation', @$student_info->motheroccupation, ['class' => 'form-control', 'placeholder' => 'Mother Occupation', 'id' => 'motheroccupation','style' => 'width:80%']) }}
                                    @error('motheroccupation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fatherincome') ? 'has-error' : '' }}">
                                {{ Form::label('fatherincome', "Father's Income :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fatherincome',@$student_info->fatherincome, ['class' => 'form-control', 'placeholder' => 'Father Income', 'id' => 'fatherincome','style' => 'width:80%']) }}
                                    @error('fatherincome')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('motherincome', "Mother's Income :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('motherincome', @$student_info->motherincome, ['class' => 'form-control', 'placeholder' => 'Mother Income', 'id' => 'motherincome','style' => 'width:80%']) }}
                                    @error('motherincome')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('caste_category') ? 'has-error' : '' }}">
                                {{ Form::label('caste_category', 'Category :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('caste_category', ['GENERAL'=> 'GENERAL', 'OBC'=> 'OBC','SC/ST'=> 'SC/ST'], @$student_info->caste_category, ['class' => 'form-control', 'id' => 'caste_category','style' => 'width:80%']) }}
                                    @error('caste_category')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('blood_group', 'Blood Group :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('blood_group', ['A+'=> 'A+', 'A-'=> 'A-', 'B+'=> 'B+', 'B-'=> 'B-', 'AB+'=> 'AB+', 'AB-'=> 'AB-', 'O+'=> 'O+', 'O-'=> 'O-'], @$student_info->blood_group, ['class' => 'form-control', 'id' => 'blood_group','style' => 'width:80%']) }}
                                    @error('blood_group')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('guardian_name') ? 'has-error' : '' }}">
                                {{ Form::label('guardian_name', 'Local Guardian Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('guardian_name',@$student_info->guardian_name, ['class' => 'form-control', 'placeholder' => 'Guardian Name', 'id' => 'guardian_name','style' => 'width:80%']) }}
                                    @error('guardian_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('guardian_phone', 'Guardian Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('guardian_phone', @$student_info->guardian_phone, ['class' => 'form-control', 'placeholder' => 'Guardian Phone', 'id' => 'guardian_phone','style' => 'width:80%']) }}
                                    @error('guardian_phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (!isset($student_info))
                                <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {{ Form::label('password', 'Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('password', @$student_info->password, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password','style' => 'width:80%']) }}
                                        @error('password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{ Form::label('confirm_password', 'Confirm Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('confirm_password', @$student_info->confirm_password, ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password','style' => 'width:80%']) }}
                                        @error('confirm_password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            @endif

                            <div class="form-group row {{ $errors->has('aadhar_number') ? 'has-error' : '' }}">
                                {{ Form::label('aadhar_number', 'Aadhar Number :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('aadhar_number', @$student_info->aadhar_number, ['class' => 'form-control', 'id' => 'aadhar_number', 'placeholder' => 'Permanent Address','style' => 'width:80%']) }}
                                    @error('aadhar_number')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('current_address') ? 'has-error' : '' }}">
                                {{ Form::label('current_address', 'Current Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('current_address', @$student_info->current_address, ['class' => 'form-control', 'id' => 'current_address', 'placeholder' => 'Current Address','style' => 'width:80%']) }}
                                    @error('current_address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('permanent_address') ? 'has-error' : '' }}">
                                {{ Form::label('permanent_address', 'Permanent Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('permanent_address', @$student_info->permanent_address, ['class' => 'form-control', 'id' => 'permanent_address', 'placeholder' => 'Permanent Address','style' => 'width:80%']) }}
                                    @error('permanent_address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ Form::label('image', 'Profile photo:*', ['class' => 'col-sm-3']) }}
                                
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
                                    
                                    @if (isset($student_info->image))
                                    Old Image: &nbsp; <img src="{{ @$student_info->image }}" alt="{{ @$student_info->get_user->name }}" 
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
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$student_info->publish_status, ['id' => 'publish_status','class' => 'form-control', 'style' => 'width:80%']) }}
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
