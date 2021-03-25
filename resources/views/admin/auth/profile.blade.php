@extends('layouts.admin')
@section('title', 'Update Profile')
@section('content')
    <section class="content-header mt-0 pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid img-circle"
                                    src="@isset($student_info->image) {{ $student_info->image }} @else {{ asset('img/AdminLTELogo.png') }} @endisset"
                                    style="width:80px" alt="User profile picture">
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
                                    <b>Razorpay Status:</b> <a
                                        class="float-right">{{ GETAPPSETTING()['razorpay_payment'] }}</a>
                                </li>
                                @endhasrole
                                @hasrole('Student')
                                <li class="list-group-item">
                                    <b>Level/Class</b> <a class="float-right">{{ @$levels[$student_info->level_id] }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Date of Birth</b> <a
                                        class="float-right">{{ ReadableDate(@$student_info->dob, 'ymd') }}</a>
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
                                    <b>Joining Date</b> <a
                                        class="float-right">{{ ReadableDate(@$teacher_info->joining_date, 'ymd') }}</a>
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

            </div>
        </div>

        </div>
        </div>
    </section>
@endsection
