# Componenti Blocks per Pagina Servizi - Tema One

## Panoramica

I componenti per la pagina servizi sono progettati seguendo la filosofia di SaluteOra: **umanità, competenza medica, accessibilità sociale**. Ogni componente riflette l'impegno verso la salute orale delle gestanti vulnerabili.

## Filosofia Design

### Principi Estetici
- **Calore Umano**: Colori rassicuranti, immagini autentiche
- **Chiarezza Medica**: Icone professionali, informazioni precise
- **Accessibilità**: Contrasti adeguati, font leggibili
- **Trust**: Design pulito, certificazioni visibili
- **Responsività**: Mobile-first per raggiungere tutti

### Palette Colori Sanitaria
- **Primary Blue**: `#2563eb` - Fiducia medica
- **Warm Green**: `#059669` - Salute, vita
- **Soft Pink**: `#ec4899` - Maternità, cura
- **Trust Gray**: `#64748b` - Professionalità
- **Alert Orange**: `#ea580c` - Urgenze, attenzione

## Componenti Servizi

### 1. Hero Servizi Medici
**Path**: `pub_theme::components.blocks.hero.medical_services`

```php
@props([
    'title' => 'I Nostri Servizi per Te e il Tuo Bambino',
    'subtitle' => 'Cure odontoiatriche gratuite per gestanti con ISEE fino a 20.000€',
    'background_image' => '/images/pregnant-woman-smile.jpg',
    'cta_text' => 'Verifica se hai diritto',
    'cta_link' => '/register',
    'secondary_cta_text' => 'Scopri di più',
    'secondary_cta_link' => '#servizi'
])
```

**Features**:
- Background con gradiente overlay per leggibilità
- Doppia CTA per percorsi differenziati
- Icone medical integrate
- Responsive con immagini ottimizzate

### 2. Griglia Servizi Medici
**Path**: `pub_theme::components.blocks.features.medical_grid`

```php
@props([
    'title' => 'Servizi Specialistici',
    'description' => 'Cure complete per la salute orale in gravidanza',
    'services' => []
])
```

**Servizi Inclusi**:
- **Prevenzione**: Controlli, detartrasi, educazione
- **Diagnosi**: Radiografie sicure, valutazioni
- **Trattamento**: Otturazioni, cura gengiviti
- **Emergenze**: Pronto soccorso odontoiatrico
- **Follow-up**: Controlli post-parto
- **Educazione**: Igiene orale bambini

### 3. Processo Assistenza
**Path**: `pub_theme::components.blocks.process.assistance_steps`

```php
@props([
    'title' => 'Il Percorso di Cura',
    'subtitle' => 'Semplice, umano, gratuito',
    'steps' => []
])
```

**Steps del Processo**:
1. **Verifica Requisiti** - ISEE, gravidanza, residenza
2. **Registrazione Veloce** - Dati essenziali, privacy
3. **Scelta Professionista** - Vicino a casa, specializzato
4. **Appuntamento Rapido** - Entro 48 ore, flessibile
5. **Cura Personalizzata** - Piano di trattamento dedicato
6. **Follow-up Continuo** - Controlli e supporto

### 4. Rete Professionisti
**Path**: `pub_theme::components.blocks.network.professionals`

```php
@props([
    'title' => 'La Nostra Rete di Esperti',
    'subtitle' => 'Odontoiatri specializzati in gravidanza',
    'professionals' => [],
    'stats' => []
])
```

**Caratteristiche**:
- Mappa interattiva dei centri
- Profili professionisti con specializzazioni
- Recensioni e certificazioni
- Disponibilità in tempo reale

### 5. Benefits Scientifici
**Path**: `pub_theme::components.blocks.benefits.scientific`

```php
@props([
    'title' => 'Perché la Salute Orale in Gravidanza è Fondamentale',
    'benefits' => [],
    'medical_sources' => []
])
```

**Benefici Evidenziati**:
- **Riduzione Parti Prematuri**: -30% con cura orale
- **Prevenzione Trasmissione**: Batteri madre-bambino
- **Benessere Generale**: Alimentazione, nutrizione
- **Economia Familiare**: Risparmio cure future

### 6. Testimonial Autentici
**Path**: `pub_theme::components.blocks.testimonials.maternal`

```php
@props([
    'title' => 'Storie di Mamme che Ce l\'Hanno Fatta',
    'testimonials' => [],
    'privacy_compliant' => true
])
```

**Features Privacy**:
- Nomi di fantasia GDPR-compliant
- Consensi documentati
- Immagini stock rappresentative
- Storie verificate ma anonimizzate

### 7. CTA Emergenza
**Path**: `pub_theme::components.blocks.cta.emergency_dental`

```php
@props([
    'title' => 'Urgenza Dentale in Gravidanza?',
    'subtitle' => 'Non aspettare, chiamaci subito',
    'phone' => '800-123-456',
    'emergency_hours' => '24/7',
    'background_color' => 'bg-red-600'
])
```

## Accessibilità e UX

### WCAG Compliance
- **Contrasto**: Minimo 4.5:1 per testi
- **Navigazione**: Keyboard-friendly
- **Screen Reader**: ARIA labels complete
- **Font Size**: Minimo 16px base

### Mobile Optimization
- **Touch Targets**: Minimo 44px
- **Loading Speed**: < 3 secondi su 3G
- **Thumb Navigation**: Zone facilmente raggiungibili
- **Offline Mode**: Contenuti base disponibili

### Performance
- **Lazy Loading**: Immagini sotto la fold
- **Critical CSS**: Above-the-fold inline
- **Font Loading**: Web fonts ottimizzati
- **Image Optimization**: WebP con fallback

## Integrazioni Mediche

### ISEE Integration
- Verifica automatica tramite API INPS
- Validazione in tempo reale
- Privacy by design

### Booking System
- Calendario professionisti
- Notifiche automatiche
- Reminder pre-appuntamento

### Medical Records
- Cartella clinica digitale
- Consensi digitali
- Condivisione sicura dati

## Testing e Quality Assurance

### A/B Testing
- Hero headlines
- CTA positioning
- Color schemes
- Form layouts

### User Testing
- Gestanti target demografico
- Test usabilità mobile
- Accessibilità con screen reader
- Performance su dispositivi low-end

### Analytics
- Conversion funnel
- Time on page
- Bounce rate
- Form completion rate

## Manutenzione e Evoluzione

### Content Updates
- Aggiornamenti scientifici trimestrali
- Nuovi testimonial
- Expansion rete professionisti
- Miglioramenti UX basati su feedback

### Technical Debt
- Refactoring componenti
- Ottimizzazioni performance
- Aggiornamenti dipendenze
- Security patches

## Collegamenti Tecnici

- [Blocks Architecture](../blocks.md)
- [Component System](../components.md)
- [CMS Integration](../../../Modules/Cms/docs/content-management.md)
- [Performance Guidelines](../../../docs/frontend/performance.md)

*Ultimo aggiornamento: 2025-01-15* 
