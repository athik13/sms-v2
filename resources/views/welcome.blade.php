<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            .background {
                background: linear-gradient(58deg, #add8e6, #57d1f5);
            }
            html, body {
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                margin: 0;
                background-repeat: no-repeat;
                background-attachment: fixed;
                overflow: hidden
            }

            #particles-js canvas {
                display: block;
                vertical-align: bottom;
                -webkit-transform: scale(1);
                -ms-transform: scale(1);
                transform: scale(1);
                opacity: 1;
                -webkit-transition: opacity .8s ease, -webkit-transform 1.4s ease;
                transition: opacity .8s ease, transform 1.4s ease
            }

            #particles-js {
                width: 100%;
                height: 100%;
                position: fixed;
                z-index: -10;
                top: 0;
                left: 0
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
                font-size: 60px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            a.button1{
                display:inline-block;
                padding:0.35em 1.2em;
                border:0.1em solid #FFFFFF;
                margin:0 0.3em 0.3em 0;
                border-radius:0.12em;
                box-sizing: border-box;
                text-decoration:none;
                font-family:'Roboto',sans-serif;
                font-weight:300;
                color:#FFFFFF;
                text-align:center;
                transition: all 0.2s;
            }
            a.button1:hover{
                color:#000000;
                background-color:#FFFFFF;
            }
            @media all and (max-width:30em){
                a.button1{
                    display:block;
                    margin:0.4em auto;
                }
            } 
        </style>
    </head>
    <body class="background">
        <div id="particles-js"></div>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a class="button1" href="{{ url('/sms') }}">Send SMS</a>
                    @else 
                        <a class="button1" href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a class="button1" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    SMS MALDIVES
                </div>
                <span style="font-size: 200%">by bl4nk.dev</span>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script>
            particlesJS.load('particles-js', 'assets/particles.json', function() {
                console.log('callback - particles.js config loaded');
            });
        </script>
    </body>
</html>
