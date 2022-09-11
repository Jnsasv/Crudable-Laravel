<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app2.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="bg-secondary bg-opacity-25">
        @include('layouts.navigation')

            <!-- Page Heading -->
            <header>
                <div class="container">
                    <div class="border bg-white rounded-3 my-2 mx-auto py-2 px-4 px-3-sm px-4-lg">
                        <h2>
                            {{ $header }}
                        </h2>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="container">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
