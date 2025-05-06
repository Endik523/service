const CACHE_NAME = "kurir-app-v1";
self.addEventListener("install", (e) => {
    e.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) =>
                cache.addAll(["/kurir", "/css/app.css", "/js/app.js"])
            )
    );
});
