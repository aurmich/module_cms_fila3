# Icona SVG - Modulo SaluteOra

## Descrizione
Icona SVG elegante e moderna per il modulo SaluteOra, ottimizzata per il dark theme e contestuale al settore sanitario.

## Caratteristiche Design

### 🎨 **Elementi Principali**
- **Cuore centrale**: Simbolo universale della salute e della cura
- **Linea di battito cardiaco**: Rappresenta la vitalità e il monitoraggio
- **Gradiente rosso**: Colori caldi che evocano passione e urgenza
- **Accenti verdi**: Elementi di vita e benessere

### 🌙 **Ottimizzazione Dark Theme**
- **Gradiente rosso**: `#ef4444` → `#dc2626` → `#b91c1c`
- **Accenti verdi**: `#10b981` per elementi decorativi
- **Effetto glow**: Filtro SVG per luminosità controllata
- **Opacità bilanciata**: 0.6-0.9 per profondità visiva

### 🏥 **Contestualità Sanitaria**
- **Cuore**: Simbolo universale della medicina
- **Battito cardiaco**: Rappresenta il monitoraggio vitale
- **Punti decorativi**: Simboleggiano pazienti/utenti
- **Design moderno**: Adatto a sistemi sanitari digitali

## Specifiche Tecniche

### 📐 **Dimensioni e ViewBox**
- **ViewBox**: `0 0 24 24`
- **Classe CSS**: `w-6 h-6` (24x24px)
- **Scalabilità**: Vettoriale, perfetta per qualsiasi dimensione

### 🎯 **Elementi SVG**
```svg
<!-- Gradienti definiti -->
<linearGradient id="heartGradient"> <!-- Rosso per cuore -->
<linearGradient id="pulseGradient"> <!-- Verde per battito -->
<filter id="glow"> <!-- Effetto luminoso -->

<!-- Cuore principale -->
<path d="M12 21.35l-1.45-1.32..."> <!-- Forma cuore -->

<!-- Linea battito cardiaco -->
<path d="M6 12l2-2 2 4..."> <!-- ECG stilizzato -->

<!-- Elementi decorativi -->
<circle cx="8" cy="8" r="0.5"> <!-- Punti verdi -->
```

### 🎨 **Palette Colori**
- **Primario**: Rosso gradiente (`#ef4444` → `#b91c1c`)
- **Secondario**: Verde (`#10b981`)
- **Accento**: Bianco (`#ffffff`)
- **Sfondo**: Trasparente (adatta a qualsiasi tema)

## Utilizzo

### 📍 **Posizione File**
```
laravel/Modules/SaluteOra/resources/svg/icon.svg
```

### 🔧 **Registrazione nel ServiceProvider**
```php
// In SaluteOraServiceProvider
FilamentAsset::register([
    Svg::make('saluteora-icon', __DIR__.'/../resources/svg/icon.svg'),
], 'saluteora');

FilamentIcon::register([
    'saluteora-icon' => Svg::make('icon', __DIR__.'/../resources/svg/icon.svg'),
]);
```

### 📝 **Utilizzo nelle Traduzioni**
```php
// In file di traduzione
return [
    'navigation' => [
        'icon' => 'saluteora-icon',
    ],
];
```

## Best Practices

### ✅ **Vantaggi**
- **Scalabilità**: Vettoriale, perfetta per qualsiasi dimensione
- **Accessibilità**: Contrasto ottimizzato per dark theme
- **Semanticità**: Simboli universali del settore sanitario
- **Modernità**: Design contemporaneo e professionale

### 🎯 **Contestualità**
- **Settore**: Sanitario e medicale
- **Funzione**: Identificazione visiva del modulo
- **Target**: Operatori sanitari e pazienti
- **Tecnologia**: Sistemi digitali moderni

## Manutenzione

### 🔄 **Aggiornamenti**
- Mantenere la coerenza con il brand SaluteOra
- Verificare la compatibilità con nuovi temi
- Testare su diversi dispositivi e risoluzioni

### 📋 **Checklist**
- [ ] Icona visibile in dark theme
- [ ] Scalabilità corretta
- [ ] Registrazione nel ServiceProvider
- [ ] Utilizzo nelle traduzioni
- [ ] Test su diversi dispositivi

## Collegamenti
- [Modulo SaluteOra](../readme.md)
- [ServiceProvider](../Providers/SaluteOraServiceProvider.php)
- [Traduzioni](../lang/it/navigation.php)

*Ultimo aggiornamento: 2025-01-27* 