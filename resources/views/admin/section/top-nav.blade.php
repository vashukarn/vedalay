        <nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <form class="form-inline ml-3 d-none d-sm-block">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge"><span class="update_notification">{{ @$notificaitoncount }}</span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header"> <span class="update_notification">{{ @$notificaitoncount }}</span> Notifications</span>

                        <div class="dropdown-divider"></div>
                        @foreach ($notification as $key => $item)
                            <a href="{{ $key }}">
                            <div class="m-3">
                                <i class='fa fa-paper-plane'></i> &nbsp; {{ $item }}
                            </div>
                            </a>
                        @endforeach

                    <span class="dropdown-footer"> <a href="{{ route('clearNotification', Auth::user()->id) }}"> Clear All Notifications <i class="ml-2 fas fa-trash"></i></a> </span>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}" target="_banner" role="button">
                        <i class="fas fa-globe-asia"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link pl-0" data-toggle="dropdown" href="#">
                        <span>{{ auth()->user()->name }} <i class="fas fa-angle-down fa-xs pl-1"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <a href="{{ route('profiledetail') }}" class="dropdown-item pl-3 href="" class="">
                            <i class=" fas fa-user pr-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        @hasrole('Super Admin')
                        <a href="{{ route('setting.index') }}" class="dropdown-item pl-3" type="button"> <i class="fas fa-cog pr-1"></i>Settings</a>
                        <div class="dropdown-divider"></div>
                        @endhasrole
                        <a class="dropdown-item pl-3" href="{{ route('user.logout') }}" title="Logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="fa fa-power-off pr-1"></i> Logout</a>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

                </li>
            </ul>
        </nav>
