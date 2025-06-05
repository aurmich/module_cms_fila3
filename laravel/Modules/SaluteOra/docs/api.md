# API Documentation - Modulo Patient

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
                },
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "appointments": [
            {
                "id": 1,
                "date": "2024-05-01T10:00:00.000000Z",
                "type": "checkup",
                "notes": "Visita di controllo",
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### Cartelle Cliniche

#### Lista Cartelle Cliniche
```http
GET /api/patients/{id}/medical-records
```

**Parametri Query:**
- `page`: Numero pagina (default: 1)
- `per_page`: Elementi per pagina (default: 20)
- `type`: Filtro per tipo
- `sort`: Campo ordinamento
- `order`: Direzione ordinamento (asc/desc)

**Risposta:**
```json
{
    "data": [
        {
            "id": 1,
            "type": "initial_visit",
            "content": {
                "anamnesi": "...",
                "diagnosi": "...",
                "terapia": "..."
            },
            "created_at": "2024-01-01T00:00:00.000000Z"
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

#### Crea Cartella Clinica
```http
POST /api/patients/{id}/medical-records
```

**Body:**
```json
{
    "type": "initial_visit",
    "content": {
        "anamnesi": "...",
        "diagnosi": "...",
        "terapia": "..."
    }
}
```

**Risposta:**
```json
{
    "data": {
        "id": 1,
        "type": "initial_visit",
        "content": {
            "anamnesi": "...",
            "diagnosi": "...",
            "terapia": "..."
        },
        "created_at": "2024-01-01T00:00:00.000000Z"
    },
    "message": "Medical record created successfully"
}
```

### Appuntamenti

#### Lista Appuntamenti
```http
GET /api/patients/{id}/appointments
```

**Parametri Query:**
- `page`: Numero pagina (default: 1)
- `per_page`: Elementi per pagina (default: 20)
- `start_date`: Data inizio
- `end_date`: Data fine
- `type`: Filtro per tipo
- `sort`: Campo ordinamento
- `order`: Direzione ordinamento (asc/desc)

**Risposta:**
```json
{
    "data": [
        {
            "id": 1,
            "date": "2024-05-01T10:00:00.000000Z",
            "type": "checkup",
            "notes": "Visita di controllo",
            "created_at": "2024-01-01T00:00:00.000000Z"
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

#### Crea Appuntamento
```http
POST /api/patients/{id}/appointments
```

**Body:**
```json
{
    "date": "2024-05-01T10:00:00",
    "type": "checkup",
    "notes": "Visita di controllo"
}
```

**Risposta:**
```json
{
    "data": {
        "id": 1,
        "date": "2024-05-01T10:00:00.000000Z",
        "type": "checkup",
        "notes": "Visita di controllo",
        "created_at": "2024-01-01T00:00:00.000000Z"
    },
    "message": "Appointment created successfully"
}
```

## Errori

### 400 Bad Request
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field": ["The field is required."]
    }
}
```

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden
```json
{
    "message": "This action is unauthorized."
}
```

### 404 Not Found
```json
{
    "message": "Resource not found."
}
```

### 500 Internal Server Error
```json
{
    "message": "Server Error"
}
```

## Autenticazione

Tutte le API richiedono autenticazione tramite Bearer Token:

```http
Authorization: Bearer {token}
```

## Rate Limiting

- 60 richieste al minuto per IP
- 1000 richieste al giorno per utente

## Versioning

L'API è versionata tramite URL:

```http
/api/v1/patients
```

## Supporto

Per supporto tecnico, contattare:
- Email: support@saluteora.it
- Telefono: +39 02 1234567 
## Collegamenti tra versioni di API.md
* [API.md](laravel/Modules/Dental/docs/API.md)
* [API.md](laravel/Modules/Patient/docs/API.md)


## Collegamenti tra versioni di api.md
* [api.md](../../Chart/docs/advanced/api.md)
* [api.md](../../Gdpr/docs/api.md)
* [api.md](../../Dental/docs/api.md)

