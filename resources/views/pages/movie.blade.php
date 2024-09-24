@extends('layout')

@section('content')
<style>
    .sr-single-hero {
        @php
            $image_check = substr($movie_thumbnail->movie_image->image, 0, 5);
            $startPos = strpos($movie_thumbnail->movie_image->image, 'movies/');
            if ($startPos !== false) {
                $image = substr($movie_thumbnail->movie_image->image, $startPos + strlen('movies/'));
            } else {
                $image = $movie_thumbnail->movie_image->image;
            }
        @endphp       
        background-image: url(
            @if ($image_check == 'https')
                '{{ $url_update . $image }}' 
            @else
                '{{ asset('uploads/movie/' . $movie_thumbnail->movie_image->image) }}'
            @endif
        );
        background-size: cover;
       
        height: 598px; 
    }
</style>

<div class="hero sr-single-hero sr-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- <h1> movie listing - list</h1>
            <ul class="breadcumb">
                <li class="active"><a href="#">Home</a></li>
                <li> <span class="ion-ios-arrow-right"></span> movie listing</li>
            </ul> -->
            </div>
        </div>
    </div>
</div>
<div class="page-single movie-single movie_single">
    <div class="container">
        <div class="row ipad-width2">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="movie-img sticky-sb">
                    <img id="wishlist_movieimage" src="{{ $movie->movie_image->image }}" alt="{{ $movie->title }}">
                    <div class="movie-btn">
                        <div class="btn-transform transform-vertical red">
                            <div><a href="#" class="item item-1 redbtn"> <i class="ion-play"></i> Xem ngay</a>
                            </div>
                            <div><a href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode . '/server-' . $episode_first->server_id) }}"
                                    class="item item-2 redbtn fancybox-media hvr-grow"><i class="ion-play"></i>{{ $movie->title }}</a>
                            </div>
                        </div>
                        <div class="btn-transform transform-vertical">
                            <div><a href="#" class="item item-1 yellowbtn"> <i class="ion-card"></i> xem trailer</a>
                            </div>
                            <div><a href="#" class="item item-2 yellowbtn"><i class="ion-card"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="movie-single-ct main-content">
                    <h1 class="bd-hd">{{ $movie->title }} <span> {{ $movie->year }} </span></h1>
                    <div class="social-btn">
                        <a id="{{ $movie->id }}" onclick="add_wishlist(this.id);" href="#" class="parent-btn"><i class="ion-heart"></i> Yêu thích</a>
                        <div class="hover-bnt">
                            <a href="#" class="parent-btn"><i class="ion-android-share-alt"></i>Chia sẻ</a>
                            <div class="hvr-item">
                                <a href="#" class="hvr-grow"><i class="ion-social-facebook"></i></a>
                                <a href="#" class="hvr-grow"><i class="ion-social-twitter"></i></a>
                                <a href="#" class="hvr-grow"><i class="ion-social-googleplus"></i></a>
                                <a href="#" class="hvr-grow"><i class="ion-social-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="movie-rate">
                        <div class="rate">
                            <i class="ion-android-star"></i>
                            <a href="https://www.imdb.com/title/{{ $movie->imdb }}" target="__blank"><p><span>{{ $values }}/ 10</span> </a><br>
                                <span class="rv">69 Đánh giá</span>
                            </p>
                        </div>
                        <div class="rate-star">
                            <p>Đánh giá phim này: </p>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star"></i>
                            <i class="ion-ios-star-outline"></i>
                        </div>
                    </div>
                    <div class="movie-tabs">
                        <div class="tabs">
                            <ul class="tab-links tabs-mv tabs-series">
                                <li class="active"><a href="#overview">Tổng quan</a></li>
                                <li><a href="#cast"> Diển viên </a></li>
                               
                                {{-- <li><a href="#season"> Season</a></li> --}}
                                <li><a href="#moviesrelated"> Phim liên quan</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="overview" class="tab active">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <p>{!! $movie->movie_description->description !!}</p>
                                            
                                            
                                            <div class="mvsingle-item ov-item">
                                                <a class="img-lightbox" data-fancybox-group="gallery"
                                                    href="images/uploads/image41.jpg"><img
                                                        src="images/uploads/image4.jpg" alt=""></a>
                                                <a class="img-lightbox" data-fancybox-group="gallery"
                                                    href="images/uploads/image51.jpg"><img
                                                        src="images/uploads/image5.jpg" alt=""></a>
                                                <a class="img-lightbox" data-fancybox-group="gallery"
                                                    href="images/uploads/image61.jpg"><img
                                                        src="images/uploads/image6.jpg" alt=""></a>
                                                <div class="vd-it">
                                                    <img class="vd-img" src="images/uploads/image7.jpg" alt="">
                                                    <a class="fancybox-media hvr-grow"
                                                        href="https://www.youtube.com/embed/o-0hcF97wy0"><img
                                                            src="images/uploads/play-vd.png" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="title-hd-sm">
                                                <h4>Diển viên</h4>
                                                
                                            </div>
                                            <!-- movie cast -->
                                            <div class="mvcast-item">
                                                @if (count($movie->movie_cast) == 0)
                                            @else
                                            @foreach ($movie->movie_cast as $cast)
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JW</h4>
                                                    <a href="{{ route('cast', $cast->slug) }}">{{ $cast->title }}</a>
                                                </div> 
                                            </div>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @endif
                                            </div>
                                            
                                           
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                            <div class="sb-it">
                                                <h6>Đạo diễn: </h6>
                                                
                                                @if (count($movie->movie_directors) == 0)
                                                @else
                                                <p>
                                                @foreach ($movie->movie_directors as $direc)
                                                
                                                <a href="{{ route('directors', $direc->slug) }}">{{ $direc->name }}</a>

                                                @if (!$loop->last)
                                                ,
                                                @endif
                                               
                                                @endforeach
                                                </p>
                                                @endif
                                            </div>
                                            
                                            <div class="sb-it">
                                                <h6>Ngôi sao: </h6>
                                                @if (count($movie->movie_cast) == 0)
                                                @else
                                                <p>
                                                @foreach ($movie->movie_cast as $cast)
                                                
                                                <a href="{{ route('cast', $cast->slug) }}">{{ $cast->title }}</a>

                                                @if (!$loop->last)
                                                ,
                                                @endif
                                                
                                                @endforeach
                                                </p>
                                                @endif
                                            </div>
                                            <div class="sb-it">
                                                <h6>Thể loại:</h6>
                                                <p>
                                                    @foreach ($movie->movie_genre as $gen)
                                                    <a href="{{ route('genre', $gen->slug) }}" rel="genre tag">
                                                        {{ $gen->title }}
                                                    </a>
                                                    @if (!$loop->last)
                                                    ,
                                                    @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                           
                                            <div class="sb-it">
                                                <h6>Thời lượng:</h6>
                                                <p>{{ $times }}</p>
                                            </div>
                                            
                                            <div class="sb-it">
                                                <h6>Từ khóa:</h6>
                                                <p class="tags">
                        
                                                    @if (isset($movie->movie_tags))
                                                    @php
                                                        $tagss = [];
                                                        $tagss = explode(',', $movie->movie_tags->tags);
                                                    @endphp
                                                    @foreach ($tagss as $key => $tag)
                                                    <span class="time"><a href="{{ url('tag/' . $tag) }}">{{ $tag }}</a></span>
                                                        
                                                    @endforeach
                                                @endif
                                                </p>
                                            </div>
                                            <div class="ads">
                                                <img src="images/uploads/ads1.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="cast" class="tab">
                                    <div class="row">
                                        <h3>Diễn viên và đoàn làm phim của</h3>
                                        <h2>{{ $movie->title }}</h2>
                                        <!-- //== -->
                                        <div class="title-hd-sm">
                                            <h4>Đạo diễn</h4>
                                        </div>
                                        <div class="mvcast-item">  
                                            @if (count($movie->movie_directors) == 0)
                                            @else
                                            @foreach ($movie->movie_directors as $direc)
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JW</h4>
                                                    <a href="{{ route('directors', $direc->slug) }}">{{ $direc->name }}</a>
                                                </div>
                                                <p>... Director</p>
                                            </div>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                        
                                        <div class="title-hd-sm">
                                            <h4>Diễn viên</h4>
                                        </div>
                                        <div class="mvcast-item">
                                            
                                            @if (count($movie->movie_cast) == 0)
                                            @else
                                            @foreach ($movie->movie_cast as $cast)
                                            <div class="cast-it">
                                                <div class="cast-left">
                                                    <h4>JW</h4>
                                                    <a href="{{ route('cast', $cast->slug) }}">{{ $cast->title }}</a>
                                                </div> 
                                            </div>
                                            @if (!$loop->last)
                                            ,
                                            @endif
                                            @endforeach
                                            @endif
                                        </div>
                                       
                                    </div>
                                </div>
                               
                                {{-- <div id="season" class="tab">
                                    <div class="row">
                                        <div class="mvcast-item">
                                            <div class="cast-it">
                                                <div class="cast-left series-it">
                                                    <img src="images/uploads/season.jpg" alt="">
                                                    <div>
                                                        <a href="#">Season 10</a>
                                                        <p>21 Episodes</p>
                                                        <p>Season 10 of The Big Bang Theory premiered on September 19,
                                                            2016.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div> --}}
                                <div id="moviesrelated" class="tab">
                                    <div class="row">
                                        <h3>Phim liên quan đến</h3>
                                        <h2>{{ $movie->title }}</h2>
                                        @foreach($related as $mov)
                                        <div class="movie-item-style-2">
                                            <img src="@php
                                            $image_check = substr($mov->movie_image->image, 0, 5);
                                            $startPos = strpos($mov->movie_image->image, 'movies/');
                                            $image = substr($mov->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                                            @if ($image_check == 'https') {{ $url_update . $image }}
                                                                            @else
                                                                               {{ asset('uploads/movie/' . $mov->movie_image->image) }} @endif" alt="{{ $mov->title }}">
                                            <div class="mv-item-infor">
                                                <h6><a href="{{ route('movie', $mov->slug) }}">{{ $mov->title }} <span>({{ $movie->year }})</span></a></h6>
                                               
                                                <p class="run-time"> Run Time: 2h21’</p>
                                              
                                            </div>
                                        </div>
                                        @endforeach
                                       
                                       
                                        <div class="topbar-filter">
                                            <label>Số phim:</label>
                                            <select>
                                                <option value="range">5 Phim</option>
                                                
                                            </select>
                                            {{ $related->links('vendor.pagination.custom') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="witshlist_moviename" value="{{ $movie->title }}">
<input type="hidden" id="witshlist_movieslug" value="{{ $movie->slug }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        var name = document.getElementById('witshlist_moviename').value;
        var slug = document.getElementById('witshlist_movieslug').value;
        var img = document.getElementById('wishlist_movieimage').src;
        var url = window.location;

        function add_recent() {
            var id = {{ $movie->id }};
            var currentTime = new Date().getTime();

            var newItems = {
                'id': id,
                'name': name,
                'slug': slug,
                'img': img,
                'url': url,
                'time': currentTime
            }
           
            if (localStorage.getItem('data_recent') == null) {
                localStorage.setItem('data_recent', '[]');
            }
            var old_datas = JSON.parse(localStorage.getItem('data_recent'));
            
            var matchess = $.grep(old_datas, function(obj) {
                return obj.id == id;

            })
            if (matchess.length) {
                matchess[0].time = currentTime;
                matchess[0].img = img;
                matchess[0].url = url;
            } else {
                old_datas.push(newItems);
            }
            old_datas.sort(function(a, b) {
                return b.time - a.time;
            });
            localStorage.setItem('data_recent', JSON.stringify(old_datas));
            
        }
        add_recent();
</script>

@endsection