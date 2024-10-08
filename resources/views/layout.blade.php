<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <!-- Basic need -->
    
    <meta charset="UTF-8">
    <meta name="description" content="xem phim trên nestphim không quảng cáo">
    <meta name="keywords" content="nestphim.site,xem phim nestphim, nestphim không quảng cáo, nestphim free,motchill,phimmoi,phimmoiandchill">
    <meta name="author" content="nestphim">
    <link rel="profile" href="#">
    <link href="{{ asset('uploads/logo/pngwing1.com.png') }}" rel="icon" type="image/x-icon">
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
    @elseif(isset($tag))
    <title> {{ $tag }} - Xem Phim Không Quảng Cáo - NESTPHIM</title>
    @elseif(isset($cast_slug))
    <title> Ngôi sao {{ $cast_slug->title }} - Xem những phim của {{ $cast_slug->title }}</title>
    @elseif(isset($directors_slug->name))
    <title> Đạo diễn {{ $directors_slug->name }} - Xem những phim của {{ $directors_slug->name }} - NESTPHIM</title>
    @elseif(isset($gen_slug->title))
    <title> Xem phim {{ $gen_slug->title }} trên NESTPHIM không quảng cáo</title>
    @else
    <title> NEST PHIM - Xem Phim Không Quảng Cáo</title>
    @endif
    @if (isset($tag))
    <meta name="description" content="Xem Phim {{ $tag }} chillout không quảng cáo tại nestphim, phim {{ $tag }} hd, phim {{ $tag }} vietsub" />
    @elseif (isset($movie->slug))
    <meta name="description" content="Xem Phim {{ $movie->title }} tại nestphim ({!! $movie->movie_description->description !!})" />
    @elseif(isset($cast_slug))
    <meta name="description" content="Xem Phim {{ $cast_slug->title }} chillout không quảng cáo tại nestphim, phim do {{ $cast_slug->title }} đóng, phim {{ $cast_slug->title }} vietsub" />
    @elseif(isset($directors_slug->name))
    <meta name="description" content="Xem Phim {{ $directors_slug->name }} chillout không quảng cáo tại nestphim, phim do {{ $directors_slug->name }} đạo diễn, phim {{ $directors_slug->name }} vietsub" />
    @elseif(isset($gen_slug->title))
    <meta name="description" content="Xem Phim {{ $gen_slug->title }} mới nhất chillout không quảng cáo tại nestphim, phim {{ $gen_slug->title }} hd, phim {{ $gen_slug->title }} vietsub, phim {{ $gen_slug->title }} hay" />
    @else
    <meta name="description"
        content="nestphim - Xem phim hay nhất, phim mới nhất, phim Việt, phim Hàn, phim Trung, phim Âu Mỹ. Kho phim khổng lồ, chất lượng HD, Vietsub đầy đủ. Truy cập nestphim ngay để thưởng thức!" />
    @endif
    @if (!isset($movie->slug))
    <meta name="title" content="NESTPHIM | Xem Phim Không Quảng Cáo" />
    @else
    <meta name="title" content="Phim {{ $movie->title }} trên nestphim, {{ $movie->name_english }}" />
    @endif
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="next" href="" />
    <meta property="og:locale" content="vi_VN" />
    @if (!isset($movie->slug))
    <meta property="og:title" content="Nestphim nơi Xem phim không quảng cáo" />
    @else
    <meta property="og:title" content="Phim {{ $movie->title }} vietsud, thuyết minh, {{ $movie->name_english }}" />
    @endif
    <meta property="og:type" content="website" />
    @if (!isset($movie->slug))
    <meta property="og:url" content="{{ route('homepage') }}" />
    @else
    <meta property="og:url" content="{{ route('homepage') }}/movie/{{ $movie->slug }}" />
    @endif
    @if (!isset($movie->slug))
    <meta name="description"
        content="nestphim - Xem phim online miễn phí chất lượng cao. Hàng ngàn bộ phim hấp dẫn, từ kinh điển đến hiện đại, đều có tại nestphim. Cập nhật phim mới liên tục, không cần đăng ký." />
    @else
    <meta property="og:description"
        content="Xem Phim {{ $movie->title }} - {{ $movie->name_english }} ({{ $movie->year }}) trên nestphim" />
    @endif
    <meta property="og:site_name" content="nestphim.site" />
    @if (isset($movie->slug))
    <meta property="og:image" content="{{ asset('uploads/movie/' . $movie->movie_image->image) }}" />
    @endif
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />


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
        <img class="logo" src="{{ asset('uploads/logo/pngwing1.com.png') }}" alt="nestphim" width="119" height="58">
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

    <script type='text/javascript'>
        $(document).ready(function() {
            $('#timkiem').keyup(function() {
                $('#result').html('');
                var search = $('#timkiem').val();
              
               
                if (search != '') {
                $('#result').css('display', 'inherit');
                function reqListener() {
                // Parse JSON response
                const responseArray = JSON.parse(this.responseText);
                $('#result').empty();
                
                // Loop through the array and append each item to the list
                responseArray.forEach(item => {
                    const imageUrl = item.movie_image.image.startsWith('https') ? item.movie_image.image : '/uploads/movie/' + item.movie_image.image;
                    $('#result').append(`     
                        <div class="top-search__item">
                            <a href="/movie/${item.slug}">
                                <div class="top-search__item--container">
                                    <div class="image-wrapper">
                                        <div class="image-wrapper__inner">
                                            <img src="${imageUrl}" alt="${item.title}">
                                        </div>
                                    </div>
                                    <div class="result-meta">
                                        <div class="result-meta__title">${item.title} (${item.year}) </span></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    `);
                });
                }
                const req = new XMLHttpRequest();
                req.addEventListener("load", reqListener);
                req.open("GET", "/tim-kiem?search=" + search);
                req.send();
                } else {
                    $('#result').css('display', 'none');
                }
            })
            $('body').on('click', function() {
                // var click_text = $(this).text().split('->');
                // $('#timkiem').val($.trim(click_text[0]));
                // $("#result").html('');
                $('#result').css('display', 'none')
            });
           
        })
    </script>
</body>

</html>