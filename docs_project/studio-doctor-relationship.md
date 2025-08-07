# Relazione Many-to-Many tra Studio e Doctor

## Panoramica

Nel sistema SaluteOra, esiste una relazione many-to-many tra studi medici e dottori:

- Uno `Studio` può avere **molti** `Doctor` (collaboratori)
- Un `Doctor` può lavorare in **molti** `Studio` (luoghi di esercizio)

## Implementazione Tecnica

### Modello Studio

La relazione è implementata come molti-a-molti:

```php
/**
 * Relazione molti-a-molti con i dottori che lavorano nello studio.
 */
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}
```

### Modello Doctor

La relazione inversa è simmetrica:

```php
/**
 * Relazione molti-a-molti con gli studi in cui il dottore lavora.
 */
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

## Filosofia, logica e motivazione
- La relazione molti-a-molti riflette la realtà sanitaria: un dottore può lavorare in più studi e uno studio può avere più dottori.
- Si usa belongsToManyX per massima flessibilità, DRY, e per supportare pivot custom e policy multi-tenant.
- La simmetria della relazione permette una gestione coerente, audit trail e policy di sicurezza centralizzate.
- La documentazione e la struttura del codice sono pensate per essere zen, chiare e facilmente estendibili.
- Vedi anche: [Xot/docs/filament/listrecords.md](../../../Xot/docs/filament/listrecords.md)

## Fondamenti Filosofici e Logici

1. **Flessibilità Professionale**: Riflette la natura moderna della professione medica
2. **Ottimizzazione delle Risorse**: Permette la condivisione di competenze tra strutture
3. **Modello Distribuito**: Supporta un approccio territoriale alla cura della salute
4. **Gestione Multipla**: Facilita la pianificazione e la disponibilità del personale medico

## Tabella Pivot

La relazione utilizza una tabella pivot automaticamente gestita dal metodo `belongsToManyX` che deduce:
- Nome tabella: basato sui nomi dei modelli (in ordine alfabetico)
- Campi: include gli ID di entrambe le entità più eventuali metadati
- Timestamps: traccia quando un'associazione viene creata o modificata

## RelationManager in Filament

I RelationManager implementati seguono questa struttura relazionale e permettono:
- Visualizzazione bidirezionale della relazione
- Gestione delle associazioni
- Filtri e ricerche specifiche per ciascuna entità

## Riferimenti
- [Documentazione Laravel BelongsToMany](https://laravel.com/docs/eloquent-relationships#many-to-many)
- [RelationX Trait](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/app/Models/Traits/RelationX.php)
- [Architettura Moduli](/var/www/html/_bases/base_saluteora/docs/modules/modules-relationships.md)

## Policy sulle relazioni

- Le relazioni tra Studio e Doctor devono usare solo belongsToManyX senza chaining superfluo (niente ->using, ->withPivot, ->withTimestamps).
- Motivazione: DRY, centralizzazione della logica, nessun lock-in, coerenza con la filosofia Xot.
- belongsToManyX gestisce automaticamente modello pivot, campi extra e timestamps.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy sulle migrazioni

- Nella tabella pivot doctor_studio usare sempre foreignIdFor(Doctor::class) e foreignIdFor(Studio::class) per le chiavi esterne, mai uuid manuale.
- Motivazione: coerenza, type safety, migliore integrazione con Eloquent, filosofia zen.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy sulle migrazioni custom (XotBaseMigration)

- Chi estende XotBaseMigration **non deve mai** dichiarare il metodo down(): è già gestito dalla base o non richiesto.
- Motivazione: DRY, centralizzazione della logica, nessun lock-in, coerenza con la filosofia Xot.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy su timestamp e soft delete nelle migrazioni Xot

- Nelle migrazioni che estendono XotBaseMigration **non si usa mai** $table->timestamps().
- Si usa sempre $this->tableUpdate con updateTimestamps($table, true) dopo la creazione della tabella.
- Motivazione: centralizzazione della logica, coerenza, DRY, gestione automatica di soft delete e campi utente.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy su BasePivot e nome tabella

- Chi estende BasePivot **non deve mai** dichiarare protected $table: la gestione del nome tabella è centralizzata in BasePivot/Xot.
- Motivazione: DRY, coerenza, nessun lock-in, filosofia zen.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

> **Nota tecnica:**  
> Per la gestione AttachAction in Filament tra Studio e Doctor (cross-db), seguire il pattern documentato in [filament-relation-managers.md](./filament-relation-managers.md#gestione-attachaction-in-relazioni-cross-database) **e applicare la policy simmetrica anche lato Doctor**.
