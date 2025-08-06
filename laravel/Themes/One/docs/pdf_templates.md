# Template PDF - Tema One

## Panoramica

Questo documento descrive i template PDF disponibili nel tema "One" e le best practices per la loro implementazione e manutenzione.

## Template Disponibili

### Report Appuntamento (`appointment/report_pdf.blade.php`)

Template per la generazione di report PDF degli appuntamenti medici, utilizzato principalmente in ambito odontoiatrico.

#### Struttura del Template

```blade
<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    <page_header>
        <!-- Header con informazioni studio, titolo e timestamp -->
    </page_header>
    
    <page_footer>
        <!-- Footer con numero documento e paginazione -->
    </page_footer>
    
    <style type="text/css">
        /* Stili CSS per la formattazione PDF */
    </style>
    
    <!-- Contenuto del report -->
</page>
```

#### Sezioni Principali

1. **Header e Footer**
   - Informazioni studio
   - Titolo del documento
   - Timestamp di generazione
   - Numero documento e paginazione

2. **Informazioni Appuntamento**
   - Data e ora
   - Stato dell'appuntamento
   - Note aggiuntive

3. **Informazioni Paziente**
   - Nome completo
   - Email e telefono
   - Data di nascita

4. **Informazioni Medico**
   - Nome completo
   - Specializzazione
   - Contatti

5. **Informazioni Studio**
   - Nome studio
   - Indirizzo completo
   - Contatti

6. **Referto Medico** (se presente)
   - Condizioni mediche
   - Informazioni gravidanza
   - Igiene orale
   - Dettagli dentali

#### Classi CSS Disponibili

```css
/* Stili per stati e indicatori */
.emergency          /* Alert emergenza */
.status-*          /* Stati appuntamento */
.yes-no            /* Indicatori sì/no */

/* Stili per sezioni mediche */
.medical-section    /* Sezioni del referto */
.medical-table      /* Tabelle mediche */
.medical-item       /* Elementi medici singoli */

/* Stili per dettagli */
.detail-box         /* Box informazioni aggiuntive */
.detail-label       /* Etichette dettagli */

/* Stili per liste */
.disease-item       /* Elementi malattie */
.tooth-item         /* Elementi denti */
.prosthesis-item    /* Elementi protesi */
.tartar-item        /* Elementi tartaro */
.plaque-item        /* Elementi placca */
```

## Best Practices

### 1. Traduzioni

- **Utilizzare sempre `@lang()`** invece di `trans()`
- **Namespace corretto**: `pub_theme::` per traduzioni del tema
- **Struttura coerente**: Mantenere la stessa struttura per tutte le lingue

```blade
<!-- ✅ CORRETTO -->
@lang('pub_theme::appointment.report.labels.date')

<!-- ❌ ERRATO -->
{{ trans('pub_theme::appointment.report.labels.date') }}
```

### 2. Gestione Dati

- **Controlli null-safe**: Utilizzare sempre `?->` per proprietà opzionali
- **Formattazione date**: Utilizzare `format('d/m/Y')` per date italiane
- **Gestione array**: Controllare sempre `is_array()` prima di iterare

```blade
<!-- ✅ CORRETTO -->
{{ $appointment->starts_at?->format('d/m/Y') }}

@if (is_array($appointment->report->specify_diseases))
    @foreach ($appointment->report->specify_diseases as $disease)
        <div class="disease-item">• {{ $disease }}</div>
    @endforeach
@else
    {{ $appointment->report->specify_diseases }}
@endif
```

### 3. Struttura HTML

- **Tag di chiusura**: Assicurarsi che tutti i tag siano chiusi correttamente
- **Indentazione**: Mantenere indentazione coerente
- **Commenti**: Utilizzare commenti per sezioni principali

### 4. Stili CSS

- **Font**: Utilizzare Arial per compatibilità PDF
- **Dimensioni**: Font-size in pixel per precisione
- **Colori**: Utilizzare codici esadecimali completi
- **Margini**: Specificare sempre unità (mm, px)

## Errori Comuni da Evitare

### 1. Duplicazione Contenuti

```blade
<!-- ❌ ERRATO: Sezioni duplicate -->
<div class="medical-item">
    <div class="medical-question">@lang('saluteora::report.fields.smokes.label')</div>
    <!-- ... -->
</div>

<div class="medical-item">
    <div class="medical-question">@lang('saluteora::report.fields.smokes.label')</div>
    <!-- ... -->
</div>
```

### 2. Traduzioni Inconsistenti

```blade
<!-- ❌ ERRATO: Mix di @lang e trans() -->
@lang('pub_theme::common.yes')
{{ trans('pub_theme::common.no') }}
```

### 3. Controlli Null Mancanti

```blade
<!-- ❌ ERRATO: Possibile errore se null -->
{{ $appointment->patient->date_of_birth->format('d/m/Y') }}

<!-- ✅ CORRETTO -->
{{ $appointment->patient->date_of_birth?->format('d/m/Y') }}
```

## Manutenzione

### Aggiornamento Traduzioni

1. Verificare che tutte le chiavi esistano nei file di traduzione
2. Mantenere coerenza tra le lingue (it, en, de)
3. Aggiornare la documentazione quando si aggiungono nuove sezioni

### Test Template

1. Generare PDF con dati completi
2. Generare PDF con dati parziali/null
3. Verificare layout su diverse dimensioni
4. Controllare caratteri speciali e accentati

### Performance

1. Ottimizzare query per evitare N+1
2. Utilizzare eager loading per relazioni
3. Considerare caching per template complessi

## Collegamenti

- [Documentazione Tema](../theme.md)
- [Componenti UI](../components.md)
- [Best Practices](../best_practices.md)
- [Traduzioni](../translations.md)

## Note Tecniche

- **Generatore PDF**: DomPDF
- **Encoding**: UTF-8
- **Formato**: A4 portrait
- **Margini**: 15mm laterali, 20mm superiore, 10mm inferiore
- **Font**: Arial (fallback sans-serif)

---

*Ultimo aggiornamento: Dicembre 2024* 