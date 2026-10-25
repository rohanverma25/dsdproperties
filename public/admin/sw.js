/*
 * Service worker for the DSD Leads admin app.
 * Lives at /admin/sw.js so its scope is limited to /admin/ — the public
 * marketing site is never intercepted.
 *
 * Deliberately conservative: lead data is never cached. Only the shell
 * (icons, offline page) and third-party CDN assets are stored, so the app
 * can open offline and tell you plainly that it needs a connection.
 * Bump CACHE_VERSION whenever this file or offline.html changes.
 */
const CACHE_VERSION = 'dsd-leads-v2';
const SHELL = [
  '/admin/offline.html',
  '/admin/manifest.webmanifest',
  '/admin/icons/icon-192.png',
  '/admin/icons/icon-512.png',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_VERSION)
      // addAll is all-or-nothing; one 404 would abort the install.
      .then((cache) => Promise.allSettled(SHELL.map((url) => cache.add(url))))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys.filter((k) => k !== CACHE_VERSION).map((k) => caches.delete(k))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('message', (event) => {
  if (event.data === 'skip-waiting') { self.skipWaiting(); }
});

self.addEventListener('fetch', (event) => {
  const req = event.request;

  // Never touch form submissions — logging an activity must always hit the server.
  if (req.method !== 'GET') return;

  const url = new URL(req.url);

  // Page loads: always go to the network so lead data is never stale.
  // If the network is gone, show the offline page instead of a browser error.
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req).catch(() => caches.match('/admin/offline.html'))
    );
    return;
  }

  // Our own icons and manifest: cache-first, they rarely change.
  if (url.origin === self.location.origin && url.pathname.startsWith('/admin/icons/')) {
    event.respondWith(
      caches.match(req).then((hit) => hit || fetch(req).then((res) => {
        const copy = res.clone();
        caches.open(CACHE_VERSION).then((c) => c.put(req, copy));
        return res;
      }))
    );
    return;
  }

  // Bootstrap / jQuery / Font Awesome from CDN: serve from cache, refresh in
  // the background. This is what makes a repeat open feel instant on 3G.
  if (url.origin !== self.location.origin) {
    event.respondWith(
      caches.match(req).then((hit) => {
        const net = fetch(req).then((res) => {
          if (res && (res.ok || res.type === 'opaque')) {
            const copy = res.clone();
            caches.open(CACHE_VERSION).then((c) => c.put(req, copy));
          }
          return res;
        }).catch(() => hit);
        return hit || net;
      })
    );
  }
});


/* ------------------------------------------------------------ notifications */

/*
 * New WhatsApp messages. The payload is written by App\Services\WhatsAppPush;
 * `tag` is per chat, so ten messages from one person replace each other rather
 * than stacking up ten notifications.
 */
self.addEventListener('push', (event) => {
  let data = {};
  try { data = event.data ? event.data.json() : {}; } catch (e) { /* not ours */ }

  const title = data.title || 'New WhatsApp message';

  event.waitUntil(
    self.registration.showNotification(title, {
      body: data.body || '',
      tag: data.tag || 'wa-message',
      renotify: true,
      icon: '/admin/icons/icon-192.png',
      badge: '/admin/icons/icon-192.png',
      data: { url: data.url || '/admin/whatsapp' },
    })
  );
});

self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  const target = event.notification.data?.url || '/admin/whatsapp';

  // Reuse an open panel rather than piling up tabs.
  event.waitUntil(
    self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clients) => {
      for (const client of clients) {
        if (client.url.includes('/admin/whatsapp') && 'focus' in client) {
          client.navigate(target);
          return client.focus();
        }
      }

      return self.clients.openWindow(target);
    })
  );
});
