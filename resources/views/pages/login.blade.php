@extends('layout')
@section('content')


@section('css')
    <link rel="stylesheet" type="text/css" href="/templatelogin/css/util.css">
    <link rel="stylesheet" type="text/css" href="/templatelogin/css/main.css">
@endsection

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-0 p-b-30">
            <form class="login100-form validate-form">
                <span class="login100-form-title p-b-40">
                    Login
                </span>
                <div>
                    <a href="{{ route('social-github-login') }}" class="btn-login-with bg3 m-b-10 delete">
                        <i class="fa-brands fa-github"></i>
                        Login with Github
                    </a>
                    <a href="{{ route('social-facebook-login') }}" class="btn-login-with bg1 m-b-10">
                        <i class="fa-brands fa-facebook"></i>
                        Login with Facebook
                    </a>

                    <a href="{{ route('social-google-login') }}" class="btn-login-with bg2 m-b-10">
                        <i class="fa-brands fa-google"></i>
                        Login with Google
                    </a>
                </div>
                {{-- <div class="text-center p-t-55 p-b-30">
                            <span class="txt1">
                                Login with email
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-20" data-validate="Please enter password">
                            <span class="btn-show-pass">
                                <i class="fa fa fa-eye"></i>
                            </span>
                            <input class="input100" type="password" name="pass" placeholder="Password">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>
                        <div class="flex-col-c p-t-224">
                            <span class="txt2 p-b-10">
                                Don’t have an account?
                            </span>
                            <a href="#" class="txt3 bo1 hov1">
                                Sign up now
                            </a>
                        </div> --}}
            </form>
        </div>
    </div>
</div>
@endsection
