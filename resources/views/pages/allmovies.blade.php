@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                {{-- <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">All Movies</a> »
                                    <span class="breadcrumb_last" aria-current="page">2023</span></span></span></div>
                    </div>
                </div> --}}
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
            <!-- Start Fillter movies-->
            @include('pages.include.fillter_movie')
            <!--End Fillter movies-->
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section>
                <div class="section-bar clearfix">
                    <h1 class="section-title"><span>Tất cả phim</span></h1>
                </div>

                <div class="halim_box">
                    <div class="scrolling-pagination">
                        @foreach ($movie as $key => $mov)
                            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}">
                                        <figure>

                                            @php
                                                $image_check = substr($mov->movie_image->image, 0, 5);
                                            @endphp
                                            @if ($image_check == 'https')
                                                <img class="lazy img-responsive" src="{{ $mov->movie_image->image }}"
                                                    alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                            @else
                                                <img class="lazy img-responsive"
                                                    src="{{ asset('uploads/movie/' . $mov->movie_image->image) }}"
                                                    alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                            @endif


                                        </figure>
                                        <span class="status">
                                            @if ($mov->quality == 1)
                                                Bluray
                                            @elseif ($mov->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif
                                        </span>
                                        @if (Auth::guard('customer')->check())
                                            @if (Auth::guard('customer')->user()->status_registration == 0)
                                                @if ($mov->paid_movie == 1)
                                                    <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                            aria-hidden="true"></i>
                                                    </span>
                                                @else
                                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                        @if ($mov->type_movie == '1')
                                                            @if ($mov->episode_count == $mov->sotap)
                                                                Hoàn tất |
                                                            @else
                                                                {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                            @endif
                                                        @endif

                                                        @if ($mov->language == 1)
                                                            VietSub
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @elseif ($mov->language == 2)
                                                            Tiếng Gốc
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @elseif ($mov->language == 3)
                                                            Lồng Tiếng
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @else
                                                            Thuyết Minh
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                @endif
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($mov->type_movie == '1')
                                                        @if ($mov->episode_count == $mov->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($mov->language == 1)
                                                        VietSub
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 2)
                                                        Tiếng Gốc
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 3)
                                                        Lồng Tiếng
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @else
                                            @if ($mov->paid_movie == 1)
                                                <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                        aria-hidden="true"></i>
                                                </span>
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($mov->type_movie == '1')
                                                        @if ($mov->episode_count == $mov->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($mov->language == 1)
                                                        VietSub
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 2)
                                                        Tiếng Gốc
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 3)
                                                        Lồng Tiếng
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @endif
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $mov->title }}</p>
                                                <p class="original_title">{{ $mov->name_english }} @if ($mov->season != 0)
                                                        Season {{ $mov->season }}
                                                    @endif
                                                    @if ($mov->year != null)
                                                        ({{ $mov->year }})
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                        {!! $movie->links() !!}
                    </div>

                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                </div>
            </section>
        </main>
        {{-- @include('pages.topview') --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endsection
