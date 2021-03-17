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
            $('#lfm1').filemanager('image');
            $('#lfm2').filemanager('image');
            $('#lfm3').filemanager('image');
            $('#lfm4').filemanager('image');
            $('#lfm5').filemanager('image');
            $('#lfm6').filemanager('image');

            
            @if (!isset($student_info))

            $(document).ready(function() {
                if ($('#admission').prop('checked')) {
                    $('#admissiondiv').show();
                } else {
                    $('#admissiondiv').hide();
                }
            });

            $("#fatherguardian").change(function() {
                if ($('#fatherguardian').prop('checked')) {
                    $("#guardian_name").prop('disabled', true);
                    $("#guardian_name").val($("#fathername").val());
                }
            });
            $("#motherguardian").change(function() {
                if ($('#motherguardian').prop('checked')) {
                    $("#guardian_name").prop('disabled', true);
                    $("#guardian_name").val($("#mothername").val());
                }
            });
            $("#localguardian").change(function() {
                if ($('#localguardian').prop('checked')) {
                    $("#guardian_name").prop('disabled', false);
                    $("#guardian_name").val('');
                }
            });
            $("#admission").change(function() {
                if ($('#admission').prop('checked')) {
                    $('#admissiondiv').show();
                } else {
                    $('#admissiondiv').hide();
                }
            });

            @endif

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
                                    {{ Form::text('name', @$student_info->get_user->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'style' => 'width:80%']) }}
                                    @error('name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                                {{ Form::label('email', 'Email :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('email', @$student_info->get_user->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'style' => 'width:80%']) }}
                                    @error('email')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                                {{ Form::label('phone', 'Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('phone', @$student_info->phone, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone', 'style' => 'width:80%']) }}
                                    @error('phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('dob') ? 'has-error' : '' }}">
                                {{ Form::label('dob', 'Date of Birth:*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::date('dob', @$student_info->dob, ['class' => 'form-control', 'id' => 'dob', 'placeholder' => 'Date of Birth', 'style' => 'width:80%']) }}
                                    @error('dob')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('gender') ? 'has-error' : '' }}">
                                {{ Form::label('gender', 'Gender :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('gender', ['male' => 'Male', 'female' => 'Female', 'others' => 'Others'], @$student_info->gender, ['class' => 'form-control', 'id' => 'gender', 'style' => 'width:80%']) }}
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
                                    {{ Form::select('level', @$levels, @$student_info->level_id, ['class' => 'form-control', 'id' => 'level', 'style' => 'width:80%']) }}
                                    @error('level')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('regpriv', 'Regular/Private :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('regpriv', ['REGULAR' => 'REGULAR', 'PRIVATE' => 'PRIVATE'], @$student_info->regpriv, ['id' => 'regpriv', 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('regpriv')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fathername') ? 'has-error' : '' }}">
                                {{ Form::label('fathername', "Father's Name :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fathername', @$student_info->fathername, ['class' => 'form-control', 'placeholder' => 'Father Name', 'id' => 'fathername', 'style' => 'width:80%']) }}
                                    @error('fathername')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('mothername', "Mother's Name :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('mothername', @$student_info->mothername, ['class' => 'form-control', 'placeholder' => 'Mother Name', 'id' => 'mothername', 'style' => 'width:80%']) }}
                                    @error('mothername')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fatheroccupation') ? 'has-error' : '' }}">
                                {{ Form::label('fatheroccupation', "Father's Occupation :", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fatheroccupation', @$student_info->fatheroccupation, ['class' => 'form-control', 'placeholder' => 'Father Occupation', 'id' => 'fatheroccupation', 'style' => 'width:80%']) }}
                                    @error('fatheroccupation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('motheroccupation', "Mother's Occupation :", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('motheroccupation', @$student_info->motheroccupation, ['class' => 'form-control', 'placeholder' => 'Mother Occupation', 'id' => 'motheroccupation', 'style' => 'width:80%']) }}
                                    @error('motheroccupation')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('fatherincome') ? 'has-error' : '' }}">
                                {{ Form::label('fatherincome', "Father's Income :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('fatherincome', @$student_info->fatherincome, ['class' => 'form-control', 'placeholder' => 'Father Income', 'id' => 'fatherincome', 'style' => 'width:80%']) }}
                                    @error('fatherincome')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('motherincome', "Mother's Income :*", ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('motherincome', @$student_info->motherincome, ['class' => 'form-control', 'placeholder' => 'Mother Income', 'id' => 'motherincome', 'style' => 'width:80%']) }}
                                    @error('motherincome')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('caste_category') ? 'has-error' : '' }}">
                                {{ Form::label('caste_category', 'Category :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('caste_category', ['GENERAL' => 'GENERAL', 'OBC' => 'OBC', 'SC/ST' => 'SC/ST'], @$student_info->caste_category, ['class' => 'form-control', 'id' => 'caste_category', 'style' => 'width:80%']) }}
                                    @error('caste_category')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('blood_group', 'Blood Group :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-'], @$student_info->blood_group, ['class' => 'form-control', 'id' => 'blood_group', 'style' => 'width:80%']) }}
                                    @error('blood_group')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-check ml-4 mb-4">
                                    <input class="form-check-input" type="radio" name="guardianradio" id="fatherguardian"
                                        value="Father">
                                    <label class="form-check-label" for="fatherguardian">
                                        Father is Guardian?
                                    </label>
                                </div>
                                <div class="form-check ml-4 mb-4">
                                    <input class="form-check-input" type="radio" name="guardianradio" id="motherguardian"
                                        value="Mother">
                                    <label class="form-check-label" for="motherguardian">
                                        Mother is Guardian?
                                    </label>
                                </div>
                                <div class="form-check ml-4 mb-4">
                                    <input class="form-check-input" type="radio" name="guardianradio" id="localguardian"
                                        value="Guardian" checked>
                                    <label class="form-check-label" for="localguardian">
                                        Seperate Local Guardian
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('guardian_name') ? 'has-error' : '' }}">
                                {{ Form::label('guardian_name', 'Local Guardian Name :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('guardian_name', @$student_info->guardian_name, ['class' => 'form-control', 'placeholder' => 'Guardian Name', 'id' => 'guardian_name', 'style' => 'width:80%']) }}
                                    @error('guardian_name')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{ Form::label('guardian_phone', 'Guardian Phone :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-3">
                                    {{ Form::text('guardian_phone', @$student_info->guardian_phone, ['class' => 'form-control', 'placeholder' => 'Guardian Phone', 'id' => 'guardian_phone', 'style' => 'width:80%']) }}
                                    @error('guardian_phone')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if (!isset($student_info))
                                <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {{ Form::label('password', 'Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('password', @$student_info->password, ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'style' => 'width:80%']) }}
                                        @error('password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{ Form::label('confirm_password', 'Confirm Password :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-3">
                                        {{ Form::password('confirm_password', @$student_info->confirm_password, ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => 'Confirm Password', 'style' => 'width:80%']) }}
                                        @error('confirm_password')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            @endif

                            <div class="form-group row {{ $errors->has('aadhar_number') ? 'has-error' : '' }}">
                                {{ Form::label('aadhar_number', 'Aadhar Number :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::number('aadhar_number', @$student_info->aadhar_number, ['class' => 'form-control', 'id' => 'aadhar_number', 'placeholder' => 'Aadhar Number', 'style' => 'width:80%']) }}
                                    @error('aadhar_number')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('current_address') ? 'has-error' : '' }}">
                                {{ Form::label('current_address', 'Current Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('current_address', @$student_info->current_address, ['class' => 'form-control', 'id' => 'current_address', 'placeholder' => 'Current Address', 'style' => 'width:80%']) }}
                                    @error('current_address')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('permanent_address') ? 'has-error' : '' }}">
                                {{ Form::label('permanent_address', 'Permanent Address :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('permanent_address', @$student_info->permanent_address, ['class' => 'form-control', 'id' => 'permanent_address', 'placeholder' => 'Permanent Address', 'style' => 'width:80%']) }}
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

                            @if (!isset($student_info))

                            <div class="form-group row {{ $errors->has('admission') ? 'has-error' : '' }}">
                                {{ Form::label('admission', 'New Admission? :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::checkbox('admission', null, @$admission_info, ['id' => 'admission', 'class' => 'form-control', 'style' => 'width:80%']) }}
                                    @error('admission')
                                        <span class="help-block error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div id="admissiondiv">
                                <div class="form-group row {{ $errors->has('last_schoolname') ? 'has-error' : '' }}">
                                    {{ Form::label('last_schoolname', 'Last School Name :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('last_schoolname', @$admission_info->last_schoolname, ['class' => 'form-control', 'id' => 'last_schoolname', 'placeholder' => 'Last School Name', 'style' => 'width:80%']) }}
                                        @error('last_schoolname')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('last_level') ? 'has-error' : '' }}">
                                    {{ Form::label('last_level', 'Last Level Studied :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('last_level', @$admission_info->last_level, ['class' => 'form-control', 'id' => 'last_level', 'placeholder' => 'Last Class Studied', 'style' => 'width:80%']) }}
                                        @error('last_level')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('last_marks') ? 'has-error' : '' }}">
                                    {{ Form::label('last_marks', 'Last % or CGPA scored :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::number('last_marks', @$admission_info->last_marks, ['class' => 'form-control', 'id' => 'last_marks', 'placeholder' => 'Last Scored % or CGPA', 'style' => 'width:80%']) }}
                                        @error('last_marks')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('last_state') ? 'has-error' : '' }}">
                                    {{ Form::label('last_state', 'Last State Studied :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('last_state', @$admission_info->last_state, ['class' => 'form-control', 'id' => 'last_state', 'placeholder' => 'Last State Studied', 'style' => 'width:80%']) }}
                                        @error('last_state')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('last_city') ? 'has-error' : '' }}">
                                    {{ Form::label('last_city', 'Last City Studied :*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('last_city', @$admission_info->last_city, ['class' => 'form-control', 'id' => 'last_city', 'placeholder' => 'Last City Studied', 'style' => 'width:80%']) }}
                                        @error('last_city')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div
                                    class="form-group row {{ $errors->has('transfer_certificate') ? 'has-error' : '' }}">
                                    {{ Form::label('transfer_certificate', 'Transfer Certificate:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm1" data-input="transfer_certificate" data-preview="holder1"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="transfer_certificate" class="form-control" type="text"
                                                name="transfer_certificate">
                                        </div>
                                        <div id="holder1" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->transfer_certificate))
                                            Uploaded Transfer Certificate: &nbsp; <img
                                                src="{{ @$admission_info->transfer_certificate }}" alt="Image not Found"
                                                class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('transfer_certificate')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div
                                    class="form-group row {{ $errors->has('migration_certificate') ? 'has-error' : '' }}">
                                    {{ Form::label('migration_certificate', 'Migration Certificate:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm2" data-input="migration_certificate" data-preview="holder2"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="migration_certificate" class="form-control" type="text"
                                                name="migration_certificate">
                                        </div>
                                        <div id="holder2" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->migration_certificate))
                                            Uploaded Migration Certificate: &nbsp; <img
                                                src="{{ @$admission_info->migration_certificate }}"
                                                alt="Image not Found" class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('migration_certificate')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div
                                    class="form-group row {{ $errors->has('character_certificate') ? 'has-error' : '' }}">
                                    {{ Form::label('character_certificate', 'Character Certificate:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm3" data-input="character_certificate" data-preview="holder3"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="character_certificate" class="form-control" type="text"
                                                name="character_certificate">
                                        </div>
                                        <div id="holder3" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->character_certificate))
                                            Uploaded Character Certificate: &nbsp; <img
                                                src="{{ @$admission_info->character_certificate }}"
                                                alt="Image not Found" class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('character_certificate')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('last_marksheet') ? 'has-error' : '' }}">
                                    {{ Form::label('last_marksheet', 'Last Obtained Marksheet:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm4" data-input="last_marksheet" data-preview="holder4"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="last_marksheet" class="form-control" type="text"
                                                name="last_marksheet">
                                        </div>
                                        <div id="holder4" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->last_marksheet))
                                            Uploaded Last Obtained Marksheet: &nbsp; <img
                                                src="{{ @$admission_info->last_marksheet }}" alt="Image not Found"
                                                class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('last_marksheet')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('medical_certificate') ? 'has-error' : '' }}">
                                    {{ Form::label('medical_certificate', 'Medical Certificate:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm5" data-input="medical_certificate" data-preview="holder5"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="medical_certificate" class="form-control" type="text"
                                                name="medical_certificate">
                                        </div>
                                        <div id="holder5" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->medical_certificate))
                                            Uploaded Last Obtained Marksheet: &nbsp; <img
                                                src="{{ @$admission_info->medical_certificate }}" alt="Image not Found"
                                                class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('medical_certificate')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('undertaking') ? 'has-error' : '' }}">
                                    {{ Form::label('undertaking', 'Undertaking:*', ['class' => 'col-sm-3']) }}
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm6" data-input="undertaking" data-preview="holder6"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="undertaking" class="form-control" type="text"
                                                name="undertaking">
                                        </div>
                                        <div id="holder6" style="
                                                            border: 1px solid #ddd;
                                                            border-radius: 4px;
                                                            padding: 5px;
                                                            width: 150px;
                                                            margin-top:15px;">
                                        </div>

                                        @if (isset($admission_info->undertaking))
                                            Uploaded Last Obtained Marksheet: &nbsp; <img
                                                src="{{ @$admission_info->undertaking }}" alt="Image not Found"
                                                class="img img-thumbail mt-2" style="width: 100px">
                                        @endif
                                        @error('undertaking')
                                            <span class="help-block error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            @endif

                            <div class="form-group row {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                                {{ Form::label('publish_status', 'Publish Status :*', ['class' => 'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('publish_status', [1 => 'Yes', 0 => 'No'], @$student_info->get_user->publish_status, ['id' => 'publish_status', 'class' => 'form-control', 'style' => 'width:80%']) }}
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
