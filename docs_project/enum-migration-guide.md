# Guida alla Migrazione degli Enum

## Introduzione

Questo documento descrive il processo di migrazione degli enum nel modulo SaluteOra, con particolare attenzione al passaggio da `AppointmentType` a `AppointmentTypeEnum`.

## File da Aggiornare

### 1. File PHP
- `app/Filament/Widgets/AdminCalendarWidget.php`
- `app/Filament/Widgets/DoctorCalendarWidget.php`
- `app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`
- `app/Http/Livewire/Calendar.php`
- `app/Models/Appointment.php`
- `app/Actions/Patient/Calendar/FetchEventsAction.php`
- `app/Actions/SendAppointmentNotificationAction.php`
- `app/Actions/Calendar/FetchCalendarEventsAction.php`

### 2. File di Documentazione
- `docs/calendar-widgets.md`
- `docs/fullcalendar_parental_widgets.md`
- `docs/find-dentist-functionality.md`
- `docs/find-dentist-implementation.md`
- `docs/appointment-type-enum-usage.md`
- `docs/errors/enum-options-method.md`
- `docs/fullcalendar_multi_tenant_widgets.md`
- `docs/fullcalendar_implementation_guide.md`
- `docs/appointment-system.md`
- `docs/fullcalendar_widgets.md`

## Passi per la Migrazione

1. **Aggiornare gli Import**
   ```php
   // Da
   use Modules\SaluteOra\App\Enums\AppointmentType;
   // A
   use Modules\SaluteOra\App\Enums\AppointmentTypeEnum;
   ```

2. **Aggiornare i Cast nei Modelli**
   ```php
   protected $casts = [
       'type' => AppointmentTypeEnum::class,
   ];
   ```

3. **Aggiornare i Riferimenti nei Widget Filament**
   ```php
   Select::make('type')
       ->options(AppointmentTypeEnum::class)
       ->default(AppointmentTypeEnum::CHECKUP->value);
   ```

4. **Aggiornare i Riferimenti nelle Azioni**
   ```php
   public function execute(array $data): void
   {
       $data['type'] = AppointmentTypeEnum::CHECKUP;
       // ...
   }
   ```

5. **Aggiornare i Riferimenti nelle Viste**
   ```php
   TextColumn::make('type')
       ->badge()
       ->color(fn (AppointmentTypeEnum $state): string => $state->getColor())
       ->formatStateUsing(fn (AppointmentTypeEnum $state): string => $state->getLabel());
   ```

## Best Practices

1. **Mantenere la Compatibilità**
   - Utilizzare `class_alias` per mantenere la compatibilità con il codice esistente
   - Rimuovere gli alias dopo la migrazione completa

2. **Test**
   - Verificare che tutti i test passino dopo la migrazione
   - Aggiungere test specifici per gli enum

3. **Documentazione**
   - Aggiornare tutti i file di documentazione
   - Aggiungere note sulla migrazione

## Rollback

In caso di problemi, è possibile fare rollback:

1. Ripristinare i file originali
2. Rimuovere gli alias
3. Verificare che tutto funzioni come prima

## Collegamenti Correlati

- [Best Practices Enum](enums-best-practices.md)
- [Implementazione Enum](enums-implementation.md)
- [Filament Enums](https://filamentphp.com/docs/3.x/support/enums) 