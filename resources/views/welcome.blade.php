<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Панель администрирования</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

        <!-- Styles -->
        <style>

            {{--@font-face {--}}
                {{--font-family: "Pe-icon-7-stroke";--}}
                {{--src: url({{ public_path('/fonts/pe7-icons/Pe-icon-7-stroke.svg') }}) format("svg");--}}
                     {{--url({{ public_path('/fonts/pe7-icons/Pe-icon-7-stroke.woff') }}) format("woff");--}}
                     {{--url({{ public_path('/fonts/pe7-icons/Pe-icon-7-stroke.ttf') }}) format("ttf");--}}
                     {{--url({{ public_path('/fonts/pe7-icons/Pe-icon-7-stroke.eot') }}) format("eot");--}}
            {{--}--}}
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .spinner-block {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #fff;
                background: #000000;
            }
            .spinner {
                font-size: 50px;
                position: relative;
            }
            .spinner:before, .spinner:after {
                content: "";
                position: relative;
                display: block;
            }
            .spinner:before {
                animation: spinner 2.5s cubic-bezier(0.75, 0, 0.5, 1) infinite normal;
                width: 1em;
                height: 1em;
                background-color: #f07260;
            }
            .spinner:after {
                animation: shadow 2.5s cubic-bezier(0.75, 0, 0.5, 1) infinite normal;
                bottom: -.5em;
                height: .25em;
                border-radius: 50%;
                background-color: rgba(#000,0.2);
            }

            @keyframes spinner {
                50% {
                    border-radius: 50%;
                    transform: scale(0.5) rotate(360deg);
                }
                100% {
                    transform: scale(1) rotate(720deg);
                }
            }
            @keyframes shadow {
                50% {
                    transform: scale(0.5);
                    background-color: rgba(#000,0.1);
                }
            }

            .fader {
                opacity: 0;
                transition: opacity 1s ease;
            }
            body.AppMounted .spinner-block { display: none; }
            body.AppMounted .fader { opacity: 1; }
        </style>

    </head>
    <body>
        <div id="app" v-cloak class="">
            {{-- ADMIN COMPONENT--}}
            <base-main></base-main>
        </div>
        <div class="spinner-block d-none">
            <h1>Загрузка...</h1>
            <div class="spinner"></div>
        </div>
        <script src="{{ asset('/js/app.js') }}"></script>
    </body>
</html>
