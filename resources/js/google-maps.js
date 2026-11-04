let mapsApiPromise;

/**
 * Loads the Maps JavaScript API once, then imports only the map libraries the
 * application needs. The callback loader follows Google's async loading flow.
 *
 * @param {{ key: string, mapId?: string }} options
 * @returns {Promise<{ AdvancedMarkerElement: unknown, Map: unknown }>}
 */
export async function loadGoogleMapsLibraries({ key, mapId }) {
    if (!key) {
        throw new Error('missing-key');
    }

    if (!window.google?.maps?.importLibrary) {
        mapsApiPromise ??= loadGoogleMapsApi({ key, mapId });

        try {
            await mapsApiPromise;
        } catch (error) {
            mapsApiPromise = undefined;

            throw error;
        }
    }

    const [{ Map }, { AdvancedMarkerElement }] = await Promise.all([
        window.google.maps.importLibrary('maps'),
        window.google.maps.importLibrary('marker'),
    ]);

    return { AdvancedMarkerElement, Map };
}

/**
 * @param {{ key: string, mapId?: string }} options
 * @returns {Promise<void>}
 */
function loadGoogleMapsApi({ key, mapId }) {
    return new Promise((resolve, reject) => {
        const callback = '__alertaPetGoogleMapsReady';
        const params = new URLSearchParams({
            callback,
            key,
            language: 'es',
            loading: 'async',
            region: 'NI',
            v: 'weekly',
        });

        if (mapId) {
            params.set('map_ids', mapId);
        }

        window[callback] = () => {
            delete window[callback];
            resolve();
        };

        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://maps.googleapis.com/maps/api/js?' + params;
        script.onerror = () => {
            delete window[callback];
            reject(new Error('load-failed'));
        };
        document.head.append(script);
    });
}
