@extends('layout')
@section('content')

@if ($movie->type_movie == 1)
<script>
    var episode={{ $tapphim }};
            var player_aaaa = {
                "vod_data": {
                    "vod_name": "{{ $movie->title }}",
                    "vod_position": "{{ $movie->slug }}_{{ $tapphim }}"
                },
            }
</script>
@else
<script>
    var player_aaaa = {
                "vod_data": {
                    "vod_name": "{{ $movie->title }}",
                    "vod_position": "{{ $movie->slug }}"
                },
            }
</script>
@endif

<style>
    .ht-header{
        display: none;
    }
    .video {
        position: relative;
        display: block;
        width: 100%;
        height: 100%;
        padding: 0;
        overflow: hidden;
    }

    .videocontainer {
        max-width: 100%;
        margin: auto !important;
        height: 530px;
    }

    /* .common-hero {
        height: 100px;
    } */

    @media (max-width: 601px) {
        .videocontainer {
            height: 215px;
        }
    }

    @media (min-width: 1920px) {
        .videocontainer {
            height: 920px;
        }
    }
</style>
<style>
    .server {
        background-color: #222;
        border-radius: 4px;
        border-style: none;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
        margin: 2px;
        max-width: none;
        min-height: 44px;
        min-width: 10px;
        outline: none;
        overflow: hidden;
        padding: 9px 20px 8px;
        position: relative;
        text-align: center;
        text-transform: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: 15%;
    }

    .server-active {
        background-color: #fff;
        color: #222;
    }

    .button-31 {
        background-color: #222;
        border-radius: 4px;
        border-style: none;
        box-sizing: border-box;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
        margin: 2px;
        max-width: none;
        min-height: 44px;
        min-width: 10px;
        outline: none;
        overflow: hidden;
        padding: 9px 20px 8px;
        position: relative;
        text-align: center;
        text-transform: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;

    }

    .img-mobile {
        height: 400px;
        width: 300px
    }


    @media (max-width: 601px) {
        .server {
            background-color: #222;
            border-radius: 4px;
            border-style: none;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.5;
            margin: 2px;
            max-width: none;
            min-height: 35px;
            min-width: 10px;
            outline: none;
            overflow: hidden;
            padding: 9px 20px 8px;
            position: relative;
            text-align: center;
            text-transform: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            width: 40%;
        }

        .server-active {
            background-color: #fff;
            color: #222;
        }

        .button-31 {
            font-size: 10px;
            min-height: 35px;
        }

        .img-mobile {
            height: 210px;
            width: 150px;
        }

    }


    .button-31:hover {
        background-color: #fff;
        color: #222;
    }

    .server:hover {
        background-color: #fff;
        color: #222;
    }

    .active-ep {
        background-color: #fff;
        color: #222;
    }

    .episode-list {
        display: none;
    }
</style>
{{-- <div class="hero common-hero">
    <div class="container">
    </div>
</div> --}}
<div class="page-single" style="padding: 0;">
    <div>
        <a href="{{ route('movie',$movie->slug) }}"><img src="{{ asset('/images/icons/arrow.png') }}" style="height: 50px; width:60px"></a>
    </div>
    <div class="videocontainer">
        <iframe id="mainiframe" class="video" frameborder="0"
            allow="accelerometer; autoplay=0; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    </div>
    <br>
    <div style="padding-left: 2%">
        @foreach ($server as $key => $ser)
        @foreach ($episode_movie as $key => $ser_mov)
        @if ($ser_mov->server_id == $ser->id)
        @if ($movie->type_movie == 0)
        @foreach ($episode_list as $key => $ep)
        @if ($ep->server_id == $ser->id)
        <div class="server{{ $server_active == 'server-' . $ser->id ? ' active-ep' : '' }} episode serverbtn"
            data-url="{{ url('api/watch/' . $movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}">
            {{ $ser->title }}
        </div>
        @endif
        @endforeach
        @else
        <div id="server-{{ $ser->id }}"
            class="server{{ $server_active == 'server-' . $ser->id ? ' server-active' : '' }} serverbtn"
            onclick="showEpisodes('server{{ $ser->id }}')">
            {{ $ser->title }}
        </div>
        @endif
        @endif
        @endforeach
        @endforeach
        @if ($movie->type_movie == 1)
        @foreach ($server as $key => $ser)
        @foreach ($episode_movie as $key => $ser_mov)
        @if ($ser_mov->server_id == $ser->id)
        <div id="episodeList{{ $ser->id }}" class="episode-list" style="padding-bottom: 1%">
            @foreach ($episode_list as $key => $ep)
            @if ($ep->server_id == $ser->id)
            <button
                data-url="{{ url('api/watch/' . $movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}"
                class="button-31 {{ $tapphim == $ep->episode && $server_active == 'server-' . $ser->id ? 'active-ep' : '' }} episode"
                {{ $tapphim==$ep->episode && $server_active == 'server-' . $ser->id ? '' : '' }}>

                {{ $movie->type_movie == 1 && $movie->sotap == $ep->episode ? 'Tập '.$ep->episode.' Cuối' : 'Tập
                '.$ep->episode }}

            </button>
            @endif

            @endforeach
        </div>
        @endif
        @endforeach
        @endforeach
        @endif

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var server_active = "{{ $server_active }}";
        document.getElementById(server_active).click();

    });
    function showEpisodes(server) {
        // Ẩn tất cả danh sách tập phim
        document.querySelectorAll('.episode-list').forEach(function(el) {
            el.style.display = 'none';
        });
        // Hiển thị danh sách tập phim của server được chọn
        document.getElementById('episodeList' + server.charAt(server.length - 1)).style.display = 'block';
    }
</script>

<script>
    var url = window.location.href;
        var index = url.indexOf("xem-phim/");
        var result = url.slice(index + 9);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.addEventListener("DOMContentLoaded", function() {
            if (window.devToolsOpen) {
            return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/watch/" + result, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var responseData = JSON.parse(xhr.responseText);
                    document.getElementById("mainiframe").src = responseData.data;
                    document.title= "Tập " + episode + " - " + name;
                }
            };
            xhr.send();
           
        });
</script>
<script>
    var buttonss = document.querySelectorAll('.serverbtn');
    var activeButton_server = document.querySelector('.serverbtn.server-active');
    buttonss.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                    if (activeButton_server !== null) {
                        activeButton_server.classList.remove('server-active');
                    }
                    btn.classList.add('server-active');
                    activeButton_server = btn;
                });
            });
</script>
<script>
    var buttons = document.querySelectorAll('.episode');
            var activeButton = document.querySelector('.episode.active-ep');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var url = button.dataset.url;
                    
                    if (activeButton !== null) {
                        activeButton.classList.remove('active-ep');
                    }
                    button.classList.add('active-ep');
                    activeButton = button;
    
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", url, true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var responseData = JSON.parse(xhr.responseText);
                
                            document.getElementById("mainiframe").src = responseData.data;
                           
                        }
                    };
                    xhr.send();
                    var index = url.indexOf("watch/");
                    var result = url.slice(index + 6);
    
                    @if ($movie->type_movie == 1)
                        var parts = result.split("/");
                        var tapPart = parts[1];
                        var tapParts = tapPart.split("tap-");
                        var episode = tapParts[1];
    
                        player_aaaa.vod_data.vod_position = "{{ $movie->slug }}_" + episode;
                        document.title= "Tập " + episode + " - " + name;
                    @endif
    
                    var newUrl = '/xem-phim/' + result;
                    history.replaceState({}, null, newUrl);
                    history.pushState({}, null, newUrl);
                    add_recent();
                   
                });
            });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        var url = window.location;
        function add_recent() {
            var id = {{ $movie->id }};
            var currentTime = new Date().getTime();

            var old_datas = JSON.parse(localStorage.getItem('data_recent'));
            
            var matchess = $.grep(old_datas, function(obj) {
                return obj.id == id;
            })
            if (matchess.length) {
                matchess[0].time = currentTime;
                matchess[0].url = url;
            } 
            old_datas.sort(function(a, b) {
                return b.time - a.time;
            });
            localStorage.setItem('data_recent', JSON.stringify(old_datas));
        }
        add_recent();
</script>
<script id="devtools-detection">
    function onDevToolsOpen() {

            // Lấy đối tượng div bằng cách sử dụng id
            var divElement = document.getElementById("mainiframe");
            divElement.src = "";
            var buttons = document.querySelectorAll('.episode');
            buttons.forEach(function(button) {
                button.style.display = 'none';
            });
            window.devToolsOpen = true;
            setTimeout(console.clear.bind(console))
            setTimeout(() => {
                console.log(
                    'open devtool.',
                )
            }, 10);
            const script = document.getElementById('devtools-detection');
            script.remove();
        }
        class DevToolsChecker extends Error {
            toString() {

            }
            get message() {
                onDevToolsOpen();
            }
        }
        console.log(new DevToolsChecker());
</script>
@endsection