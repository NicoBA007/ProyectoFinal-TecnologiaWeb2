<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - PrimeCinemas</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @livewireStyles
</head>
<body class="font-sans antialiased bg-black text-white selection:bg-red-600">
    
    <div class="min-h-screen flex flex-col">
        @include('layouts.sideBar')

        <div class="flex-grow lg:ml-64 flex flex-col min-h-screen">
            
            <main class="flex-grow">
                {{ $slot }}
            </main>

            @include('layouts.footerAdmin')
        </div>
    </div>

    @livewireScripts
</body>
</html>