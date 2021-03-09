<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link" style="background-color:#374f65">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="Guru Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ @$sitesetting->name ?? env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-0 mb-3 d-flex">
            <div class="image">
                <a href="" class="">
                    <img src="{{ asset('img/AdminLTELogo.png') }}" class="img-circle elevation-2" alt="User Image">
                </a>
            </div>
            <div class="info">
                <a href="{{ route('dashboard.index') }}" class="d-block">{{ auth()->user()->name }}<br>
                    <small>{{ request()->user()->roles->first()->name }}</small></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ request()->user()->roles->first()->name }} Dashboard
                        </p>
                    </a>
                </li>

                @canany([
                'student-list', 'student-create','student-edit','student-delete',
                'teacher-list', 'teacher-create','teacher-edit','teacher-delete',
                'staff-list', 'staff-create','staff-edit','staff-delete'
                ])
                <li class="nav-header">USER MANAGEMENT</li>
                @endcanany
                @canany(['student-list', 'student-create','student-edit','student-delete'])
                <li
                    class="nav-item has-treeview {{ request()->is('user/student*') || request()->is('user/admission*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('user/student*') || request()->is('user/admission*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Student Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('student-create')
                            <li class="nav-item">
                                <a href="{{ route('student.create') }}"
                                    class="nav-link  {{ request()->is('user/student/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Student</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('student.index') }}"
                                class="nav-link {{ request()->is('user/student') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Students List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admission') }}"
                                class="nav-link {{ request()->is('user/admission') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Admission List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['teacher-list', 'teacher-create','teacher-edit','teacher-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/teacher*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/teacher*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Teacher Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('teacher-create')
                            <li class="nav-item">
                                <a href="{{ route('teacher.create') }}"
                                    class="nav-link  {{ request()->is('user/teacher/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Teacher</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('teacher.index') }}"
                                class="nav-link {{ request()->is('user/teacher') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Teachers List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['staff-list', 'staff-create','staff-edit','staff-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/staff*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/staff*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Staff Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('staff-create')
                            <li class="nav-item">
                                <a href="{{ route('staff.create') }}"
                                    class="nav-link  {{ request()->is('user/staff/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Staff</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('staff.index') }}"
                                class="nav-link {{ request()->is('user/staff') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Staff List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['vacancy-list', 'vacancy-create','vacancy-edit','vacancy-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/vacancy*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/vacancy*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-badge"></i>
                        <p>
                            Vacancy Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('vacancy-create')
                            <li class="nav-item">
                                <a href="{{ route('vacancy.create') }}"
                                    class="nav-link  {{ request()->is('user/vacancy/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Vacancy</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('vacancy.index') }}"
                                class="nav-link {{ request()->is('user/vacancy') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Vacancy List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany([
                'subject-list', 'subject-create','subject-edit','subject-delete',
                'fee-list', 'fee-create','fee-edit','fee-delete',
                'salary-list', 'salary-create','salary-edit','salary-delete',
                'attendance-list', 'attendance-create','attendance-edit','attendance-delete',
                'exam-list', 'exam-create','exam-edit','exam-delete',
                'result-list', 'result-create','exam-edit','exam-delete',
                ])
                <li class="nav-header">ACADEMICS MANAGEMENT</li>
                @endcanany
                @canany(['subject-list', 'subject-create','subject-edit','subject-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/subject*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/subject*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Subject Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('subject-create')
                            <li class="nav-item">
                                <a href="{{ route('subject.create') }}"
                                    class="nav-link  {{ request()->is('user/subject/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Subject</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('subject.index') }}"
                                class="nav-link {{ request()->is('user/subject') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Subject List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['fee-list', 'fee-create','fee-edit','fee-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/fee*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/fee*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Fee Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('fee-create')
                            <li class="nav-item">
                                <a href="{{ route('fee.create') }}"
                                    class="nav-link  {{ request()->is('user/fee/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Fee</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('fee.index') }}"
                                class="nav-link {{ request()->is('user/fee') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Fee Addition List</p>
                            </a>
                        </li>
                        @can('feepayment-create')
                            <li class="nav-item">
                                <a href="{{ route('feepayment.create') }}"
                                    class="nav-link  {{ request()->is('user/feepayment/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Pay Fee</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('feepayment.index') }}"
                                class="nav-link {{ request()->is('user/feepayment') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Fee Payments</p>
                            </a>
                        </li>
                        {{-- @canany(['feeadvance-list', 'feeadvance-create','feeadvance-edit','feeadvance-delete'])
                        <li class="nav-item">
                            <a href="{{ route('feeadvance.index') }}"
                                class="nav-link {{ request()->is('user/feeadvance') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Advance Fee</p>
                            </a>
                        </li>
                        @endcanany --}}
                    </ul>
                </li>
                @endcanany

                @canany(['salary-list', 'salary-create','salary-edit','salary-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/salary*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/salary*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Salary Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('salary-create')
                            <li class="nav-item">
                                <a href="{{ route('salary.create') }}"
                                    class="nav-link  {{ request()->is('user/salary/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Salary</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('salary.index') }}"
                                class="nav-link {{ request()->is('user/salary') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Salary Addition List</p>
                            </a>
                        </li>
                        @canany(['advancesalary-list',
                        'advancesalary-create','advancesalary-edit','advancesalary-delete'])
                        <li class="nav-item">
                            <a href="{{ route('advancesalary.index') }}"
                                class="nav-link {{ request()->is('user/advancesalary') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Advance Salary List</p>
                            </a>
                        </li>
                        @endcanany
                    </ul>
                </li>
                @endcanany

                @canany(['noticeboard-list', 'noticeboard-create','noticeboard-edit','noticeboard-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/noticeboard*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/noticeboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                            Notice Board Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('noticeboard-create')
                            <li class="nav-item">
                                <a href="{{ route('noticeboard.create') }}"
                                    class="nav-link  {{ request()->is('user/noticeboard/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Notice Board</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('noticeboard.index') }}"
                                class="nav-link {{ request()->is('user/noticeboard') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Notice Board List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['attendance-list','attendance-create','attendance-edit','attendance-delete'])
                <li
                    class="nav-item has-treeview {{ request()->is('user/attendance*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('user/attendance*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Attendance Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (isset($subjects))
                            @hasanyrole('Teacher')
                            @foreach ($subjects as $key => $item)
                                <li class="nav-item">
                                    <a href="{{ route('attendance.show', $key) }}"
                                        class="nav-link {{ request()->is('user/attendance/' . $key) ? 'active' : '' }}">
                                        <i class="fas fa-archive nav-icon"></i>
                                        <p>{{ $item }}</p>
                                    </a>
                                </li>
                            @endforeach
                            @endhasanyrole
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('attendance.index') }}"
                                class="nav-link {{ request()->is('user/attendance') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Attendance List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['assignment-list','assignment-create','assignment-edit','assignment-delete'])
                <li
                    class="nav-item has-treeview {{ request()->is('user/assignment*') || request()->is('user/takeassignment*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('user/assignment*') || request()->is('user/takeassignment*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Assignment Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (isset($subjects))
                            @hasanyrole('Teacher')
                            @foreach ($subjects as $key => $item)
                                <li class="nav-item">
                                    <a href="{{ route('assignment.show', $key) }}"
                                        class="nav-link {{ request()->is('user/assignment/' . $key) ? 'active' : '' }}">
                                        <i class="fas fa-book-open nav-icon"></i>
                                        <p>{{ $item }}</p>
                                    </a>
                                </li>
                            @endforeach
                            @endhasanyrole
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('assignment.index') }}"
                                class="nav-link {{ request()->is('user/assignment') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Assignment List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany


                @canany(['exam-list', 'exam-create','exam-edit','exam-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/exam*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/exam*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-diagnoses"></i>
                        <p>
                            Exam Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('exam-create')
                            <li class="nav-item">
                                <a href="{{ route('exam.create') }}"
                                    class="nav-link  {{ request()->is('user/exam/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Exam</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('exam.index') }}"
                                class="nav-link {{ request()->is('user/exam') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Exam List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['result-list', 'result-create','result-edit','result-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/result*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/result*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-poll-h"></i>
                        <p>
                            Result Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('result-create')
                            <li class="nav-item">
                                <a href="{{ route('result.create') }}"
                                    class="nav-link  {{ request()->is('user/result/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Result</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('result.index') }}"
                                class="nav-link {{ request()->is('user/result') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Results List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                @canany(['expense-list', 'expense-create','expense-edit','expense-delete'])
                <li class="nav-item has-treeview {{ request()->is('user/expense*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/expense*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            Expense Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('expense-create')
                            <li class="nav-item">
                                <a href="{{ route('expense.create') }}"
                                    class="nav-link  {{ request()->is('user/expense/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Expense</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('expense.index') }}"
                                class="nav-link {{ request()->is('user/expense') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Expenses List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['session-list', 'session-create','session-edit','session-delete'])
                <li class="nav-item">
                    <a href="{{ route('session.index') }}"
                        class="nav-link {{ request()->is('user/session') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Session Management</p>
                    </a>
                </li>
                @endcanany
                @canany(['level-list', 'level-create','level-edit','level-delete'])
                <li class="nav-item">
                    <a href="{{ route('level.index') }}"
                        class="nav-link {{ request()->is('user/level') ? 'active' : '' }}">
                        <i class="fas fa-list nav-icon"></i>
                        <p>Level/Class Management</p>
                    </a>
                </li>
                @endcanany

                @hasanyrole('Super Admin')
                <li class="nav-header">WEB CONTENT</li>
                <li class="nav-item">
                    <a href="{{ route('homepage.index') }}"
                        class="nav-link {{ request()->is('user/homepage*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Homepage Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('slider.index') }}"
                        class="nav-link {{ request()->is('user/slider*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>Slider</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('information.index') }}"
                        class="nav-link {{ request()->is('user/information*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Information</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('feature.index') }}"
                        class="nav-link {{ request()->is('user/feature*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Features</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('testimonial.index') }}"
                        class="nav-link {{ request()->is('user/testimonial*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Testimonials</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq.index') }}"
                        class="nav-link {{ request()->is('user/faq*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Faq</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('blog.index') }}"
                        class="nav-link {{ request()->is('user/blog*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-clone"></i>
                        <p>Blogs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('team.index') }}"
                        class="nav-link {{ request()->is('user/team*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-users-cog"></i>
                        <p>Team</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}"
                        class="nav-link {{ request()->is('user/contact*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-user-circle"></i>
                        <p>Contact Form</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('newsletter.index') }}"
                        class="nav-link {{ request()->is('newsletter*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-newspaper"></i>
                        <p>Newsletter Requests</p>
                    </a>
                </li>

                <li class="nav-header">APP SETTINGS</li>
                <li
                    class="nav-item has-treeview {{ request()->is('user/users*') || request()->is('user/roles*') || request()->is('user/user-log') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('user/users*') || request()->is('user/roles*') || request()->is('user/user-log') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}"
                                class="nav-link  {{ request()->is('user/users/create') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add New User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ request()->is('user/users') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->is('user/roles*') ? 'active' : '' }}">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>Roles & Permission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user-log.index') }}"
                                class="nav-link {{ request()->is('user/user-log') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>User Activity Log</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('user/menu*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('user/menu*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('menu.create') }}"
                                class="nav-link {{ request()->is('user/menu/create') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add New Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('menu.index') }}"
                                class="nav-link {{ request()->is('user/menu*') && !request()->is('user/menu/create') ? 'active' : '' }}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Menu List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->is('user/setting*') || request()->is('user/cities') || request()->is('user/vehicletype') || request()->is('user/ridingcost') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('user/setting*') || request()->is('user/cities') || request()->is('user/vehicletype') || request()->is('user/ridingcost') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            General Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('setting.index') }}"
                                class="nav-link {{ request()->is('user/setting') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>App Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasallroles
            </ul>
        </nav>
    </div>
</aside>
