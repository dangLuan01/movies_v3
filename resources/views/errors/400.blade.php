@extends('layout')
@section('content')
    <style type="text/css">
        @keyframes noise {
            0% {
                background-position-y: 0px;
            }

            100% {
                background-position-y: -420px;
            }
        }

        body,
        html {
            overflow: hidden;
            margin: 0px;
            background: rgb(31, 31, 31);
            height: 100vh;
            box-shadow: 0px 0px 122px 25px black inset;
            background-image: url('https://i.imgur.com/eg7VIun.jpg');
            background-repeat: repeat;
            animation: noise 230ms steps(6) infinite;

        }

        .glitch-wrapper {


            padding: 120px;
            padding-left: 120px;

            animation: glitch 2s linear infinite;
            margin-bottom: 50%;
            padding-left: 20%;
        }



       

        .glitch-text {
            position: relative;
            z-index: 2;
            opacity: .9;
            margin: 0 auto;
            text-shadow: 0px 0px 3px white;
            animation: glitch 3s infinite;
            cursor: pointer;
            font-size: 52px;
            color: white;
        }


       

      


        .paused {
            animation-play-state: paused;
        }


        /* JUST RANDOM VALUES HERE! */
        @keyframes glitch {
            3% {
                text-shadow: 7px 7px 0px red;
            }

            6% {
                text-shadow: -9px 4px 0px blue;
                transform: translate(4px, -10px) skewX(3240deg);
            }

            7% {
                text-shadow: 3px -4px 0px green;
            }

            9% {
                text-shadow: 0px 0px 3px white;
                transform: translate(0px, 0px) skewX(0deg);
            }

            2%,
            54% {
                transform: translateX(0px) skew(0deg);
            }

            55% {
                transform: translate(-2px, 6px) skew(-5530deg);
            }

            56% {
                text-shadow: 0px 0px 3px white;
                transform: translate(0px, 0px) skew(0deg);
            }

            57% {
                text-shadow: 7px 7px 0px red;
                transform: translate(4px, -10px) skew(-70deg);
            }

            58% {
                text-shadow: 0px 0px 3px white;
                transform: translate(0px, 0px) skew(0deg);
            }

            62% {
                text-shadow: 3px -4px 0px green;
                transform: translate(0px, 20px) skew(0deg);
            }

            63% {
                text-shadow: 0px 0px 3px white;
                transform: translate(4px, -2px) skew(0deg);
            }

            64% {
                transform: translate(1px, 3px);
                skew(-230deg);
            }

            65% {
                transform: translate(-7px, 2px);
                skew(120deg);
            }

            66% {
                transform: translate(0px, 0px) skew(0deg);
            }

        }
    </style>
    <div class="glitch-wrapper">
        <div class="glitch-text">
            ERROR Movie: Not found
        </div>
        <h1>Hmm, why did you land here somehow?</h1>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $('button').hover(function() {
            $('.glitch-wrapper').toggleClass('paused');
            $('body').toggleClass('paused');
        });
    </script>
@endsection
