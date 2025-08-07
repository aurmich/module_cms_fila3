# SaluteMo Module - Icon Design

## Concetto Design
L'icona del modulo SaluteMo rappresenta la salute e il benessere attraverso simboli medici e sanitari.

## Elementi Visivi
- **Croce medica di sfondo**: Simbolo universale della medicina
- **Cuore principale**: Rappresenta la salute cardiovascolare e il benessere
- **Linea del battito cardiaco**: Indica vitalità e monitoraggio sanitario
- **Simbolo + medico**: Icona di assistenza sanitaria
- **Indicatori di salute**: Punti che rappresentano parametri vitali

## Animazioni

### heartbeat (2s, infinite)
- **Effetto**: Il cuore batte con un ritmo realistico
- **Tecnica**: `scale` con sequenza `1 → 1.1 → 1 → 1.05 → 1`
- **Scopo**: Simula il battito cardiaco naturale

### glow (3s, infinite alternate)
- **Effetto**: La croce medica brilla delicatamente
- **Tecnica**: `opacity` da `0.7` a `1`
- **Scopo**: Evidenzia l'aspetto medico e professionale

### pulse (1.5s, infinite)
- **Effetto**: La linea del battito si muove come un ECG
- **Tecnica**: `stroke-dashoffset` animato con `stroke-dasharray`
- **Scopo**: Simula il monitoraggio dei parametri vitali

## Accessibilità
- Supporto `prefers-reduced-motion` per disabilitare animazioni
- Uso di `currentColor` per adattamento automatico ai temi
- Opacità variabile per creare gerarchia visiva senza dipendere dal colore

## Utilizzo
```php
// Nel ServiceProvider del modulo SaluteMo
FilamentIcon::register([
    'salutemo-icon' => 'salutemo-icon',
]);
```

## Collegamenti
- [Design System Globale](../../../../docs/module-icons-design-system.md)
- [SaluteMo Module Documentation](./README.md)

*Creato: Agosto 2025*
