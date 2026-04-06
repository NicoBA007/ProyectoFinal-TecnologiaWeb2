<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso - PrimeCinemas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans text-gray-100 antialiased bg-black selection:bg-red-600 selection:text-white">

    {{-- 1. Navigation va FUERA del div relativo del contenido para que siempre esté arriba --}}
    @include('layouts.navigation', ['forceSolid' => true])

    <div class="min-h-screen flex flex-col">
        {{-- 2. El main debe tener un padding top para que el Nav fixed no lo tape --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Copyright --}}
        <div class="fixed bottom-6 right-10 z-50 hidden lg:block">
            <p class="text-gray-600 text-[10px] font-black uppercase tracking-[0.3em] opacity-50">
                &copy; {{ date('Y') }} PrimeCinemas Cochabamba
            </p>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
