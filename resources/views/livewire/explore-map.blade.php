<div>
    <section class="border-b border-pet-charcoal/10 bg-pet-surface py-5 sm:py-6">
        <div class="page-shell flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="eyebrow">Explorar</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-pet-deep sm:text-4xl">Mascotas y alertas cerca de ti.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-pet-muted sm:text-base">Usamos tu ubicación solo en este dispositivo para centrar el mapa y mostrarte qué ocurre a tu alrededor.</p>
            </div>
            <button id="explore-current-location" type="button" disabled class="button-primary self-start disabled:cursor-not-allowed disabled:opacity-60 md:self-auto"><i class="fa-solid fa-location-crosshairs" aria-hidden="true"></i> Centrar en mi ubicación</button>
        </div>
    </section>

    <section class="py-6 sm:py-8">
        <div class="page-shell grid gap-6 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="surface-card overflow-hidden">
                    <div class="flex flex-col gap-4 border-b border-pet-charcoal/10 p-5">
                    <div>
                        <h2 class="font-bold text-pet-deep">Mapa comunitario</h2>
                        <p id="explore-map-status" class="mt-1 text-sm text-pet-muted" aria-live="polite">Preparando el mapa y solicitando tu ubicación…</p>
                    </div>
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                            <div id="explore-place-search" class="relative w-full max-w-xl">
                                <form id="explore-place-search-form" class="relative flex min-h-12 items-center rounded-xl border border-pet-charcoal/15 bg-pet-cream shadow-sm" role="search">
                                    <label class="sr-only" for="explore-place-query">Buscar una ciudad, zona o dirección</label>
                                    <i class="fa-solid fa-magnifying-glass ml-4 text-pet-muted" aria-hidden="true"></i>
                                    <input id="explore-place-query" type="search" autocomplete="off" placeholder="Busca una ciudad, zona o dirección" disabled class="min-w-0 grow bg-transparent px-3 py-3 text-sm text-pet-ink outline-none placeholder:text-pet-muted" aria-controls="explore-place-results" aria-expanded="false">
                                    <button type="submit" class="button-tertiary mr-1 min-h-10 px-3" aria-label="Buscar ubicación"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                                </form>
                                <div id="explore-place-results" class="absolute inset-x-0 top-[calc(100%+0.5rem)] z-20 hidden overflow-hidden rounded-xl border border-pet-charcoal/15 bg-pet-cream py-1 shadow-lg" role="listbox" aria-label="Sugerencias de ubicaciones"></div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="status-badge"><i class="fa-solid fa-location-dot text-pet-gold-strong" aria-hidden="true"></i> <span id="explore-location-zone">Tu zona</span></span>
                                <button id="explore-filters" type="button" class="button-secondary min-h-12 px-4 text-sm"><i class="fa-solid fa-sliders" aria-hidden="true"></i> Filtros</button>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div wire:ignore id="explore-google-map" class="h-[min(68vh,44rem)] min-h-[25rem] w-full bg-pet-surface" role="application" aria-label="Mapa de Google centrado en tu ubicación"></div>
                        <div class="pointer-events-none absolute inset-x-0 top-0 flex flex-wrap gap-2 p-3" aria-label="Tipos de alertas mostradas en el mapa">
                            <span class="status-badge bg-pet-cream shadow-sm"><i class="fa-solid fa-house text-pet-gold-strong" aria-hidden="true"></i> En adopción</span>
                            <span class="status-badge bg-pet-cream shadow-sm"><i class="fa-solid fa-magnifying-glass text-pet-gold-strong" aria-hidden="true"></i> Perdidos</span>
                            <span class="status-badge bg-pet-cream shadow-sm"><i class="fa-solid fa-eye text-pet-gold-strong" aria-hidden="true"></i> Avistamientos</span>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-center text-xs leading-5 text-pet-muted">Busca una ciudad, zona o dirección; también puedes permitir tu ubicación o elegir un punto en el mapa. Si no la compartes, mostraremos Managua como referencia.</p>
            </div>
            <aside class="lg:col-span-4" aria-labelledby="nearby-notifications-title">
                <div class="flex items-center justify-between gap-3">
                    <div><p class="eyebrow">Cerca de ti</p><h2 id="nearby-notifications-title" class="mt-1 text-xl font-black text-pet-deep">Notificaciones</h2></div>
                    <span class="status-badge">Próximamente</span>
                </div>
                <div class="mt-4 grid gap-3">
                    @foreach (range(1, 4) as $notification)
                        <article class="surface-card p-4" aria-busy="true" aria-label="Notificación cercana próximamente disponible">
                            <div class="flex gap-3"><span class="skeleton size-10 shrink-0 rounded-xl"></span><div class="grow space-y-3"><span class="skeleton block h-4 w-4/5 rounded-full"></span><span class="skeleton block h-3 w-full rounded-full"></span><span class="skeleton block h-3 w-2/3 rounded-full"></span></div></div>
                        </article>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>
    <dialog id="explore-filters-dialog" class="fixed inset-0 m-auto max-h-[calc(100dvh-2.5rem)] w-[calc(100%-2.5rem)] max-w-xl overflow-y-auto rounded-2xl border border-pet-charcoal/10 bg-pet-cream p-0 text-pet-ink shadow-xl backdrop:bg-black/55">
        <form method="dialog" class="p-6 sm:p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="eyebrow">Próximamente</p>
                    <h2 class="mt-1 text-2xl font-black">Filtrar el mapa</h2>
                    <p class="mt-2 text-sm leading-6 text-pet-muted">Estas opciones estarán disponibles cuando publiquemos alertas y adopciones en tiempo real.</p>
                </div>
                <button type="submit" value="close" class="button-tertiary size-11 shrink-0 p-0" aria-label="Cerrar filtros"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
            </div>
            <fieldset class="mt-6 space-y-3" disabled>
                <legend class="font-bold">Buscar</legend>
                <label class="flex items-center gap-3 rounded-xl border border-pet-charcoal/10 p-3 text-sm"><input type="checkbox" class="size-4 accent-pet-gold-strong"> En adopción</label>
                <label class="flex items-center gap-3 rounded-xl border border-pet-charcoal/10 p-3 text-sm"><input type="checkbox" class="size-4 accent-pet-gold-strong"> Reportes de pérdidas</label>
                <label class="flex items-center gap-3 rounded-xl border border-pet-charcoal/10 p-3 text-sm"><input type="checkbox" class="size-4 accent-pet-gold-strong"> Reportes de avistamientos</label>
            </fieldset>
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <label class="grid gap-2 text-sm font-bold">Categoría de mascota<select class="min-h-11 rounded-xl border border-pet-charcoal/15 bg-pet-surface px-3 text-sm font-normal" disabled><option>Todas</option><option>Perros</option><option>Gatos</option><option>Otras mascotas</option></select></label>
                <label class="grid gap-2 text-sm font-bold">Raza<select class="min-h-11 rounded-xl border border-pet-charcoal/15 bg-pet-surface px-3 text-sm font-normal" disabled><option>Todas las razas</option></select></label>
                <label class="grid gap-2 text-sm font-bold">Días de incidencia<select class="min-h-11 rounded-xl border border-pet-charcoal/15 bg-pet-surface px-3 text-sm font-normal" disabled><option>Cualquier fecha</option><option>Últimas 24 horas</option><option>Últimos 7 días</option></select></label>
            </div>
            <div class="mt-7 flex justify-end"><button type="submit" value="close" class="button-secondary">Cerrar</button></div>
        </form>
    </dialog>
@pushOnce('explore-map-scripts')
    @push('scripts')
        <script>
            (() => {
                const googleMapsApiKey = @json(config('services.google_maps.key'));
                const googleMapsMapId = @json(config('services.google_maps.map_id') ?: 'DEMO_MAP_ID');
                const mapElement = document.getElementById('explore-google-map');
                const status = document.getElementById('explore-map-status');
                const locateButton = document.getElementById('explore-current-location');
                const locationZone = document.getElementById('explore-location-zone');
                const placeSearchForm = document.getElementById('explore-place-search-form');
                const placeSearchInput = document.getElementById('explore-place-query');
                const placeSearchResults = document.getElementById('explore-place-results');
                const filtersButton = document.getElementById('explore-filters');
                const filtersDialog = document.getElementById('explore-filters-dialog');
                const defaultCenter = { lat: 12.1364, lng: -86.2514 };
                const darkMapStyles = [
                    { elementType: 'geometry', stylers: [{ color: '#242424' }] },
                    { elementType: 'labels.text.fill', stylers: [{ color: '#bdbdbd' }] },
                    { elementType: 'labels.text.stroke', stylers: [{ color: '#242424' }] },
                    { featureType: 'administrative', elementType: 'geometry.stroke', stylers: [{ color: '#3f3f3f' }] },
                    { featureType: 'poi', elementType: 'geometry', stylers: [{ color: '#2e2e2e' }] },
                    { featureType: 'poi.park', elementType: 'geometry', stylers: [{ color: '#263127' }] },
                    { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#383838' }] },
                    { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#4a4a4a' }] },
                    { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#151515' }] },
                ];
                let googleMap;
                let locationMarker;
                let AdvancedMarkerElement;
                let geocoder;
                let AutocompleteSessionToken;
                let AutocompleteSuggestion;
                let autocompleteSessionToken;
                let placeSearchTimeout;
                let newestPlaceSearchRequest = 0;

                const isDarkTheme = () => document.documentElement.dataset.theme === 'dark';

                const getZone = (results) => {
                    const components = results?.[0]?.address_components ?? [];
                    const preferredTypes = ['neighborhood', 'sublocality_level_1', 'locality', 'administrative_area_level_2', 'administrative_area_level_1'];

                    return preferredTypes
                        .map((type) => components.find((component) => component.types.includes(type))?.long_name)
                        .find(Boolean);
                };

                const updateZone = async (point) => {
                    try {
                        const { results } = await geocoder.geocode({ location: point });
                        const zone = getZone(results);
                        locationZone.textContent = zone ?? 'Zona aproximada';
                    } catch (error) {
                        locationZone.textContent = 'Zona no disponible';
                    }
                };

                const setPoint = (point, label) => {
                    googleMap.panTo(point);
                    googleMap.setZoom(14);

                    if (locationMarker) {
                        locationMarker.position = point;
                    } else {
                        locationMarker = new AdvancedMarkerElement({
                            map: googleMap,
                            position: point,
                            title: 'Tu ubicación actual',
                        });
                    }

                    status.textContent = label;
                    void updateZone(point);
                };

                const setLocation = (position, label) => setPoint(
                    new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    label,
                );

                const centerOnCurrentLocation = () => {
                    if (!googleMap) {
                        return;
                    }

                    if (!window.isSecureContext) {
                        status.textContent = 'La ubicación GPS requiere HTTPS. Abre el sitio con https://alertapet.test o busca una ubicación.';

                        return;
                    }

                    if (!navigator.geolocation) {
                        status.textContent = 'Tu navegador no permite obtener la ubicación. Puedes seleccionar un punto manualmente en el mapa.';

                        return;
                    }

                    status.textContent = 'Buscando tu ubicación actual…';
                    navigator.geolocation.getCurrentPosition(
                        (position) => setLocation(position, 'Mapa centrado en tu ubicación actual.'),
                        (error) => {
                            status.textContent = error.code === error.PERMISSION_DENIED
                                ? 'No compartiste la ubicación. Puedes seleccionar un punto manualmente en el mapa.'
                                : 'No pudimos obtener tu ubicación. Puedes seleccionar un punto manualmente en el mapa.';
                            googleMap.setCenter(defaultCenter);
                            googleMap.setZoom(12);
                        },
                        { enableHighAccuracy: true, maximumAge: 60000, timeout: 10000 },
                    );
                };

                const hidePlaceSuggestions = () => {
                    placeSearchResults.replaceChildren();
                    placeSearchResults.classList.add('hidden');
                    placeSearchInput.setAttribute('aria-expanded', 'false');
                };

                const showPlace = async (place) => {
                    await place.fetchFields({ fields: ['displayName', 'formattedAddress', 'location', 'viewport'] });

                    if (!place.location) {
                        status.textContent = 'No encontramos una ubicación para esa selección.';

                        return;
                    }

                    if (place.viewport) {
                        googleMap.fitBounds(place.viewport);
                    }

                    setPoint(place.location, place.formattedAddress ?? place.displayName ?? 'Ubicación seleccionada.');
                    placeSearchInput.value = place.formattedAddress ?? place.displayName ?? '';
                    autocompleteSessionToken = new AutocompleteSessionToken();
                    hidePlaceSuggestions();
                };

                const searchWithGeocoder = async (query) => {
                    if (!query.trim()) {
                        return;
                    }

                    status.textContent = 'Buscando la ubicación seleccionada…';

                    try {
                        const { results } = await geocoder.geocode({ address: query, componentRestrictions: { country: 'NI' } });
                        const result = results[0];

                        if (!result?.geometry?.location) {
                            throw new Error('not-found');
                        }

                        if (result.geometry.viewport) {
                            googleMap.fitBounds(result.geometry.viewport);
                        }

                        setPoint(result.geometry.location, result.formatted_address ?? 'Ubicación seleccionada.');
                        placeSearchInput.value = result.formatted_address ?? query;
                        hidePlaceSuggestions();
                    } catch (error) {
                        status.textContent = 'No pudimos encontrar esa ubicación. Verifica el texto o selecciona una sugerencia.';
                    }
                };

                const showPlaceSuggestions = async (query) => {
                    if (!AutocompleteSuggestion || query.trim().length < 2) {
                        hidePlaceSuggestions();

                        return;
                    }

                    const requestId = ++newestPlaceSearchRequest;

                    try {
                        const { suggestions } = await AutocompleteSuggestion.fetchAutocompleteSuggestions({
                            input: query,
                            includedRegionCodes: ['ni'],
                            language: 'es',
                            region: 'ni',
                            sessionToken: autocompleteSessionToken,
                        });

                        if (requestId !== newestPlaceSearchRequest) {
                            return;
                        }

                        const fragment = document.createDocumentFragment();
                        const placePredictions = suggestions.map((suggestion) => suggestion.placePrediction).filter(Boolean);

                        placePredictions.forEach((placePrediction) => {
                            const option = document.createElement('button');
                            option.type = 'button';
                            option.className = 'flex w-full items-center gap-3 px-4 py-3 text-left text-sm text-pet-ink hover:bg-pet-surface focus-visible:bg-pet-surface focus-visible:outline-none';
                            option.setAttribute('role', 'option');
                            option.innerHTML = '<i class="fa-solid fa-location-dot text-pet-gold-strong" aria-hidden="true"></i><span></span>';
                            option.querySelector('span').textContent = placePrediction.text.toString();
                            option.addEventListener('click', () => void showPlace(placePrediction.toPlace()));
                            fragment.appendChild(option);
                        });

                        placeSearchResults.replaceChildren(fragment);
                        placeSearchResults.classList.toggle('hidden', placePredictions.length === 0);
                        placeSearchInput.setAttribute('aria-expanded', String(placePredictions.length > 0));
                    } catch (error) {
                        hidePlaceSuggestions();
                    }
                };

                const initializePlaceSearch = async () => {
                    try {
                        ({ AutocompleteSessionToken, AutocompleteSuggestion } = await window.google.maps.importLibrary('places'));
                        autocompleteSessionToken = new AutocompleteSessionToken();
                    } catch (error) {
                        status.textContent = 'Las sugerencias de Google Places no están disponibles; aún puedes buscar una ubicación por nombre.';
                    }

                    placeSearchInput.disabled = false;
                };

                const initializeMap = async () => {
                    try {
                        const libraries = await window.alertaPetGoogleMaps.loadGoogleMapsLibraries({ key: googleMapsApiKey, mapId: googleMapsMapId });
                        AdvancedMarkerElement = libraries.AdvancedMarkerElement;
                        geocoder = new google.maps.Geocoder();
                        googleMap = new libraries.Map(mapElement, {
                            center: defaultCenter,
                            zoom: 12,
                            mapId: googleMapsMapId,
                            fullscreenControl: true,
                            mapTypeControl: false,
                            streetViewControl: false,
                            styles: isDarkTheme() ? darkMapStyles : null,
                        });
                        googleMap.addListener('click', (event) => {
                            setPoint(event.latLng, 'Ubicación manual seleccionada.');
                        });
                        locateButton.disabled = false;
                        void initializePlaceSearch();
                        centerOnCurrentLocation();
                    } catch (error) {
                        status.textContent = error.message === 'missing-key'
                            ? 'Configura GOOGLE_MAPS_API_KEY para habilitar el mapa.'
                            : 'No fue posible cargar Google Maps. Revisa tu conexión o bloqueador de contenido.';
                    }
                };

                locateButton.addEventListener('click', centerOnCurrentLocation);
                placeSearchForm.addEventListener('submit', (event) => {
                    event.preventDefault();
                    void searchWithGeocoder(placeSearchInput.value);
                });
                placeSearchInput.addEventListener('input', () => {
                    window.clearTimeout(placeSearchTimeout);
                    placeSearchTimeout = window.setTimeout(() => void showPlaceSuggestions(placeSearchInput.value), 250);
                });
                placeSearchInput.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        hidePlaceSuggestions();
                    }
                });
                filtersButton.addEventListener('click', () => filtersDialog.showModal());
                window.addEventListener('alertapet:theme-changed', (event) => googleMap?.setOptions({
                    styles: event.detail.theme === 'dark' ? darkMapStyles : null,
                }));

                if (window.alertaPetGoogleMaps) {
                    initializeMap();
                } else {
                    window.addEventListener('alertapet:google-maps-loader-ready', initializeMap, { once: true });
                }
            })();
        </script>
    @endpush
@endPushOnce
</div>
