<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <!-- Basic need -->
    <title>NEST PHIM</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="profile" href="#">

    <!--Google Font-->
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600' />
    <!-- Mobile specific meta -->
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone-no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (isset($tapphim) && $movie->type_movie == 1)
    <title>
    </title>
    @elseif (isset($movie->slug))
    <title>
        {{ $movie->title }} - NEST PHIM
    </title>
    @else
    <title>NEST PHIM | Xem Phim Chill</title>
    @endif
    @if (!isset($movie->slug))
    <meta name="description"
        content="Fullhdphim, Phim hay - Xem phim hay nhất, xem phim online miễn phí, phim nhanh, Xem Phim Online, Phim Vietsub, Xem Phim Hay, phim HD , phim hot ,phim mới, phim bom tấn" />
    @else
    <meta name="description"
        content="Xem Phim {{ $movie->title }} - {{ $movie->name_english }} ({!! $movie->movie_description->description !!})" />
    @endif
    @if (!isset($movie->slug))
    <meta name="title" content="FullHDPhim | Xem Phim Chất Lượng Tốt Nhất" />
    @else
    <meta name="title" content="Phim {{ $movie->title }} [Full HD], {{ $movie->name_english }}" />
    @endif
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="next" href="" />
    <meta property="og:locale" content="vi_VN" />
    @if (!isset($movie->slug))
    <meta property="og:title" content="Phim hay 2023 - Xem phim hay nhất" />
    @else
    <meta property="og:title" content="Phim {{ $movie->title }} [Full HD], {{ $movie->name_english }}" />
    @endif
    <meta property="og:type" content="website" />
    @if (!isset($movie->slug))
    <meta property="og:url" content="{{ route('homepage') }}" />
    @else
    <meta property="og:url" content="{{ route('homepage') }}/movie/{{ $movie->slug }}" />
    @endif
    @if (!isset($movie->slug))
    <meta property="og:description"
        content="Phim hay 2023 - Xem phim hay nhất, phim hay trung quốc, hàn quốc, việt nam, mỹ, hong kong , chiếu rạp" />
    @else
    <meta property="og:description"
        content="Xem Phim {{ $movie->title }} - {{ $movie->name_english }} ({{ $movie->year }})" />
    @endif
    <meta property="og:site_name" content="fullhdphim.click" />
    @if (!isset($movie->slug))
    <meta property="og:image" content="" />
    @else
    <meta property="og:image" content="{{ asset('uploads/movie/' . $movie->movie_image->image) }}" />
    @endif
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    @if (!isset($movie->slug))
    <meta name="keywords"
        content="Phim, xem phim, xem phim online, phim online, xem phim hd, phim vietsub, phim thuyet minh, fullhdphim, fullhdphim.click" />
    @else
    <meta name="keywords"
        content="xem phim {{ $movie->title }},xem phim {{ $movie->title }} vietsub,xem phim {{ $movie->title }} online,xem phim {{ $movie->title }} bluray,xem phim {{ $movie->title }} hd,xem phim {{ $movie->title }} full hd,xem phim {{ $movie->title }} 1080p,xem phim {{ $movie->title }} vietsub online,xem phim {{ $movie->title }} free,xem phim {{ $movie->title }} miễn ph&#237;,xem online, phim chất lượng, si&#234;u n&#233;t, bluray,fullhd, xem phim {{ $movie->name_english }}" />
    @endif


    @if (!isset($movie->slug))
    <link rel="canonical" href="{{ route('homepage') }}" />
    @else
    <link rel="canonical" href="{{ route('homepage') }}/movie/{{ $movie->slug }}" />
    @endif

    <!-- CSS files -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <!--preloading-->
    <div id="preloader">
        <img class="logo" src="{{ asset('images/logo1.png') }}" alt="" width="119" height="58">
        <div id="status">
            <span></span>
            <span></span>
        </div>
    </div>
    <!--end of preloading-->

    <!--end of signup form popup-->

    @include('nav')

    @yield('content')
    <!-- footer section-->
    @include('footer')
    <!-- end of footer section-->

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/plugins2.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>