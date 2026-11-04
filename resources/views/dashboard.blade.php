<x-layouts.app>
    @php
        $user = auth()->user();
        $profileLocation = implode(', ', array_filter([$user->city, $user->country?->name]));
        $memberSince = $user->created_at?->locale('es')->translatedFormat('M Y');
    @endphp

    <section class="border-b border-pet-charcoal/10 bg-pet-surface py-6 sm:py-8">
        <div class="page-shell flex flex-col justify-between gap-5 md:flex-row md:items-end">
            <div>
                <p class="eyebrow">Tu espacio</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-pet-deep sm:text-4xl">Hola, {{ $user->name }}.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-pet-muted sm:text-base">Gestiona tu presencia, explora alertas cercanas y acompaña a la comunidad.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('explore') }}" class="button-secondary"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Explorar mapa</a>
                <a href="{{ route('adopt') }}" class="button-primary"><i class="fa-solid fa-paw" aria-hidden="true"></i> Ver adopciones</a>
            </div>
        </div>
    </section>

    <section class="py-8 sm:py-10">
        <div class="page-shell">
            <div class="grid gap-6 lg:grid-cols-12">
                <article class="surface-card flex flex-col p-6 sm:p-7 lg:col-span-4">
                    <div class="flex items-start justify-between gap-4">
                        @if ($user->profile_photo_path)
                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="Foto de perfil de {{ $user->name }}" class="size-24 rounded-full object-cover ring-4 ring-pet-surface">
                        @else
                            <span class="grid size-24 place-items-center rounded-full bg-pet-surface text-3xl font-black text-pet-gold-strong">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                        <a href="{{ route('profile') }}" class="button-tertiary min-h-10 px-3" aria-label="Editar mi perfil"><i class="fa-solid fa-pen" aria-hidden="true"></i></a>
                    </div>

                    <div class="mt-6">
                        <p class="eyebrow">Mi perfil</p>
                        <div class="mt-2 flex flex-wrap items-center gap-1">
                            <h2 class="text-2xl font-black text-pet-deep">{{ $user->name }}</h2>
                            @if ($user->is_verified)<i class="fa-solid fa-circle-check text-pet-primary" title="Cuenta verificada" aria-label="Cuenta verificada"></i>@endif
                            @if ($user->is_worker_organization)<span class="inline-grid size-5 place-items-center rounded-[0.3rem] bg-pet-sepia text-xs text-pet-cream" title="Organización aliada" aria-label="Organización aliada"><i class="fa-solid fa-house" aria-hidden="true"></i></span>@endif
                        </div>
                        @if ($user->alias)<p class="mt-1 text-sm font-bold text-pet-gold-strong">@ {{ $user->alias }}</p>@endif
                        <p class="mt-3 break-words text-sm text-pet-muted">{{ $user->email }}</p>
                        @if ($profileLocation)<p class="mt-2 flex items-center gap-2 text-sm text-pet-muted"><i class="fa-solid fa-location-dot text-pet-gold-strong" aria-hidden="true"></i>{{ $profileLocation }}</p>@endif
                        @if ($user->bio)<p class="mt-4 text-sm leading-6 text-pet-muted">{{ $user->bio }}</p>@endif
                    </div>

                    @if ($memberSince)<div class="mt-6 rounded-xl bg-pet-surface px-4 py-3 text-sm font-bold text-pet-deep"><i class="fa-solid fa-paw mr-2 text-pet-gold-strong" aria-hidden="true"></i>En AlertaPet desde {{ $memberSince }}</div>@endif

                    <div class="mt-8 grid gap-3 border-t border-pet-charcoal/10 pt-6">
                        <div class="flex items-center justify-between gap-4 text-sm"><span class="text-pet-muted">Teléfono</span><span class="font-bold text-pet-deep">{{ $user->phone ?: 'Pendiente' }}</span></div>
                        <div class="flex items-center justify-between gap-4 text-sm"><span class="text-pet-muted">Correo de recuperación</span><span class="font-bold text-pet-deep">{{ $user->recovery_email ?: 'Pendiente' }}</span></div>
                    </div>
                    <a href="{{ route('profile') }}" class="button-secondary mt-8 w-full">Completar mi perfil <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </article>

                <div class="grid gap-6 lg:col-span-8">
                    <div class="grid gap-4 sm:grid-cols-3">
                        @foreach ([
                            ['explore', 'fa-map-location-dot', 'Mapa comunitario', 'Encuentra alertas y mascotas cerca de ti.', 'Explorar'],
                            ['adopt', 'fa-heart', 'Adopciones', 'Conoce mascotas que esperan un hogar.', 'Ver adopciones'],
                            ['profile', 'fa-user-gear', 'Configuración', 'Actualiza privacidad, contacto y cuenta.', 'Administrar'],
                        ] as [$route, $icon, $title, $description, $action])
                            <a href="{{ route($route) }}" class="surface-card group p-5">
                                <span class="grid size-11 place-items-center rounded-xl bg-pet-surface text-pet-gold-strong"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i></span>
                                <h2 class="mt-5 text-base font-black text-pet-deep">{{ $title }}</h2><p class="mt-2 text-sm leading-6 text-pet-muted">{{ $description }}</p>
                                <span class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-pet-gold-strong">{{ $action }} <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1" aria-hidden="true"></i></span>
                            </a>
                        @endforeach
                    </div>

                    <article class="surface-card p-6 sm:p-7">
                        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow">Mis reportes</p><h2 class="mt-2 text-xl font-black text-pet-deep">Tu actividad de ayuda</h2></div><span class="status-badge">Próximamente</span></div>
                        <div class="mt-6 grid gap-4 md:grid-cols-3">
                            @foreach ([['fa-heart', 'Adopciones', 'Publicaciones para dar una nueva oportunidad.'], ['fa-eye', 'Avistamientos', 'Mascotas que has visto y reportado.'], ['fa-magnifying-glass', 'Mascotas perdidas', 'Alertas activas de búsqueda.']] as [$icon, $title, $description])
                                <div class="rounded-xl border border-pet-charcoal/10 bg-pet-surface p-4" aria-busy="true">
                                    <div class="flex items-start justify-between gap-3"><i class="fa-solid {{ $icon }} text-pet-gold-strong" aria-hidden="true"></i><span class="skeleton h-5 w-10 rounded-full"></span></div>
                                    <h3 class="mt-5 text-sm font-black text-pet-deep">{{ $title }}</h3><p class="mt-2 min-h-10 text-xs leading-5 text-pet-muted">{{ $description }}</p>
                                    <div class="mt-4 grid gap-2"><span class="skeleton h-2.5 w-full rounded-full"></span><span class="skeleton h-2.5 w-2/3 rounded-full"></span></div>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <div class="grid gap-6 md:grid-cols-2">
                        <article class="surface-card p-6"><div class="flex items-center justify-between gap-4"><div><p class="eyebrow">Seguimiento</p><h2 class="mt-2 text-lg font-black text-pet-deep">Alertas guardadas</h2></div><i class="fa-solid fa-bookmark text-pet-gold-strong" aria-hidden="true"></i></div><div class="mt-5 grid gap-3" aria-busy="true">@foreach (range(1, 2) as $item)<div class="flex gap-3"><span class="skeleton size-10 rounded-xl"></span><div class="grow space-y-2"><span class="skeleton block h-3 w-4/5 rounded-full"></span><span class="skeleton block h-3 w-2/3 rounded-full"></span></div></div>@endforeach</div></article>
                        <article class="surface-card p-6"><div class="flex items-center justify-between gap-4"><div><p class="eyebrow">Comunidad</p><h2 class="mt-2 text-lg font-black text-pet-deep">Mis aportes</h2></div><i class="fa-solid fa-hand-holding-heart text-pet-gold-strong" aria-hidden="true"></i></div><p class="mt-5 text-sm leading-6 text-pet-muted">Aquí verás el impacto de reportes, adopciones y alertas que compartas con la comunidad.</p><div class="mt-5 grid grid-cols-3 gap-3" aria-busy="true">@foreach (range(1, 3) as $metric)<span class="skeleton block h-16 rounded-xl"></span>@endforeach</div></article>
                    </div>
                </div>
            </div>
            <article class="mt-6 flex flex-col justify-between gap-4 rounded-2xl border border-pet-charcoal/10 bg-pet-surface p-5 sm:flex-row sm:items-center"><div><h2 class="font-black text-pet-deep">¿Terminaste por hoy?</h2><p class="mt-1 text-sm text-pet-muted">Cierra tu sesión de forma segura en este dispositivo.</p></div><form method="POST" action="{{ route('logout') }}">@csrf <button class="button-secondary w-full sm:w-auto"><i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i> Cerrar sesión</button></form></article>
        </div>
    </section>
</x-layouts.app>
