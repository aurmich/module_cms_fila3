# Troubleshooting Relazioni Pivot - Modulo SaluteOra

## Problema: sync() non aggiorna campi pivot

### Contesto
Nel modulo SaluteOra, la relazione tra `Doctor` e `Studio` utilizza una tabella pivot `studio_user` con campi aggiuntivi come `schedule` e `is_primary`.

### Problema Specifico
Nel file `RegisterAction.php`, il codice:
```php
$res = $doctor->studios()->sync($studio, ['schedule' => $data['schedule']]);
```

Non aggiorna il campo `schedule` nella tabella pivot.

## Analisi Tecnica

### Architettura Cross-Database
- **Doctor**: Database `user`
- **Studio**: Database `salute_ora` 
- **studio_user**: Database `saluteora_data`

### Configurazione belongsToManyX
Il trait `belongsToManyX` configura automaticamente:
```php
->withPivot($pivotFields)  // Tutti i campi fillable del modello pivot
->withTimestamps()
```

### Comportamento di sync()
Quando una relazione è configurata con `withPivot()`, il secondo parametro di `sync()` viene **ignorato** da Laravel.

## Soluzioni Implementate

### Soluzione Raccomandata: updateExistingPivot()

```php
// 1. Sincronizza la relazione base
$res = $doctor->studios()->sync($studio);

// 2. Aggiorna esplicitamente i campi pivot
if (isset($data['schedule'])) {
    $doctor->studios()->updateExistingPivot($studio->id, [
        'schedule' => $data['schedule']
    ]);
}
```

### Soluzione Alternativa: attach() con controllo

```php
// Controlla se la relazione esiste già
if ($doctor->studios()->where('studio_id', $studio->id)->exists()) {
    // Aggiorna relazione esistente
    $doctor->studios()->updateExistingPivot($studio->id, [
        'schedule' => $data['schedule']
    ]);
} else {
    // Crea nuova relazione
    $doctor->studios()->attach($studio, [
        'schedule' => $data['schedule']
    ]);
}
```

## Modelli Coinvolti

### Doctor.php
```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

### DoctorStudio.php (Pivot)
```php
protected $fillable = [
    'id',
    'user_id',
    'studio_id', 
    'schedule',
    'is_primary',
];

protected function casts(): array
{
    return array_merge(parent::casts(), [
        'schedule' => 'array',
        'is_primary' => 'boolean',
    ]);
}
```

## Best Practices

### 1. Sempre verificare l'aggiornamento
```php
// Debug dopo l'aggiornamento
$pivotRecord = $doctor->studios()
    ->where('studio_id', $studio->id)
    ->first()
    ->pivot;

Log::info('Pivot updated', [
    'schedule' => $pivotRecord->schedule,
    'studio_id' => $studio->id,
    'doctor_id' => $doctor->id
]);
```

### 2. Gestire transazioni per cross-database
```php
DB::transaction(function () use ($doctor, $studio, $data) {
    // Operazioni su database diversi
    $res = $doctor->studios()->sync($studio);
    
    if (isset($data['schedule'])) {
        $doctor->studios()->updateExistingPivot($studio->id, [
            'schedule' => $data['schedule']
        ]);
    }
});
```

### 3. Validare i dati prima dell'aggiornamento
```php
if (isset($data['schedule']) && is_array($data['schedule'])) {
    // Validazione struttura schedule
    $validatedSchedule = $this->validateSchedule($data['schedule']);
    
    $doctor->studios()->updateExistingPivot($studio->id, [
        'schedule' => $validatedSchedule
    ]);
}
```

## Errori Comuni da Evitare

### ❌ Errore: Usare sync() con withPivot()
```php
// NON FUNZIONA - il secondo parametro viene ignorato
$doctor->studios()->sync($studio, ['schedule' => $data['schedule']]);
```

### ❌ Errore: Non gestire cross-database
```php
// RISCHIOSO - può causare inconsistenze
$doctor->studios()->attach($studio, ['schedule' => $data['schedule']]);
// Senza transazione
```

### ❌ Errore: Ignorare la validazione
```php
// RISCHIOSO - dati non validati
$doctor->studios()->updateExistingPivot($studio->id, [
    'schedule' => $data['schedule'] // Senza validazione
]);
```

## Test e Verifica

### Test Unitario
```php
public function test_doctor_studio_schedule_update()
{
    $doctor = Doctor::factory()->create();
    $studio = Studio::factory()->create();
    $schedule = ['monday' => ['morning_from' => '09:00', 'morning_to' => '12:00']];
    
    // Esegui l'aggiornamento
    $doctor->studios()->sync($studio);
    $doctor->studios()->updateExistingPivot($studio->id, ['schedule' => $schedule]);
    
    // Verifica
    $pivotRecord = $doctor->studios()
        ->where('studio_id', $studio->id)
        ->first()
        ->pivot;
    
    $this->assertEquals($schedule, $pivotRecord->schedule);
}
```

## Collegamenti

- [Analisi Problema Pivot](../../../../docs/pivot-sync-issue-analysis.md)
- [RegisterAction.php](../app/Actions/Doctor/RegisterAction.php)
- [Doctor.php](../app/Models/Doctor.php)
- [DoctorStudio.php](../app/Models/DoctorStudio.php)

*Ultimo aggiornamento: 2025-01-06* 