<x-layouts.app>
    <section class="border-b border-pet-charcoal/10 bg-pet-surface py-7 sm:py-9"><div class="page-shell"><p class="eyebrow">Adopción responsable</p><div class="mt-2 flex flex-col justify-between gap-3 sm:flex-row sm:items-end"><div><h1 class="text-3xl font-black tracking-tight text-pet-charcoal sm:text-4xl">Encuentra un compañero cerca de ti.</h1><p class="mt-2 max-w-2xl text-sm leading-6 text-pet-slate sm:text-base">Explora por especie, categoría, raza y ubicación.</p></div><button type="button" id="open-location-picker" class="button-primary self-start sm:self-auto"><i class="fa-solid fa-location-crosshairs" aria-hidden="true"></i> Usar mi ubicación</button></div></div>
    </section>

    <section class="py-6 sm:py-8"><div class="page-shell"><div class="grid gap-6 xl:grid-cols-[17rem_minmax(0,1fr)]">
        <aside class="h-fit rounded-2xl border border-pet-charcoal/10 bg-white p-4 xl:sticky xl:top-24" aria-labelledby="filters-title"><div class="flex items-center justify-between"><h2 id="filters-title" class="text-lg font-black text-pet-charcoal">Filtros</h2><button type="reset" form="adoption-filters" class="text-sm font-bold text-pet-gold-strong">Limpiar</button></div>
            <form id="adoption-filters" class="mt-4 grid gap-4" aria-label="Filtros de adopción"><fieldset><legend class="text-sm font-bold text-pet-charcoal">Especie</legend><div class="mt-2 grid gap-1">@foreach (['Perro', 'Gato', 'Otra especie'] as $species)<label class="flex min-h-8 items-center gap-2 text-sm text-pet-slate"><input class="size-4 accent-pet-primary" type="checkbox" name="species[]" value="{{ $species }}"> {{ $species }}</label>@endforeach</div></fieldset><fieldset><legend class="text-sm font-bold text-pet-charcoal">Categoría</legend><div class="mt-2 grid gap-1">@foreach (['Cachorro', 'Joven', 'Adulto', 'Senior'] as $category)<label class="flex min-h-8 items-center gap-2 text-sm text-pet-slate"><input class="size-4 accent-pet-primary" type="checkbox" name="category[]" value="{{ $category }}"> {{ $category }}</label>@endforeach</div></fieldset><label class="grid gap-1 text-sm font-bold text-pet-charcoal">Raza<select class="min-h-10 rounded-xl border border-pet-charcoal/20 bg-white px-3 font-normal text-pet-slate"><option value="">Todas las razas</option><option>Mestizo</option><option>Labrador</option><option>Pastor</option><option>Siamés</option></select></label><label class="grid gap-1 text-sm font-bold text-pet-charcoal">Radio <output id="radius-output" class="font-normal text-pet-slate">10 km</output><input id="radius" class="w-full accent-pet-primary" type="range" min="1" max="50" value="10"></label></form>
        </aside>
        <div><div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center"><div><h2 class="text-2xl font-black text-pet-charcoal">Mascotas cerca de ti</h2><p id="location-summary" class="mt-1 text-sm text-pet-slate" aria-live="polite">Selecciona una ubicación para delimitar tu búsqueda.</p></div><span class="status-badge self-start sm:self-auto">Vista de demostración</span></div><div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">@foreach ([['Luna', 'Perra mestiza · joven', 'Managua', 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=900&q=80'], ['Milo', 'Gato · adulto', 'León', 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?auto=format&fit=crop&w=900&q=80'], ['Nala', 'Perra mestiza · cachorro', 'Granada', 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=900&q=80']] as [$name, $detail, $location, $photo])<article class="surface-card overflow-hidden"><img class="aspect-[4/3] w-full object-cover" src="{{ $photo }}" alt="{{ $name }}, mascota en vista de demostración" loading="lazy"><div class="p-5"><span class="status-badge">Demostración</span><h3 class="mt-3 text-xl font-bold text-pet-charcoal">{{ $name }}</h3><p class="mt-1 text-sm text-pet-slate">{{ $detail }}</p><p class="mt-3 text-sm font-bold text-pet-charcoal"><i class="fa-solid fa-location-dot text-pet-gold-strong" aria-hidden="true"></i> {{ $location }}</p></div></article>@endforeach</div></div>
    </div></div></section>

    <dialog id="location-dialog" class="m-auto w-[min(92vw,52rem)] rounded-3xl border border-pet-charcoal/15 bg-white p-0 text-pet-charcoal shadow-2xl backdrop:bg-pet-charcoal/60"><div class="flex items-start justify-between gap-5 border-b border-pet-charcoal/10 p-5"><div><h2 class="text-xl font-black">Selecciona tu ubicación</h2><p class="mt-1 text-sm text-pet-slate">Navega el mapa o pulsa un punto para colocar el pin.</p></div><button type="button" id="close-location-picker" class="grid size-10 place-items-center rounded-xl text-pet-charcoal hover:bg-pet-surface" aria-label="Cerrar selector de ubicación"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button></div><div id="google-map" class="h-[min(58vh,30rem)] w-full bg-pet-surface" role="application" aria-label="Mapa de Google para seleccionar una ubicación"></div><div class="flex flex-col justify-between gap-3 border-t border-pet-charcoal/10 p-5 sm:flex-row sm:items-center"><p id="map-picker-status" class="text-sm text-pet-slate" aria-live="polite">Aún no has seleccionado un punto.</p><div class="flex gap-3"><button type="button" id="use-current-location" class="button-secondary min-h-10 px-4">Ubicación actual</button><button type="button" id="confirm-location" class="button-primary min-h-10 px-4" disabled>Confirmar punto</button></div></div></dialog>
</x-layouts.app>

@push('scripts')
    <script>
        const googleMapsApiKey = @json(config('services.google_maps.key'));
        const dialog = document.getElementById('location-dialog');
        const openPicker = document.getElementById('open-location-picker');
        const closePicker = document.getElementById('close-location-picker');
        const confirmLocation = document.getElementById('confirm-location');
        const useCurrentLocation = document.getElementById('use-current-location');
        const radiusInput = document.getElementById('radius');
        const radiusOutput = document.getElementById('radius-output');
        const locationSummary = document.getElementById('location-summary');
        const pickerStatus = document.getElementById('map-picker-status');
        let googleMap;
        let googleMarker;
        let googleRadiusCircle;
        let selectedLocation;

        const formatLocation = (location) => `${location.lat().toFixed(4)}, ${location.lng().toFixed(4)}`;
        const setSelectedLocation = (location) => { selectedLocation = location; googleMarker?.setPosition(location) || (googleMarker = new google.maps.Marker({ map: googleMap, position: location })); googleRadiusCircle?.setCenter(location).setRadius(Number(radiusInput.value) * 1000) || (googleRadiusCircle = new google.maps.Circle({ map: googleMap, center: location, radius: Number(radiusInput.value) * 1000, strokeColor: '#806400', strokeOpacity: 0.8, strokeWeight: 2, fillColor: '#C8A11F', fillOpacity: 0.15 })); pickerStatus.textContent = `Punto seleccionado: ${formatLocation(location)}.`; confirmLocation.disabled = false; };

        const loadGoogleMaps = () => new Promise((resolve, reject) => {
            if (window.google?.maps) { resolve(); return; }
            if (!googleMapsApiKey) { reject(new Error('missing-key')); return; }
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(googleMapsApiKey)}&v=weekly`;
            script.async = true;
            script.onload = resolve;
            script.onerror = () => reject(new Error('load-failed'));
            document.head.append(script);
        });

        const initializeMap = async () => {
            try {
                await loadGoogleMaps();
                if (googleMap) { return; }
                const center = { lat: 12.1364, lng: -86.2514 };
                googleMap = new google.maps.Map(document.getElementById('google-map'), { center, zoom: 12, mapTypeControl: false, streetViewControl: false, fullscreenControl: true });
                googleMap.addListener('click', (event) => setSelectedLocation(event.latLng));
            } catch (error) {
                pickerStatus.textContent = error.message === 'missing-key' ? 'Configura GOOGLE_MAPS_API_KEY para habilitar Google Maps.' : 'No fue posible cargar Google Maps. Intenta de nuevo más tarde.';
            }
        };

        openPicker.addEventListener('click', async () => { dialog.showModal(); await initializeMap(); });
        closePicker.addEventListener('click', () => dialog.close());
        dialog.addEventListener('click', (event) => { if (event.target === dialog) { dialog.close(); } });
        radiusInput.addEventListener('input', () => { radiusOutput.textContent = `${radiusInput.value} km`; googleRadiusCircle?.setRadius(Number(radiusInput.value) * 1000); if (selectedLocation) { locationSummary.textContent = `Centro: ${formatLocation(selectedLocation)} · radio de ${radiusInput.value} km.`; } });
        useCurrentLocation.addEventListener('click', () => { if (!googleMap || !window.google?.maps) { pickerStatus.textContent = 'Google Maps debe estar configurado antes de usar tu ubicación.'; return; } navigator.geolocation?.getCurrentPosition((position) => { const point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude); googleMap.setCenter(point); googleMap.setZoom(14); setSelectedLocation(point); }, () => { pickerStatus.textContent = 'No se pudo obtener tu ubicación. Puedes seleccionar un punto manualmente.'; }); });
        confirmLocation.addEventListener('click', () => { locationSummary.textContent = `Centro: ${formatLocation(selectedLocation)} · radio de ${radiusInput.value} km.`; dialog.close(); });
    </script>
@endpush
