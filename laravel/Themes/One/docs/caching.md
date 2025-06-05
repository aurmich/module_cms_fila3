# Sistema di Caching

## Introduzione

Questo documento descrive il sistema di caching del tema "One", inclusi i driver, le configurazioni e le best practices per l'ottimizzazione delle performance.

## Configurazione Cache

### Driver Supportati
```php
// config/cache.php
return [
    'default' => env('CACHE_DRIVER', 'redis'),
    
    'stores' => [
        'apc' => [
            'driver' => 'apc',
        ],
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
        ],
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],
    ],
    
    'prefix' => env('CACHE_PREFIX', 'theme_one_'),
];
```

### Configurazione Redis
```php
// config/database.php
'redis' => [
    'cache' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_CACHE_DB', '1'),
    ],
],
```

## Cache di Configurazione

### Cache Routes
```php
// app/Console/Commands/CacheRoutes.php
class CacheRoutes extends Command
{
    protected $signature = 'theme:cache-routes';
    
    public function handle()
    {
        $this->call('route:cache');
        $this->info('Routes cached successfully!');
    }
}
```

### Cache Views
```php
// app/Console/Commands/CacheViews.php
class CacheViews extends Command
{
    protected $signature = 'theme:cache-views';
    
    public function handle()
    {
        $this->call('view:cache');
        $this->info('Views cached successfully!');
    }
}
```

## Cache di Dati

### Cache Service
```php
// app/Services/CacheService.php
class CacheService
{
    protected $cache;
    protected $prefix;
    
    public function __construct()
    {
        $this->cache = Cache::store('redis');
        $this->prefix = config('cache.prefix');
    }
    
    public function remember($key, $ttl, $callback)
    {
        return $this->cache->remember($this->prefix . $key, $ttl, $callback);
    }
    
    public function forget($key)
    {
        return $this->cache->forget($this->prefix . $key);
    }
    
    public function flush()
    {
        return $this->cache->flush();
    }
}
```

### Cache Tags
```php
// app/Services/CacheTagService.php
class CacheTagService
{
    protected $cache;
    
    public function __construct()
    {
        $this->cache = Cache::tags(['theme', 'data']);
    }
    
    public function remember($key, $ttl, $callback)
    {
        return $this->cache->remember($key, $ttl, $callback);
    }
    
    public function flushTag($tag)
    {
        return Cache::tags($tag)->flush();
    }
}
```

## Cache Frontend

### Service Worker
```javascript
// public/sw.js
const CACHE_NAME = 'theme-one-v1';
const urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/images/logo.png',
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
```

### Cache API
```javascript
// resources/js/utils/cache.js
export const cache = {
    async get(key) {
        const cached = await caches.match(key);
        return cached ? await cached.json() : null;
    },
    
    async set(key, data) {
        const response = new Response(JSON.stringify(data));
        const cache = await caches.open('theme-data');
        await cache.put(key, response);
    },
    
    async delete(key) {
        const cache = await caches.open('theme-data');
        await cache.delete(key);
    },
};
```

## Best Practices

### Caching
- Utilizzare tag appropriati
- Gestire TTL correttamente
- Implementare invalidazione
- Monitorare utilizzo
- Ottimizzare dimensioni

### Performance
- Cache dati frequenti
- Minimizzare chiamate
- Utilizzare CDN
- Ottimizzare assets
- Monitorare hit rate

### Manutenzione
- Pulire cache regolarmente
- Gestire versioni
- Monitorare spazio
- Documentare strategie
- Testare performance

## Metriche di Successo

### Performance
- Hit rate cache
- Tempo risposta
- Utilizzo risorse
- Scalabilità
- Disponibilità

### Qualità
- Accuratezza dati
- Consistenza
- Manutenibilità
- Documentazione
- Automazione

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
