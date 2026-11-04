<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#FF385C">
        <meta name="color-scheme" content="light dark">
        <title>AlertaPet</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script>try { document.documentElement.dataset.theme = localStorage.getItem('alertapet-theme') ?? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'); } catch { document.documentElement.dataset.theme = 'light'; }</script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        @livewireStyles
    </head>
    <body class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-pet-deep/10 bg-pet-cream/95 backdrop-blur">
            <div class="page-shell flex min-h-18 items-center justify-between gap-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black tracking-tight text-pet-deep" aria-label="AlertaPet, inicio"><span class="grid size-9 place-items-center rounded-xl bg-pet-marine text-pet-deep"><i class="fa-solid fa-paw" aria-hidden="true"></i></span>Alerta<span class="text-pet-gold-strong">Pet</span></a>
                <nav class="hidden items-center gap-1 md:flex" aria-label="Navegación principal"><a href="{{ route('home') }}" class="button-tertiary">Inicio</a><a href="{{ route('home') }}#como-funciona" class="button-tertiary">Cómo funciona</a><a href="{{ route('explore') }}" class="button-tertiary">Explorar mapa</a><a href="{{ route('adopt') }}" class="button-tertiary">Adopta</a><a href="{{ route('about') }}" class="button-tertiary">Nosotros</a></nav>
                <details class="relative md:hidden"><summary class="grid size-10 cursor-pointer list-none place-items-center rounded-xl border border-pet-deep/15 bg-white text-pet-deep" aria-label="Abrir navegación"><i class="fa-solid fa-bars" aria-hidden="true"></i></summary><nav class="absolute right-0 top-12 z-40 grid w-52 gap-1 rounded-2xl border border-pet-deep/10 bg-white p-2 shadow-xl" aria-label="Navegación móvil"><a href="{{ route('home') }}" class="button-tertiary justify-start">Inicio</a><a href="{{ route('home') }}#como-funciona" class="button-tertiary justify-start">Cómo funciona</a><a href="{{ route('explore') }}" class="button-tertiary justify-start">Explorar mapa</a><a href="{{ route('adopt') }}" class="button-tertiary justify-start">Adopta</a><a href="{{ route('about') }}" class="button-tertiary justify-start">Nosotros</a></nav></details>
                <div class="flex items-center gap-2 sm:gap-3">
                    <button type="button" data-theme-toggle class="grid size-10 place-items-center rounded-xl border border-pet-deep/15 bg-white text-pet-deep hover:bg-pet-surface" aria-label="Activar modo oscuro" aria-pressed="false"><i data-theme-icon class="fa-solid fa-moon" aria-hidden="true"></i><span data-theme-label class="sr-only">Modo oscuro</span></button>
                @auth
                    @php($navigationUser = auth()->user())
                    <div class="flex items-center gap-2 sm:gap-3">
                        <a href="{{ route('inicio') }}" class="flex min-h-10 items-center gap-2 rounded-xl px-1 text-sm font-bold text-pet-deep hover:bg-pet-surface sm:px-2" aria-label="Abrir mi inicio">
                            @if ($navigationUser->profile_photo_path)
                                <img src="{{ asset('storage/'.$navigationUser->profile_photo_path) }}" alt="" class="size-9 rounded-full object-cover ring-2 ring-pet-surface">
                            @else
                                <span class="grid size-9 place-items-center rounded-full bg-pet-surface text-xs font-black text-pet-gold-strong">{{ strtoupper(substr($navigationUser->name, 0, 1)) }}</span>
                            @endif
                            <span class="hidden max-w-32 truncate sm:inline">{{ $navigationUser->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">@csrf <button class="button-tertiary min-h-10 px-3" aria-label="Cerrar sesión"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i><span class="hidden sm:inline">Salir</span></button></form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="button-primary min-h-10 px-3 sm:px-4"><i class="fa-solid fa-right-to-bracket sm:hidden" aria-hidden="true"></i><span class="hidden sm:inline">Iniciar sesión</span><span class="sr-only sm:hidden">Iniciar sesión</span></a>
                @endauth
                </div>
            </div>
        </header>
        <main class="grow">{{ $slot }}</main>
        <footer class="bg-pet-deep py-12 text-white/70"><div class="page-shell"><div class="grid gap-10 border-b border-white/15 pb-10 md:grid-cols-2 lg:grid-cols-[1.35fr_repeat(3,.65fr)]"><div><a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xl font-black tracking-tight text-white"><span class="grid size-9 place-items-center rounded-xl bg-pet-primary"><i class="fa-solid fa-paw" aria-hidden="true"></i></span>AlertaPet</a><p class="mt-4 max-w-sm text-sm leading-6">Una red comunitaria para encontrar, proteger y dar una nueva oportunidad a cada mascota.</p><div class="mt-5 flex gap-2"><a href="#" class="grid size-9 place-items-center rounded-lg border border-white/15 hover:bg-white/10" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a><a href="#" class="grid size-9 place-items-center rounded-lg border border-white/15 hover:bg-white/10" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a><a href="#" class="grid size-9 place-items-center rounded-lg border border-white/15 hover:bg-white/10" aria-label="X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a></div></div><nav aria-label="Explorar"><h2 class="text-sm font-bold text-white">Explorar</h2><ul class="mt-4 grid gap-3 text-sm"><li><a href="{{ route('explore') }}" class="hover:text-white">Mapa comunitario</a></li><li><a href="{{ route('adopt') }}" class="hover:text-white">Adopciones</a></li><li><a href="#" class="hover:text-white">Mascotas perdidas</a></li><li><a href="#" class="hover:text-white">Mascotas encontradas</a></li><li><a href="{{ route('about') }}" class="hover:text-white">Nuestra comunidad</a></li></ul></nav><nav aria-label="Ayuda"><h2 class="text-sm font-bold text-white">Ayuda</h2><ul class="mt-4 grid gap-3 text-sm"><li><a href="#" class="hover:text-white">Centro de ayuda</a></li><li><a href="#" class="hover:text-white">Preguntas frecuentes</a></li><li><a href="#" class="hover:text-white">Seguridad y confianza</a></li><li><a href="#" class="hover:text-white">Contactar soporte</a></li></ul></nav><nav aria-label="Legal"><h2 class="text-sm font-bold text-white">Legal</h2><ul class="mt-4 grid gap-3 text-sm"><li><a href="#" class="hover:text-white">Términos y condiciones</a></li><li><a href="#" class="hover:text-white">Política de privacidad</a></li><li><a href="#" class="hover:text-white">Política de anuncios</a></li><li><a href="#" class="hover:text-white">Cookies</a></li><li><a href="#" class="hover:text-white">Accesibilidad</a></li></ul></nav></div><div class="flex flex-col justify-between gap-3 pt-6 text-xs sm:flex-row sm:items-center"><p>© {{ date('Y') }} AlertaPet. Todos los derechos reservados.</p><div class="flex flex-wrap gap-x-4 gap-y-2"><a href="#" class="hover:text-white">Estado del servicio</a><a href="#" class="hover:text-white">Directrices de la comunidad</a><a href="#" class="hover:text-white">Preferencias de privacidad</a></div></div></div></footer>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
