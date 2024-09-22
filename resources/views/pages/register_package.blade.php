@extends('layout')
@section('content')
    <style>
        .demo {
            background: #FAD2C8;
            padding: 30px 0
        }

        a {
            text-decoration: none;
        }

        .pricingTable {
            padding: 25px 10px 70px;
            margin: 0 15px;
            text-align: center;
            z-index: 1;
            position: relative
        }

        .pricingTable:after,
        .pricingTable:before {
            content: "";
            position: absolute;
            left: 0
        }

        .pricingTable .price-value .amount {
            display: inline-block;
            font-size: 50px;
            font-weight: 700
        }

        .pricingTable .price-value .month {
            display: block;
            font-size: 20px;
            font-weight: 500;
            line-height: 10px;
            text-transform: uppercase
        }

        .pricingTable:before {
            width: 100%;
            height: 100%;
            background: #fff;
            top: 0;
            z-index: -1;
            -webkit-clip-path: polygon(100% 0, 100% 85%, 50% 100%, 0 85%, 0 0);
            clip-path: polygon(100% 0, 100% 85%, 50% 100%, 0 85%, 0 0)
        }

        .pricingTable:after {
            width: 70px;
            height: 30px;
            background: #1daa72;
            margin: 0 auto;
            top: 70px;
            right: 0;
            -webkit-clip-path: polygon(50% 100%, 0 0, 100% 0);
            clip-path: polygon(50% 100%, 0 0, 100% 0)
        }

        .pricingTable .title {
            padding: 15px 0;
            margin: 0 -25px 30px;
            background: #1daa72;
            font-size: 25px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            position: relative
        }

        .pricingTable .title:after,
        .pricingTable .title:before {
            border-top: 15px solid #51836d;
            border-bottom: 15px solid transparent;
            position: absolute;
            bottom: -30px;
            content: ""
        }

        .pricingTable .title:before {
            border-left: 15px solid transparent;
            left: 0
        }

        .pricingTable .title:after {
            border-right: 15px solid transparent;
            right: 0
        }

        .pricingTable .price-value {
            margin-bottom: 25px;
            color: #1daa72
        }

        .pricingTable .currency {
            display: inline-block;
            font-size: 30px;
            vertical-align: top;
            margin-top: 8px
        }

        .price-value .amount {
            display: inline-block;
            font-size: 50px;
            font-weight: 700
        }

        .price-value .month {
            display: block;
            font-size: 20px;
            font-weight: 500;
            line-height: 10px;
            text-transform: uppercase
        }

        .pricingTable .pricing-content {
            padding: 0;
            margin: 0 0 25px;
            list-style: none;
            border-top: 1px solid #8f8f8f;
            border-bottom: 1px solid #8f8f8f
        }

        .pricingTable .pricing-content li {
            font-size: 17px;
            color: #8f8f8f;
            line-height: 55px
        }

        .pricingTable .pricingTable-signup {
            display: inline-block;
            padding: 10px 30px;
            background: #1daa72;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            overflow: hidden;
            position: relative;
            transition: all .7s ease 0s
        }

        .pricingTable .pricingTable-signup:before {
            content: "";
            display: inline-block;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 100%);
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transform: translate(0, 100%);
            transition: all .6s ease-in-out 0s
        }

        .pricingTable .pricingTable-signup:hover:before {
            opacity: 1;
            transform: translate(0, -100%)
        }

        .pricingTable.blue .pricingTable-signup,
        .pricingTable.blue .title,
        .pricingTable.blue:after {
            background: #49b0ca
        }

        .pricingTable.blue .title:after,
        .pricingTable.blue .title:before {
            border-top: 15px solid #407a88
        }

        .pricingTable.blue .price-value {
            color: #49b0ca
        }

        .pricingTable.pink .pricingTable-signup,
        .pricingTable.pink .title,
        .pricingTable.pink:after {
            background: #e44444
        }

        .pricingTable.pink .price-value {
            color: #e44444
        }

        .pricingTable.pink .title:after,
        .pricingTable.pink .title:before {
            border-top: 15px solid #773667
        }

        @media only screen and (max-width:990px) {
            .pricingTable {
                margin-bottom: 30px
            }
        }
    </style>
     <!-- Button trigger modal -->
     
    <!-- Modal -->
    <div class="modal fade" id="exampleModal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div style="background-color: #1b2b3c;border-bottom:none;" class="modal-header">
                    <h3 style="color: #d7dfe4;" class="modal-title text-center">
                        Login
                    </h3>
                    {{-- <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span style="color: #ffff;" aria-hidden="true">
                            X
                        </span>
                    </button> --}}
                </div>
                <div style="background-color: #1b2b3c;" class="modal-body">
                    <div>
                        <a href="{{ route('social-github-login') }}"
                            class="btn-login-with bg3 m-b-10 delete">
                            <i class="fa-brands fa-github"></i>
                            Login with Github
                        </a>
                        <a href="{{ route('social-facebook-login') }}"
                            class="btn-login-with bg1 m-b-10">
                            <i class="fa-brands fa-facebook"></i>
                            Login with Facebook
                        </a>

                        <a href="{{ route('social-google-login') }}"
                            class="btn-login-with bg2 m-b-10">
                            <i class="fa-brands fa-google"></i>
                            Login with Google
                        </a>
                    </div>
                </div>
                <div style="background-color: #1b2b3c;border-top:none;" class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="demo">
        <div class="container">
            <div style="margin-right: 15px;" class="row">
                
                @foreach ($list_package as $package)
                    @if ($package->time > 31 && $package->time < 92)
                    <form action="{{ route('checkout') }}" method="post"> 
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <div class="col-md-4 col-sm-6">
                            <div class="pricingTable blue">
                                <h3 class="title">{{ $package->title }}</h3>
                                <input type="hidden" name="name_package" value="{{ $package->title }}">
                                <div class="price-value">
                                    @if ($package->price != 0)
                                        <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="currency">VNĐ</span>
                                        <span class="amount">{{ number_format($package->price, 0, '', ',') }}</span>
                                        {{-- <span class="month">/month</span> --}}
                                    @else
                                        <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="amount">Free</span>
                                    @endif

                                </div>
                                <ul class="pricing-content">
                                    <li><b>{{ $package->time }}</b> Ngày</li>
                                    <input type="hidden" name="time_package" value="{{ $package->time }}">
                                    <input type="hidden" name="description_package" value="{!! $package->description !!}">
                                    <li><b>Mô tả</b> {!! $package->description !!} </li>
                                </ul>
                                @if (Auth::guard('customer')->check())
                                    <button style="submit" class="pricingTable-signup">Đăng Ký Ngay</button>
                                @else
                                    <a href="javascription:void(0);" class="pricingTable-signup" data-toggle="modal"
                                        data-target="#exampleModal1">Đăng Ký Ngay</a>
                                @endif
                            </div>
                        </div>
                       
                    </form>   
                    @elseif ($package->time < 31)
                    <form action="{{ route('checkout') }}" method="post"> 
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <div class="col-md-4 col-sm-6">
                            <div class="pricingTable">
                                <h3 class="title">{{ $package->title }}</h3>
                                <input type="hidden" name="name_package" value="{{ $package->title }}">
                                <div class="price-value">
                                    @if ($package->price != 0)
                                    <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="currency">VNĐ</span>
                                        <span class="amount">{{ number_format($package->price, 0, '', ',') }}</span>
                                        {{-- <span class="month">/month</span> --}}
                                    @else
                                    <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="amount">Free</span>
                                    @endif

                                </div>
                                <ul class="pricing-content">
                                    <li><b>{{ $package->time }}</b> Ngày</li>
                                    <input type="hidden" name="time_package" value="{{ $package->time }}">
                                    <input type="hidden" name="description_package" value="{!! $package->description !!}">
                                    <li><b>Mô tả</b> {!! $package->description !!} </li>
                                </ul>
                                @if (Auth::guard('customer')->check())
                                <button style="submit" class="pricingTable-signup">Đăng Ký Ngay</button>
                                @else
                                <a href="javascription:void(0);" class="pricingTable-signup" data-toggle="modal"
                                    data-target="#exampleModal1">Đăng Ký Ngay</a>
                            @endif
                            </div>
                        </div>
                    </form>   
                    @else
                    <form action="{{ route('checkout') }}" method="post"> 
                        @csrf
                        <input type="hidden" name="id" value="{{ $package->id }}">
                        <div class="col-md-4 col-sm-6">
                            <div class="pricingTable pink">
                                <h3 class="title">{{ $package->title }}</h3>
                                <input type="hidden" name="name_package" value="{{ $package->title }}">
                                <div class="price-value">
                                    @if ($package->price != 0)
                                        <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="currency">VNĐ</span>
                                        <span class="amount">{{ number_format($package->price, 0, '', ',') }}</span>
                                        {{-- <span class="month">/month</span> --}}
                                    @else
                                    <input type="hidden" name="price" value="{{ $package->price }}">
                                        <span class="amount">Free</span>
                                    @endif

                                </div>
                                <ul class="pricing-content">
                                    <input type="hidden" name="time_package" value="{{ $package->time }}">
                                    <li><b>{{ $package->time }}</b> Ngày</li>
                                    <input type="hidden" name="description_package" value="{!! $package->description !!}">
                                    <li><b>Mô tả</b> {!! $package->description !!} </li>
                                </ul>
                                @if (Auth::guard('customer')->check())
                                <button style="submit" class="pricingTable-signup">Đăng Ký Ngay</button>
                                @else
                                <a href="javascription:void(0);" class="pricingTable-signup" data-toggle="modal"
                                    data-target="#exampleModal1">Đăng Ký Ngay</a>
                            @endif
                            </div>
                        </div>
                    </form>   
                    @endif
                @endforeach

            </div>
        </div>
    </div>
   
@endsection
