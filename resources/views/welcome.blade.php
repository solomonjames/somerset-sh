<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Somerset.sh - Redirect your life</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative flex justify-center min-h-screen bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="inline">
                <img src="{{ asset('images/logo.png') }}" />
            </div>
        </div>
    </body>
</html>
