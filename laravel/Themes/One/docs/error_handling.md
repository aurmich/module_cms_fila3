# Sistema di Gestione Errori

## Introduzione

Questo documento descrive il sistema di gestione degli errori del tema "One", inclusi i componenti, le configurazioni e le best practices per la gestione e il reporting degli errori.

## Struttura Errori

### Classi di Errore
```php
// app/Exceptions/ThemeException.php
class ThemeException extends Exception
{
    protected $code = 500;
    protected $message = 'Errore generico del tema';
    
    public function render($request)
    {
        return response()->json([
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
                'details' => $this->getMessage(),
            ]
        ], $this->code);
    }
}

// app/Exceptions/ValidationException.php
class ValidationException extends ThemeException
{
    protected $code = 422;
    protected $message = 'Errore di validazione';
    
    private $errors;
    
    public function __construct($errors)
    {
        parent::__construct();
        $this->errors = $errors;
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
                'details' => $this->errors,
            ]
        ], $this->code);
    }
}
```

### Handler Globale
```php
// app/Exceptions/Handler.php
class Handler extends ExceptionHandler
{
    protected $dontReport = [
        ValidationException::class,
        AuthenticationException::class,
    ];
    
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
        
        $this->renderable(function (ThemeException $e, $request) {
            return $e->render($request);
        });
    }
}
```

## Componenti Frontend

### Error Boundary
```javascript
// resources/js/components/ErrorBoundary.vue
<template>
    <div v-if="error" class="error-boundary">
        <h2>{{ error.title }}</h2>
        <p>{{ error.message }}</p>
        <button @click="resetError">Riprova</button>
    </div>
    <slot v-else></slot>
</template>

<script>
export default {
    data() {
        return {
            error: null,
        };
    },
    errorCaptured(err, vm, info) {
        this.error = {
            title: 'Errore',
            message: err.message,
        };
        return false;
    },
    methods: {
        resetError() {
            this.error = null;
        },
    },
};
</script>
```

### Gestore Errori
```javascript
// resources/js/utils/errorHandler.js
export const handleError = (error) => {
    if (error.response) {
        // Errore HTTP
        switch (error.response.status) {
            case 401:
                return handleUnauthorized();
            case 403:
                return handleForbidden();
            case 404:
                return handleNotFound();
            case 422:
                return handleValidation(error.response.data);
            case 500:
                return handleServerError();
            default:
                return handleGenericError();
        }
    } else if (error.request) {
        // Errore di rete
        return handleNetworkError();
    } else {
        // Errore generico
        return handleGenericError(error.message);
    }
};

const handleValidation = (errors) => {
    return {
        type: 'validation',
        message: 'Si sono verificati errori di validazione',
        details: errors,
    };
};

const handleUnauthorized = () => {
    return {
        type: 'auth',
        message: 'Non sei autorizzato',
        action: 'login',
    };
};
```

## Pagine di Errore

### 404 Not Found
```php
// resources/views/errors/404.blade.php
@extends('layouts.error')

@section('title', 'Pagina non trovata')

@section('content')
<div class="error-page">
    <h1>404</h1>
    <h2>Pagina non trovata</h2>
    <p>La pagina che stai cercando non esiste o è stata spostata.</p>
    <a href="{{ url('/') }}" class="button">Torna alla home</a>
</div>
@endsection
```

### 500 Server Error
```php
// resources/views/errors/500.blade.php
@extends('layouts.error')

@section('title', 'Errore del server')

@section('content')
<div class="error-page">
    <h1>500</h1>
    <h2>Errore del server</h2>
    <p>Si è verificato un errore interno del server.</p>
    <a href="{{ url('/') }}" class="button">Torna alla home</a>
</div>
@endsection
```

## Logging e Monitoraggio

### Configurazione Logging
```php
// config/logging.php
return [
    'channels' => [
        'theme' => [
            'driver' => 'daily',
            'path' => storage_path('logs/theme.log'),
            'level' => 'debug',
            'days' => 14,
        ],
        'errors' => [
            'driver' => 'daily',
            'path' => storage_path('logs/errors.log'),
            'level' => 'error',
            'days' => 30,
        ],
    ],
];
```

### Integrazione Sentry
```php
// config/sentry.php
return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'release' => env('SENTRY_RELEASE'),
    'environment' => env('APP_ENV'),
    'breadcrumbs' => [
        'sql_queries' => true,
        'bindings' => true,
    ],
    'traces_sample_rate' => 1.0,
];
```

## Best Practices

### Gestione Errori
- Definire classi specifiche
- Fornire messaggi chiari
- Loggare dettagli
- Monitorare errori
- Implementare recovery

### Frontend
- Utilizzare error boundary
- Gestire stati loading/error
- Fornire feedback utente
- Implementare retry
- Documentare errori

### Backend
- Validare input
- Gestire eccezioni
- Loggare appropriatamente
- Monitorare performance
- Implementare fallback

## Metriche di Successo

### Qualità
- Errori gestiti
- Tempo risoluzione
- Qualità messaggi
- Copertura test
- Documentazione

### Performance
- Tempo rilevamento
- Impatto utente
- Utilizzo risorse
- Automazione
- Scalabilità

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
