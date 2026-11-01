<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#636B3F">
        <title>AlertaPet</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        @livewireStyles
    </head>
    <body>
        <header class="sticky top-0 z-30 border-b border-pet-deep/10 bg-pet-cream/95 backdrop-blur">
            <div class="page-shell flex min-h-18 items-center justify-between gap-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black tracking-tight text-pet-deep" aria-label="AlertaPet, inicio"><span class="grid size-9 place-items-center rounded-xl bg-pet-marine text-pet-deep"><i class="fa-solid fa-paw" aria-hidden="true"></i></span>Alerta<span class="text-pet-gold-strong">Pet</span></a>
                <nav class="hidden items-center gap-1 md:flex" aria-label="Navegación principal"><a href="{{ route('home') }}" class="button-tertiary">Inicio</a><a href="{{ route('home') }}#como-funciona" class="button-tertiary">Cómo funciona</a><a href="{{ route('adopt') }}" class="button-tertiary">Adopta</a><a href="{{ route('about') }}" class="button-tertiary">Nosotros</a></nav>
                <details class="relative md:hidden"><summary class="grid size-10 cursor-pointer list-none place-items-center rounded-xl border border-pet-deep/15 bg-white text-pet-deep" aria-label="Abrir navegación"><i class="fa-solid fa-bars" aria-hidden="true"></i></summary><nav class="absolute right-0 top-12 z-40 grid w-52 gap-1 rounded-2xl border border-pet-deep/10 bg-white p-2 shadow-xl" aria-label="Navegación móvil"><a href="{{ route('home') }}" class="button-tertiary justify-start">Inicio</a><a href="{{ route('home') }}#como-funciona" class="button-tertiary justify-start">Cómo funciona</a><a href="{{ route('adopt') }}" class="button-tertiary justify-start">Adopta</a><a href="{{ route('about') }}" class="button-tertiary justify-start">Nosotros</a></nav></details>
                @auth
                    <div class="flex items-center gap-3"><a href="{{ route('inicio') }}" class="hidden text-sm font-bold text-pet-deep sm:block">Mi cuenta</a><form method="POST" action="{{ route('logout') }}">@csrf <button class="button-primary min-h-10 px-4">Salir</button></form></div>
                @else
                    <a href="{{ route('login') }}" class="button-primary min-h-10 px-3 sm:px-4"><i class="fa-solid fa-right-to-bracket sm:hidden" aria-hidden="true"></i><span class="hidden sm:inline">Iniciar sesión</span><span class="sr-only sm:hidden">Iniciar sesión</span></a>
                @endauth
            </div>
        </header>
        <main>{{ $slot }}</main>
        <footer class="bg-pet-deep py-10 text-pet-cream/80"><div class="page-shell flex flex-col justify-between gap-5 text-sm sm:flex-row sm:items-center"><p><span class="font-bold text-white">AlertaPet</span> · Red comunitaria para el bienestar animal.</p><p>© {{ date('Y') }} AlertaPet</p></div></footer>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
