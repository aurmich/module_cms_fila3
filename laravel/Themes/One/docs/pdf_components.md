# Componenti PDF - Tema One

## Panoramica

Questo documento descrive i componenti PDF disponibili nel tema "One" e le best practices per la loro implementazione e manutenzione.

## Componenti Disponibili

### 1. CSS Base (`xot::pdf.css`)

**Scopo**: Stili CSS standardizzati per tutti i PDF del sistema

**Utilizzo**:
```blade
@include('xot::pdf.css')
```

**Caratteristiche**:
- Stili per header e footer
- Classi per tabelle e layout
- Stili per stati (success, error, warning)
- Stili per elementi medicali
- Responsive design per PDF

### 2. Informazioni Appuntamento (`pub_theme::appointment.report_pdf.appointment`)

**Scopo**: Visualizza le informazioni base dell'appuntamento

**Parametri**:
- `$appointment`: Modello dell'appuntamento

**Utilizzo**:
```blade
@include('pub_theme::appointment.report_pdf.appointment', ['appointment' => $appointment])
```

**Contenuto**:
- Data e ora dell'appuntamento
- Formattazione standardizzata

### 3. Informazioni Paziente (`pub_theme::appointment.report_pdf.patient`)

**Scopo**: Visualizza le informazioni del paziente

**Parametri**:
- `$patient`: Modello del paziente

**Utilizzo**:
```blade
@includeWhen($appointment->patient, 'pub_theme::appointment.report_pdf.patient', ['patient' => $appointment->patient])
```

**Contenuto**:
- Nome completo
- Email (se disponibile)
- Telefono (se disponibile)
- Data di nascita (se disponibile)

## Struttura dei Componenti

### Organizzazione File
```
laravel/Themes/One/resources/views/appointment/report_pdf/
├── appointment.blade.php    # Informazioni appuntamento
├── patient.blade.php        # Informazioni paziente
└── [altri_componenti].blade.php
```

### Convenzioni Naming
- **File**: kebab-case (es. `patient-info.blade.php`)
- **Namespace**: `pub_theme::appointment.report_pdf.*`
- **Parametri**: camelCase (es. `$appointment`, `$patient`)

### Struttura Componente
```blade
{{-- 
    Documentazione del componente
    Scopo, parametri, utilizzo
--}}

<!-- Sezione HTML -->
<h2>@lang('pub_theme::appointment.report.sections.section_name')</h2>
<table class="info">
    <!-- Contenuto del componente -->
</table>
```

## Best Practices

### 1. Responsabilità Singola
Ogni componente deve avere una responsabilità specifica:
- ✅ **Corretto**: Componente solo per informazioni paziente
- ❌ **Errato**: Componente che gestisce paziente + appuntamento + medico

### 2. Parametri Espliciti
Passare sempre i parametri necessari:
```blade
{{-- ✅ Corretto --}}
@include('pub_theme::appointment.report_pdf.patient', ['patient' => $patient])

{{-- ❌ Errato --}}
@include('pub_theme::appointment.report_pdf.patient')
```

### 3. Controlli Condizionali
Utilizzare `@includeWhen()` per dati opzionali:
```blade
{{-- ✅ Corretto --}}
@includeWhen($appointment->patient, 'pub_theme::appointment.report_pdf.patient', ['patient' => $appointment->patient])

{{-- ❌ Errato --}}
@if($appointment->patient)
    @include('pub_theme::appointment.report_pdf.patient', ['patient' => $appointment->patient])
@endif
```

### 4. Documentazione
Ogni componente deve avere:
- Commento di scopo
- Lista dei parametri
- Esempio di utilizzo
- Note di manutenzione

## Esempi di Implementazione

### Template PDF Completo
```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    @include('xot::pdf.css')
    
    <!-- Header principale -->
    <h1>@lang('pub_theme::appointment.report.pdf_title') #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</h1>
    
    <!-- Componenti riutilizzabili -->
    @include('pub_theme::appointment.report_pdf.appointment', ['appointment' => $appointment])
    @includeWhen($appointment->patient, 'pub_theme::appointment.report_pdf.patient', ['patient' => $appointment->patient])
    
    <!-- Contenuto specifico del template -->
    <!-- ... -->
</page>
```

### Template PDF Semplificato
```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    @include('xot::pdf.css')
    
    <!-- Solo informazioni paziente -->
    @includeWhen($patient, 'pub_theme::appointment.report_pdf.patient', ['patient' => $patient])
</page>
```

## Vantaggi dell'Approccio Modulare

### 1. Manutenibilità
- Componenti con responsabilità singola
- Facile aggiornamento e debugging
- Riduzione della complessità

### 2. Riutilizzabilità
- Componenti utilizzabili in diversi template
- Riduzione della duplicazione di codice
- Coerenza tra i PDF

### 3. Testabilità
- Componenti testabili indipendentemente
- Facile mock dei parametri
- Test di regressione semplificati

### 4. Scalabilità
- Facile aggiunta di nuovi componenti
- Struttura modulare e estensibile
- Supporto per diversi tipi di PDF

## Collegamenti

- [Template PDF](pdf_templates.md) - Documentazione completa template PDF
- [Miglioramenti DRY + KISS](dry_kiss_improvements.md) - Ottimizzazioni template PDF
- [Best Practices](best_practices.md) - Linee guida sviluppo

## Note di Sviluppo

Quando si aggiungono nuovi componenti PDF:

1. **Valutare la riutilizzabilità**: Il componente può essere utilizzato in altri template?
2. **Seguire le convenzioni**: Utilizzare naming e struttura coerenti
3. **Documentare**: Aggiornare questa documentazione per nuovi componenti
4. **Testare**: Verificare che i PDF generati abbiano l'aspetto corretto

**Ultimo aggiornamento**: Dicembre 2024 