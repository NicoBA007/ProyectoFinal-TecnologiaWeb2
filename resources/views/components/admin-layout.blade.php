<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PrimeCinemas Admin') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #0a0a0a; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #1f1f1f; rounded: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #dc2626; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white selection:bg-red-600/30 selection:text-red-500">
        
        <div class="min-h-screen flex">
            
            {{-- 1. INCLUIR EL SIDEBAR --}}
            {{-- Puedes pegar el código del <nav> directamente aquí o usar un @include si lo tienes aparte --}}
            @include('layouts.sidebar-admin') 

            {{-- 2. CONTENIDO PRINCIPAL --}}
            {{-- Usamos ml-64 para dejar espacio al Sidebar cuando está abierto --}}
            <main class="flex-1 transition-all duration-300 ml-20 md:ml-64">
                <div class="min-h-screen">
                    {{ $slot }}
                </div>
            </main>

        </div>

        {{-- Scripts adicionales de AlpineJS (si no están en app.js) --}}
        @stack('scripts')
    </body>
</html>