@extends('layout')
@section('content')
<div class="slider movie-items">
    <div class="container">
        <div class="row">
            <div class="social-link">
                <p>Follow chúng tôi: </p>
                <a href="#"><i class="ion-social-facebook"></i></a>
                <a href="#"><i class="ion-social-twitter"></i></a>
                <a href="#"><i class="ion-social-googleplus"></i></a>
                <a href="#"><i class="ion-social-youtube"></i></a>
            </div>
            <div class="slick-multiItemSlider">
                @foreach($hot_with_ratings as $h)

                <div class="movie-item">
                    <div class="mv-img">
                        <a href="#"><img
                                src="@php
                        $image_check = substr($h['movie']->movie_image->image, 0, 5);
                        $startPos = strpos($h['movie']->movie_image->image, 'movies/');
                        $image = substr($h['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                        @if ($image_check == 'https') {{ $url_update . $image }}
                                                        @else
                                                           {{ asset('uploads/movie/' . $h['movie']->movie_image->image) }} @endif"
                                alt="{{ $h['movie']->title }}" style="width: 285px;height: 370px;" width="285" height="437"
                                loading="lazy"></a>
                    </div>
                    <div class="title-in">
                        <div class="cate">
                            <span class="blue"><a href="#">@foreach($h['movie']->movie_genre->take(1) as $genre)
                                    {{ $genre->title }}
                                @endforeach</a></span>
                        </div>
                        <h6><a href="{{ route('movie', $h['movie']->slug) }}">{{ $h['movie']->title }}</a></h6>

                        <p><i class="ion-android-star"></i><span>
                            {{ $h['imdbRating'] }}
                               </span> /10</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="movie-items full-width">
        <div class="row">
            <div class="col-md-12">
                <div class="title-hd">
                    <h2>Phim Âu Mỹ</h2>
                    <a href="{{ route('country','au-my') }}" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab1">#Mới cập nhật</a></li>
                        <li><a href="#tab3"> #Oscar </a></li>
                        <li><a href="#tab2"> #Sắp chiếu</a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab active">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_us_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="                    @php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie', $movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                  </span>{{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_us_coming as $movie)
                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="@php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                </span>{{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                   
                                </div>
                            </div>
                        </div>
                        <div id="tab3" class="tab">
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_oscar_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="                    @php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                    </span> {{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    
                                   
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="title-hd">
                    <h2>Phim Netflix</h2>
                    <a href="{{ route('genre','netflix') }}" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab21">#Đề xuất</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab21" class="tab active" >
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_netflix_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="                    @php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                  </span>{{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="title-hd">
                    <h2>Phim Bộ</h2>
                    <a href="{{ route('category','tv-series') }}" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab222">#Mới cập nhật</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab222" class="tab active" >
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($tv_series_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="                    @php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                  {{ $movie['imdbRating'] }}
                                                </span> /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            
            </div>
        </div>
</div>

<div class="trailers full-width">
    <div class="row ipad-width">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="title-hd">
                <h2>phim chiếu rạp</h2>
                {{-- <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a> --}}
            </div>
            <div class="videos">
                <div class="slider-for-2 video-ft">
                    @foreach($hot_with_ratings as $trailer)
                    
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/{{ $trailer['movie']->movie_trailer->trailer }}"></iframe>
                    </div>
                    @endforeach
                </div>
                <div class="slider-nav-2 thumb-ft">
                    @foreach($hot_with_ratings as $movie)
                    <div class="item">
                        <div class="trailer-img">
                            <img src="@php
                            $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                            $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                            $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                            @if ($image_check == 'https') {{ $url_update . $image }}
                                @else
                                   {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif" alt="photo by Barn Images" width="4096" height="2737" loading="lazy">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">{{ $movie['movie']->title }}</h4>
                            {{-- <p>2:30</p> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="sidebar">
                <div class="celebrities">
                    <h4 class="sb-title">Top phim</h4>
                    @foreach($topview as $movie)
                   
                    <div class="celeb-item">
                        <a href="#"><img src=
                            "@php
                            $image_check = substr($movie->image, 0, 5);
                            $startPos = strpos($movie->image, 'movies/');
                            $image = substr($movie->image, $startPos + strlen('movies/')); @endphp
                            @if ($image_check == 'https') {{ $url_update . $image }}
                                @else
                                   {{ asset('uploads/movie/' . $movie->image) }} @endif" alt="{{ $movie->title }}" width="70" height="70" loading="lazy"></a>
                        <div class="celeb-author">
                            <h6><a href="{{ route('movie', $movie->slug) }}">{{ $movie->title }}</a></h6>
                            <span>{{ $movie->count_views }} </span><p>lượt xem</p>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>

</div>
<div class="movie-items full-width">
        <div class="row">
            <div class="col-md-12">
                <div class="title-hd">
                    <h2>Phim Hoạt Hình</h2>
                    <a href="{{ route('genre','hoat-hinh') }}" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab22"></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab22" class="tab active" >
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_animation_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="                    @php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif"
                                                    alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                   </span>{{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="title-hd">
                    <h2>Phim Kinh Dị</h2>
                    <a href="{{ route('genre','kinh-di') }}" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab22"></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab22" class="tab active" >
                            <div class="row">
                                <div class="slick-multiItem2">
                                    @foreach($movie_horror_with_ratings as $movie)

                                    <div class="slide-it">
                                        <div class="movie-item">
                                            <div class="mv-img">
                                                <img src="@php
                                                $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                                                $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                                                $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif" 
                                                loading="lazy" alt="{{ $movie['movie']->title }}" width="190" height="284" style="width: 190px; height:230px;">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="{{ route('movie', $movie['movie']->slug) }}">{{ $movie['movie']->title }}</a></h6>
                                                <p><i class="ion-android-star"></i><span>
                                                  </span>{{ $movie['imdbRating'] }} /10</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>

            </div>
           
        </div>
</div>

@endsection