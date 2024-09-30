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
                            <div><a href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode . '/server-' . $episode_first->server_id) }}" class="item item-1 redbtn"> <i class="ion-play"></i> Xem ngay</a>
                            </div>
                            <div><a href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode . '/server-' . $episode_first->server_id) }}"
                                    class="item item-2 redbtn fancybox-media hvr-grow"><i class="ion-play"></i>{{ $movie->title }}</a>
                            </div>
                        </div>
                        <div class="btn-transform transform-vertical">
                            <div><a href="https://www.youtube.com/embed/{{ $movie->movie_trailer->trailer }}" class="item item-1 yellowbtn"> <i class="ion-card"></i> xem trailer</a>
                            </div>
                            <div><a href="https://www.youtube.com/embed/{{ $movie->movie_trailer->trailer }}" class="item item-2 yellowbtn fancybox-media hvr-grow" ><i class="ion-card"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="movie-single-ct main-content">
                    <h1 class="bd-hd">{{ $movie->title }} <span> {{ $movie->year }} </span></h1>
                    <div class="social-btn">
                        <style>
                            .heart:hover{
                                background-color: #dd003f;
                                color: white;
                            }
                            .active-heart{
                                background-color: #dd003f;
                                color: white;
                            }
                        </style>

                        <div class="wishlist">
                        <a href="javacript:void(0)" id="{{ $movie->id }}" onclick="add_wishlist(this.id);" class="parent-btn"><i class="ion-heart heart"></i> Yêu thích</a>
                        </div>
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
                                            
                                            <div class="title-hd-sm">
                                                <h4>Diễn viên</h4>
                                                
                                            </div>
                                            <!-- movie cast -->
                                            <div class="mvcast-item cast">

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
                                                <h6>Quốc gia:</h6>
                                                <p>{{ $movie->country->title }}</p>
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
                                            <h4>Đạo diễn & Sản xuất</h4>
                                        </div>
                                        <div class="mvcast-item crew">
                                            
                                        </div>
                                        
                                        <div class="title-hd-sm">
                                            <h4>Diễn viên</h4>
                                        </div>
                                        <div class="mvcast-item cast">
                                            
                                           
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
        var mylist = document.getElementById({{ $movie->id }});
        var url = window.location;

        function view() {
            if (localStorage.getItem('data') != null) {
                var data = JSON.parse(localStorage.getItem('data'));

                for (i = 0; i < data.length; i++) {
                    var slugs = data[i].slug;

                    if (slugs === slug) {

                        mylist.remove();
                        $(".wishlist").append(
                            '<a href="javacript:void(0)" id="{{ $movie->id }}" onclick="add_wishlist(this.id);" class="parent-btn"><i class="ion-heart active-heart"></i> Yêu thích</a>'
                        );
                    }
                }
            }

        }
        view();

        function add_wishlist(clicked_id) {
            var id = clicked_id;
            var currentTime = new Date().getTime();
            var newItem = {
                'id': id,
                'name': name,
                'slug': slug,
                'url': url,
                'img': img,
                'time':currentTime
            }
            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }
            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;

            })
            if (matches.length) {
                return false;
            } else {
                old_data.push(newItem);
            }
            old_data.sort(function(a, b) {
                return b.time - a.time;
            });
            localStorage.setItem('data', JSON.stringify(old_data));
            mylist.remove();
            $(".wishlist").append(
                '<a href="javacript:void(0)" id="{{ $movie->id }}" onclick="add_wishlist(this.id);" class="parent-btn"><i class="ion-heart active-heart"></i> Yêu thích</a>'
            );

        }
        
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
<script>
        const key ="Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMmViYzQ1NzAyODhlY2QyZDNkZDA3NWQ0YzdkNTRhMSIsIm5iZiI6MTcyNzMxNjk2MS4wOTYwNDgsInN1YiI6IjY2MWI0YjVlNGU0ZGZmMDE5ZDAzN2RkMCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.tfm-5-BNTHcfuo4wR4LK6FYr2cSCmEiqw_kj9JCDUXk";
        var url_api = "https://api.themoviedb.org";
        var url_image = "https://media.themoviedb.org";
        function movieListener() {
        // Parse JSON response
        const responseArray = JSON.parse(this.responseText);
    
        if (responseArray['tv_results'].length === 0) {
           
            responseArray['movie_results'].forEach(item_movie => {
            const id_movie = item_movie.id
            function castListener() {
                const responseCastArray = JSON.parse(this.responseText);
                responseCastArray['cast'].forEach(item_cast =>{
                    const img_cast = url_image + '/t/p/w138_and_h175_face/'+item_cast.profile_path;
                    $(".cast").append(`
                    <div class="cast-it">
                        <div class="cast-left">
                            <img src="${img_cast}" alt="">
                             <a href="#">${item_cast.name}</a>
                        </div>
                        <p>${item_cast.character}</p>
                    </div>
                    `);
                });
                responseCastArray['crew'].forEach(item_crew =>{
                    const img_crew = url_image + '/t/p/w138_and_h175_face/'+item_crew.profile_path;
                    $(".crew").append(`
                    <div class="cast-it">
                        <div class="cast-left">
                            <img src="${img_crew}" alt="">
                             <a href="#">${item_crew.name}</a>
                        </div>
                        <p>${item_crew.department}</p>
                    </div>
                    `);
                })
            }
            const cast = new XMLHttpRequest();
            cast.addEventListener("load", castListener);
            cast.open("GET", url_api+"/3/movie/"+id_movie+"/credits");
            cast.setRequestHeader("Authorization", key);
            cast.send();    


        });
        } else if (responseArray['movie_results'].length === 0){
           
            responseArray['tv_results'].forEach(item_movie => {
            const id_movie = item_movie.id;
            function castListener() {
                const responseCastArray = JSON.parse(this.responseText);
                responseCastArray['cast'].forEach(item_cast =>{
                    const img_cast = url_image + '/t/p/w138_and_h175_face/'+item_cast.profile_path;
                    $(".cast").append(`
                    <div class="cast-it">
                        <div class="cast-left">
                            <img src="${img_cast}" alt="">
                             <a href="#">${item_cast.name}</a>
                        </div>
                        <p>${item_cast.character}</p>
                    </div>
                    `);
                });
                responseCastArray['crew'].forEach(item_crew =>{
                    const img_crew = url_image + '/t/p/w138_and_h175_face/'+item_crew.profile_path;
                    $(".crew").append(`
                    <div class="cast-it">
                        <div class="cast-left">
                            <img src="${img_crew}" alt="">
                             <a href="#">${item_crew.name}</a>
                        </div>
                        <p>${item_crew.department}</p>
                    </div>
                    `);
                })
            }
            const cast = new XMLHttpRequest();
            cast.addEventListener("load", castListener);
            cast.open("GET", url_api+"/3/tv/"+id_movie+"/credits");
            cast.setRequestHeader("Authorization", key);
            cast.send();    


        });
        }
       
        }
        
        const movie = new XMLHttpRequest();
        movie.addEventListener("load", movieListener);
        movie.open("GET", url_api+"/3/find/{{ $movie->imdb }}?external_source=imdb_id");
        movie.setRequestHeader("Authorization", key);
        movie.send();
</script>
@endsection