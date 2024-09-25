@extends('layout')

@section('content')
    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1> #{{ $tag }}</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="#">Home</a></li>
                            <li> <span class="ion-ios-arrow-right"></span> Phim theo tag {{ $tag }}</li>
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
                        @foreach($movie_tag_with_ratings as $movie)
                        
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

                    {{ $movie_tag->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @include('pages.include.filter_movie')
            </div>
        </div>
    </div>
@endsection
