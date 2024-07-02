<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
            .auth-block{
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="">Dashboard</a>
                    @else
                        <div class="auth-block row">
                            <div class="col"></div>
                            <a href="{{ route('login') }}" class="col btn btn-primary link-light link-underline-opacity-0">Log in</a>
                            <div class="col"></div>
                        </div>
                        @if (Route::has('register'))
                        <div class="auth-block row">
                            <div class="col"></div>
                            <a href="{{ route('register') }}" class="col btn btn-primary link-light link-underline-opacity-0">Register</a>
                            <div class="col"></div>
                        </div>
                        @endif
                    @endauth
                </div>
            @endif

            
        </div>
    </body>
</html>
