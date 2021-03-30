@extends('layouts.admin')
@section('title',
    request()
    ->user()
    ->roles->first()->name . ' Dashboard',)
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="{{ asset('/custom/chartdata.js') }}"></script>
    @endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                @role('Super Admin')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Super Admin Count</span>
                            <span class="info-box-number">
                                {{ @$usertotal->superadmincount }}
                            </span>
                        </div>
                    </div>
                </div>
                @endrole
                @role('Super Admin|Admin')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Admin Count</span>
                            <span class="info-box-number">
                                {{ @$usertotal->admincount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Teacher Count</span>
                            <span class="info-box-number">
                                {{ @$usertotal->teachercount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-id-card"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Staff Count</span>
                            <span class="info-box-number">
                                {{ @$usertotal->staffcount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Student Count</span>
                            <span class="info-box-number">
                                {{ @$usertotal->studentcount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Admissions
                                ({{ date_format(date_create(date('Y-m-d')), 'M') }})</span>
                            <span class="info-box-number">
                                {{ count(@$admission) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-muted elevation-1"><i class="fas fa-clipboard"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Notices</span>
                            <span class="info-box-number">
                                {{ @$notices }}
                            </span>
                        </div>
                    </div>
                </div>
                @hasanyrole('Teacher|Staff|Student|Admin')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-day"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Granted Leaves
                                ({{ date_format(date_create(date('Y-m-d')), 'M') }})</span>
                            <span class="info-box-number">
                                {{ @$leaves }}
                            </span>
                        </div>
                    </div>
                </div>
                @endhasanyrole
                {{-- {{ dd($month) }} --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Monthly Report</h5>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-center">
                                        <strong>Earning/Expenditure: ({{ date('Y') }})</strong>
                                    </p>

                                    <div class="chart">
                                        <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Goal Completion</strong>
                                    </p>

                                    <div class="progress-group">
                                        Add Products to Cart
                                        <span class="float-right"><b>160</b>/200</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->

                                    <div class="progress-group">
                                        Complete Purchase
                                        <span class="float-right"><b>310</b>/400</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger" style="width: 75%"></div>
                                        </div>
                                    </div>

                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        <span class="progress-text">Visit Premium Page</span>
                                        <span class="float-right"><b>480</b>/800</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width: 60%"></div>
                                        </div>
                                    </div>

                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                        Send Inquiries
                                        <span class="float-right"><b>250</b>/500</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-3 col-6">
                                    <div id="incomedifference" class="description-block border-right">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div id="expensedifference" class="description-block border-right">
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div id="yearincome" class="description-block border-right">
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 col-6">
                                    <div id="yearexpense" class="description-block">
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Admissions ({{ date_format(date_create(date('Y-m-d')), 'M') }})
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-danger">{{ count(@$admission) }} New
                                    {{ count(@$admission) > 1 ? 'Admissions' : 'Admission' }}</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                @foreach ($admission as $key => $item)
                                    <li>
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }} Image">
                                        <a class="users-list-name"
                                            href="{{ route('admissionshow', @$key) }}">{{ $item['name'] }}</a>
                                        <span
                                            class="users-list-date">{{ ReadableDate($item['join_date'], 'all') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('admission') }}">View All Users</a>
                        </div>
                    </div>
                </div>
                @endrole

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
                            <h3>{{ @$attendance_percentage ? @$attendance_percentage . '%' : 'No Data' }}</h3>
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

            </div>

        </div>
    </div>
@endsection
