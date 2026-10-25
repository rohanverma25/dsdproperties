/**
 * Service worker for the DSD Properties seller app.
 *
 * Deliberately conservative about what it stores. The seller area is behind a login and
 * several sellers may share a device, so no page under /seller/ is ever written to the
 * cache — only static assets and a small offline fallback. Anything that is not a plain
 * GET (every form submit, photo upload and draft autosave) is passed straight through.
 *
 * Lives at the site root so it can claim the /seller/ scope; it only ever acts on
 * requests inside that scope.
 */

const VERSION     = 'seller-v1';
const SHELL_CACHE = `${VERSION}-shell`;
const ASSET_CACHE = `${VERSION}-assets`;

const OFFLINE_URL = '/seller-app/offline.html';

const PRECACHE = [
    OFFLINE_URL,
    '/seller-app/manifest.webmanifest',
    '/seller-app/icon-192.png',
    '/seller-app/icon-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(SHELL_CACHE)
            .then((cache) => cache.addAll(PRECACHE))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(
                keys.filter((k) => !k.startsWith(VERSION)).map((k) => caches.delete(k))
            ))
            .then(() => self.clients.claim())
    );
});

/** Static files that are safe to serve from cache and revalidate in the background. */
function isCacheableAsset(url) {
    return url.origin === self.location.origin
        && /\.(css|js|png|jpe?g|webp|svg|ico|woff2?|ttf)$/i.test(url.pathname);
}

self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Uploads, logins, draft autosaves — never touched.
    if (request.method !== 'GET') return;

    const url = new URL(request.url);

    // Leave other origins (Google Maps, fonts, Quill CDN) to the browser.
    if (url.origin !== self.location.origin) return;

    // Only act inside the seller app and its own asset folder.
    const inScope = url.pathname.startsWith('/seller/') || url.pathname.startsWith('/seller-app/');
    if (!inScope && !isCacheableAsset(url)) return;

    // Page loads: always go to the network so the seller never sees another session's
    // page or a stale listing. Only if the network fails do we show the offline notice.
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match(OFFLINE_URL, { ignoreSearch: true }))
        );
        return;
    }

    if (isCacheableAsset(url)) {
        event.respondWith(staleWhileRevalidate(request));
    }
});

/** Serve the cached asset immediately, then refresh it for next time. */
async function staleWhileRevalidate(request) {
    const cache  = await caches.open(ASSET_CACHE);
    const cached = await cache.match(request);

    const network = fetch(request)
        .then((response) => {
            // Opaque and error responses are not worth storing.
            if (response && response.status === 200 && response.type === 'basic') {
                cache.put(request, response.clone());
            }
            return response;
        })
        .catch(() => null);

    return cached || network.then((r) => r || fetch(request));
}

// Lets the page trigger an immediate update instead of waiting for a later visit.
self.addEventListener('message', (event) => {
    if (event.data === 'skip-waiting') self.skipWaiting();
});
