<!-- BEGIN | Header -->
<header class="ht-header">
    <div class="container">
        <nav class="navbar navbar-default navbar-custom">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header logo">
                <div class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <div id="nav-icon1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <a href="/"><img class="logo" src="{{ asset('images/logo1.png') }}" alt="" width="119" height="58"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav flex-child-menu menu-left">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="">
                        <a href="/" class="btn btn-default">
                            Trang Chủ
                        </a>

                    </li>
                    @foreach($category as $cate)
                    <li class="dropdown first">
                        <a href="moviegrid.html" class="btn btn-default dropdown-toggle lv1">
                            {{ $cate->title }}
                        </a>

                    </li>
                    @endforeach
                    
                    {{-- <li class="dropdown first">
                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
                            Phim Bộ
                        </a>

                    </li> --}}
                    <li class="dropdown first">
                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
                            Tiếp tục xem
                        </a>

                    </li>
                    <li class="dropdown first">
                        <a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown" data-hover="dropdown">
                            Phim yêu thích
                        </a>

                    </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <!-- top search form -->
        <div class="top-search">
            <select>
                <option value="united">TV show</option>
                <option value="saab">Others</option>
            </select>
            <input type="text" placeholder="Search for a movie, TV Show or celebrity that you are looking for">
        </div>
    </div>
</header>
<!-- END | Header -->