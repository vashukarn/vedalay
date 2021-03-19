@extends('layouts.admin')
@section('title','Update Profile')
@section('content')
<section class="content-header mt-0 pt-0"></section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="img-fluid img-circle" src="@isset($student_info->image) {{ $student_info->image }} @else {{ asset('img/AdminLTELogo.png') }} @endisset" style="width:80px" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

            <p class="text-muted text-center">{{ request()->user()->roles->first()->name }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email</b> <a class="float-right">{{ @$user_info->email }}</a>
              </li>
              @hasrole('Super Admin')
              <li class="list-group-item">
                <b>Session Id:</b> <a class="float-right">#{{ GETAPPSETTING()['session'] }}</a>
              </li>
              <li class="list-group-item">
                <b>Marks Scheme:</b> <a class="float-right">{{ GETAPPSETTING()['marks_scheme'] }}</a>
              </li>
              <li class="list-group-item">
                <b>Razorpay Status:</b> <a class="float-right">{{ GETAPPSETTING()['razorpay_payment'] }}</a>
              </li>
              @endhasrole
              @hasrole('Student')
              <li class="list-group-item">
                <b>Level/Class</b> <a class="float-right">{{ @$levels[$student_info->level_id] }}</a>
              </li>
              <li class="list-group-item">
                <b>Date of Birth</b> <a class="float-right">{{ ReadableDate(@$student_info->dob, 'ymd') }}</a>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right">{{ @$student_info->gender }}</a>
              </li>
              @endhasrole
              @hasrole('Teacher')
              <li class="list-group-item">
                <b>Short Name</b> <a class="float-right">{{ @$teacher_info->short_name }}</a>
              </li>
              <li class="list-group-item">
                <b>Joining Date</b> <a class="float-right">{{ ReadableDate(@$teacher_info->joining_date, 'ymd') }}</a>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right">{{ @$teacher_info->gender }}</a>
              </li>
              @endhasrole
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>View More</b></a>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="card card-primary">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="img-fluid img-circle" src="@isset($student_info->image) {{ $student_info->image }} @else {{ asset('img/AdminLTELogo.png') }} @endisset" style="width:80px" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

            <p class="text-muted text-center">{{ request()->user()->roles->first()->name }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email</b> <a class="float-right">{{ @$user_info->email }}</a>
              </li>
              @hasrole('Student')
              <li class="list-group-item">
                <b>Level/Class</b> <a class="float-right">{{ @$levels[$student_info->level_id] }}</a>
              </li>
              <li class="list-group-item">
                <b>Date of Birth</b> <a class="float-right">{{ ReadableDate(@$student_info->dob, 'ymd') }}</a>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right">{{ @$student_info->gender }}</a>
              </li>
              @endhasrole
              @hasrole('Teacher')
              <li class="list-group-item">
                <b>Short Name</b> <a class="float-right">{{ @$teacher_info->short_name }}</a>
              </li>
              <li class="list-group-item">
                <b>Joining Date</b> <a class="float-right">{{ ReadableDate(@$teacher_info->joining_date, 'ymd') }}</a>
              </li>
              <li class="list-group-item">
                <b>Gender</b> <a class="float-right">{{ @$teacher_info->gender }}</a>
              </li>
              @endhasrole
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>View More</b></a>
          </div>
        </div>
      </div>


      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-bold">Update Profile Data</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body">
              <div class="row">
                <div class="col-md-6 border-right">
                  <h5 class="text-primary">Two Factor Authentication</h5>
                  <p class="text-sm">Add Aditional Security to your account using two factor authentication.</p>
                  <hr>
                  <div class="m-b-20">
                    @if (session('status')=='two-factor-authentication-enabled' ||
                    auth()->user()->two_factor_recovery_codes)
                    <p class="mb-4 font-strong">You have enabled 2FA, please scan the following QR code into
                        your phones authenticator application.</p>
                    <div class="d-flex justify-content-center">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    <p class="mt-4 font-strong">Please store these recovery code in secure place.</p>
                    <div class="d-flex justify-content-center">
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes,true)) as
                        $code)
                        {{ trim($code) }} <br>
                        @endforeach
                    </div>
                    @endif

                    @if (auth()->user()->two_factor_secret)
                    <p class="mt-4 strong">You are enabled two factor authentication.</p>
                    {{Form::open(['url'=>url('user/two-factor-authentication'),'files'=>false,'class'=>'form'])}}
                    @method('delete')
                    @csrf
                    {{Form::button("Disable 2FA",['class'=>'btn btn-danger','type'=>'submit'])}}
                    {{ Form::close() }}
                    @else
                    <p class="mt-4 strong">You are not enabled two factor authentication</p>
                    {{Form::open(['url'=>url('user/two-factor-authentication'),'files'=>false,'class'=>'form'])}}
                    @csrf
                    {{Form::button("Enable 2FA",['class'=>'btn btn-success mb-3','type'=>'submit'])}}
                    {{ Form::close() }}
                    @endif
                </div>

                </div>
                <div class="col-md-6">
                  <h5 class="text-primary">Update Password</h5>
                  <p class="text-sm">Ensure your account is using a long random password to stay secure.</p>
                  <hr>
                  <div class="m-0">
                    {{Form::open(['url'=>route('update-password',auth()->user()->id),'files'=>true,'class'=>'form'])}}
                    @method('put')
                    <div class="form-group row @error('name') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('name','User Name:*',['class'=>''])}}
                            {{Form::text('name',@(auth()->user()->name),['class'=>'form-control form-control','id'=>'name','placeholder'=>'Email','required'=>true,'style'=>'width:80%'])}}
                            @error('name')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('current_password') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('current_password','Current Password:*',['class'=>''])}}
                            {{Form::password('current_password',['class'=>'form-control form-control','id'=>'current_password','placeholder'=>'Current Password','style'=>'width:80%','required'=>true])}}
                            @error('current_password')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('password') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('password','New Password:*',['class'=>''])}}
                            {{Form::password('password',['class'=>'form-control form-control','id'=>'password','placeholder'=>'New Password','style'=>'width:80%','required'=>true])}}
                            @error('password')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('password_confirmation') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('password_confirmation','Confirm Password:*',['class'=>''])}}
                            {{Form::password('password_confirmation',['class'=>'form-control form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password','style'=>'width:80%','required'=>true])}}
                            @error('password_confirmation')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('','',['class'=>'col-sm-7'])}}
                        <div class="col-sm-5">
                            {{Form::button("<i class='fa fa-paper-plane'></i> Update",['class'=>'btn btn-primary','type'=>'submit'])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>

                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-bold">Manage User Credential & Security</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body">
              <div class="row">
                <div class="col-md-6 border-right">
                  <h5 class="text-primary">Two Factor Authentication</h5>
                  <p class="text-sm">Add Aditional Security to your account using two factor authentication.</p>
                  <hr>
                  <div class="m-b-20">
                    @if (session('status')=='two-factor-authentication-enabled' ||
                    auth()->user()->two_factor_recovery_codes)
                    <p class="mb-4 font-strong">You have enabled 2FA, please scan the following QR code into
                        your phones authenticator application.</p>
                    <div class="d-flex justify-content-center">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    <p class="mt-4 font-strong">Please store these recovery code in secure place.</p>
                    <div class="d-flex justify-content-center">
                        @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes,true)) as
                        $code)
                        {{ trim($code) }} <br>
                        @endforeach
                    </div>
                    @endif

                    @if (auth()->user()->two_factor_secret)
                    <p class="mt-4 strong">You are enabled two factor authentication.</p>
                    {{Form::open(['url'=>url('user/two-factor-authentication'),'files'=>false,'class'=>'form'])}}
                    @method('delete')
                    @csrf
                    {{Form::button("Disable 2FA",['class'=>'btn btn-danger','type'=>'submit'])}}
                    {{ Form::close() }}
                    @else
                    <p class="mt-4 strong">You are not enabled two factor authentication</p>
                    {{Form::open(['url'=>url('user/two-factor-authentication'),'files'=>false,'class'=>'form'])}}
                    @csrf
                    {{Form::button("Enable 2FA",['class'=>'btn btn-success mb-3','type'=>'submit'])}}
                    {{ Form::close() }}
                    @endif
                </div>

                </div>
                <div class="col-md-6">
                  <h5 class="text-primary">Update Password</h5>
                  <p class="text-sm">Ensure your account is using a long random password to stay secure.</p>
                  <hr>
                  <div class="m-0">
                    {{Form::open(['url'=>route('update-password',auth()->user()->id),'files'=>true,'class'=>'form'])}}
                    @method('put')
                    <div class="form-group row @error('name') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('name','User Name:*',['class'=>''])}}
                            {{Form::text('name',@(auth()->user()->name),['class'=>'form-control form-control','id'=>'name','placeholder'=>'Email','required'=>true,'style'=>'width:80%'])}}
                            @error('name')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('current_password') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('current_password','Current Password:*',['class'=>''])}}
                            {{Form::password('current_password',['class'=>'form-control form-control','id'=>'current_password','placeholder'=>'Current Password','style'=>'width:80%','required'=>true])}}
                            @error('current_password')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('password') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('password','New Password:*',['class'=>''])}}
                            {{Form::password('password',['class'=>'form-control form-control','id'=>'password','placeholder'=>'New Password','style'=>'width:80%','required'=>true])}}
                            @error('password')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('password_confirmation') has-error @enderror">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-11">
                            {{Form::label('password_confirmation','Confirm Password:*',['class'=>''])}}
                            {{Form::password('password_confirmation',['class'=>'form-control form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password','style'=>'width:80%','required'=>true])}}
                            @error('password_confirmation')
                            <span class="help-block error"><small>{{$message}}</small></span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        {{Form::label('','',['class'=>'col-sm-7'])}}
                        <div class="col-sm-5">
                            {{Form::button("<i class='fa fa-paper-plane'></i> Update",['class'=>'btn btn-primary','type'=>'submit'])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>

                </div>
              </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection