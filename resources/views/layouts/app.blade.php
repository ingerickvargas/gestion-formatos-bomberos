<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" href="{{ asset('images/ico-bomberos.ico') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
	<body class="font-sans antialiased">
        <div
            x-data="{ sidebarOpen: false }"
            class="min-h-screen bg-gray-100"
        >
            {{-- NAV + SIDEBAR --}}
            @include('layouts.navigation')

            {{-- CONTENIDO (se corre cuando sidebarOpen=true en pantallas lg+) --}}
            <div class="transition-all duration-200" :class="sidebarOpen ? 'lg:pl-72' : 'lg:pl-0'">

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="w-full py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="w-full px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </body>
</html>
