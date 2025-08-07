# Vista Lista Documenti Paziente

## Overview
Questo documento descrive l'implementazione della vista lista dei documenti del paziente nel modulo SaluteOra.

## Documenti Gestiti
- Tessera Sanitaria (health_card)
- Documento di Identità (identity_document)
- Certificazione ISEE (isee_certificate)
- Certificato di Gravidanza (pregnancy_certificate)

## Implementazione

### ListPatients
La classe `ListPatients` estende `ListUsers` e aggiunge colonne specifiche per i documenti del paziente.

```php
public function getTableColumns(): array
{
    $columns = parent::getTableColumns();
    $columns = Arr::except($columns, ['type']);
    
    // Aggiungi colonne per i documenti
    $columns['health_card'] = Tables\Columns\SpatieMediaLibraryImageColumn::make('health_card')
        ->collection('tessera_sanitaria')
        ->circular();
        
    $columns['identity_document'] = Tables\Columns\SpatieMediaLibraryImageColumn::make('identity_document')
        ->collection('documento_identita')
        ->circular();
        
    $columns['isee_certificate'] = Tables\Columns\SpatieMediaLibraryImageColumn::make('isee_certificate')
        ->collection('certificazione_isee')
        ->circular();
        
    $columns['pregnancy_certificate'] = Tables\Columns\SpatieMediaLibraryImageColumn::make('pregnancy_certificate')
        ->collection('certificato_gravidanza')
        ->circular();
        
    return $columns;
}
```

## Best Practices
1. Utilizzare `SpatieMediaLibraryImageColumn` per visualizzare le immagini
2. Mantenere la coerenza con le collezioni definite nel modello
3. Utilizzare il trait `HasMedia` nel modello Patient
4. Implementare la validazione dei file nel form
5. Gestire correttamente i permessi di accesso ai file

## Collegamenti
- [Spatie Media Library Documentation](https://spatie.be/docs/laravel-medialibrary)
- [Filament Spatie Media Library Plugin](https://filamentphp.com/plugins/filament-spatie-media-library)
- [Patient Resource Implementation](../patient-resource-implementation.md) 
