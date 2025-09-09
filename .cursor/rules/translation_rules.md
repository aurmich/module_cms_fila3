# Regole Critiche per Traduzioni PDF

## Struttura Traduzioni Obbligatoria
- **SEMPRE** usare struttura completa: `sections.{sezione}.label`
- **MAI** usare chiavi dirette senza `.label` per sezioni
- **SEMPRE** verificare esistenza in tutte e tre le lingue (it, en, de)

## Controllo Qualità Traduzioni
- **SEMPRE** aggiungere traduzioni in tutte e tre le lingue
- **MAI** rimuovere contenuto esistente dalle traduzioni
- **SEMPRE** migliorare e aggiungere, mai togliere
- **SEMPRE** verificare struttura coerente tra le lingue

## Pattern Corretto per Sezioni PDF
```blade
{{-- CORRETTO --}}
<h3>@lang('pub_theme::appointment.report.sections.medical_conditions.label')</h3>

{{-- ERRATO --}}
<h3>@lang('pub_theme::appointment.report.sections.medical_conditions')</h3>
```

## Checklist Pre-commit Traduzioni
- [ ] Verificare esistenza chiave in tutte e tre le lingue
- [ ] Controllare struttura `.label` per tutte le sezioni
- [ ] Verificare che componenti usino struttura corretta
- [ ] Testare template PDF con tutte le lingue
- [ ] Documentare modifiche nelle docs

## Strategia di Correzione
**IMPORTANTE**: MAI rimuovere contenuto dalle traduzioni, solo aggiungere o migliorare!

### Quando si trovano duplicazioni:
1. **Aggiungere** le sezioni mancanti alla prima sezione
2. **Mantenere** la seconda sezione per compatibilità
3. **Verificare** che tutti i componenti usino la struttura corretta
4. **Controllare** che tutte e tre le lingue abbiano la stessa struttura

## Errori Comuni da Evitare
- ❌ Rimuovere contenuto dalle traduzioni
- ❌ Usare chiavi senza `.label` per sezioni
- ❌ Aggiungere traduzioni solo in una lingua
- ❌ Non verificare la struttura dei componenti
- ❌ Non documentare le modifiche

## Regole Specifiche per PDF
- **SEMPRE** usare `@lang` per le traduzioni
- **SEMPRE** verificare che le chiavi esistano prima dell'uso
- **SEMPRE** testare con tutte e tre le lingue
- **SEMPRE** aggiornare la documentazione dopo le modifiche

## Pattern di Verifica
```bash
# Verificare che tutte le chiavi usino .label
grep -r "sections\.[a-z_]*')\$" laravel/Themes/One/resources/views/appointment/report_pdf.blade.php

# Verificare che i componenti usino la struttura corretta
grep -r "sections\." laravel/Themes/One/resources/views/appointment/report_pdf/ --include="*.blade.php"

# Verificare che le traduzioni esistano in tutte le lingue
grep -r "medical_conditions" laravel/Themes/One/lang/ --include="*.php"
```

## Ultimo aggiornamento
2025-01-06 - Corretta strategia di non rimozione contenuto traduzioni 