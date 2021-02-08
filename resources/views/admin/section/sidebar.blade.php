<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link" style="background-color:#374f65">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
                            Admin Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header">WEB CONTENT</li>
               @if(in_array('slider', $app_content))
                @canany(['slider-list','slider-create','slider-edit','slider-delete'])
                <li class="nav-item">
                    <a href="{{ route('slider.index') }}" class="nav-link {{ request()->is('admin/slider*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>Slider</p>
                    </a>
                </li>
                @endcanany
                @endif 
                @if(in_array('information', $app_content))
                @canany(['information-list','information-create','information-edit','information-delete'])
                <li class="nav-item">
                    <a href="{{ route('information.index') }}" class="nav-link {{ request()->is('admin/information*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Information</p>
                    </a>
                </li>
                @endcanany
                @endif 
                @if(in_array('features', $app_content))
                @canany(['feature-list','feature-create','feature-edit','feature-delete'])
                <li class="nav-item">
                    <a href="{{ route('feature.index') }}" class="nav-link {{ request()->is('admin/feature*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Features</p>
                    </a>
                </li>
                @endcanany
                @endif 
                @if(in_array('testimonial', $app_content))
                @canany(['testimonial-list','testimonial-create','testimonial-edit','testimonial-delete'])
                <li class="nav-item">
                    <a href="{{ route('testimonial.index') }}" class="nav-link {{ request()->is('admin/testimonial*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Testimonials</p>
                    </a>
                </li>
                @endcanany
                @endif 
                @if(in_array('news', $app_content))
                <li class="nav-item has-treeview {{ request()->is('admin/news*') || request()->is('admin/tag*') ?'menu-open':'' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/news*')  ||  request()->is('admin/tag*')?'active':'' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            News  Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @canany(['tag-list','tag-create','tag-edit','tag-delete'])
                        <li class="nav-item">
                            <a href="{{ route('tag.index') }}" class="nav-link {{ request()->is('admin/tag*') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        @endcanany
                        @can('menu-create')
                        <li class="nav-item">
                            <a href="{{ route('news.index') }}" class="nav-link {{ request()->is('admin/news') ? 'active' : '' }}">
                              <i class="fas fa-list nav-icon"></i>
                                <p>News List</p>
                            </a>
                        </li>
                        @endcan
                        @canany(['menu-list', 'menu-create','menu-edit','menu-delete'])
                        <li class="nav-item">
                            <a href="{{ route('news.create') }}" class="nav-link {{ (request()->is('admin/news/create')&&!request()->is('admin/news/create'))?'active':'' }}">
                              <i class="fas fa-list nav-icon"></i>
                                <p>Add News</p>
                            </a>
                        </li>
                        @endcanany
                    </ul>
                </li>
                @endif 
                @if(in_array('faq', $app_content))
                @canany(['faq-list','faq-create','faq-edit','faq-delete'])
                <li class="nav-item">
                    <a href="{{ route('faq.index') }}" class="nav-link {{ request()->is('admin/faq*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Faq</p>
                    </a>
                </li>
                @endcanany
                @endif 

               
                @if(in_array('blogs', $app_content))
                @canany(['blog-list','blog-create','blog-edit','blog-delete'])
                <li class="nav-item">
                    <a href="{{ route('blog.index') }}" class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-clone"></i>
                        <p>Blogs</p>
                    </a>
                </li>
                @endcanany
                @endif 
                @if(in_array('contact', $app_content))
                @canany(['contact-list','contact-view','contact-edit','contact-delete'])
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa fa-user-circle"></i>
                        <p>Contact</p>
                    </a>
                </li>
                @endcanany
                @endif 
                
                @if(in_array('reporter', $app_content))
                <li class="nav-header">APP SETTINGS</li>
                {{-- @canany(['menu-list', 'menu-create','menu-edit','menu-delete']) --}}
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link {{ (request()->is('admin/profile*')&&!request()->is('admin/menu/create'))?'active':'' }}">
                      <i class="fas fa-microphone nav-icon"></i>
                        <p>Reporter List</p>
                    </a>
                </li>
                @endif 
                {{-- @endcanany --}}
                @hasanyrole('Super Admin')
                @if(in_array('user', $app_content))
                @canany(['user-list',
                'user-create','user-edit','user-delete','role-list','role-create','role-edit','role-delete'])
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
                @endif 
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
                        <li class="nav-item">
                            <a href="{{ route('websiteContentFormat') }}" class="nav-link">
                                <i class="fas fa-cogs nav-icon"></i>
                                <p>Website Content Format </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('websiteContent') }}" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Website Content </p>
                            </a>
                        </li>
                           

                    </ul>
                </li>
                @endhasallroles
            </ul>
        </nav>
    </div>
</aside>
