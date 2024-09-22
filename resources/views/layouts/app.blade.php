<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
    <title>
        Administrator
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="Administrator" />
    <script type="application/x-javascript">
      addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

                      function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css"> --}}
    @yield('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('backend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- font-awesome icons CSS -->
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- //font-awesome icons CSS-->
    <!-- side nav css file -->
    <link href="{{ asset('backend/css/SidebarNav.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- //side nav css file -->
    @yield('css')
    <!-- js-->
    
    <script src="{{ asset('backend/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/modernizr.custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet" />
    <!--//webfonts-->
    <!-- chart -->
    <script src="{{ asset('backend/js/Chart.js') }}"></script>
    <!-- //chart -->
    <!-- Metis Menu -->
    <script src="{{ asset('backend/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet" />
    <!--//Metis Menu -->

    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>
    <!--pie-chart -->
    <!-- index page sales reviews visitors pie chart -->
    <script src="{{ asset('backend/js/pie-chart.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element)
                        .find('.pie-value')
                        .text(Math.round(percent) + '%');
                },
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element)
                        .find('.pie-value')
                        .text(Math.round(percent) + '%');
                },
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element)
                        .find('.pie-value')
                        .text(Math.round(percent) + '%');
                },
            });
        });
    </script>
    <!-- //pie-chart -->
    <!-- index page sales reviews visitors pie chart -->
    <!-- requried-jsfiles-for owl -->
    <link href="{{ asset('backend/css/owl.carousel.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/owl.carousel.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#owl-demo').owlCarousel({
                items: 3,
                lazyLoad: true,
                autoPlay: true,
                pagination: true,
                nav: true,
            });
        });
    </script>
    <!-- //requried-jsfiles-for owl -->
</head>

<body class="cbp-spmenu-push">

    <div class="main-content">

        @include('layouts.navbar')

        <!--left-fixed -navigation-->
        <!-- header-starts -->
        <div class="sticky-header header-section">
            <div class="header-left">
                <!--toggle button start-->
                <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                <!--toggle button end-->
                {{-- <div class="profile_details_left">
            <!--notifications of menu start -->
            <ul class="nofitications-dropdown">
              <li class="dropdown head-dpdn">
                <a
                  href="#"
                  class="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-expanded="false"
                  ><i class="fa fa-envelope"></i><span class="badge">4</span></a
                >
                <ul class="dropdown-menu">
                  <li>
                    <div class="notification_header">
                      <h3>You have 3 new messages</h3>
                    </div>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/1.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li class="odd">
                    <a href="#">
                      <div class="user_img">
                        <img src="images/4.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/3.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/2.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <div class="notification_bottom">
                      <a href="#">See all messages</a>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="dropdown head-dpdn">
                <a
                  href="#"
                  class="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-expanded="false"
                  ><i class="fa fa-bell"></i
                  ><span class="badge blue">4</span></a
                >
                <ul class="dropdown-menu">
                  <li>
                    <div class="notification_header">
                      <h3>You have 3 new notification</h3>
                    </div>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/4.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li class="odd">
                    <a href="#">
                      <div class="user_img">
                        <img src="images/1.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/3.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="user_img">
                        <img src="images/2.jpg" alt="" />
                      </div>
                      <div class="notification_desc">
                        <p>Lorem ipsum dolor amet</p>
                        <p><span>1 hour ago</span></p>
                      </div>
                      <div class="clearfix"></div>
                    </a>
                  </li>
                  <li>
                    <div class="notification_bottom">
                      <a href="#">See all notifications</a>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="dropdown head-dpdn">
                <a
                  href="#"
                  class="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-expanded="false"
                  ><i class="fa fa-tasks"></i
                  ><span class="badge blue1">8</span></a
                >
                <ul class="dropdown-menu">
                  <li>
                    <div class="notification_header">
                      <h3>You have 8 pending task</h3>
                    </div>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <span class="task-desc">Database update</span
                        ><span class="percentage">40%</span>
                        <div class="clearfix"></div>
                      </div>
                      <div class="progress progress-striped active">
                        <div class="bar yellow" style="width: 40%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <span class="task-desc">Dashboard done</span
                        ><span class="percentage">90%</span>
                        <div class="clearfix"></div>
                      </div>
                      <div class="progress progress-striped active">
                        <div class="bar green" style="width: 90%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <span class="task-desc">Mobile App</span
                        ><span class="percentage">33%</span>
                        <div class="clearfix"></div>
                      </div>
                      <div class="progress progress-striped active">
                        <div class="bar red" style="width: 33%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="task-info">
                        <span class="task-desc">Issues fixed</span
                        ><span class="percentage">80%</span>
                        <div class="clearfix"></div>
                      </div>
                      <div class="progress progress-striped active">
                        <div class="bar blue" style="width: 80%"></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="notification_bottom">
                      <a href="#">See all pending tasks</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div> --}}
                <!--notification menu end -->
                <div class="clearfix"></div>
            </div>
            <div class="header-right">
                <!--search-box-->
                {{-- <div class="search-box">
                        <form class="input">
                            <input class="sb-search-input input__field--madoka" placeholder="Search..." type="search"
                                id="input-31" />
                            <label class="input__label" for="input-31">
                                <svg class="graphic" width="100%" height="100%" viewBox="0 0 404 77"
                                    preserveAspectRatio="none">
                                    <path d="m0,0l404,0l0,77l-404,0l0,-77z" />
                                </svg>
                            </label>
                        </form>
                    </div> --}}
                <!--//end-search-box-->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <div class="profile_details">
                        <ul>
                            <li class="dropdown profile_details_drop">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <div class="profile_img">
                                        <span class="prfil-img"><img src="" alt="" />
                                        </span>
                                        <div class="user-name">
                                            <p>{{ Auth::user()->name }}</p>
                                            <span style="text-transform: uppercase;">
                                                @foreach (Auth::user()->roles as $role)
                                                    Role: {{ $role->name }}
                                                @endforeach
                                            </span>
                                        </div>
                                        <i class="fa fa-angle-down lnr"></i>
                                        <i class="fa fa-angle-up lnr"></i>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu drp-mnu">
                                    {{-- <li>
                                        <a href="#"><i class="fa fa-cog"></i> Settings</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ url('clear-cache') }}"><i class="fa fa-user"></i> Clear Cache</a>
                                    </li>
                                    {{-- <li>
                                        <a href="#"><i class="fa fa-suitcase"></i> Profile</a>
                                    </li> --}}
                                    <li>

                                        <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @endguest
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- //header-ends -->
        <!-- main content start-->
        <div id="page-wrapper" style="overflow:auto;">

            <div class="main-page">
                <div class="col_3">

                    <div class="clearfix"></div>
                </div>
                <div class="row-one widgettable">
                    @yield('statistical')

                </div>

                <!-- for amcharts js -->
                {{-- <script src="{{ asset('backend/js/amcharts.js') }}"></script>
                <script src="{{ asset('backend/js/serial.js') }}"></script>
                <script src="{{ asset('backend/js/export.min.js') }}"></script>
                <link rel="stylesheet" href="{{ asset('backend/css/export.css') }}" type="text/css" media="all" />
                <script src="{{ asset('backend/js/light.js') }}"></script> --}}
                <!-- for amcharts js -->
                {{-- <script src="{{ asset('backend/js/index1.js') }}"></script> --}}

                @yield('content')
                @yield('content2')
                @yield('content3')
                @yield('content4')
                @yield('content1')
               
            </div>
            @yield('chart')
            <div class="clearfix"></div>
        </div>
        <!--footer-->
        {{-- <div class="footer">
        <p>
          &copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by
          <a href="https://w3layouts.com/" target="_blank">w3layouts</a>
        </p>
      </div> --}}
        <!--//footer-->
    </div>
    @yield('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
    <script type="text/javascript" src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- new added graphs chart js-->
    <script src="{{ asset('backend/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/utils.js') }}"></script>
    @yield('js')

    <script type="text/javascript">
        $('.select-movie').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('select-movie') }}",
                method: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#show_movie').html(data);
                },
                error: function() {
                    alert('Error');
                }
            });
        })
    </script>
    <script type="text/javascript">
        $('.select-year').change(function() {
            var year = $(this).find(":selected").val();
            var id_phim = $(this).attr("id");

            $.ajax({
                url: "{{ url('/update-year-phim') }}",
                method: "GET",
                data: {
                    year: year,
                    id_phim: id_phim,
                },
                success: function() {
                    alert('Thay doi nam phim theo nam ' + year + ' thanh cong ');
                },
                error: function() {
                    alert('Error');
                }
            });
        })
    </script>

    <script type="text/javascript">
        $('.select-season').change(function() {
            var season = $(this).find(":selected").val();
            var id_phim = $(this).attr("id");
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ url('/update-season-phim') }}",
                method: "POST",
                data: {
                    season: season,
                    id_phim: id_phim,
                    _token: _token
                },

                success: function() {

                    alert('Thay doi phim season ' + season + ' thanh cong ');
                },
                error: function() {
                    alert('Thay doi phim season ' + season + ' that bai ');
                }
            });
        })
    </script>
    <script type="text/javascript">
        $('.movie_hot').change(function() {
            var moviehot_val = $(this).val();
            var movie_id = $(this).attr('id');
            // alert(moviehot_val);
            // alert(movie_id);

            $.ajax({
                url: "{{ route('movie-hot-change') }}",
                method: "GET",
                data: {
                    moviehot_val: moviehot_val,
                    movie_id: movie_id,
                },
                success: function(data) {
                    alert('Change movie hot success!');
                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status == 403) {
                        alert('Access deny!');
                    } else
                        alert('Requested page not found.');
                },
            });
        })
    </script>

    <script type="text/javascript">
        $('.status_movie').change(function() {
            var moviestatus_val = $(this).val();
            var movie_id = $(this).attr('id');
            // alert(moviehot_val);
            // alert(movie_id);

            $.ajax({
                url: "{{ route('movie-status-change') }}",
                method: "GET",
                data: {
                    moviestatus_val: moviestatus_val,
                    movie_id: movie_id,
                },
                success: function(data) {
                    // window.location.reload();
                    alert('Change movie status success!');
                },
                error: function() {
                    alert('Error');
                }
            });
        })
    </script>

<script type="text/javascript">
    $('.status_customer').change(function() {
        var customerstatus_val = $(this).val();
        var customer_id = $(this).attr('id');
         //alert(customerstatus_val);
         //alert(customer_id);

        $.ajax({
            url: "{{ route('customersstatus') }}",
            method: "GET",
            data: {
                customerstatus_val: customerstatus_val,
                customer_id: customer_id,
            },
            success: function(data) {
                // window.location.reload();
                alert('Change customer status success!');
            },
            error: function() {
                alert('Error');
            }
        });
    })
</script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablephim').DataTable();
        });

        function ChangeToSlug() {

            var slug;

            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
    <script type="text/javascript">
        $('.order_position').sortable({

            placeholder: 'ui-state-highlightt',

            update: function(event, ui) {
                var array_id = [];
                $('.order_position tr').each(function() {
                    array_id.push($(this).attr('id'));
                })

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('resorting') }}",
                    method: "POST",
                    data: {
                        array_id: array_id
                    },
                    success: function(data) {
                        alert('Sap xep thanh cong !');
                    },
                    error: function() {
                        alert('Error');
                    }
                });
            }
        })
    </script>

    <script type="text/javascript">
        $(function() {
            $('[data-toggles="tooltip"]').tooltip({
                track: true

            });
        });
    </script>


    <script>
        var MONTHS = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
            ],
            datasets: [{
                    label: 'Dataset 1',
                    backgroundColor: color(window.chartColors.red)
                        .alpha(0.5)
                        .rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                },
                {
                    label: 'Dataset 2',
                    backgroundColor: color(window.chartColors.blue)
                        .alpha(0.5)
                        .rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1,
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                },
            ],
        };

        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Bar Chart',
                    },
                },
            });
        };

        document
            .getElementById('randomizeData')
            .addEventListener('click', function() {
                var zero = Math.random() < 0.2 ? true : false;
                barChartData.datasets.forEach(function(dataset) {
                    dataset.data = dataset.data.map(function() {
                        return zero ? 0.0 : randomScalingFactor();
                    });
                });
                window.myBar.update();
            });

        var colorNames = Object.keys(window.chartColors);
        document
            .getElementById('addDataset')
            .addEventListener('click', function() {
                var colorName =
                    colorNames[barChartData.datasets.length % colorNames.length];
                var dsColor = window.chartColors[colorName];
                var newDataset = {
                    label: 'Dataset ' + barChartData.datasets.length,
                    backgroundColor: color(dsColor).alpha(0.5).rgbString(),
                    borderColor: dsColor,
                    borderWidth: 1,
                    data: [],
                };

                for (var index = 0; index < barChartData.labels.length; ++index) {
                    newDataset.data.push(randomScalingFactor());
                }

                barChartData.datasets.push(newDataset);
                window.myBar.update();
            });

        document.getElementById('addData').addEventListener('click', function() {
            if (barChartData.datasets.length > 0) {
                var month = MONTHS[barChartData.labels.length % MONTHS.length];
                barChartData.labels.push(month);

                for (var index = 0; index < barChartData.datasets.length; ++index) {
                    //window.myBar.addData(randomScalingFactor(), index);
                    barChartData.datasets[index].data.push(randomScalingFactor());
                }

                window.myBar.update();
            }
        });

        document
            .getElementById('removeDataset')
            .addEventListener('click', function() {
                barChartData.datasets.splice(0, 1);
                window.myBar.update();
            });

        document
            .getElementById('removeData')
            .addEventListener('click', function() {
                barChartData.labels.splice(-1, 1); // remove the label first

                barChartData.datasets.forEach(function(dataset, datasetIndex) {
                    dataset.data.pop();
                });

                window.myBar.update();
            });
    </script>
    <!-- new added graphs chart js-->
    <!-- Classie -->
    <!-- for toggle left push menu script -->
    <script src="{{ asset('backend/js/classie.js') }}"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->
    <!--scrolling js-->
    {{-- <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script> --}}
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <!--//scrolling js-->
    <!-- side nav js -->
    <script src="{{ asset('backend/js/SidebarNav.min.js') }}" type="text/javascript"></script>
    <script>
        $('.sidebar-menu').SidebarNav();
    </script>
    <!-- //side nav js -->
    <!-- for index page weekly sales java script -->
    <script src="{{ asset('backend/js/SimpleChart.js') }}"></script>
    <script>
        var graphdata1 = {
            linecolor: '#CCA300',
            title: 'Monday',
            values: [{
                    X: '6:00',
                    Y: 10.0
                },
                {
                    X: '7:00',
                    Y: 20.0
                },
                {
                    X: '8:00',
                    Y: 40.0
                },
                {
                    X: '9:00',
                    Y: 34.0
                },
                {
                    X: '10:00',
                    Y: 40.25
                },
                {
                    X: '11:00',
                    Y: 28.56
                },
                {
                    X: '12:00',
                    Y: 18.57
                },
                {
                    X: '13:00',
                    Y: 34.0
                },
                {
                    X: '14:00',
                    Y: 40.89
                },
                {
                    X: '15:00',
                    Y: 12.57
                },
                {
                    X: '16:00',
                    Y: 28.24
                },
                {
                    X: '17:00',
                    Y: 18.0
                },
                {
                    X: '18:00',
                    Y: 34.24
                },
                {
                    X: '19:00',
                    Y: 40.58
                },
                {
                    X: '20:00',
                    Y: 12.54
                },
                {
                    X: '21:00',
                    Y: 28.0
                },
                {
                    X: '22:00',
                    Y: 18.0
                },
                {
                    X: '23:00',
                    Y: 34.89
                },
                {
                    X: '0:00',
                    Y: 40.26
                },
                {
                    X: '1:00',
                    Y: 28.89
                },
                {
                    X: '2:00',
                    Y: 18.87
                },
                {
                    X: '3:00',
                    Y: 34.0
                },
                {
                    X: '4:00',
                    Y: 40.0
                },
            ],
        };
        var graphdata2 = {
            linecolor: '#00CC66',
            title: 'Tuesday',
            values: [{
                    X: '6:00',
                    Y: 100.0
                },
                {
                    X: '7:00',
                    Y: 120.0
                },
                {
                    X: '8:00',
                    Y: 140.0
                },
                {
                    X: '9:00',
                    Y: 134.0
                },
                {
                    X: '10:00',
                    Y: 140.25
                },
                {
                    X: '11:00',
                    Y: 128.56
                },
                {
                    X: '12:00',
                    Y: 118.57
                },
                {
                    X: '13:00',
                    Y: 134.0
                },
                {
                    X: '14:00',
                    Y: 140.89
                },
                {
                    X: '15:00',
                    Y: 112.57
                },
                {
                    X: '16:00',
                    Y: 128.24
                },
                {
                    X: '17:00',
                    Y: 118.0
                },
                {
                    X: '18:00',
                    Y: 134.24
                },
                {
                    X: '19:00',
                    Y: 140.58
                },
                {
                    X: '20:00',
                    Y: 112.54
                },
                {
                    X: '21:00',
                    Y: 128.0
                },
                {
                    X: '22:00',
                    Y: 118.0
                },
                {
                    X: '23:00',
                    Y: 134.89
                },
                {
                    X: '0:00',
                    Y: 140.26
                },
                {
                    X: '1:00',
                    Y: 128.89
                },
                {
                    X: '2:00',
                    Y: 118.87
                },
                {
                    X: '3:00',
                    Y: 134.0
                },
                {
                    X: '4:00',
                    Y: 180.0
                },
            ],
        };
        var graphdata3 = {
            linecolor: '#FF99CC',
            title: 'Wednesday',
            values: [{
                    X: '6:00',
                    Y: 230.0
                },
                {
                    X: '7:00',
                    Y: 210.0
                },
                {
                    X: '8:00',
                    Y: 214.0
                },
                {
                    X: '9:00',
                    Y: 234.0
                },
                {
                    X: '10:00',
                    Y: 247.25
                },
                {
                    X: '11:00',
                    Y: 218.56
                },
                {
                    X: '12:00',
                    Y: 268.57
                },
                {
                    X: '13:00',
                    Y: 274.0
                },
                {
                    X: '14:00',
                    Y: 280.89
                },
                {
                    X: '15:00',
                    Y: 242.57
                },
                {
                    X: '16:00',
                    Y: 298.24
                },
                {
                    X: '17:00',
                    Y: 208.0
                },
                {
                    X: '18:00',
                    Y: 214.24
                },
                {
                    X: '19:00',
                    Y: 214.58
                },
                {
                    X: '20:00',
                    Y: 211.54
                },
                {
                    X: '21:00',
                    Y: 248.0
                },
                {
                    X: '22:00',
                    Y: 258.0
                },
                {
                    X: '23:00',
                    Y: 234.89
                },
                {
                    X: '0:00',
                    Y: 210.26
                },
                {
                    X: '1:00',
                    Y: 248.89
                },
                {
                    X: '2:00',
                    Y: 238.87
                },
                {
                    X: '3:00',
                    Y: 264.0
                },
                {
                    X: '4:00',
                    Y: 270.0
                },
            ],
        };
        var graphdata4 = {
            linecolor: 'Random',
            title: 'Thursday',
            values: [{
                    X: '6:00',
                    Y: 300.0
                },
                {
                    X: '7:00',
                    Y: 410.98
                },
                {
                    X: '8:00',
                    Y: 310.0
                },
                {
                    X: '9:00',
                    Y: 314.0
                },
                {
                    X: '10:00',
                    Y: 310.25
                },
                {
                    X: '11:00',
                    Y: 318.56
                },
                {
                    X: '12:00',
                    Y: 318.57
                },
                {
                    X: '13:00',
                    Y: 314.0
                },
                {
                    X: '14:00',
                    Y: 310.89
                },
                {
                    X: '15:00',
                    Y: 512.57
                },
                {
                    X: '16:00',
                    Y: 318.24
                },
                {
                    X: '17:00',
                    Y: 318.0
                },
                {
                    X: '18:00',
                    Y: 314.24
                },
                {
                    X: '19:00',
                    Y: 310.58
                },
                {
                    X: '20:00',
                    Y: 312.54
                },
                {
                    X: '21:00',
                    Y: 318.0
                },
                {
                    X: '22:00',
                    Y: 318.0
                },
                {
                    X: '23:00',
                    Y: 314.89
                },
                {
                    X: '0:00',
                    Y: 310.26
                },
                {
                    X: '1:00',
                    Y: 318.89
                },
                {
                    X: '2:00',
                    Y: 518.87
                },
                {
                    X: '3:00',
                    Y: 314.0
                },
                {
                    X: '4:00',
                    Y: 310.0
                },
            ],
        };
        var Piedata = {
            linecolor: 'Random',
            title: 'Profit',
            values: [{
                    X: 'Monday',
                    Y: 50.0
                },
                {
                    X: 'Tuesday',
                    Y: 110.98
                },
                {
                    X: 'Wednesday',
                    Y: 70.0
                },
                {
                    X: 'Thursday',
                    Y: 204.0
                },
                {
                    X: 'Friday',
                    Y: 80.25
                },
                {
                    X: 'Saturday',
                    Y: 38.56
                },
                {
                    X: 'Sunday',
                    Y: 98.57
                },
            ],
        };
        $(function() {
            $('#Bargraph').SimpleChart({
                ChartType: 'Bar',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata4, graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
            $('#sltchartype').on('change', function() {
                $('#Bargraph').SimpleChart('ChartType', $(this).val());
                $('#Bargraph').SimpleChart('reload', 'true');
            });
            $('#Hybridgraph').SimpleChart({
                ChartType: 'Hybrid',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata4],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
            $('#Linegraph').SimpleChart({
                ChartType: 'Line',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: false,
                data: [graphdata4, graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
            $('#Areagraph').SimpleChart({
                ChartType: 'Area',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata4, graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
            $('#Scatterredgraph').SimpleChart({
                ChartType: 'Scattered',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata4, graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
            $('#Piegraph').SimpleChart({
                ChartType: 'Pie',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                showpielables: true,
                data: [Piedata],
                legendsize: '250',
                legendposition: 'right',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });

            $('#Stackedbargraph').SimpleChart({
                ChartType: 'Stacked',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });

            $('#StackedHybridbargraph').SimpleChart({
                ChartType: 'StackedHybrid',
                toolwidth: '50',
                toolheight: '25',
                axiscolor: '#E6E6E6',
                textcolor: '#6E6E6E',
                showlegends: true,
                data: [graphdata3, graphdata2, graphdata1],
                legendsize: '140',
                legendposition: 'bottom',
                xaxislabel: 'Hours',
                title: 'Weekly Profit',
                yaxislabel: 'Profit in $',
            });
        });
    </script>
    <!-- //for index page weekly sales java script -->
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>

    <!-- //Bootstrap Core JavaScript -->
    

</body>

</html>
