# API Documentation - SaluteOra

## Endpoints

### Pazienti

#### Lista Pazienti
```http
GET /api/patients
```

**Parametri Query:**
- `page`: Numero pagina (default: 1)
- `per_page`: Elementi per pagina (default: 20)
- `search`: Ricerca per nome/cognome/codice fiscale
- `sort`: Campo ordinamento
- `order`: Direzione ordinamento (asc/desc)

**Risposta:**
```json
{
    "data": [
        {
            "id": 1,
            "first_name": "Mario",
            "last_name": "Rossi",
            "fiscal_code": "RSSMRA80A01H501R",
            "birth_date": "1980-01-01",
            "gender": "M",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 20,
        "to": 1,
        "total": 1
    }
}
```

#### Crea Paziente
```http
POST /api/patients
```

**Body:**
```json
{
    "first_name": "Mario",
    "last_name": "Rossi",
    "fiscal_code": "RSSMRA80A01H501R",
    "birth_date": "1980-01-01",
    "gender": "M"
}
```

**Risposta:**
```json
{
    "data": {
        "id": 1,
        "first_name": "Mario",
        "last_name": "Rossi",
        "fiscal_code": "RSSMRA80A01H501R",
        "birth_date": "1980-01-01",
        "gender": "M",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    "message": "Patient created successfully"
}
```

#### Dettaglio Paziente
```http
GET /api/patients/{id}
```

**Risposta:**
```json
{
    "data": {
        "id": 1,
        "first_name": "Mario",
        "last_name": "Rossi",
        "fiscal_code": "RSSMRA80A01H501R",
        "birth_date": "1980-01-01",
        "gender": "M",
        "medical_records": [
            {
                "id": 1,
                "type": "initial_visit",
                "content": {
                    "anamnesi": "...",
                    "diagnosi": "...",
                    "terapia": "..."
                }
            }
        ]
    }
}
```

## ChartService API

### Creazione di un Grafico

```php
/**
 * Crea un nuovo grafico con le configurazioni specificate.
 *
 * @param array $config Configurazione del grafico
 * @return \Modules\Chart\Models\Chart
 */
public function createChart(array $config): Chart
```

Esempio:
```php
$chartService = app(\Modules\Chart\Services\ChartService::class);

$chart = $chartService->createChart([
    'type' => 'bar',
    'title' => 'Andamento Vendite',
    'data' => [
        'labels' => ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu'],
        'datasets' => [
            [
                'label' => 'Vendite 2023',
                'data' => [12, 19, 3, 5, 2, 3],
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1
            ]
        ]
    ],
    'options' => [
        'scales' => [
            'y' => [
                'beginAtZero' => true
            ]
        ]
    ]
]);
```

### Rendering di un Grafico

```php
/**
 * Renderizza un grafico come HTML/JavaScript.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param array $options Opzioni di rendering aggiuntive
 * @return string HTML con il grafico renderizzato
 */
public function render(Chart $chart, array $options = []): string
```

Esempio:
```php
$html = $chartService->render($chart, [
    'height' => '400px',
    'width' => '100%',
    'responsive' => true,
    'container_class' => 'my-custom-chart-container'
]);
```

### Generazione di un'Immagine del Grafico

```php
/**
 * Genera un'immagine del grafico.
 *
 * @param \Modules\Chart\Models\Chart $chart
 * @param string $format Formato dell'immagine (png, jpg)
 * @param int $width Larghezza dell'immagine
 * @param int $height Altezza dell'immagine
 * @return string Percorso dell'immagine generata
 */
public function generateImage(Chart $chart, string $format = 'png', int $width = 800, int $height = 400): string
```

Esempio:
```php
$imagePath = $chartService->generateImage($chart, 'png', 1200, 600);
```

## DataProvider API

### Recupero Dati

```php
/**
 * Recupera i dati per un grafico dalla sorgente specificata.
 *
 * @param string $source Sorgente dati
 * @param array $filters Filtri da applicare
 * @return array Dati formattati per il grafico
 */
public function getData(string $source, array $filters = []): array
```

## Autenticazione

Tutte le API richiedono autenticazione tramite Bearer Token:

```http
Authorization: Bearer {your-token}
```

## Gestione Errori

### Errori Comuni

**401 Unauthorized**
```json
{
    "error": "Unauthorized",
    "message": "Invalid or missing authentication token"
}
```

**422 Validation Error**
```json
{
    "error": "Validation failed",
    "message": "The given data was invalid",
    "errors": {
        "field_name": ["The field is required"]
    }
}
```

**500 Internal Server Error**
```json
{
    "error": "Internal server error",
    "message": "An unexpected error occurred"
}
```

## Rate Limiting

Le API sono soggette a rate limiting:
- **Limite**: 60 richieste per minuto per utente
- **Header di risposta**: `X-RateLimit-Remaining`
- **Reset**: Ogni minuto

## Versioning

Le API utilizzano versioning tramite URL:
- **Versione corrente**: `/api/v1/`
- **Compatibilità**: Mantenuta per almeno 6 mesi
- **Deprecazione**: Annunciata con 3 mesi di anticipo

## Documentazione Completa

Per la documentazione completa delle API, consultare:
- [Swagger UI](/api/documentation)
- [Postman Collection](/api/postman)
- [SDK PHP](/api/sdk)

