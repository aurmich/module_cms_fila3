# Form Components Custom

Questa sezione raccoglie la documentazione e le best practices per i campi custom Filament sviluppati nel modulo SaluteOra.

## Indice
- [OpeningHoursField](./opening-hours-field.md): campo avanzato per la gestione degli orari di apertura
- [StudioDoctorSelector](./studio-doctor-selector.md): componente per la selezione studio+dottore con card UI

## Filosofia
- **DRY**: ogni campo custom deve essere riusabile nel modulo 
- **KISS**: UI semplice, validazione centralizzata
- **Zen**: serenità nella compilazione, feedback immediato
- **Separazione**: Logica nel modulo, presentazione nel tema

## Best Practices  
- Documentare sempre input/output e edge case
- Validare sia lato client che server
- Collegare sempre a risorse esterne (es. Spatie/opening-hours)
- **Componenti specifici SaluteOra**: Nel modulo, non in UI generico
- **View nel tema**: `pub_theme::` per personalizzazione visiva

## Architettura
- **Logica**: `Modules/SaluteOra/app/Forms/Components/`
- **Presentazione**: `Themes/One/resources/views/filament/forms/components/`  
- **Traduzioni**: `Modules/SaluteOra/lang/it/`

## Risorse
- [Filament Custom Fields](https://filamentphp.com/docs/3.x/forms/custom-fields)
- [spatie/opening-hours](https://github.com/spatie/opening-hours)

---

Per suggerimenti o nuovi componenti, aprire una issue o PR. 
