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

            [v-cloak] .v-cloak--block {
                display: block;
            }
            [v-cloak] .v-cloak--inline {
                display: inline;
            }
            [v-cloak] .v-cloak--inlineBlock {
                display: inline-block;
            }
            [v-cloak] .v-cloak--hidden {
                display: none;
            }
            [v-cloak] .v-cloak--invisible {
                visibility: hidden;
            }
            .v-cloak--block,
            .v-cloak--inline,
            .v-cloak--inlineBlock {
                display: none;
            }
        </style>
    </head>
    <body>
        <div id="app" v-cloak class="container-fluid row">
            {{--<dashboard>--}}

            {{--</dashboard>--}}
            {{-- ADMIN COMPONENT--}}
            <admin>

            </admin>
        </div>
        <script src="{{ asset('/js/app.js') }}"></script>
    </body>
</html>
