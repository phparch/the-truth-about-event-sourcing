<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased flex flex-col min-h-screen">
<div class="flex-grow bg-gray-100">

    <!-- Page Heading -->
    @if (isset($header))
        <div class="max-w-7xl p-6 lg:px-8 text-6xl font-extrabold text-center mx-auto">
            {{ $header }}
        </div>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<footer class="bg-gray-800 text-white py-4">

    <div
        class="flex flex-col md:flex-row justify-between items-center pr-4 pl-4">
        <nav class="flex flex-wrap justify-center space-x-6">
            <a href="https://phparch.com"
               class="font-normal text-sm hover:text-gray-400 dark:text-white dark:hover:text-tek-orange-900 mb-2">
                <img class="h-10" src="https://cdn.phparch.social/logos/php%5Barchitect%5D%20Logo%202023.png"
                     alt="PHP Architect, LLC."></a>
        </nav>
        <p class="text-sm text-center md:text-right">
            PHP Architect Magazine. For Developer. By Developer.
        </p>

        <p class="text-sm text-center md:text-right">
            &copy; {{ date('Y') }} PHP Architect LLC. All rights reserved.
        </p>
    </div>
</footer>

@stack('modals')
@livewireScripts
</body>
</html>
