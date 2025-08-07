# API Modulo GDPR

## Panoramica
Il modulo GDPR espone una serie di API RESTful per la gestione dei consensi, l'esportazione dei dati e altre funzionalità GDPR.

## Autenticazione

### Bearer Token
```http
GET /api/gdpr/consents
Authorization: Bearer {token}
```

### Sanctum
```php
use Laravel\Sanctum\HasApiTokens;

class User extends XotBaseUser
{
    use HasApiTokens;
}
```

## Endpoints

### Consensi

#### Lista Consensi
```http
GET /api/gdpr/consents

Response 200 (application/json)
{
    "data": [
        {
            "id": 1,
            "type": "marketing",
            "value": true,
            "expires_at": "2024-12-31T23:59:59Z"
        }
    ]
}
```

#### Crea Consenso
```http
POST /api/gdpr/consents
Content-Type: application/json

{
    "type": "marketing",
    "value": true,
    "expires_at": "2024-12-31T23:59:59Z"
}

Response 201 (application/json)
{
    "data": {
        "id": 1,
        "type": "marketing",
        "value": true,
        "expires_at": "2024-12-31T23:59:59Z"
    }
}
```

#### Aggiorna Consenso
```http
PUT /api/gdpr/consents/{id}
Content-Type: application/json

{
    "value": false
}

Response 200 (application/json)
{
    "data": {
        "id": 1,
        "type": "marketing",
        "value": false,
        "expires_at": "2024-12-31T23:59:59Z"
    }
}
```

### Esportazione Dati

#### Richiedi Esportazione
```http
POST /api/gdpr/export
Content-Type: application/json

{
    "format": "json",
    "types": ["profile", "activity"]
}

Response 202 (application/json)
{
    "message": "Export scheduled",
    "job_id": "123e4567-e89b-12d3-a456-426614174000"
}
```

#### Stato Esportazione
```http
GET /api/gdpr/export/{job_id}

Response 200 (application/json)
{
    "status": "completed",
    "download_url": "/storage/exports/123e4567.zip",
    "expires_at": "2024-01-01T00:00:00Z"
}
```

### Diritti GDPR

#### Richiesta Cancellazione
```http
POST /api/gdpr/erasure
Content-Type: application/json

{
    "reason": "Richiesta di cancellazione dati",
    "scope": ["profile", "activity"]
}

Response 202 (application/json)
{
    "message": "Erasure request received",
    "request_id": "123e4567-e89b-12d3-a456-426614174000"
}
```

#### Richiesta Rettifica
```http
POST /api/gdpr/rectification
Content-Type: application/json

{
    "field": "email",
    "current_value": "old@example.com",
    "new_value": "new@example.com"
}

Response 202 (application/json)
{
    "message": "Rectification request received",
    "request_id": "123e4567-e89b-12d3-a456-426614174000"
}
```

## Risposte

### Struttura Standard
```json
{
    "data": {},
    "meta": {
        "timestamp": "2024-01-01T00:00:00Z",
        "version": "1.0"
    }
}
```

### Errori
```json
{
    "error": {
        "code": "GDPR001",
        "message": "Invalid consent type",
        "details": {
            "field": "type",
            "value": "invalid",
            "allowed": ["marketing", "analytics"]
        }
    }
}
```

## Rate Limiting

### Configurazione
```php
// config/gdpr.php
return [
    'api' => [
        'rate_limit' => [
            'attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],
];
```

### Headers
```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1577836800
```

## Versioning

### Header Versione
```http
Accept: application/vnd.gdpr.v1+json
```

### Deprecation
```http
Deprecation: Sun, 31 Dec 2024 23:59:59 GMT
Sunset: Sun, 31 Dec 2024 23:59:59 GMT
Link: </api/gdpr/v2/consents>; rel="successor-version"
```

## Sicurezza

### CORS
```php
// config/cors.php
return [
    'paths' => ['api/gdpr/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://<nome progetto>.com'],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['X-RateLimit-Limit'],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

### Validazione
```php
namespace Modules\Gdpr\Http\Requests;

class ConsentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::in(['marketing', 'analytics'])],
            'value' => ['required', 'boolean'],
            'expires_at' => ['required', 'date', 'after:now'],
        ];
    }
}
```

## Esempi

### cURL
```bash

# Lista consensi
curl -X GET \
  https://api.<nome progetto>.com/gdpr/consents \
  -H 'Authorization: Bearer {token}'

# Crea consenso
curl -X POST \
  https://api.<nome progetto>.com/gdpr/consents \
  -H 'Authorization: Bearer {token}' \
  -H 'Content-Type: application/json' \
  -d '{
    "type": "marketing",
    "value": true
  }'
```

### PHP
```php
use Illuminate\Support\Facades\Http;

$response = Http::withToken($token)
    ->post('https://api.<nome progetto>.com/gdpr/consents', [
        'type' => 'marketing',
        'value' => true,
    ]);

$consent = $response->json()['data'];
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [API User](../User/docs/api.md)
- [API Activity](../Activity/docs/api.md)
- [API Xot](../Xot/docs/api.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Security](./security.md)
- [Testing](./testing.md) 

## Collegamenti tra versioni di api.md
* [api.md](../../Chart/docs/advanced/api.md)
* [api.md](../../Dental/docs/api.md)
* [api.md](../../Patient/docs/api.md)

