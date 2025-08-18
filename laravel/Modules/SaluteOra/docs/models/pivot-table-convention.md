# Convenzioni per i Modelli Pivot

## Regola Fondamentale: Niente Dichiarazione Esplicita di `$table`

In SaluteOra, i modelli che estendono `BasePivot` **NON DEVONO MAI** dichiarare esplicitamente la proprietà `protected $table`. 

### Motivazioni Tecniche

1. **Gestione Centralizzata**: `BasePivot` implementa una logica interna per la determinazione del nome della tabella pivot
2. **Coerenza**: Garantisce uniformità nella denominazione delle tabelle pivot in tutto il sistema
3. **Manutenibilità**: Riduce la duplicazione del codice e facilita le modifiche globali
4. **Prevenzione Errori**: Evita il rischio di discrepanze tra la tabella dichiarata e quella attesa da Laravel

### Impatto Architetturale

La gestione centralizzata delle tabelle pivot in `BasePivot` fa parte di un'architettura più ampia che enfatizza:

- **Coesione**: Il codice correlato rimane insieme
- **Basso Accoppiamento**: I componenti sono indipendenti
- **Principio DRY**: La logica dei nomi delle tabelle pivot è definita una sola volta

### Implementazione Corretta

```php
// ✓ CORRETTO
class DoctorStudio extends BasePivot
{
    // Nessuna dichiarazione di $table
    
    protected $fillable = [
        'doctor_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];
}
```

### Implementazione Errata

```php
// ✗ ERRATO
class DoctorStudio extends BasePivot
{
    protected $table = 'doctor_studio'; // MAI dichiarare questa proprietà!
    
    protected $fillable = [
        'doctor_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];
}
```

## Logica Interna di `BasePivot`

Internamente, la classe `BasePivot` utilizza convenzioni intelligenti per determinare il nome della tabella:

1. Analizza i modelli coinvolti nella relazione
2. Applica regole di nomenclatura coerenti (ordine alfabetico dei modelli, separati da underscore)
3. Gestisce automaticamente i prefissi e pluralizzazione secondo le configurazioni di Laravel

## Considerazioni Filosofiche

La dichiarazione ridondante di `$table` nei modelli pivot viola i seguenti principi:

- **Principio di Singola Responsabilità**: La responsabilità della determinazione del nome della tabella dovrebbe appartenere a una singola classe (`BasePivot`)
- **Principio di Delega Appropriata**: Un modello pivot dovrebbe delegare la logica comune alla sua classe genitore
- **Principio di Minima Sorpresa**: Tutti i modelli pivot dovrebbero comportarsi in modo coerente

## Collegamenti alla Documentazione Correlata

- [Pivot Models](./pivot-models.md)
- [Inheritance Structure](./inheritance-structure.md)
- [Studio-Doctor Relation](../studio-doctor-relation.md)
