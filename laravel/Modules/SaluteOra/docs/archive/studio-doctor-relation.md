# Relazione Many-to-Many tra Studio e Doctor

## Panoramica

Questa documentazione descrive la corretta implementazione della relazione many-to-many (molti a molti) tra le entità `Studio` e `Doctor` nel sistema SaluteOra.

## Motivazione Concettuale

La relazione tra studi medici e dottori è intrinsecamente una relazione many-to-many perché:

1. **Realtà Professionale**: Un dottore tipicamente lavora in più strutture sanitarie
2. **Efficienza Organizzativa**: Uno studio necessita di più professionisti con diverse specializzazioni
3. **Flessibilità Operativa**: Questa struttura supporta orari flessibili e disponibilità variabili

## Implementazione Tecnica

### Tabella Pivot

La relazione utilizza una tabella pivot `doctor_studio` con la seguente struttura:

```php
Schema::create('doctor_studio', function (Blueprint $table) {
    $table->id(); // Chiave primaria autoincrement
    $table->uuid('doctor_id')->comment('ID del dottore (riferimento alla tabella users)');
    $table->uuid('studio_id')->comment('ID dello studio (riferimento alla tabella studios)');
    $table->json('schedule')->nullable()->comment('Orari del dottore in questo studio');
    $table->boolean('is_primary')->default(false)->comment('Indica se è lo studio principale');
    $table->timestamps();
    
    // Garantisce l'unicità della relazione doctor-studio
    $table->unique(['doctor_id', 'studio_id']);
});
```

### Modello Pivot

A differenza delle relazioni many-to-many standard, utilizziamo un modello personalizzato per la tabella pivot:

```php
class DoctorStudio extends Model
{
    protected $table = 'doctor_studio';
    
    protected $fillable = [
        'doctor_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];
    
    protected $casts = [
        'schedule' => 'array',
        'is_primary' => 'boolean',
    ];
    
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
```

### Modello Studio

```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class)
        ->using(DoctorStudio::class)
        ->withPivot(['schedule', 'is_primary'])
        ->withTimestamps();
}
```

### Modello Doctor

```php
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class)
        ->using(DoctorStudio::class)
        ->withPivot(['schedule', 'is_primary'])
        ->withTimestamps();
}
```

## Impatto sui RelationManager

Questo cambiamento influisce sui seguenti componenti:

1. `DoctorsRelationManager` nel `StudioResource`
2. `StudiosRelationManager` nel `DoctorResource`

Entrambi devono essere aggiornati per riflettere la relazione many-to-many, inclusa la gestione dei dati pivot.

## Considerazioni sulla Migrazione dei Dati

Se si passa da una relazione HasMany a BelongsToMany in un sistema esistente, è necessario:

1. Creare la tabella pivot
2. Migrare i dati esistenti (dove tenant_id era utilizzato)
3. Aggiornare tutte le query e i riferimenti alla relazione

## Collegamenti ad Altri Documenti

- [Modello Studio](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/studio.md)
- [Modello Doctor](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/models/doctor.md)
- [RelationManager in Filament](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/filament-relation-managers.md)
