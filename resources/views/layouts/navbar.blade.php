@if (Auth::id())
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
        <!--left-fixed -navigation-->
        <aside class="sidebar-left">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                        aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h1>
                        <a class="navbar-brand" href="{{ route('home') }}"><span class="fa fa-area-chart"></span>
                            Manager<span class="dashboard_text">Dashboard</span></a>
                    </h1>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                    </ul>
                    <ul style=" 
                        height: 600px;
                        width: 100%;
                        overflow-x: hidden;
                        overflow-y: auto;
                        scrollbar-width: thin;
                        scrollbar-color: rgb(228, 169, 61) rgb(32, 32, 32);"
                        class="sidebar-menu">
                        <li class="treeview">
                            <a href="{{ route('home') }}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        @php
                            $segment = Request::segment(2);
                        @endphp
                        @can('update info')
                            <li class="treeview {{ $segment == 'info' ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-genderless"></i>
                                    <span>Info Web</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ route('info-web.create') }}"><i class="fa fa-angle-right"></i>
                                            Update Info</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        <li class="treeview {{ $segment == 'category' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Categorys Movies</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('category.index') }}"><i class="fa fa-angle-right"></i> List
                                        Categorys</a>
                                </li>
                                <li>
                                    <a href="{{ route('category.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Category</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'country' ? 'active' : '' }} ">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Countrys Movies</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu ">
                                <li>
                                    <a href="{{ route('country.index') }}"><i class="fa fa-angle-right"></i> List
                                        Countrys</a>
                                </li>
                                <li>
                                    <a href="{{ route('country.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Country</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'genre' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Genres Movies</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('genre.index') }}"><i class="fa fa-angle-right"></i> List
                                        Genres</a>
                                </li>
                                <li>
                                    <a href="{{ route('genre.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Genre</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'movie' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Movies</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('movie.index') }}"><i class="fa fa-angle-right"></i> List
                                        Movies</a>
                                </li>
                                <li>
                                    <a href="{{ route('movie.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Movie</a>
                                </li>
                                <li>
                                    <a href="{{ route('get_api_ophim') }}"><i class="fa fa-angle-right"></i>
                                        Api Movie</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'episode' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Episode</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('episode.index') }}"><i class="fa fa-angle-right"></i> List
                                        Episodes</a>
                                </li>
                                <li>
                                    <a href="{{ route('episode.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Episode</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'server-movie' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Server</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('server-movie.index') }}"><i class="fa fa-angle-right"></i> List
                                        Server</a>
                                </li>
                                <li>
                                    <a href="{{ route('server-movie.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Server</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'directors' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Directors</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('directors.index') }}"><i class="fa fa-angle-right"></i> List
                                        Directors</a>
                                </li>
                                <li>
                                    {{-- <a href="{{ route('directors.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Directors</a> --}}
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'cast' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Cast Movies</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('cast.index') }}"><i class="fa fa-angle-right"></i> List
                                        Cast</a>
                                </li>
                                <li>
                                    {{-- <a href="{{ route('cast.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Actor</a> --}}
                                </li>
                            </ul>
                        </li>

                        <li
                            class="treeview @if ($segment == 'user') active
                        @elseif($segment == 'customers')
                            active @endif">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Manage User</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>

                            <ul class="treeview-menu">
                                <li class="{{ $segment == 'user' ? 'active' : '' }}">
                                    <a href="javascription:void(0);">
                                        <i class="fa fa-genderless"></i>
                                        <span>User</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('user.index') }}"><i class="fa fa-angle-right"></i>
                                                List
                                                User</a>
                                        </li>
                                        @can('create user')
                                            <li>
                                                <a href="{{ route('user.create') }}"><i class="fa fa-angle-right"></i>
                                                    Create User</a>
                                            </li>
                                        @endcan

                                    </ul>
                                </li>

                                <li class="{{ $segment == 'customers' ? 'active' : '' }}">
                                    <a href="javascription:void(0);">
                                        <i class="fa fa-genderless"></i>
                                        <span>Customer</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="{{ route('listcustomer') }}"><i class="fa fa-angle-right"></i>
                                                List
                                                Customers</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('listorder') }}"><i class="fa fa-angle-right"></i>
                                                List Orders</a>
                                        </li>


                                    </ul>
                                </li>


                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'package' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Package Movie</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('package.index') }}"><i class="fa fa-angle-right"></i>
                                        List Package
                                    </a>
                                </li>
                                {{-- @can('create user') --}}
                                <li>
                                    <a href="{{ route('package.create') }}"><i class="fa fa-angle-right"></i>
                                        Create Package</a>
                                </li>
                                {{-- @endcan --}}

                            </ul>
                        </li>
                        <li class="treeview {{ $segment == 'comments' ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-genderless"></i>
                                <span>Manage Comment</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('manage-comment') }}"><i class="fa fa-angle-right"></i>
                                        List Comment
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('manage-reply') }}"><i class="fa fa-angle-right"></i>
                                        List Reply</a>
                                </li>


                            </ul>
                        </li>
                        @can('update role')
                            <li class="treeview {{ $segment == 'role' ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-genderless"></i>
                                    <span>Role</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ route('role.index') }}"><i class="fa fa-angle-right"></i> List
                                            Role &Permission</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('role.create') }}"><i class="fa fa-angle-right"></i>
                                            Create Role & Permission</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('assignpermission') }}"><i class="fa fa-angle-right"></i>
                                            Assign Permission To Role</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('view log')
                            <li class="treeview {{ $segment == 'log' ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-genderless"></i>
                                    <span>Log</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ route('log') }}"><i class="fa fa-angle-right"></i>
                                            Tracker</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('log-error') }}"><i class="fa fa-angle-right"></i>
                                            Tracker_Error</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('manager')
                            <li class="treeview {{ $segment == 'shutdown' ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-genderless"></i>
                                    <span>Maintanance System</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        {{-- <a href="{{ route('episode.index') }}"><i class="fa fa-angle-right"></i> List
                                  Movies</a> --}}
                                    </li>
                                    <li>
                                        <a href="{{ route('index') }}"><i class="fa fa-angle-right"></i>
                                            Shutdown Server</a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                      
                            <li class="treeview {{ $segment == 'resume' ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fa fa-genderless"></i>
                                    <span>Resume</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        {{-- <a href="{{ route('episode.index') }}"><i class="fa fa-angle-right"></i> List
                                  Movies</a> --}}
                                    </li>
                                    <li>
                                        <a href="{{ route('resume.create') }}"><i class="fa fa-angle-right"></i>
                                            Create-Show</a>
                                    </li>
                                </ul>
                            </li>
                        
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
        </aside>
    </div>
@endif
