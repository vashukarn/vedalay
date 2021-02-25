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
                <li class="nav-item has-treeview {{ request()->is('admin/student*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/student*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/student/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Student</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('student.index') }}"
                                class="nav-link {{ request()->is('admin/student') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Students List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['teacher-list', 'teacher-create','teacher-edit','teacher-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/teacher*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/teacher*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/teacher/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Teacher</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('teacher.index') }}"
                                class="nav-link {{ request()->is('admin/teacher') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Teachers List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                
                @canany(['staff-list', 'staff-create','staff-edit','staff-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/staff*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/staff*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/staff/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Staff</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('staff.index') }}"
                                class="nav-link {{ request()->is('admin/staff') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Staff List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                
                @canany(['vacancy-list', 'vacancy-create','vacancy-edit','vacancy-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/vacancy*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/vacancy*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/vacancy/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Vacancy</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('vacancy.index') }}"
                                class="nav-link {{ request()->is('admin/vacancy') ? 'active' : '' }}">
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
                    'attendacemanagement-list', 'attendacemanagement-create','attendacemanagement-edit','attendacemanagement-delete',
                    'attendace-list', 'attendace-create','attendace-edit','attendace-delete',
                    'exam-list', 'exam-create','exam-edit','exam-delete',
                    'result-list', 'result-create','exam-edit','exam-delete',
                    ])
                <li class="nav-header">ACADEMICS MANAGEMENT</li>
                @endcanany
                @canany(['subject-list', 'subject-create','subject-edit','subject-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/subject*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/subject*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/subject/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New Subject</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('subject.index') }}"
                                class="nav-link {{ request()->is('admin/subject') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Subject List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['fee-list', 'fee-create','fee-edit','fee-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/fee*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/fee*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/fee/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Fee</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('fee.index') }}"
                                class="nav-link {{ request()->is('admin/fee') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Fee Addition List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                
                @canany(['salary-list', 'salary-create','salary-edit','salary-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/salary*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/salary*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/salary/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Salary</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('salary.index') }}"
                                class="nav-link {{ request()->is('admin/salary') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Salary Addition List</p>
                            </a>
                        </li>
                        @canany(['advancesalary-list', 'advancesalary-create','advancesalary-edit','advancesalary-delete'])
                        <li class="nav-item">
                            <a href="{{ route('advancesalary.index') }}"
                            class="nav-link {{ request()->is('admin/advancesalary') ? 'active' : '' }}">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Advance Salary List</p>
                        </a>
                    </li>
                    @endcanany
                </ul>
            </li>
            @endcanany

                @canany(['attendancemanagement-list', 'attendancemanagement-create','attendancemanagement-edit','attendancemanagement-delete','attendance-list', 'attendance-create','attendance-edit','attendance-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/attendance*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/attendance*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Attendance Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @canany(['attendancemanagement-list', 'attendancemanagement-create','attendancemanagement-edit','attendancemanagement-delete'])
                        <li class="nav-item">
                            <a href="{{ route('attendance.index') }}"
                                class="nav-link {{ request()->is('admin/attendance') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Attendance List</p>
                            </a>
                        </li>
                        @endcanany
                        {{-- @can('staffattendance-create')
                            <li class="nav-item">
                                <a href="{{ route('staffattendance.create') }}"
                                    class="nav-link  {{ request()->is('admin/staffattendance/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Mark Employee Attendance</p>
                                </a>
                            </li>
                        @endcan
                        @canany(['staffattendance-list', 'staffattendance-create','staffattendance-edit','staffattendance-delete'])
                        <li class="nav-item">
                            <a href="{{ route('staffattendance.index') }}"
                                class="nav-link {{ request()->is('admin/staffattendance') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Employee Attendance List</p>
                            </a>
                        </li>
                        @endcanany --}}
                        @canany(['attendance-list', 'attendance-create','attendance-edit','attendance-delete'])
                        @if(isset($subjects))
                        @foreach ($subjects as $key => $item)
                        <li class="nav-item">
                            <a href="{{ route('takeAttendance', $key) }}"
                                class="nav-link {{ request()->is('admin/attendance') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>{{ $item }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('attendanceList', $key) }}"
                                class="nav-link {{ request()->is('admin/attendance') ? 'active' : '' }}">
                                <i class="fas fa-archive nav-icon"></i>
                                <p>{{ $item }} Summary</p>
                            </a>
                        </li>
                        @endforeach
                        @endif
                        @endcanany
                    </ul>
                </li>
                @endcanany

                @canany(['exam-list', 'exam-create','exam-edit','exam-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/exam*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/exam*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/exam/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Exam</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('exam.index') }}"
                                class="nav-link {{ request()->is('admin/exam') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Exam List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany(['result-list', 'result-create','result-edit','result-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/result*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/result*') ? 'active' : '' }}">
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
                                    class="nav-link  {{ request()->is('admin/result/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Result</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('result.index') }}"
                                class="nav-link {{ request()->is('admin/result') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Results List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                @canany([
                    'slider-list','slider-create','slider-edit','slider-delete',
                    'information-list','information-create','information-edit','information-delete',
                    'feature-list','feature-create','information-edit','information-delete',
                    'testimonial-list','testimonial-create','information-edit','information-delete',
                    'faq-list','faq-create','information-edit','information-delete',
                    'blog-list','blog-create','information-edit','information-delete',
                    'contact-list','contact-create','information-edit','information-delete',
                    ])
                <li class="nav-header">WEB CONTENT</li>
                @endcanany
                <li class="nav-item has-treeview {{ request()->is('admin/result*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/result*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-poll-h"></i>
                        <p>
                            Page Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('homepage-edit')
                        <li class="nav-item">
                            <a href="{{ route('homepage.index') }}" class="nav-link {{ request()->is('admin/slider*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>Home Page Details</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @canany(['slider-list','slider-create','slider-edit','slider-delete'])
                <li class="nav-item">
                    <a href="{{ route('slider.index') }}" class="nav-link {{ request()->is('admin/slider*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>Slider</p>
                    </a>
                </li>
                @endcanany
                @canany(['information-list','information-create','information-edit','information-delete'])
                <li class="nav-item">
                    <a href="{{ route('information.index') }}" class="nav-link {{ request()->is('admin/information*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Information</p>
                    </a>
                </li>
                @endcanany
                @canany(['feature-list','feature-create','feature-edit','feature-delete'])
                <li class="nav-item">
                    <a href="{{ route('feature.index') }}" class="nav-link {{ request()->is('admin/feature*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Features</p>
                    </a>
                </li>
                @endcanany
                @canany(['testimonial-list','testimonial-create','testimonial-edit','testimonial-delete'])
                <li class="nav-item">
                    <a href="{{ route('testimonial.index') }}" class="nav-link {{ request()->is('admin/testimonial*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Testimonials</p>
                    </a>
                </li>
                @endcanany
                @canany(['faq-list','faq-create','faq-edit','faq-delete'])
                <li class="nav-item">
                    <a href="{{ route('faq.index') }}" class="nav-link {{ request()->is('admin/faq*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Faq</p>
                    </a>
                </li>
                @endcanany
                @canany(['blog-list','blog-create','blog-edit','blog-delete'])
                <li class="nav-item">
                    <a href="{{ route('blog.index') }}" class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-clone"></i>
                        <p>Blogs</p>
                    </a>
                </li>
                @endcanany
                @canany(['contact-list','contact-view','contact-edit','contact-delete'])
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-user-circle"></i>
                        <p>Contact</p>
                    </a>
                </li>
                @endcanany
                @hasanyrole('Super Admin')
                <li class="nav-header">APP SETTINGS</li>
                @endhasanyrole
                @hasanyrole('Super Admin')
                @canany(['user-list','user-create','user-edit','user-delete','role-list','role-create','role-edit','role-delete'])
                <li
                    class="nav-item has-treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') ||request()->is('admin/user-log') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/user-log') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user-create')
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}"
                                    class="nav-link  {{ request()->is('admin/users/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add New User</p>
                                </a>
                            </li>
                        @endcan
                        @canany(['user-list', 'user-create','user-edit','user-delete'])
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}"
                                class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users List</p>
                            </a>
                        </li>
                        @endcanany
                        @canany(['role-list','role-create','role-edit','role-delete'])
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}"
                                class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>Roles & Permission</p>
                            </a>
                        </li>
                        @endcanany
                        <li class="nav-item">
                            <a href="{{ route('user-log.index') }}" class="nav-link {{ request()->is('admin/user-log')?'active':'' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>User Activity Log</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
                @canany(['menu-list', 'menu-create','menu-edit','menu-delete'])
                <li class="nav-item has-treeview {{ request()->is('admin/menu*') ?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/menu*') ?'active':'' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('menu-create')
                        <li class="nav-item">
                            <a href="{{ route('menu.create') }}" class="nav-link {{ request()->is('admin/menu/create')?'active':'' }}">
                              <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add New Menu</p>
                            </a>
                        </li>
                        @endcan
                        @canany(['menu-list', 'menu-create','menu-edit','menu-delete'])
                        <li class="nav-item">
                            <a href="{{ route('menu.index') }}" class="nav-link {{ (request()->is('admin/menu*')&&!request()->is('admin/menu/create'))?'active':'' }}">
                              <i class="fas fa-bars nav-icon"></i>
                                <p>Menu List</p>
                            </a>
                        </li>
                        @endcanany
                    </ul>
                </li>
                @endcanany
                @endhasallroles

                @hasanyrole('Super Admin')
                <li class="nav-item has-treeview {{ request()->is('admin/setting*')||request()->is('admin/cities') ||request()->is('admin/vehicletype') ||request()->is('admin/ridingcost') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/setting*') ||request()->is('admin/cities') ||request()->is('admin/vehicletype') ||request()->is('admin/ridingcost') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            General Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('setting.index') }}"
                                class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}">
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
