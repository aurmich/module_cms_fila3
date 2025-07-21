# Appointment Date Field Issues

## Problema Identificato
Il modello `Appointment` non ha una proprietà `date`. Tutte le occorrenze di `appointment->date` nel codice sono errate. Il modello usa invece i campi `starts_at` e `ends_at` per le date e gli orari degli appuntamenti.

## Elenco dei file con utilizzo errato

### Modulo Notify
1. `/var/www/html/_bases/base_saluteora/laravel/Modules/Notify/resources/views/emails/appointments/generic.blade.php` (linea 68):
   ```php
   <p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
   ```

2. `/var/www/html/_bases/base_saluteora/laravel/Modules/Notify/resources/views/emails/appointments/cancelled.blade.php` (linea 68):
   ```php
   <p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
   ```

3. `/var/www/html/_bases/base_saluteora/laravel/Modules/Notify/resources/views/emails/appointments/rescheduled.blade.php` (linea 97):
   ```php
   <p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
   ```

4. `/var/www/html/_bases/base_saluteora/laravel/Modules/Notify/resources/views/emails/appointments/confirmed.blade.php` (linea 68):
   ```php
   <p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>
   ```

5. `/var/www/html/_bases/base_saluteora/laravel/Modules/Notify/app/Actions/SendAppointmentNotificationAction.php.old` (linea 119):
   ```php
   'date' => $appointment->date->format('Y-m-d'),
   ```

### Modulo UI
6. `/var/www/html/_bases/base_saluteora/laravel/Modules/UI/resources/views/components/blocks/patient_dashboard.blade.php` (linea 14):
   ```php
   {{ $nextAppointment->date->format('d/m/Y') }}
   ```

### Modulo Lang
7. `/var/www/html/_bases/base_saluteora/laravel/Modules/Lang/docs/localizing-dates-currencies.md` (linea 168):
   ```php
   <p>Data: {{ $appointment->date->isoFormat('dddd, D MMMM YYYY') }}</p>
   ```

8. `/var/www/html/_bases/base_saluteora/laravel/Modules/Lang/docs/localizing-dates-and-currencies.md` (linea 154):
   ```php
   <p>Data Appuntamento: {{ $appointment->date->isoFormat('dddd, D MMMM YYYY') }}</p>
   ```

### Modulo Cms
9. `/var/www/html/_bases/base_saluteora/laravel/Modules/Cms/docs/daisyui-componenti.md` (linea 524):
   ```php
   <td>{{ $appointment->date->format('d/m/Y') }}</td>
   ```

## Soluzione

Tutte le occorrenze di `appointment->date` devono essere sostituite con:

- `appointment->starts_at` per la data di inizio dell'appuntamento
- `appointment->ends_at` per la data di fine (quando necessario)

### Esempi di correzioni

#### Per email e template:
```php
// ERRATO
<p><strong>Data:</strong> {{ $appointment->date->format('d/m/Y') }}</p>

// CORRETTO
<p><strong>Data:</strong> {{ $appointment->starts_at->format('d/m/Y') }}</p>
```

#### Per array di dati:
```php
// ERRATO
'date' => $appointment->date->format('Y-m-d'),

// CORRETTO
'date' => $appointment->starts_at->format('Y-m-d'),
```

#### Per formattazione ISO:
```php
// ERRATO
<p>Data: {{ $appointment->date->isoFormat('dddd, D MMMM YYYY') }}</p>

// CORRETTO
<p>Data: {{ $appointment->starts_at->isoFormat('dddd, D MMMM YYYY') }}</p>
```

## Piano d'azione
1. Correggere tutti i riferimenti identificati sostituendo `date` con `starts_at` o `ends_at`
2. Eseguire test per verificare che tutto funzioni correttamente dopo le modifiche
3. Aggiornare tutti i file di documentazione che menzionano il campo `date`
4. Se necessario, aggiungere un accessor `getDateAttribute()` nel modello Appointment come soluzione temporanea per garantire la retrocompatibilità

## Note
- Questa modifica è strettamente collegata all'audit sul corretto utilizzo dei campi `starts_at`/`ends_at` invece di `start_time`/`end_time`
- Entrambe le correzioni devono essere coordinate per evitare conflitti
