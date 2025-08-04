# Modulo UI - Documentazione

## Panoramica
Il modulo UI fornisce componenti, widget e funzionalità di interfaccia utente condivise per l'ecosistema Laraxot.

## Funzionalità Principali
- Componenti Blade riutilizzabili
- Widget Filament personalizzati
- Gestione orari di apertura
- Componenti calendario
- Utility di interfaccia
- **TableLayoutEnum**: Sistema di layout per tabelle Filament (lista/griglia)

## File di Traduzione

### Traduzioni Principali
- `opening_hours.php` - Traduzioni per la gestione orari di apertura
- `opening_hours_field.php` - **FIX COMPLETATO**: Traduzioni per i campi orari con sincronizzazione lingue
- `user_calendar.php` - Traduzioni per il calendario utente
- `components.php` - Traduzioni per i componenti UI
- `table-layout.php` - **NUOVO**: Traduzioni per TableLayoutEnum (IT/EN/DE)

### Fix Implementati
- [Fix Traduzioni Opening Hours Field](opening_hours_translation_fix.md) - **REGOLA CRITICA**: Sincronizzazione obbligatoria tra lingue IT/EN
- [Fix Traduzioni Opening Hours](opening_hours_translation_improvement.md) - Miglioramento traduzioni orari
- [Analisi TableLayoutEnum](table_layout_enum_analysis.md) - **NUOVO**: Documentazione completa enum layout tabelle

## Regole Critiche

### ❌ MAI usare ->label()
```php
// ERRORE - Non fare mai questo
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')

// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
Action::make('save')
```

### ✅ SEMPRE usa transClass() negli Enum
```php
// ✅ CORRETTO - Implementazione Enum con TransTrait
use Modules\Xot\Filament\Traits\TransTrait;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value . '.color');
    }
}
```

### ❌ MAI usa match() per traduzioni negli Enum
```php
// ❌ ERRORE - Non fare mai questo
public function getLabel(): string
{
    return match ($this) {
        self::LIST => __('ui::table-layout.list.label'),
        self::GRID => __('ui::table-layout.grid.label'),
    };
}
```

### Sistema Traduzioni Automatico
- Il LangServiceProvider gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`
- **SEMPRE** implementare traduzioni nei file lang/ prima di usare i componenti

### Sincronizzazione Lingue
- **TUTTI** i file `lang/en/` devono avere le stesse voci di `lang/it/`
- **SEMPRE** confrontare file IT e EN prima di modifiche
- **SEMPRE** aggiungere nuove voci in entrambe le lingue
- **NUOVO**: Aggiungere sempre anche traduzioni tedesche (DE)

### Struttura Traduzioni
- Struttura espansa obbligatoria per tutti i campi
- Sintassi moderna `[]` invece di `array()`
- `declare(strict_types=1);` sempre presente
- `tooltip` e `helper_text` per ogni campo

## Componenti UI

### Posizionamento
- **SEMPRE** in `Modules/UI/resources/views/components/ui/`
- **MAI** nella root `resources/views/components/`

### Convenzioni
- Nomi file in minuscolo
- PHPDoc completo per ogni componente
- Organizzazione in sottocartelle logiche

## Enums e Utilities

### TableLayoutEnum
- **Scopo**: Gestione layout tabelle Filament (lista/griglia)
- **Funzionalità**: Toggle responsive, traduzioni, colori, icone
- **Interfacce**: HasColor, HasIcon, HasLabel
- **Pattern**: Strategy Pattern per colonne dinamiche
- **Implementazione**: TransTrait con transClass()

### Utilizzo TableLayoutEnum
```php
use Modules\UI\Enums\TableLayoutEnum;

class ListUsers extends ListRecords
{
    protected TableLayoutEnum $layout = TableLayoutEnum::LIST;
    
    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumnsForLayout())
            ->contentGrid($this->layout->getTableContentGrid());
    }
}
```

## Collegamenti

- [Documentazione Root](../../../docs/translation_standards_links.md)
- [Regole Traduzioni](translation_rules.md)
- [Best Practices Filament](filament_best_practices.md)
- [Componenti UI](components.md)
- [TableLayoutEnum Analysis](table_layout_enum_analysis.md)
- [TableLayoutEnum Usage](table-layout-enum-usage.md)
- **[REGOLA CRITICA: MAI usare ->label()](never_use_label_rule.md)**
- **[REGOLA CRITICA: SEMPRE usa transClass()](transclass_rule.md)**

*Ultimo aggiornamento: gennaio 2025* 
