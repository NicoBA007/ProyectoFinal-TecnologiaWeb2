<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Acceso - PrimeCinemas</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-100 antialiased bg-gray-950 selection:bg-red-600 selection:text-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">

        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-red-900/20 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-red-900/10 blur-[120px] rounded-full">
            </div>
        </div>

        <div class="z-10 transform transition hover:scale-105 duration-300">
            <a href="/" class="text-4xl font-black tracking-tighter flex items-center gap-3">
                <span class="filter drop-shadow-[0_0_8px_rgba(220,38,38,0.8)] text-5xl">🎬</span>
                <div class="flex flex-col leading-none">
                    <span class="text-white">PRIME</span>
                    <span class="text-red-600">CINEMAS</span>
                </div>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-8 px-8 py-10 bg-gray-900/60 backdrop-blur-xl border border-gray-800 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden sm:rounded-3xl z-10 mx-4">
            {{ $slot }}
        </div>

        <p class="mt-8 text-gray-600 text-xs font-bold uppercase tracking-widest z-10">
            &copy; {{ date('Y') }} PrimeCinemas Cochabamba
        </p>
    </div>
</body>

</html>