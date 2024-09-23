@extends('layout')
@section('content')
<div class="slider movie-items">
    <div class="container">
        <div class="row">
            <div class="social-link">
                <p>Follow us: </p>
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
                    <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
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
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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
                                                <img src="                    @php
                                                $image_check = substr($movie->movie_image->image, 0, 5);
                                                $startPos = strpos($movie->movie_image->image, 'movies/');
                                                $image = substr($movie->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                @if ($image_check == 'https') {{ $url_update . $image }}
                                                    @else
                                                       {{ asset('uploads/movie/' . $movie->movie_image->image) }} @endif"
                                                    alt="{{ $movie->title }}" width="190" height="284" style="width: 190px; height:230px;" loading="lazy">
                                            </div>
                                            <div class="hvr-inner">
                                                <a href="{{ route('movie',$movie->slug) }}"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="#">{{ $movie->title }}</a></h6>
                                                
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
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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
                    <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
                </div>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="active"><a href="#tab21"></a></li>
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
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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
                    <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
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
                                                <a href="moviesingle.html"> Xem <i
                                                        class="ion-android-arrow-dropright"></i> </a>
                                            </div>
                                            <div class="title-in">
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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
                <h2>in theater</h2>
                <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
            </div>
            <div class="videos">
                <div class="slider-for-2 video-ft">
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/1Q8fG0TtVAY"></iframe>
                    </div>
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/w0qQkSuWOS8"></iframe>
                    </div>
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/44LdLqgOpjo"></iframe>
                    </div>
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/gbug3zTm3Ws"></iframe>
                    </div>
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/e3Nl_TCQXuw"></iframe>
                    </div>
                    <div>
                        <iframe class="item-video" src="" data-src="https://www.youtube.com/embed/NxhEZG0k9_w"></iframe>
                    </div>

                </div>
                <div class="slider-nav-2 thumb-ft">
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer7.jpg" alt="photo by Barn Images" width="4096" height="2737">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Wonder Woman</h4>
                            <p>2:30</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer2.jpg" alt="photo by Barn Images" width="350" height="200">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Oblivion: Official Teaser Trailer</h4>
                            <p>2:37</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer6.jpg" alt="photo by Joshua Earle" width="509" height="301">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Exclusive Interview: Skull Island</h4>
                            <p>2:44</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer3.png" alt="photo by Alexander Dimitrov" width="100" height="56">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Logan: Director James Mangold Interview</h4>
                            <p>2:43</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer4.png" alt="photo by Wojciech Szaturski" width="100" height="56">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Beauty and the Beast: Official Teaser Trailer 2</h4>
                            <p>2: 32</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="trailer-img">
                            <img src="images/uploads/trailer5.jpg" alt="photo by Wojciech Szaturski" width="360" height="189">
                        </div>
                        <div class="trailer-infor">
                            <h4 class="desc">Fast&Furious 8</h4>
                            <p>3:11</p>
                        </div>
                    </div>
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
                                   {{ asset('uploads/movie/' . $movie->image) }} @endif" alt="{{ $movie->title }}" width="70" height="70"></a>
                        <div class="celeb-author">
                            <h6><a href="#">{{ $movie->title }}</a></h6>
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
                    <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
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
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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
                    <a href="#" class="viewall">View all <i class="ion-ios-arrow-right"></i></a>
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
                                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
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