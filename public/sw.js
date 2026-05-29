const CACHE = 'noteva-v3';

const PRECACHE = [
    '/notes',
    '/manifest.json',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
];

// Install — cache core pages
self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE).then(cache =>
            Promise.allSettled(PRECACHE.map(url => cache.add(url).catch(() => {})))
        )
    );
});

// Activate — clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(keys.filter(k => k !== CACHE).map(k => caches.delete(k))))
            .then(() => self.clients.claim())
    );
});

// Fetch — cache everything, serve from cache when offline
self.addEventListener('fetch', event => {
    const { request } = event;

    // Skip non-GET
    if (request.method !== 'GET') return;
    if (!request.url.startsWith('http')) return;

    // Skip API/JSON calls — let them fail naturally offline
    if (request.headers.get('Accept')?.includes('application/json')) return;

    event.respondWith(
        caches.open(CACHE).then(async cache => {
            // Try network first
            try {
                const response = await fetch(request);
                // Cache successful HTML/CSS/JS/image responses
                if (response.ok) {
                    cache.put(request, response.clone());
                }
                return response;
            } catch {
                // Offline — serve from cache
                const cached = await cache.match(request);
                if (cached) return cached;

                // For navigation, serve the notes page from cache
                if (request.mode === 'navigate') {
                    const notesPage = await cache.match('/notes');
                    if (notesPage) return notesPage;
                }

                // Fallback offline page
                return new Response(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>Noteva — Offline</title>
                        <style>
                            *{margin:0;padding:0;box-sizing:border-box;}
                            body{font-family:sans-serif;background:#0f0e17;color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px;}
                            .card{background:#1a1827;border:1px solid rgba(255,255,255,0.07);border-radius:24px;padding:48px 36px;max-width:380px;width:100%;}
                            h1{font-size:24px;margin:16px 0 10px;}
                            p{color:#a7a9be;font-size:14px;line-height:1.7;margin-bottom:24px;}
                            button{padding:12px 28px;border-radius:50px;border:none;background:linear-gradient(135deg,#ff6b6b,#ff8e53);color:white;font-size:14px;font-weight:600;cursor:pointer;}
                        </style>
                    </head>
                    <body>
                        <div class="card">
                            <div style="font-size:56px">📡</div>
                            <h1>You're Offline</h1>
                            <p>Open the app while online first so it can be cached, then it will work offline.</p>
                            <button onclick="location.reload()">Try Again</button>
                        </div>
                    </body>
                    </html>
                `, { headers: { 'Content-Type': 'text/html' } });
            }
        })
    );
});