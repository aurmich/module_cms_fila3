# Regole per Form Schema in Filament Resources

## ⚠️ Errori Comuni e Correzioni

### 1. Errore: Reimplementazione vs Riutilizzo
Quando si creano form schema simili per risorse correlate (es: Doctor e Patient), è fondamentale:

❌ **NON** reimplementare la logica da zero
✅ **SI** riutilizzare la struttura esistente e documentata

### 2. Errore: Ignorare la Documentazione Esistente
Prima di implementare un form schema:

❌ **NON** procedere senza consultare:
- Form schema esistenti di risorse simili
- Documentazione nei file .md, .html, .blade.php
- Specifiche nei file di documentazione del progetto

✅ **SI** seguire questo processo:
1. Cercare risorse simili già implementate
2. Consultare la documentazione nella cartella `docs/`
3. Verificare specifiche nei file .md, .html, .blade.php
4. Implementare seguendo il pattern esistente

### 3. Errore: Struttura Form Non Standard
Quando si definisce un form schema:

❌ **NON**:
- Creare strutture personalizzate
- Ignorare i pattern esistenti
- Implementare logica duplicata

✅ **SI**:
- Seguire la struttura del wizard esistente
- Riutilizzare componenti comuni
- Mantenere consistenza tra risorse simili

## Best Practices

### 1. Analisi Preliminare
```php
// Prima di implementare un nuovo form schema
public static function getFormSchemaWidget(): array
{
    // 1. Cercare risorse simili
    // es: PatientResource::getFormSchemaWidget()
    
    // 2. Consultare documentazione
    // docs/images/*.{md,html,blade.php}
    
    // 3. Seguire pattern esistente
    return [
        // Implementazione basata su documentazione e pattern
    ];
}
```

### 2. Struttura Standard Wizard
```php
return [
    'wizard' => Forms\Components\Wizard::make()
        ->schema([
            Forms\Components\Wizard\Step::make('step1')
                ->schema([
                    // Schema basato su documentazione
                ]),
            // Altri step...
        ])
];
```

### 3. Documentazione e Riferimenti
- Mantenere riferimenti alla documentazione originale
- Commentare le deviazioni dal pattern standard
- Spiegare le personalizzazioni necessarie

## Checklist Implementazione

Prima di implementare un form schema:
- [ ] Cercare risorse simili nel progetto
- [ ] Consultare documentazione in `docs/images/`
- [ ] Verificare pattern esistenti
- [ ] Seguire struttura wizard se presente
- [ ] Mantenere consistenza con altre risorse

## Note Importanti

1. La documentazione del form schema si trova in:
   - File .md per specifiche generali
   - File .html per struttura
   - File .blade.php per implementazione

2. Priorità delle fonti:
   - Prima: Documentazione progetto
   - Seconda: Form schema esistenti
   - Terza: Pattern comuni Filament

## Collegamenti
- [Wizard Form Schema](../../../docs/images/13.md)
- [Form Implementation](../../../docs/images/13.blade.php)
- [Structure Documentation](../../../docs/images/13.html) 