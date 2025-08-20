# FILAMENT.md - Filament Best Practices PTVX

> **CENTRALIZZAZIONE FILAMENT**: Tutte le regole per Filament in un unico file per massima coerenza e zero duplicazioni.

## 🚨 **REGOLE CRITICHE FILAMENT (SEMPRE APPLICARE)**

### 1. **ESTENSIONE CLASSI BASE (OBBLIGATORIO)**

```php
// ✅ SEMPRE fare questo
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

// ❌ MAI fare questo
use Filament\Resources\Resource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
```

**Motivazione**: Le classi base Xot forniscono traduzioni automatiche, comportamenti standardizzati e funzionalità comuni.

### 2. **VIETATO USO DI ->label(), ->placeholder(), ->helperText()**

```php
// ✅ CORRETTO - Nessun metodo di traduzione
TextInput::make('name')
    ->required()
    ->maxLength(255);

// ❌ VIETATO - Mai usare questi metodi
TextInput::make('name')
    ->label('Nome')           // VIETATO
    ->placeholder('Inserisci nome')  // VIETATO
    ->helperText('Nome completo')    // VIETATO
```

**Motivazione**: Le traduzioni vengono gestite automaticamente dal LangServiceProvider tramite i file di traduzione del modulo.

### 3. **IMPLEMENTAZIONE METODI CORRETTI**

```php
// ✅ CORRETTO - Usare i metodi get*()
public function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        EmailInput::make('email')->required(),
    ];
}

public function getTableColumns(): array
{
    return [
        TextColumn::make('name')->searchable()->sortable(),
        TextColumn::make('email')->searchable(),
    ];
}

// ❌ VIETATO - Non sovrascrivere questi metodi
public function form(Form $form): Form { /* VIETATO */ }
public function table(Table $table): Table { /* VIETATO */ }
```

## 🏗️ **STRUTTURA RISORSE FILAMENT**

### Resource Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\NomeModulo\Models\User;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestione Utenti';
    protected static ?int $navigationSort = 1;
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informazioni Base')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\EmailInput::make('email')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                        
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->minLength(8)
                        ->confirmed(),
                        
                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create'),
                ])
                ->columns(2),
                
            Forms\Components\Section::make('Ruoli e Permessi')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->searchable(),
                        
                    Forms\Components\Toggle::make('is_active')
                        ->label('Utente Attivo')
                        ->default(true),
                ])
                ->columns(2),
        ];
    }
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('roles.name')
                ->badge()
                ->separator(',')
                ->searchable(),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('is_active')
                ->query(fn ($query) => $query->where('is_active', true))
                ->label('Solo Utenti Attivi'),
                
            Tables\Filters\SelectFilter::make('roles')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('activate')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn (User $record) => $record->update(['is_active' => true]))
                ->visible(fn (User $record) => !$record->is_active),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('activate')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->update(['is_active' => true])),
            ]),
        ];
    }
    
    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function getTableFiltersFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('created_from')
                ->label('Creato da'),
                
            Forms\Components\DatePicker::make('created_until')
                ->label('Creato fino a'),
        ];
    }
}
```

### Pagine Resource

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources\UserResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\NomeModulo\Filament\Resources\UserResource;

class ListUsers extends XotBaseListRecords
{
    protected static string $resource = UserResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make(),
            Actions\ExportAction::make(),
        ];
    }
}

class CreateUser extends XotBaseCreateRecord
{
    protected static string $resource = UserResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        
        return $data;
    }
}

class EditUser extends XotBaseEditRecord
{
    protected static string $resource = UserResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        return $data;
    }
}
```

## 🔗 **RELATION MANAGERS**

### Relation Manager Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'posts';
    protected static ?string $recordTitleAttribute = 'title';
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
                
            Forms\Components\Textarea::make('content')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
                
            Forms\Components\Toggle::make('is_published')
                ->label('Pubblicato')
                ->default(false),
        ];
    }
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable(),
                
            Tables\Columns\IconColumn::make('is_published')
                ->boolean()
                ->sortable(),
                
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ];
    }
    
    /**
     * @return array<string, \Filament\Tables\Filters\Filter>
     */
    public function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('is_published')
                ->query(fn (Builder $query) => $query->where('is_published', true))
                ->label('Solo Pubblicati'),
        ];
    }
}
```

## 🎯 **AZIONI PERSONALIZZATE**

### Action Custom

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Modules\NomeModulo\Models\User;

class ActivateUserAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('nomemodulo::actions.activate_user.label'))
            ->icon('heroicon-o-check-circle')
            ->color(Color::SUCCESS)
            ->requiresConfirmation()
            ->modalHeading(__('nomemodulo::actions.activate_user.modal.heading'))
            ->modalDescription(__('nomemodulo::actions.activate_user.modal.description'))
            ->modalSubmitActionLabel(__('nomemodulo::actions.activate_user.modal.confirm'))
            ->action(fn (User $record) => $this->activateUser($record))
            ->successNotificationTitle(__('nomemodulo::actions.activate_user.notifications.success'));
    }
    
    protected function activateUser(User $user): void
    {
        $user->update(['is_active' => true]);
        
        // Log dell'azione
        activity()
            ->performedOn($user)
            ->log('User activated');
    }
}
```

### Bulk Action Custom

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Actions;

use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Modules\NomeModulo\Models\User;

class BulkActivateUsersAction extends BulkAction
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('nomemodulo::actions.bulk_activate_users.label'))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading(__('nomemodulo::actions.bulk_activate_users.modal.heading'))
            ->modalDescription(__('nomemodulo::actions.bulk_activate_users.modal.description'))
            ->modalSubmitActionLabel(__('nomemodulo::actions.bulk_activate_users.modal.confirm'))
            ->action(fn (Collection $records) => $this->bulkActivateUsers($records))
            ->successNotificationTitle(__('nomemodulo::actions.bulk_activate_users.notifications.success', [
                'count' => fn (Collection $records) => $records->count()
            ]));
    }
    
    protected function bulkActivateUsers(Collection $users): void
    {
        $users->each->update(['is_active' => true]);
        
        // Log dell'azione bulk
        activity()
            ->log("Bulk activated {$users->count()} users");
    }
}
```

## 📱 **PAGINE FILAMENT**

### Pagina Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Pages;

use Filament\Pages\Page;
use Modules\Xot\Filament\Pages\XotBasePage;

class Dashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'nomemodulo::filament.pages.dashboard';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?int $navigationSort = 1;
    
    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverviewWidget::class,
            Widgets\ChartWidget::class,
        ];
    }
    
    protected function getFooterWidgets(): array
    {
        return [
            Widgets\LatestUsersWidget::class,
            Widgets\ActivityLogWidget::class,
        ];
    }
    
    protected function getViewData(): array
    {
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ];
    }
}
```

## 🎨 **WIDGET FILAMENT**

### Widget Base

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\NomeModulo\Models\User;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?bool $isLazy = true;
    protected static ?string $pollingInterval = null;
    
    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        return [
            Stat::make(
                __('nomemodulo::widgets.stats.total_users.label'),
                User::count()
            )
                ->description(__('nomemodulo::widgets.stats.total_users.description'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
                
            Stat::make(
                __('nomemodulo::widgets.stats.active_users.label'),
                User::where('is_active', true)->count()
            )
                ->description(__('nomemodulo::widgets.stats.active_users.description'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
                
            Stat::make(
                __('nomemodulo::widgets.stats.new_users_this_month.label'),
                User::whereMonth('created_at', now()->month)->count()
            )
                ->description(__('nomemodulo::widgets.stats.new_users_this_month.description'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}
```

## 🌐 **TRADUZIONI FILAMENT**

### File di Traduzione

```php
<?php

declare(strict_types=1);

// Modules/NomeModulo/lang/it/filament/resources/user-resource.php
return [
    'label' => 'Utente',
    'plural_label' => 'Utenti',
    'navigation_group' => 'Gestione Utenti',
    'navigation_icon' => 'heroicon-o-users',
    'navigation_sort' => 1,
    'description' => 'Gestione completa degli utenti del sistema',
    
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome completo',
            'help' => 'Nome e cognome dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Email utilizzata per l\'accesso al sistema',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'help' => 'Password di almeno 8 caratteri',
        ],
        'is_active' => [
            'label' => 'Utente Attivo',
            'help' => 'Determina se l\'utente può accedere al sistema',
        ],
    ],
    
    'actions' => [
        'create' => [
            'label' => 'Nuovo Utente',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo utente',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica l\'utente selezionato',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina l\'utente selezionato',
            'modal' => [
                'heading' => 'Elimina Utente',
                'description' => 'Sei sicuro di voler eliminare questo utente? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
        ],
        'activate_user' => [
            'label' => 'Attiva Utente',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'tooltip' => 'Attiva l\'utente selezionato',
            'modal' => [
                'heading' => 'Attiva Utente',
                'description' => 'Sei sicuro di voler attivare questo utente?',
                'confirm' => 'Attiva',
            ],
            'notifications' => [
                'success' => 'Utente attivato con successo',
            ],
        ],
    ],
    
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'tooltip' => 'Dati principali dell\'utente',
        ],
        'roles_permissions' => [
            'label' => 'Ruoli e Permessi',
            'tooltip' => 'Gestione ruoli e permessi utente',
        ],
    ],
    
    'messages' => [
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'activated' => 'Utente attivato con successo',
    ],
];
```

## 📋 **CHECKLIST FILAMENT**

### Prima di ogni Resource
- [ ] Estende XotBaseResource
- [ ] Nessun uso di ->label(), ->placeholder(), ->helperText()
- [ ] Traduzioni complete nei file di lingua
- [ ] Metodi get*() implementati correttamente
- [ ] Form schema completo e validato
- [ ] Table columns ottimizzate
- [ ] Filtri e azioni implementati
- [ ] Bulk actions configurate

### Per Relation Managers
- [ ] Estende XotBaseRelationManager
- [ ] Metodi get*() implementati
- [ ] Form schema per relazioni
- [ ] Table columns per relazioni
- [ ] Azioni appropriate per relazioni

### Per Azioni Custom
- [ ] Override di setUp() per configurazione
- [ ] Traduzioni complete per label e messaggi
- [ ] Gestione errori appropriata
- [ ] Log delle azioni eseguite
- [ ] Conferme per azioni distruttive

### Per Widget
- [ ] Estende widget base appropriati
- [ ] Traduzioni per statistiche e messaggi
- [ ] Performance ottimizzate (lazy loading)
- [ ] Polling configurato se necessario

---

**Ultimo aggiornamento**: Giugno 2025  
**Versione**: 2.0 (Refactor DRY + KISS)  
**File**: FILAMENT.md - Filament centralizzato
