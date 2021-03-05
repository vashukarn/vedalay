@extends('layouts.admin')
@section('title', request()->user()->roles->first()->name .' Dashboard')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                @role('Super Admin')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ @$usertotal->superadmincount }}</h3>
                            <p>Super Admin</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-admin"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endrole

                @hasanyrole('Super Admin|Admin')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ @$usertotal->admincount }}</h3>
                            <p>Admins</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endhasanyrole
                
                @can('teacher-list')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-navy">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$usertotal->teachercount }}</h3>
                            <p>Teachers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <a href="{{ route('teacher.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endcan
                
                @can('staff-list')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-warning">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$usertotal->staffcount }}</h3>
                            <p>Staffs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <a href="{{ route('staff.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endcan
                
                @can('student-list')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-primary">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$usertotal->studentcount }}</h3>
                            <p>Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-secondary">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$admissions }}</h3>
                            <p>Admissions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <a href="{{ route('admission') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endcan
                
                @hasanyrole('Teacher')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-primary">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$subjectcount }}</h3>
                            <p>Subjects</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-secondary">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$extraclass }}</h3>
                            <p>Extra Class Earnings</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                @endhasanyrole
                @hasanyrole('Staff')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-secondary">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$incentives }}</h3>
                            <p>Incentives till now</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                @endhasanyrole
                @hasanyrole('Teacher|Staff')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-success">
                        <div class="inner" style="color:#fff;">
                            <h3>Rs. {{ @$paidsalary }}</h3>
                            <p>Salary till now</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-warning">
                        <div class="inner" style="color:#fff;">
                            <h3>Rs. {{ @$advancesalary }}</h3>
                            <p>Advance Salary</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                @endhasanyrole
                @hasanyrole('Student')
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-warning">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$assignment }}</h3>
                            <p>Assignment</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="{{ route('assignment.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-info">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$attendance_percentage ? @$attendance_percentage.'%' : 'No Data' }}</h3>
                            <p>Attendance</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-success">
                        <div class="inner" style="color:#fff;">
                            <h3>Rs. {{ @$due_fee }}</h3>
                            <p>Due Fee Till Now</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        {{-- <a href="{{ route('student.index') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                @endhasanyrole
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="small-box bg-danger">
                        <div class="inner" style="color:#fff;">
                            <h3>{{ @$notices }}</h3>
                            <p>Visible Notices</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        {{-- <a href="{{ route('admission') }}" class="small-box-footer" color="#fff">More info <i
                                class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                 
            </div>

            {{-- <div class="card">
                <div class="row"  style="margin-bottom: 50px;">
                    <div class="col-md-6">
                        <div class="card-header" style="background-color: #374f65;">
                            <h3 class="card-title" style="color: azure;">Viewers</h3>
                        </div>
                        <div class="card-body card-format">
                            <canvas id="all-riding-request" height="280" width="600"></canvas>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-header" style="background-color: #374f65;">
                            <h3 class="card-title" style="color: azure;">Total News</h3>
                        </div>
                        <div class="card-body card-format">
                            <canvas id="hourly-complete-riding" height="280" width="600"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection
