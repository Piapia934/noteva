const CACHE_NAME = 'noteva-v1';
const OFFLINE_URL = '/notes';

// Assets to cache on install
const STATIC_ASSETS = [
    '/',
    '/notes',
    '/manifest.json',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            // Cache what we can, ignore failures
            return Promise.allSettled(
                STATIC_ASSETS.map(url => cache.add(url).catch(() => {}))
            );
        }).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        ).then(() => self.clients.claim())
    );
});

// Network-first strategy (fresh data, fallback to cache for offline)
self.addEventListener('fetch', event => {
    const { request } = event;

    // Only handle GET requests
    if (request.method !== 'GET') return;

    // Skip chrome-extension and non-http
    if (!request.url.startsWith('http')) return;

    event.respondWith(
        fetch(request)
            .then(response => {
                // Cache successful navigations
                if (response.ok && request.mode === 'navigate') {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                }
                return response;
            })
            .catch(() => {
                // Offline: try cache
                return caches.match(request).then(cached => {
                    if (cached) return cached;
                    // For navigation, return the notes page from cache
                    if (request.mode === 'navigate') {
                        return caches.match(OFFLINE_URL);
                    }
                });
            })
    );
});
