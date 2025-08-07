# Regole per Risorse Filament in SaluteMo

## Principi Fondamentali

- **Estensione Base**: SEMPRE estendere le classi base di Xot invece di Filament direttamente
- **Traduzioni**: MAI utilizzare metodi di traduzione diretti (->label(), ->placeholder(), etc.)
- **Form Schema**: Utilizzare sempre getFormSchema() invece di form()
- **Tipizzazione**: Rigorosa tipizzazione per PHPStan livello 9+
- **Campi Reali**: MAI inventare campi, usare solo quelli del modello e della migrazione

## Pattern di Estensione Corretti

### 1. Regole per XotBaseResource

**Struttura Base:**

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;
use Modules\SaluteMo\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;

    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
```

**❌ VIOLAZIONI GRAVI DA EVITARE:**

1. **MAI usare ->label() nei form components:**
   ```php
   // ❌ ERRATO
   TextInput::make('name')->label('Nome')
   
   // ✅ CORRETTO
   TextInput::make('name') // Label gestita da LangServiceProvider
   ```

2. **MAI inventare campi che non esistono nel modello:**
   ```php
   // ❌ ERRATO - Campi inventati
   'title' => Tables\Columns\TextColumn::make('title'), // Non esiste nel modello Report
   'type' => Tables\Columns\TextColumn::make('type'),   // Non esiste nel modello Report
   'status' => Tables\Columns\TextColumn::make('status'), // Non esiste nel modello Report
   
   // ✅ CORRETTO - Campi reali dal modello Report
   'patient_id' => Tables\Columns\TextColumn::make('patient_id'),
   'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain'),
   'smokes' => Tables\Columns\IconColumn::make('smokes'),
   ```

3. **MAI estendere classi Filament direttamente:**
   ```php
   // ❌ ERRATO
   class AppointmentResource extends Resource
   
   // ✅ CORRETTO
   class AppointmentResource extends XotBaseResource
   ```

4. **MAI definire navigationIcon se si estende XotBaseResource:**
   ```php
   // ❌ ERRATO
   class ReportResource extends XotBaseResource
   {
       protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // GESTITO AUTOMATICAMENTE
   }
   
   // ✅ CORRETTO
   class ReportResource extends XotBaseResource
   {
       // Navigation icon gestita automaticamente da XotBaseResource
   }
   ```

### 2. Regole per XotBaseListRecords

**Struttura Corretta:**

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Modules\SaluteMo\Filament\Resources\ReportResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;
use Filament\Tables;

class ListReports extends XotBaseListRecords
{
    protected static string $resource = ReportResource::class;

    /**
     * ✅ CAMPI REALI: Utilizzo solo i campi che esistono nel modello Report
     * ✅ NO LABEL: Non uso ->label() perché gestito da LangServiceProvider
     * ✅ DA MIGRAZIONE: Campi presi dalla migrazione create_reports_table
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->searchable()
                ->sortable(),
            'patient_id' => Tables\Columns\TextColumn::make('patient_id')
                ->searchable()
                ->sortable(),
            'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain')
                ->boolean()
                ->sortable(),
            // Altri campi reali del modello Report...
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

**❌ VIOLAZIONI GRAVI DA EVITARE:**

1. **MAI inventare campi per la tabella:**
   ```php
   // ❌ ERRATO - Campi inventati che non esistono
   'title' => Tables\Columns\TextColumn::make('title'),
   'type' => Tables\Columns\TextColumn::make('type'),
   'status' => Tables\Columns\TextColumn::make('status'),
   
   // ✅ CORRETTO - Campi reali dal modello
   'patient_id' => Tables\Columns\TextColumn::make('patient_id'),
   'appointment_id' => Tables\Columns\TextColumn::make('appointment_id'),
   'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain'),
   ```

2. **MAI usare ->label() nelle azioni:**
   ```php
   // ❌ ERRATO
   Actions\CreateAction::make()->label('Crea nuovo')
   
   // ✅ CORRETTO
   Actions\CreateAction::make() // Label gestita da LangServiceProvider
   ```

### 3. Regole per XotBaseEditRecord

**Struttura Corretta:**

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Actions;

/**
 * Pagina di modifica per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseEditRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende EditRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseEditRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class EditAppointment extends XotBaseEditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(), // ✅ NO ->label() hardcoded
        ];
    }
}
```

### 4. Regole per XotBaseCreateRecord

**Struttura Corretta:**

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

/**
 * Pagina di creazione per gli appuntamenti.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseCreateRecord
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende CreateRecord di Filament direttamente
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO FORM: Il metodo form() è già implementato in XotBaseCreateRecord
 * ✅ UTILIZZA getFormSchema(): Dalla risorsa AppointmentResource
 */
class CreateAppointment extends XotBaseCreateRecord
{
    protected static string $resource = AppointmentResource::class;
}
```

## Esempi di Implementazione Corretta

### ReportResource.php - IMPLEMENTAZIONE CORRETTA

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\ReportResource\Pages;
use Modules\SaluteOra\Models\Report;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;

/**
 * Risorsa Filament per i report.
 * 
 * ✅ IMPLEMENTAZIONE CORRETTA: Estende XotBaseResource
 * ✅ SEGUE IL PATTERN LARAXOT: Non estende Resource di Filament direttamente
 * ✅ IMPLEMENTA getFormSchema(): Metodo obbligatorio per XotBaseResource
 * ✅ DOCUMENTAZIONE AGGIORNATA: PHPDoc completo e chiaro
 * ✅ NO NAVIGATION ICON: Non definito perché gestito da XotBaseResource
 * ✅ NO FORM/TABLE: Metodi gestiti automaticamente da XotBaseResource
 * ✅ NO LABEL HARDCODED: Tutte le label gestite da LangServiceProvider
 */
class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    /**
     * Get the form schema.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // ✅ NO ->label(): Tutte le label gestite da LangServiceProvider
            Forms\Components\Select::make('patient_id')
                ->relationship('patient', 'name')
                ->required(),
            
            Forms\Components\Toggle::make('has_mouth_or_teeth_pain'),
            Forms\Components\Toggle::make('smokes'),
            // Altri campi reali del modello Report...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
```

## Checklist di Conformità

Prima di considerare completa una risorsa Filament, verificare:

### ✅ Estensione Base
- [ ] Estende `XotBaseResource` invece di `Resource`
- [ ] Estende `XotBaseListRecords` invece di `ListRecords`
- [ ] Estende `XotBaseEditRecord` invece di `EditRecord`
- [ ] Estende `XotBaseCreateRecord` invece di `CreateRecord`

### ✅ Traduzioni
- [ ] NESSUN `->label()` hardcoded nei form components
- [ ] NESSUN `->placeholder()` hardcoded
- [ ] NESSUN `->helperText()` hardcoded
- [ ] Tutte le traduzioni nei file di lingua del modulo

### ✅ Campi Reali
- [ ] Tutti i campi della tabella esistono nel modello
- [ ] Tutti i campi del form esistono nel modello
- [ ] Campi presi dalla migrazione, non inventati
- [ ] Verificato con `$fillable` del modello

### ✅ Metodi Obbligatori
- [ ] `getFormSchema()` implementato in XotBaseResource
- [ ] `getTableColumns()` implementato in XotBaseListRecords
- [ ] Nessun override di metodi già gestiti da XotBaseResource

### ✅ Documentazione
- [ ] PHPDoc completo per tutte le classi e metodi
- [ ] Commenti che spiegano le scelte implementative
- [ ] Documentazione aggiornata nel modulo e nella root

## File Corretti

### ✅ ReportResource
- `ReportResource.php` - Estende `XotBaseResource`
- `ListReports.php` - Estende `XotBaseListRecords`
- `CreateReport.php` - Estende `XotBaseCreateRecord`
- `EditReport.php` - Estende `XotBaseEditRecord`

### ✅ AppointmentResource
- `AppointmentResource.php` - Estende `XotBaseResource`
- `ListAppointments.php` - Estende `XotBaseListRecords`
- `CreateAppointment.php` - Estende `XotBaseCreateRecord`
- `EditAppointment.php` - Estende `XotBaseEditRecord` 