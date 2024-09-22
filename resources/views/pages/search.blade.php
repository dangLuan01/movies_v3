@extends('layout')
@section('content')
    <style>
        input[type=text] {
            width: 130px;
            box-sizing: border-box;
            border: 1px solid white;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            background-color: rgb(14, 14, 14);
            background-position: 10px 10px;
            background-repeat: no-repeat;
            padding: 12px 20px 12px 40px;
            -webkit-transition: width 0.4s ease-in-out;
            transition: width 0.4s ease-in-out;
        }

        input[type=text]:focus {
            width: 100%;
        }
    </style>
    <!--paretn div with black bg after main hero section-->
    <div class="searchform d-flex flex-center flex-middle" style="padding-top: 150px;">
        <form>
            <input type="text" name="search" placeholder="Search.." autocomplete="off">
        </form>
    </div>
    <div class="searchresult">

    </div>
@endsection
