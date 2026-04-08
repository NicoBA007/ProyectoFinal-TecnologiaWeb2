<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mi Panel - PrimeCinemas</title>

    {{-- 1. AGREGAR ESTO (Alpine.js) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- 2. AGREGAR ESTO (Para que x-cloak funcione) --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-950 text-white selection:bg-red-600 selection:text-white">
    <div class="min-h-screen bg-gray-950">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-gray-900 border-b border-gray-800 shadow-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>

    @livewireScripts

    @stack('scripts')
</body>

</html>
