# Icona SVG - Modulo SaluteOra

## Data: 2025-01-27

## Panoramica
Icona SVG personalizzata per il modulo SaluteOra, rappresentante un sistema sanitario integrato con elementi medici e di gestione pazienti.

## Caratteristiche

### Design
- **Stile**: Minimalista ed elegante
- **Tema**: Compatibile con dark theme
- **Colori**: Utilizza `currentColor` per adattamento automatico
- **Dimensioni**: 24x24 viewBox, scalabile

### Elementi Compositi
1. **Croce Medica Principale**: Rappresenta il servizio sanitario
2. **Cerchio Sistema**: Simbolizza l'integrazione e la completezza
3. **Pulsazioni Cardiache**: Indica il monitoraggio della salute
4. **Punti Utenti**: Rappresentano pazienti e operatori
5. **Centro Sistema**: Cuore del sistema di gestione

## Utilizzo

### In Filament
```php
// Nel ServiceProvider
FilamentIcon::register([
    'saluteora-icon' => \Filament\Support\Components\Svg::make('icon', __DIR__.'/../../resources/svg/icon.svg'),
]);

// Nei componenti
->icon('saluteora-icon')
```

### In Blade Templates
```blade
<x-filament::icon name="saluteora-icon" class="w-6 h-6" />
```

### In Navigation
```php
protected static ?string $navigationIcon = 'saluteora-icon';
```

## Registrazione

### ServiceProvider
L'icona è registrata in `SaluteOraServiceProvider.php`:

```php
protected function registerSvgIcons(): void
{
    FilamentIcon::register([
        'saluteora-icon' => \Filament\Support\Components\Svg::make('icon', __DIR__.'/../../resources/svg/icon.svg'),
    ]);
}
```

### Percorso File
- **Posizione**: `Modules/SaluteOra/resources/svg/icon.svg`
- **Namespace**: `saluteora-icon`
- **Accesso**: Tramite FilamentIcon facade

## Caratteristiche Tecniche

### SVG Structure
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
  <!-- Croce medica principale -->
  <path d="M12 2L12 22" stroke="currentColor" stroke-width="2.5"/>
  <path d="M2 12L22 12" stroke="currentColor" stroke-width="2.5"/>
  
  <!-- Cerchio esterno per rappresentare il sistema -->
  <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.6"/>
  
  <!-- Pulsazioni cardiache stilizzate -->
  <path d="M8 8L10 10L12 8L14 10L16 8" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.8"/>
  
  <!-- Punti per rappresentare pazienti/utenti -->
  <circle cx="8" cy="8" r="1" fill="currentColor" opacity="0.7"/>
  <circle cx="16" cy="8" r="1" fill="currentColor" opacity="0.7"/>
  <circle cx="8" cy="16" r="1" fill="currentColor" opacity="0.7"/>
  <circle cx="16" cy="16" r="1" fill="currentColor" opacity="0.7"/>
  
  <!-- Elemento centrale per rappresentare il cuore del sistema -->
  <circle cx="12" cy="12" r="2" fill="currentColor" opacity="0.9"/>
</svg>
```

### Attributi
- **viewBox**: "0 0 24 24" per scalabilità
- **stroke**: "currentColor" per adattamento tema
- **stroke-width**: Variabile per gerarchia visiva
- **opacity**: Differenziata per profondità

## Best Practices

### 1. **Scalabilità**
- Utilizza viewBox per scalabilità perfetta
- Mantiene proporzioni su tutti i dispositivi

### 2. **Accessibilità**
- Utilizza `currentColor` per adattamento automatico
- Compatibile con screen reader

### 3. **Performance**
- SVG ottimizzato e compresso
- Nessuna dipendenza esterna

### 4. **Manutenibilità**
- Codice pulito e ben commentato
- Struttura modulare per modifiche future

## Collegamenti

- [ServiceProvider](../app/Providers/SaluteOraServiceProvider.php)
- [Risorse SVG](../resources/svg/)
- [Documentazione Modulo](./README.md)

---

*Ultimo aggiornamento: 2025-01-27*
*Stato: ATTIVO - ICONA REGISTRATA* 