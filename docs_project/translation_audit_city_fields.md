# Audit Traduzioni Campi "Città" - Documentazione Root

## Problema Identificato

I file di traduzione tedeschi e inglesi nel modulo SaluteOra contengono ancora testo in italiano invece di essere completamente tradotti nelle rispettive lingue.

### File Analizzati e da Correggere

#### File Tedeschi con Testo in Italiano
- **patient-resource.php**: `'label' => 'Città'` → deve essere `'Stadt'`
- **studio-resource.php**: `'placeholder' => 'eingeben la città'` → deve essere `'Stadt eingeben'`
- **patient.php**: `'placeholder' => 'eingeben nome della città'` → deve essere `'Stadtname eingeben'`
- **studio.php**: `'placeholder' => 'eingeben la città dove si trova lo studio'` → deve essere `'Stadt der Praxis eingeben'`
- **find_doctor_and_appointment_widget.php**: `'placeholder' => 'eingeben la tua città o zona'` → deve essere `'Deine Stadt oder Gegend eingeben'`

#### File Inglesi con Testo in Italiano
- **studio.php**: `'placeholder' => 'Select una città'` → deve essere `'Select a city'`
- **find_doctor_and_appointment_widget.php**: `'help' => 'Scegli la città dove preferisci trovare il dottore'` → deve essere `'Choose the city where you prefer to find the doctor'`

## Problemi Specifici Risolti

### 1. Struttura Completa dei Campi
Ogni campo deve avere la struttura completa:
```php
'city' => [
    'label' => 'Stadt', // Tedesco
    'placeholder' => 'Stadt eingeben',
    'tooltip' => 'Stadt der Praxis',
    'helper_text' => 'Geben Sie die Stadt ein, in der sich die Praxis befindet',
    'description' => 'Stadt der Praxis für die Terminbuchung',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### 2. Terminologia Medica Tedesca
- **Stadt**: Città
- **Praxis**: Studio medico
- **Termin**: Appuntamento
- **Arzt**: Medico
- **Patient**: Paziente

### 3. Terminologia Medica Inglese
- **City**: Città
- **Practice**: Studio medico
- **Appointment**: Appuntamento
- **Doctor**: Medico
- **Patient**: Paziente

## Soluzioni Implementate

### 1. File Tedeschi Corretti
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt eingeben',
            'tooltip' => 'Stadt der Praxis',
            'helper_text' => 'Geben Sie die Stadt ein, in der sich die Praxis befindet',
            'description' => 'Stadt der Praxis für die Terminbuchung',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
    ],
];
```

### 2. File Inglesi Corretti
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter city',
            'tooltip' => 'Practice city',
            'helper_text' => 'Enter the city where the practice is located',
            'description' => 'Practice city for appointment booking',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
    ],
];
```

## Regole di Traduzione

### 1. Struttura Completa Obbligatoria
Ogni campo deve includere:
- `label`: Etichetta del campo
- `placeholder`: Testo di esempio
- `tooltip`: Suggerimento al passaggio del mouse
- `helper_text`: Testo di aiuto sotto il campo
- `description`: Descrizione dettagliata
- `icon`: Icona Heroicons (opzionale)
- `color`: Colore del campo (opzionale)

### 2. Coerenza Terminologica
- **Tedesco**: Utilizzare terminologia medica tedesca standard
- **Inglese**: Utilizzare terminologia medica inglese standard
- **Italiano**: Mantenere terminologia medica italiana esistente

### 3. Sintassi Moderna
- Utilizzare sempre `declare(strict_types=1);`
- Utilizzare sintassi breve `[]` invece di `array()`
- Includere PHPDoc per documentare la struttura

## File da Correggere

### Priorità Alta
1. `laravel/Modules/SaluteOra/lang/de/patient-resource.php`
2. `laravel/Modules/SaluteOra/lang/de/studio-resource.php`
3. `laravel/Modules/SaluteOra/lang/de/patient.php`
4. `laravel/Modules/SaluteOra/lang/de/studio.php`
5. `laravel/Modules/SaluteOra/lang/de/find_doctor_and_appointment_widget.php`

### Priorità Media
1. `laravel/Modules/SaluteOra/lang/en/studio.php`
2. `laravel/Modules/SaluteOra/lang/en/find_doctor_and_appointment_widget.php`

## Checklist di Verifica

- [ ] Tutti i campi hanno struttura completa (label, placeholder, tooltip, helper_text, description)
- [ ] Nessun testo in italiano nei file tedeschi
- [ ] Nessun testo in italiano nei file inglesi
- [ ] Tutti i file includono `declare(strict_types=1);`
- [ ] Tutti i file utilizzano sintassi moderna `[]`
- [ ] Terminologia medica coerente in ogni lingua
- [ ] Icone Heroicons valide
- [ ] Colori appropriati per il contesto

## Collegamenti

- [Audit Traduzioni Find Doctor Widget](../laravel/Modules/SaluteOra/docs/translation_audit_find_doctor_widget.md)
- [Regole Traduzioni SaluteOra](../laravel/Modules/SaluteOra/docs/README.md#regole-critiche)
- [Documentazione Modulo](../laravel/Modules/SaluteOra/docs/translation_audit_city_fields.md)

*Ultimo aggiornamento: 2025-01-06*
