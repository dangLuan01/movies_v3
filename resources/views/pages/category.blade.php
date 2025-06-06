@extends('layout')

@section('content')

    <div class="hero common-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-ct">
                        <h1> {{ $cate_movie->title }}</h1>
                        <ul class="breadcumb">
                            <li class="active"><a href="#">Home</a></li>
                            <li> <span class="ion-ios-arrow-right"></span> Danh sách phim {{ $cate_movie->title }}</li>
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
                        @foreach($category_page as $movie)
                        
                        <div class="movie-item-style-2 movie-item-style-1">
                            <img src="@php
                            $image_check = substr($movie->movie_image->image, 0, 5);
                            $startPos = strpos($movie->movie_image->image, 'movies/');
                            $image = substr($movie->movie_image->image, $startPos + strlen('movies/')); @endphp
                                                            @if ($image_check == 'https') {{ $url_update . $image }}
                                                            @else
                                                               {{ asset('uploads/movie/' . $movie->movie_image->image) }} @endif" alt="{{ $movie->title }}"style="width: 190px; height:230px;" loading="lazy">
                            <div class="hvr-inner">
                                <a href="{{ route('movie',$movie->slug) }}"> Xem <i class="ion-android-arrow-dropright"></i> </a>
                            </div>
                            <div class="mv-item-infor">
                                <h6><a href="#">{{ $movie->title }}</a></h6>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="topbar-filter">
                        <label>Phim mỏi trang:</label>
                        <select>
						<option value="range">20 Phim</option>
					</select>

                    {{ $category_page->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @include('pages.include.filter_movie')
            </div>
        </div>
    </div>
@endsection
