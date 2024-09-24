@extends('layout')
@section('content')
<div class="hero common-hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-ct">
                    <h1>Phim Đã xem</h1>
                    <ul class="breadcumb">
                        <li class="active"><a href="/">Home</a></li>
                        <li> <span class="ion-ios-arrow-right"></span>xem gần đây</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="row_recent" class="flex-wrap-movielist mv-grid-fw">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function view() {
            if (localStorage.getItem('data_recent') != null) {
                var data = JSON.parse(localStorage.getItem('data_recent'));

                for (var i = 0 ; i <= data.length ; i++) {
                    var name = data[i].name;
                    var slug = data[i].slug;
                    var img = data[i].img;
                    var url = data[i].url;

                    $("#row_recent").append(`
                    <div class="movie-item-style-2 movie-item-style-1">
                        <img src="${img}" alt="${name}" style="width: 100%; height:230px;" loading="lazy">
                        <div class="hvr-inner">
                            <a href="${url['href']}"> Xem tiếp <i class="ion-android-arrow-dropright"></i> </a>
                        </div>
                        <div class="mv-item-infor">
                            <h6><a href="${url['href']}">${name}</a></h6>
                        </div>
                    </div>
                    `);    

                }
            }

        }
        view();
</script>
@endsection