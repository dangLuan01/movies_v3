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
        height: 580px;
    }
    .common-hero {
        height: 100px;
        background: #020D18;
}
</style>
<div class="hero common-hero">
    <div class="container">
    </div>
</div>
<div class="page-single">
   
            <!-- hero section video-->
            <div class="videocontainer">
                <iframe id="mainiframe" class="video" frameborder="0"
                    allow="accelerometer; autoplay=0; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
    
</div>
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
@endsection