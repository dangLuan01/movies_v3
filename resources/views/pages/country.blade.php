@extends('layout')

@section('content')

    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1> {{ $count_slug->title }}</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="#">Home</a></li>
                            <li> <span class="ion-ios-arrow-right"></span> Danh sách phim {{ $count_slug->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-single">
        <div class="container">
            <div class="row ipad-width">
                <div class="col-md-8 col-sm-12 col-xs-12">

                    <div class="flex-wrap-movielist">
                        @foreach($movie_country_with_ratings as $movie)
                        
                        <div class="movie-item-style-2 movie-item-style-1">
                            <img src="@php
                            $image_check = substr($movie['movie']->movie_image->image, 0, 5);
                            $startPos = strpos($movie['movie']->movie_image->image, 'movies/');
                            $image = substr($movie['movie']->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                            @if ($image_check == 'https') {{ $url_update . $image }}
                                                            @else
                                                               {{ asset('uploads/movie/' . $movie['movie']->movie_image->image) }} @endif" alt="{{ $movie['movie']->title }}"style="width: 190px; height:230px;" loading="lazy">
                            <div class="hvr-inner">
                                <a href="{{ route('movie',$movie['movie']->slug) }}"> Xem <i class="ion-android-arrow-dropright"></i> </a>
                            </div>
                            <div class="mv-item-infor">
                                <h6><a href="#">{{ $movie['movie']->title }}</a></h6>
                                <p class="rate"><i class="ion-android-star"></i><span>{{ $movie['imdbRating'] }}</span> /10</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="topbar-filter">
                        <label>Movies per page:</label>
                        <select>
						<option value="range">20 Movies</option>
					</select>

                    {{ $movie_country->links('vendor.pagination.custom') }}
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="sidebar">
                        <div class="searh-form">
                            <h4 class="sb-title">Tìm kiếm</h4>
                            <form class="form-style-1" action="#">
                                <div class="row">
                                    <div class="col-md-12 form-it">
                                        <label>Tên phim</label>
                                        <input type="text" placeholder="Nhập tên phim">
                                    </div>
                                    <div class="col-md-12 form-it">
                                        <label>Thể loại</label>
                                        <div class="group-ip">
                                            <select name="skills" multiple="" class="ui fluid dropdown">
											<option value="">Chọn thể loại</option>
                                            @foreach($genre as $gen)
                                            <option value="{{ $gen->slug }}">{{ $gen->title }}</option>
                                            @endforeach
											
										</select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-it">
                                        <label>Quốc gia</label>
                                        <div class="group-ip">
                                            <select name="skills" multiple="" class="ui fluid dropdown">
											<option value="">Chọn thể loại</option>
                                            @foreach($country as $coun)
                                            <option value="{{ $coun->slug }}">{{ $coun->title }}</option>
                                            @endforeach
											
										</select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-it">
                                        <label>Năm</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select>
											  <option value="number">2024</option>
                                              <option value="number">2023</option>
											</select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <input class="submit" type="submit" value="Tìm">
                                    </div>
                                </div>
                            </form>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
