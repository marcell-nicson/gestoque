<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <section style="background-image: url('/images/gestao.jpg');" class="bg-no-repeat bg-cover bg-center bg-gray-700 bg-blend-multiply bg-opacity-60">
            <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto min-h-screen sm:px-8"> 
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-white">
                    G ESTOQUE
                </a>
                <div class="w-full bg-white rounded-lg shadow mt-4 sm:max-w-md dark:bg-gray-800">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </body>
</html>
