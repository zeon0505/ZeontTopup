const CACHE_NAME = 'zeongame-v1';
const urlsToCache = [
    '/',
    '/css/style.css',
    'https://cdn.tailwindcss.com',
    'https://unpkg.com/aos@2.3.1/dist/aos.css'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
