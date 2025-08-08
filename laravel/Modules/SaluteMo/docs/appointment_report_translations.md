# Traduzioni Appointment Report (Referto Appuntamenti) - SaluteMo Module

## Principi DRY + KISS Applicati

### REGOLE ASSOLUTE RISPETTATE:
- ✅ `declare(strict_types=1);` obbligatorio
- ✅ Sintassi array brevi `[]` invece di `array()`
- ✅ Struttura espansa completa a 7 elementi per ogni campo
- ✅ Traduzioni italiane complete e professionali
- ✅ Nessuna rimozione di contenuto esistente (solo aggiunta/miglioramento)

### STRUTTURA ESPANSA COMPLETA (7 elementi):
1. **label** - Etichetta del campo
2. **placeholder** - Testo di esempio
3. **tooltip** - Suggerimento breve
4. **helper_text** - Testo di aiuto dettagliato
5. **description** - Descrizione completa del campo
6. **icon** - Icona Heroicons appropriata
7. **color** - Colore del contesto

### SEZIONI IMPLEMENTATE:
- **model** - Informazioni del modello
- **navigation** - Navigazione e menu
- **pages** - Pagine del report
- **fields** - Campi del form con struttura espansa
- **actions** - Azioni disponibili
- **messages** - Messaggi di feedback
- **validation** - Regole di validazione

### CAMPI REPORT SPECIFICI:
- **date_range** - Selezione periodo (date picker range)
- **doctor_filter** - Filtro per medico (select con ricerca)
- **patient_filter** - Filtro per paziente (select con ricerca)
- **studio_filter** - Filtro per studio (select multiplo)
- **status_filter** - Filtro per stato (select con enum)
- **report_type** - Tipo di report (select con opzioni predefinite)
- **export_format** - Formato esportazione (select: PDF, Excel, CSV)
- **include_notes** - Includi note (toggle boolean)
- **include_costs** - Includi costi (toggle boolean)
- **group_by** - Raggruppa per (select: medico, studio, data)
- **sort_order** - Ordinamento (select: ASC, DESC)
- **chart_type** - Tipo grafico (select: bar, line, pie)
- **summary_stats** - Statistiche riassuntive (toggle boolean)

## Collegamenti Bidirezionali:
- [SaluteMo Module Docs](../README.md)
- [Traduzioni Appointment](./appointment_translations.md)
- [Root Translation Rules](../../../docs/translation_rules.md)

*Ultimo aggiornamento: 2025-08-08 - Refactoring DRY+KISS completo*