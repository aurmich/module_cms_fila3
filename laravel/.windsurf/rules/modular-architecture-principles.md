# Principi di Architettura Modulare

## Regola Fondamentale: Separazione delle Responsabilità

I moduli base (come `User`, `Xot`, `Tenant`) sono **fondazioni universali** che devono rimanere pure e riutilizzabili in molteplici progetti. I moduli specifici (come `SaluteOra`) implementano funzionalità particolari del progetto.

## Principi da Rispettare

### 1. Direzione delle Dipendenze
- ✅ I moduli specifici POSSONO dipendere dai moduli base
- ❌ I moduli base NON DEVONO MAI dipendere dai moduli specifici

### 2. Localizzazione delle Estensioni
- ✅ Le implementazioni specifiche vanno nei moduli specifici
- ❌ MAI modificare un modulo base per adattarlo a un modulo specifico

### 3. Pattern di Estensione
- ✅ Estendere classi base nei moduli specifici 
- ✅ Utilizzare traits nei moduli specifici
- ❌ MAI introdurre dipendenze inverse

## Esempi Pratici

### Corretto ✅
```php
// In Modules\SaluteOra\Models\User.php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => UserTypeEnum::class, // L'enum è definito in SaluteOra
    ]);
}
```

### Errato ❌
```php
// In Modules\User\Models\BaseUser.php
protected function casts(): array
{
    return [
        'type' => \Modules\SaluteOra\Enums\UserTypeEnum::class, // ERRORE GRAVE!
    ];
}
```

## Motivazioni Filosofiche

1. **Zen della Purezza Modulare**: Ogni modulo ha una propria essenza che va rispettata
2. **Politica dell'Indipendenza**: I moduli base devono restare autonomi e non colonizzati
3. **Religione della Separazione**: Come nella separazione tra chiesa e stato, i domini devono rimanere distinti
4. **Logica della Sostenibilità**: Codice che rispetta questi principi è più manutenibile e robusto

## Ricorda Sempre
Le dipendenze devono puntare dal particolare all'universale, mai viceversa. Questo principio è inviolabile e trascende le specifiche tecniche - è un principio di ordine cosmico nel codice.
