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
                        <a href="{{ route('category',$cate->slug) }}" class="btn btn-default dropdown-toggle lv1">
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
                <option value="saab">Movie</option>
            </select>
            <input id="timkiem" type="text" placeholder="Tìm kiếm phim cho bạn">
        </div>
        <div class="top-search">
            <style>
                #result {
                    display: flex;
                    flex-direction: column;
                    max-height: 400px;
                    overflow-y: auto; 
                }
                .top-search__list {

                    width: 100%;
                    background: #233a50;
                    border: 4px solid #020d18;
                    border-radius: 4px;
                }

                .top-search__item {
                    padding: 8px 10px 8px 20px;
                }

                .top-search__item--container {
                    display: flex;
                }

                .top-search__item--container .image-wrapper {
                    flex: 0 0 90px;
                }

                .top-search .image-wrapper__inner {
                    position: relative;
                }

                .result-meta {
                    padding-left: 10px;
                }

                .result-meta__title {
                    color: #fff;
                    font-family: Nunito, sans-serif;
                    font-size: 1.1em;
                    font-weight: 700;
                }
            </style>
            <div id="result" class="top-search__list" style="display: block;">

            </div>
        </div>
    </div>
</header>
<!-- END | Header -->