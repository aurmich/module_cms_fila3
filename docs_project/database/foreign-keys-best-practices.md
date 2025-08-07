# Best Practices per Chiavi Esterne nelle Migrazioni

## Principio Fondamentale

Per dichiarare chiavi esterne nelle migrazioni, **utilizzare sempre `foreignIdFor()`** anziché definire manualmente le colonne con `uuid()`.

## Implementazione Corretta

```php
// ✅ CORRETTO
$table->foreignIdFor(\Modules\SaluteOra\Models\Doctor::class);
$table->foreignIdFor(\Modules\SaluteOra\Models\Studio::class);
```

## Implementazione Errata

```php
// ❌ ERRATO
$table->uuid('doctor_id');
$table->uuid('studio_id');
```

## Motivazioni

### Tecniche

1. **Type safety** - `foreignIdFor()` garantisce che il tipo di colonna corrisponda al tipo di ID del modello correlato
2. **Convenzioni automatiche** - Genera automaticamente nomi di colonna standardizzati (es. `doctor_id`)
3. **Vincoli di integrità** - Facilita l'aggiunta di vincoli `constrained()` per l'integrità referenziale
4. **Evoluzione del codice** - Se il tipo di ID del modello cambia (es. da integer a UUID), la migrazione rimane valida

### Filosofiche

1. **Chiarezza d'intento** - Esprime esplicitamente la relazione tra entità, non solo un campo tecnico
2. **Astrazione semantica** - Lavora al livello delle entità di dominio, non delle strutture database
3. **Leggibilità** - Il codice comunica il "perché" (relazione) oltre al "come" (definizione tecnica)
4. **Principio DRY** - Evita duplicazione di informazioni già definite nel modello

### Religiose e Zen

1. **Rispetto dell'ordine** - Segue il "sentiero" stabilito dai creatori del framework
2. **Armonia** - Si integra naturalmente con il resto dell'ecosistema
3. **Semplicità** - "Fare di più con meno", lasciando che il framework gestisca i dettagli
4. **Coesione** - Mantiene unità tra la rappresentazione del dominio (modelli) e la struttura persistente (database)

### Politiche

1. **Standardizzazione** - Crea un terreno comune di comprensione tra sviluppatori
2. **Contratto sociale** - Stabilisce pratiche condivise che facilitano la collaborazione
3. **Governance** - Rafforza le strutture di decisione tecnica esistenti

## Applicazione alla Tabella Pivot `doctor_studio`

Nella tabella pivot `doctor_studio`, è particolarmente importante utilizzare `foreignIdFor()` per:

1. Mantenere la coerenza con i tipi di ID utilizzati nelle tabelle `users` (per dottori) e `studios`
2. Facilitare eventuali vincoli di integrità referenziale
3. Rendere esplicita la natura relazionale della tabella pivot

```php
public function up(): void
{
    $this->tableCreate(function (Blueprint $table): void {
        $table->id();
        $table->foreignIdFor(\Modules\SaluteOra\Models\Doctor::class);
        $table->foreignIdFor(\Modules\SaluteOra\Models\Studio::class);
        $table->json('schedule')->nullable();
        $table->boolean('is_primary')->default(false);
        $table->timestamps();
        
        $table->unique(['doctor_id', 'studio_id']);
    });
}
```

## Collegamenti a Documentazione Correlata

- [Migrazioni e Schema Builder di Laravel](https://laravel.com/docs/migrations#foreign-key-constraints)
- [Convenzioni di Migrazioni in SaluteOra](migrations.md)
- [Relazione Studio-Doctor](../studio-doctor-relation.md)
