@extends('layout')
@section('content')
<section id="mylist" class="container p-t-40">
    <h4 class="romantic-heading">
       Filter Result
    </h4>
    <style>
        .list-film {
            margin-right: -10px;
            position: relative;
            overflow: hidden;
            list-style-type: none;
            padding: 0;
        }

        @-webkit-keyframes rotateplane {
            0% {
                -webkit-transform: perspective(120px)
            }

            50% {
                -webkit-transform: perspective(120px) rotateY(180deg)
            }

            100% {
                -webkit-transform: perspective(120px) rotateY(180deg) rotateX(180deg)
            }
        }

        @keyframes rotateplane {
            0% {
                -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg);
                transform: perspective(120px) rotateX(0deg) rotateY(0deg)
            }

            50% {
                -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
                transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg)
            }

            100% {
                -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
                transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg)
            }
        }

        .list-film>.item {
            float: left;
            width: 20%;
            position: relative;
            font-family: roboto;
            font-size: 15px
        }

        .list-film .item .label {
            position: absolute;
            padding: 5px;
            font-size: 11px;
            color: #fff;
            background: #1b2a39;
            border-bottom: 2px solid #bb3c2f;
            border: 1px solid #1b2a3900;
            position: relative top:5px;
            z-index: 2;
            font-weight: 400;
            background-size: 200% 100%;
            background-image: linear-gradient(to right, #C02425 0%, #F0CB35 51%, #C02425 100%);
            transition: .7s
        }

        .list-film .item .label:after {
            content: '';
            border-bottom: 6px solid #dd8b52;
            border-left: 6px solid transparent;
            display: block;
            border-right: 6px solid transparent;
            bottom: -10px;
            left: 50%;
            position: absolute;
            -webkit-transform: translate(-50%, -50%) rotate(180deg);
            transform: translate(-50%, -50%) rotate(180deg)
        }

        .list-film .item.large .label {
            padding: 10px;
            font-size: 14px
        }

        .text-promotion {
            color: #ffeb3b
        }

        .list-film .item .label-quality {
            position: absolute;
            padding: 5px;
            font-size: 11px;
            color: #fff;
            z-index: 2;
            left: 0;
            background: #ff9601;
            border-radius: 0 5px 5px 0
        }


        .list-film>.item.large {
            width: 40%
        }

        .list-film>.item.large a {
            margin: 0 10px 0 0;
            display: block
        }

        .list-film>.item a {
            margin: 0 10px 10px 0;
            display: block;
            position: relative;
            overflow: hidden
        }

        .list-film>.item p {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, .6);
            color: #fff;
            padding: 10px;
            line-height: 1.3em;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden
        }

        .list-film>.item.large p {
            right: 0;
            bottom: 0;
            font-size: 20px
        }

        .item .icon-play {
            background: #ce0e0e;
            height: 50px;
            width: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -25px 0 0 -25px;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all .3s ease-in-out
        }

        .icon-play:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            border: 15px solid transparent;
            border-left: 20px solid #fff;
            margin: -15px 0 0 -6px
        }

        .item:hover .icon-play {
            transform: scale(1);
            opacity: .8
        }

        img {
            width: 100%;
            object-fit: cover;
            transition: all .3s ease-in-out;
            vertical-align: middle;
        }

        .list-film .item:hover img {
            transform: scale(1.2);
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .list-film>.item {
                width: 25%;
            }

            .list-film>.item.large {
                width: 50%;
            }

            .list-film>.item p {
                font-size: 14px;
            }

            .list-film>.item.large p {
                font-size: 18px;
            }
        }

        @media (max-width: 768px) {
            .list-film>.item {
                width: 33.33%;
            }

            .list-film>.item.large {
                width: 66.66%;
            }

            .list-film>.item p {
                font-size: 12px;
            }

            .list-film>.item.large p {
                font-size: 16px;
            }

            .list-film .item .label,
            .list-film .item.large .label {
                font-size: 10px;
            }

            .list-film .item.large .label {
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .list-film>.item {
                width: 50%;
            }

            .list-film>.item.large {
                width: 100%;
            }

            .list-film>.item p {
                font-size: 10px;
                padding: 8px;
            }

            .list-film>.item.large p {
                font-size: 14px;
                padding: 10px;
            }

            .list-film .item .label,
            .list-film .item.large .label {
                font-size: 9px;
            }

            .list-film .item.large .label {
                padding: 6px;
            }
        }
    </style>
    <article class="">
        @if (count($movie) != 0)
        <div class="link-container">
            <ul class="list-film horizontal">
                @foreach ($movie as $key => $mov)
                @foreach ($mov->episode->take(1) as $ep)
                <li class="item small"> 
                    {{-- <span class="label">
                        <div class="status">HD-Vietsub</div>
                    </span>  --}}
                    <a title="{{ $mov->title }}" href="javascript:void()" style="height: 150px;"
                        onclick="location.href='{{ url('xem-phim/' . $mov->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}'">
                        <img alt="{{ $mov->title }}" src="@php
                            $image_check = substr($mov->movie_image->image, 0, 5); $startPos = strpos($mov->movie_image->image, 'movies/');
                            $image = substr($mov->movie_image->image, $startPos + strlen('movies/')); 
                            @endphp
                            @if ($image_check == 'https')
                                {{ $url_update . $image }}
                            @else
                                {{ asset('uploads/movie/' . $mov->movie_image->image) }} @endif" loading="lazy">
                        <i class="icon-play"></i>
                    </a>
                </li>
                @endforeach
                @endforeach
            </ul>
        </div>
        @else
        <span>Không tìm thấy phim!</span>
        @endif
    </article>
</section>

<div class="text-right">
    {{ $movie->appends($_GET)->links('vendor.pagination.custom') }}
</div>
@endsection