<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.2.1/dist/alpine.js" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div class="font-sans antialiased text-gray-900">
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container flex flex-col items-center px-6 mx-auto">
            <i class="fas fa-exclamation-triangle fa-4x w-12 h-12 mt-8 text-purple-200"></i>
            <h1 class="text-6xl font-semibold text-gray-700 dark:text-gray-200 mt-8">
                404
            </h1>
            <p class="text-gray-700 dark:text-gray-300">
                Página não encontrada. Confira o endereço ou volte para a
                <a class="text-purple-600 hover:underline dark:text-purple-300" href="{{ url('/') }}">
                    página inicial
                </a>
                .
            </p>
        </div>
    </main>
</div>
</body>
</html>
