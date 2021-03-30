@extends('layouts.admin')
@section('title',
    request()
    ->user()
    ->roles->first()->name . ' Dashboard',)
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        @role('Super Admin|Admin')
        <script src="{{ asset('/custom/adminchartdata.js') }}"></script>
        @endrole
        @role('Student')
        <script src="{{ asset('/custom/studentchartdata.js') }}"></script>
        @endrole
    @endpush
@section('content')
    @role('Super Admin|Admin')
    <meta name="expenseIncomeChart" content="{{ route('chart.incomeexpense') }}">
    @endrole
    @role('Student')
    {{-- <meta name="expenseIncomeChart" content="{{ route('attendacneChart') }}"> --}}
    @endrole
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
                @endrole
                @role('Teacher|Staff|Student|Admin')
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
                @endrole
                @role('Teacher')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-book"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Subjects</span>
                            <span class="info-box-number">
                                {{ @$subjectcount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-rupee-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Extra Class Earnings</span>
                            <span class="info-box-number">
                                Rs. {{ @$extraclass }}
                            </span>
                        </div>
                    </div>
                </div>
                @endrole
                @role('Staff')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-rupee-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Incentives</span>
                            <span class="info-box-number">
                                Rs. {{ @$incentives }}
                            </span>
                        </div>
                    </div>
                </div>
                @endrole
                @role('Teacher|Staff')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-rupee-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Salary Recieved</span>
                            <span class="info-box-number">
                                Rs. {{ @$paidsalary }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-light elevation-1"><i class="fas fa-rupee-sign"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Advance Salary Recieved</span>
                            <span class="info-box-number">
                                Rs. {{ @$advancesalary }}
                            </span>
                        </div>
                    </div>
                </div>
                @endrole
                @role('Student')
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Assignment</span>
                            <a href="{{ route('assignment.index') }}">
                                <span class="info-box-number">
                                    {{ @$assignment }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Attendance</span>
                            <span class="info-box-number">
                                {{ @$attendance_percentage ? @$attendance_percentage . '%' : 'No Data Yet' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-rupee-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Due Fee</span>
                            <span class="info-box-number">
                                Rs. {{ @$due_fee }}
                            </span>
                        </div>
                    </div>
                </div>
                @endrole
                @role('Super Admin|Admin')
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
                                <div class="col-md-4">
                                    <p class="text-center">
                                        <strong>Attendance Report</strong>
                                    </p>
                                    @isset($attendancetoday)
                                        <div class="progress-group">
                                            Present Attendents (Today)
                                            <span
                                                class="float-right"><b>{{ $attendancetoday['present'] }}</b>/{{ $attendancetoday['total'] }}</span>
                                            <div class="progress progress-sm">
                                                @if ($attendancetoday['total'] != 0)
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ ($attendancetoday['present'] * 100) / $attendancetoday['total'] }}%">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Absent Attendents (Today)
                                            <span
                                                class="float-right"><b>{{ $attendancetoday['absent'] }}</b>/{{ $attendancetoday['total'] }}</span>
                                            <div class="progress progress-sm">
                                                @if ($attendancetoday['total'] != 0)
                                                    <div class="progress-bar bg-danger"
                                                        style="width: {{ ($attendancetoday['absent'] * 100) / $attendancetoday['total'] }}%">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endisset

                                    @isset($attendanceall)
                                        <div class="progress-group">
                                            <span class="progress-text">Total Present Attendents (Month)</span>
                                            <span
                                                class="float-right"><b>{{ $attendanceall['present'] }}</b>/{{ $attendanceall['total'] }}</span>
                                            <div class="progress progress-sm">
                                                @if ($attendanceall['total'] != 0)
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ ($attendanceall['absent'] * 100) / $attendanceall['total'] ?? 0 }}%">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            Total Absent Attendents (Month)
                                            <span
                                                class="float-right"><b>{{ $attendanceall['present'] }}</b>/{{ $attendanceall['total'] }}</span>
                                            <div class="progress progress-sm">
                                                @if ($attendanceall['total'] != 0)
                                                    <div class="progress-bar bg-warning"
                                                        style="width: {{ ($attendanceall['absent'] * 100) / $attendanceall['total'] }}%">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
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
                            <h3 class="card-title">New Admissions
                                ({{ date_format(date_create(date('Y-m-d')), 'M') }})
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
            </div>

        </div>
    </div>
@endsection
