/*
 | Admin panel JavaScript entry.
 |
 | Deliberately separate from resources/js/app.js: the public bundle pulls in
 | lodash, axios and page-specific scripts that the admin panel has no use for,
 | and any error in those aborts the whole module before Alpine can start.
 | The admin panel needs Alpine and nothing else.
 */
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Inline `alpine:init` listeners in the Blade views register components.
// This entry is a module, so it runs after those inline scripts have parsed.
Alpine.start();
