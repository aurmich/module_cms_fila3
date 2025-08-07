# Problema: Campo Schedule non Aggiornato nel Pivot durante Sync

## Descrizione del Problema

Nel file `RegisterAction.php` alla riga 64, il codice:

```php
$res = $doctor->studios()->sync($studio, ['schedule' => $data['schedule']]);
```

**NON** aggiorna il campo `schedule` nella tabella pivot `studio_user`.

## Analisi del Problema

### 1. Struttura della Relazione

La relazione `studios()` nel modello `Doctor` è definita come:

```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

### 2. Funzionamento di `belongsToManyX`

Il trait `RelationX::belongsToManyX()` configura automaticamente la relazione con:

- **Tabella pivot**: `studio_user` (non `doctor_studio`)
- **Modello pivot**: `StudioUser` (non `DoctorStudio`)
- **Campi pivot**: Tutti i campi in `$fillable` del modello pivot
- **Timestamps**: Abilitati automaticamente

### 3. Il Problema Principale

Il metodo `sync()` di Laravel funziona correttamente, ma il problema è nella **logica di business**:

1. **Prima sync**: Viene creato un record nella tabella `studio_user` con `schedule` vuoto
2. **Seconda sync**: Il record esiste già, quindi `sync()` non aggiorna i campi pivot esistenti

## Soluzione

### Opzione 1: Usare `attach()` invece di `sync()`

```php
// Sostituire la riga 64 con:
$doctor->studios()->attach($studio, ['schedule' => $data['schedule']]);
```

**Vantaggi:**
- Semplicità
- Funziona sempre

**Svantaggi:**
- Non gestisce duplicati
- Può creare record multipli

### Opzione 2: Usare `updateExistingPivot()` dopo `sync()`

```php
// Dopo la sync, aggiornare esplicitamente il pivot
$doctor->studios()->sync($studio);
$doctor->studios()->updateExistingPivot($studio->id, ['schedule' => $data['schedule']]);
```

**Vantaggi:**
- Gestisce correttamente i duplicati
- Aggiorna sempre il campo schedule

**Svantaggi:**
- Due query invece di una
- Più complesso

### Opzione 3: Usare `syncWithoutDetaching()` con `updateExistingPivot()`

```php
// La soluzione più robusta
$doctor->studios()->syncWithoutDetaching([$studio->id => ['schedule' => $data['schedule']]]);
```

**Vantaggi:**
- Una sola query
- Gestisce correttamente i duplicati
- Aggiorna sempre il campo schedule
- Non rimuove relazioni esistenti

## Raccomandazione

**Usare l'Opzione 3** (`syncWithoutDetaching()`) perché:

1. È la soluzione più elegante e performante
2. Gestisce correttamente tutti i casi edge
3. Mantiene la coerenza dei dati
4. È la pratica standard di Laravel per questo tipo di operazioni

## Implementazione Corretta

```php
// Sostituire la riga 64 in RegisterAction.php:
$doctor->studios()->syncWithoutDetaching([$studio->id => ['schedule' => $data['schedule']]]);
```

## Verifica della Soluzione

Per verificare che la soluzione funzioni:

```php
// Dopo la sync, verificare che il campo schedule sia stato salvato
$pivot = $doctor->studios()->where('studio_id', $studio->id)->first()->pivot;
dd($pivot->schedule); // Dovrebbe contenere $data['schedule']
```

## Note Tecniche

### Struttura della Tabella Pivot

La tabella `studio_user` contiene:
- `user_id` (riferimento al dottore)
- `studio_id` (riferimento allo studio)
- `schedule` (array JSON con gli orari)
- `is_primary` (boolean)
- `created_at`, `updated_at`

### Casting Automatico

Il campo `schedule` è automaticamente castato come `array` nel modello `StudioUser`, quindi Laravel gestisce automaticamente la conversione JSON ↔ Array.

## Collegamenti Correlati

- [Documentazione Laravel - Sync](https://laravel.com/docs/10.x/eloquent-relationships#syncing-associations)
- [Documentazione Laravel - Pivot Tables](https://laravel.com/docs/10.x/eloquent-relationships#many-to-many)
- [Modules/Xot/docs/RELATION_X.md](../../Xot/docs/RELATION_X.md)
- [Modules/SaluteOra/docs/DOCTOR_STUDIO_RELATIONSHIP.md](./DOCTOR_STUDIO_RELATIONSHIP.md)

---

**Ultimo aggiornamento**: 2025-01-06  
**Autore**: AI Assistant  
**Stato**: ✅ Risolto 