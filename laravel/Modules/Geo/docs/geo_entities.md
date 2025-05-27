# Entità Geografiche

## Filosofia e Principi

### 1. Separazione dei Domini
- Le entità geografiche (Regioni, Province, Città, CAP) sono state spostate dal modulo SaluteOra al modulo Geo
- Questo segue il principio di Single Responsibility (SRP) dei principi SOLID
- Ogni modulo deve gestire solo il proprio dominio specifico

### 2. DRY (Don't Repeat Yourself)
- Le entità geografiche sono utilizzate in più contesti (indirizzi, zone di copertura, etc.)
- Centralizzandole nel modulo Geo, evitiamo duplicazione di codice e logica
- Migliora la manutenibilità e riduce la possibilità di errori

### 3. KISS (Keep It Simple, Stupid)
- Struttura semplice e intuitiva
- Relazioni chiare e dirette tra le entità
- Naming esplicito e auto-documentante

### 4. Clean Code
- Ogni classe ha una singola responsabilità
- Nomi significativi e descrittivi
- Codice ben documentato
- Type hinting completo

## Struttura delle Entità

### Region
```php
class Region extends Model
{
    protected $fillable = ['name', 'code'];
    public function provinces(): HasMany
}
```
- Rappresenta una regione italiana
- Codice univoco di 2 caratteri
- Relazione one-to-many con Province

### Province
```php
class Province extends Model
{
    protected $fillable = ['name', 'code', 'region_id'];
    public function region(): BelongsTo
    public function cities(): HasMany
}
```
- Rappresenta una provincia italiana
- Codice univoco di 2 caratteri
- Appartiene a una Regione
- Relazione one-to-many con Cities

### City
```php
class City extends Model
{
    protected $fillable = ['name', 'province_id'];
    public function province(): BelongsTo
    public function caps(): HasMany
}
```
- Rappresenta un comune italiano
- Appartiene a una Provincia
- Relazione one-to-many con CAP

### Cap
```php
class Cap extends Model
{
    protected $fillable = ['code', 'city_id'];
    public function city(): BelongsTo
}
```
- Rappresenta un codice di avviamento postale
- Appartiene a una Città

## Migrazioni

### regions
```php
Schema::create('regions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code', 2)->unique();
    $table->timestamps();
});
```

### provinces
```php
Schema::create('provinces', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code', 2)->unique();
    $table->foreignId('region_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### cities
```php
Schema::create('cities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('province_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### caps
```php
Schema::create('caps', function (Blueprint $table) {
    $table->id();
    $table->string('code', 5);
    $table->foreignId('city_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

## Best Practices

### 1. Utilizzo
- Importare i modelli dal namespace `Modules\Geo\Models`
- Utilizzare le relazioni per navigare tra le entità
- Mantenere l'integrità referenziale con le foreign keys

### 2. Performance
- Utilizzare eager loading per evitare N+1 queries
- Aggiungere indici appropriati per le ricerche frequenti
- Considerare il caching per dati raramente modificati

### 3. Sicurezza
- Validare sempre i dati in input
- Utilizzare i fillable per il mass assignment
- Implementare controlli di accesso appropriati

### 4. Testing
- Test unitari per ogni modello
- Test di integrazione per le relazioni
- Test delle migrazioni

## Esempi di Utilizzo

### Recupero Gerarchico
```php
$region = Region::with(['provinces.cities.caps'])->find(1);
```

### Ricerca per CAP
```php
$city = Cap::where('code', '20100')->first()->city;
```

### Creazione Gerarchica
```php
$region = Region::create(['name' => 'Lombardia', 'code' => 'LO']);
$province = $region->provinces()->create(['name' => 'Milano', 'code' => 'MI']);
```

## Manutenzione

### 1. Aggiornamenti
- Mantenere sincronizzati i dati con fonti ufficiali
- Documentare eventuali modifiche alla struttura
- Versionare le migrazioni

### 2. Monitoraggio
- Tracciare le performance delle query
- Monitorare l'utilizzo della memoria
- Loggare gli errori significativi

### 3. Backup
- Backup regolari dei dati
- Test di ripristino
- Documentazione delle procedure

## Troubleshooting

### Problemi Comuni
1. **Errori di Foreign Key**
   - Verificare l'ordine delle migrazioni
   - Controllare l'integrità dei dati

2. **Performance Lente**
   - Verificare gli indici
   - Ottimizzare le query
   - Utilizzare il caching

3. **Dati Inconsistenti**
   - Validare i dati in input
   - Implementare controlli di integrità
   - Eseguire controlli periodici 