@extends('layouts.app')

@section('statistical')
    <div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-film icon-rounded"></i>
                <div class="stats">
                    <h5><strong>{{ $total_movie_home }}</strong></h5>
                    <span>Total Movies</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-bars user1 icon-rounded"></i>
                <div class="stats">
                    <h5><strong>{{ $total_category_home }}</strong></h5>
                    <span>Total Categorys</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-genderless user2 icon-rounded"></i>
                <div class="stats">
                    <h5><strong>{{ $total_genre_home }}</strong></h5>
                    <span>Total Genres</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget widget1">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-flag dollar1 icon-rounded"></i>
                <div class="stats">
                    <h5><strong>{{ $total_country_home }}</strong></h5>
                    <span>Total Countrys</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 widget">
            <div class="r3_counter_box">
                <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                <div class="stats">
                    <h5><strong>{{ $total_user_home }}</strong></h5>
                    <span>Total Customers</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content2')
<div class="charts">
    <div class="col-md-4 charts-grids widget">
        <div class="card-header">
            <h3>Top Film Weekly</h3>
        </div>
        <div id="container" style="width: 100%; height: 270px; overflow: auto; ">
            <table class="table">
                <thead>
                    @foreach ($topview_week as $key => $movie)
                        <tr>
                            <th>{{ $movie->title }}</th>
                            <th>Views-({{ $movie->count_views }})</th>
                        </tr>
                    @endforeach
                </thead>
            </table>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
    
@endsection
@section('content3')
<div class="charts">
    <div class="col-md-4 charts-grids widget">
        <div class="card-header">
            <h3>Top Film Monthly</h3>
        </div>
        <div id="container" style="width: 100%; height: 270px; overflow: auto; ">
            <table class="table">
                <thead>
                    @foreach ($topview_month as $key => $movie)
                        <tr>
                            <th>{{ $movie->title }}</th>
                            <th>Views-({{ $movie->count_views }})</th>
                        </tr>
                    @endforeach
                </thead>
            </table>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
    
@endsection
@section('content4')
<div class="charts">
    <div class="col-md-4 charts-grids widget">
        <div class="card-header">
            <h3>Top Film</h3>
        </div>
        <div id="container" style="width: 100%; height: 270px; overflow: auto; ">
            <table class="table">
                <thead>
                    @foreach ($topview as $key => $movie)
                        <tr>
                            <th>{{ $movie->title }}</th>
                            <th>Views-({{ $movie->count_views }})</th>
                        </tr>
                    @endforeach
                </thead>
            </table>

        </div>
    </div>
    <div class="clearfix"></div>
</div>
    
@endsection
@section('content1')
    @can('statist')
        <div class="col-md-3 stat">
            <div class="content-top-1">
                <div class="col-md-6 top-content">
                    <h5>Online</h5>
                    <label style="color: #1ce96a">
                        <div id="userOnline"></div>
                        {{-- {{ $onlineusers }} --}}
                    </label>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-3 stat">
            <div class="content-top-1">
                <div class="col-md-6 top-content">
                    <h5>Total Views </h5>
                    <label>
                        {{ $pageViews->sum('total') }}
                    </label>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    @endcan
@endsection

@section('content')
    <div class="charts">
        <div class="col-md-4 charts-grids widget">
            <div class="card-header">
                <h3>Top Browser</h3>
            </div>
            <div id="container" style="width: 100%; height: 270px">
                <table class="table">
                    <thead>
                        @foreach ($top_browser as $key => $browser)
                            <tr>
                                <th>{{ $browser->browser }}</th>
                                <th>Top {{ $key + 1 }}-({{ $browser->total }})</th>
                            </tr>
                        @endforeach
                    </thead>
                </table>

            </div>
        </div>

        {{-- <div class="col-md-4 charts-grids widget states-mdl">
            <div class="card-header">
                <h3>Column & Line Graph</h3>
            </div>
            <div id="chartdiv"></div>
        </div> --}}
        <div class="clearfix"></div>
    </div>
   

    <!-- for amcharts js -->
    <script src="{{ asset('backend/js/amcharts.js') }}"></script>
    <script src="{{ asset('backend/js/serial.js') }}"></script>
    <script src="{{ asset('backend/js/export.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/css/export.css') }}" type="text/css" media="all" />
    <script src="{{ asset('backend/js/light.js') }}"></script>
    <!-- for amcharts js -->
    {{-- <script src="{{ asset('backend/js/index1.js') }}"></script> --}}

    <!--data chart -->
    <script>
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "dataDateFormat": "YYYY-MM-DD",
            "precision": 2,
            "valueAxes": [{
                "id": "v1",
                "title": "Sales",
                "position": "left",
                "autoGridCount": false,
                "labelFunction": function(value) {
                    return "$" + Math.round(value) + "M";
                }
            }, {
                "id": "v2",
                "title": "Market Days",
                "gridAlpha": 0,
                "position": "right",
                "autoGridCount": false
            }],
            "graphs": [{
                "id": "g3",
                "valueAxis": "v1",
                "lineColor": "#e1ede9",
                "fillColors": "#e1ede9",
                "fillAlphas": 1,
                "type": "column",
                "title": "Actual Sales",
                "valueField": "sales2",
                "clustered": false,
                "columnWidth": 0.5,
                "legendValueText": "$[[value]]M",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                "id": "g4",
                "valueAxis": "v1",
                "lineColor": "#62cf73",
                "fillColors": "#62cf73",
                "fillAlphas": 1,
                "type": "column",
                "title": "Target Sales",
                "valueField": "sales1",
                "clustered": false,
                "columnWidth": 0.3,
                "legendValueText": "$[[value]]M",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>$[[value]]M</b>"
            }, {
                "id": "g1",
                "valueAxis": "v2",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 50,
                "lineThickness": 2,
                "lineColor": "#20acd4",
                "type": "smoothedLine",
                "title": "Market Days",
                "useLineColorForBulletBorder": true,
                "valueField": "market1",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }, {
                "id": "g2",
                "valueAxis": "v2",
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 50,
                "lineThickness": 2,
                "lineColor": "#e1ede9",
                "type": "smoothedLine",
                "dashLength": 5,
                "title": "Market Days ALL",
                "useLineColorForBulletBorder": true,
                "valueField": "market2",
                "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
            }],
            "chartScrollbar": {
                "graph": "g1",
                "oppositeAxis": false,
                "offset": 30,
                "scrollbarHeight": 50,
                "backgroundAlpha": 0,
                "selectedBackgroundAlpha": 0.1,
                "selectedBackgroundColor": "#888888",
                "graphFillAlpha": 0,
                "graphLineAlpha": 0.5,
                "selectedGraphFillAlpha": 0,
                "selectedGraphLineAlpha": 1,
                "autoGridCount": true,
                "color": "#AAAAAA"
            },
            "chartCursor": {
                "pan": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "cursorAlpha": 0,
                "valueLineAlpha": 0.2
            },
            "categoryField": "date",
            "categoryAxis": {
                "parseDates": true,
                "dashLength": 1,
                "minorGridEnabled": true
            },
            "legend": {
                "useGraphSettings": true,
                "position": "top"
            },
            "balloon": {
                "borderThickness": 1,
                "shadowAlpha": 0
            },
            "export": {
                "enabled": true
            },

            "dataProvider": [{
                    "date": "2013-01-16",
                    "market1": 71,
                    "market2": 75,
                    "sales1": 3,
                    "sales2": 8
                },

                {
                    "date": "2013-01-17",
                    "market1": 74,
                    "market2": 78,
                    "sales1": 2,
                    "sales2": 6
                },
            ]
        });
    </script>
    <!--get user online ajax -->
    <script>
        // $('document').ready(function() {
        //     $.ajax({
        //         url: "{{ route('useronline') }}",
        //         type: "GET",

        //         success: function(data) {
        //             //console.log(data)
        //             $("#userOnline").html(data)
        //         }
        //     })
        //     setInterval(function() {
        //         getRealData()
        //     }, 60000); //request every x seconds

        // });

        // function getRealData(event) {
        //     // event.preventDefault();
        //     $.ajax({
        //         url: "{{ route('useronline') }}",
        //         type: "GET",

        //         success: function(data) {
        //             //console.log(data)
        //             $("#userOnline").html(data)
        //         }
        //     })
        // };
        function updateOnlineUsers() {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var onlineUsers = parseInt(xhr.responseText);
                    document.getElementById('userOnline').innerText = onlineUsers;
                }
            };

            xhr.open('GET', '{{ route('useronline') }}', true);
            xhr.send();
        }

        // Cập nhật số người dùng online mỗi 1 phút
        setInterval(updateOnlineUsers, 60000);
        
        // Gọi hàm lần đầu khi trang được load
        updateOnlineUsers();
    </script>
@section('js')
@endsection
@endsection
