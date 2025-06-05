# Regole Traduzioni

## Indice
- [Regole Fondamentali](#regole-fondamentali)
- [Struttura](#struttura)
- [Best Practices](#best-practices)
- [Checklist](#checklist)

## Regole Fondamentali

### Traduzioni
- **REGOLA FONDAMENTALE**: Ogni stringa deve essere tradotta
- Usare `LangServiceProvider`
- Evitare l'uso diretto di `->label()`
- Documentare le traduzioni

### Esempio Corretto
```php
// CORRETTO
class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?string $navigationLabel = __('filament.resources.doctor.navigation.label');
    
    protected static ?string $modelLabel = __('filament.resources.doctor.model.label');
    
    protected static ?string $pluralModelLabel = __('filament.resources.doctor.model.plural');
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.resources.doctor.form.name.label'))
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->label(__('filament.resources.doctor.form.email.label'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                
                Forms\Components\TextInput::make('phone')
                    ->label(__('filament.resources.doctor.form.phone.label'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.doctor.table.name.label'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.resources.doctor.table.email.label'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament.resources.doctor.table.phone.label'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.doctor.table.created_at.label'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.resources.doctor.table.updated_at.label'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}

// ERRATO
class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?string $navigationLabel = 'Doctors'; // ❌ No traduzione
    
    protected static ?string $modelLabel = 'Doctor'; // ❌ No traduzione
    
    protected static ?string $pluralModelLabel = 'Doctors'; // ❌ No traduzione
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255), // ❌ No label, no traduzione
                
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(), // ❌ No ignoreRecord
                
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255), // ❌ No label, no traduzione
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(), // ❌ No label, no traduzione
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(), // ❌ No label, no traduzione
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(), // ❌ No label, no traduzione
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // ❌ No label, no traduzione
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // ❌ No label, no traduzione
            ]);
    }
}
```

## Struttura

### Regole Fondamentali
1. **Namespace**
   - `App\Providers\LangServiceProvider`
   - `Modules\{Module}\Providers\LangServiceProvider`

2. **Nome Classe**
   - Suffisso `LangServiceProvider`
   - Nome descrittivo
   - PascalCase

3. **Metodi**
   - `boot()`: Registra traduzioni
   - `register()`: Registra provider
   - `loadTranslations()`: Carica traduzioni

### Esempi

#### Provider Base
```php
// CORRETTO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
    }
    
    public function register(): void
    {
        //
    }
    
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
    }
}

// ERRATO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ❌ No caricamento traduzioni
    }
    
    public function register(): void
    {
        //
    }
    
    protected function loadTranslations(): void
    {
        // ❌ No caricamento traduzioni
    }
}
```

#### Provider con Traduzioni
```php
// CORRETTO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
        
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament'),
        ], 'filament-translations');
    }
    
    public function register(): void
    {
        //
    }
    
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
        
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament'),
        ], 'filament-translations');
    }
}

// ERRATO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ❌ No caricamento traduzioni
        // ❌ No pubblicazione traduzioni
    }
    
    public function register(): void
    {
        //
    }
    
    protected function loadTranslations(): void
    {
        // ❌ No caricamento traduzioni
        // ❌ No pubblicazione traduzioni
    }
}
```

## Best Practices

### Regole Fondamentali
1. **Traduzioni**
   - File dedicati
   - Chiavi standard
   - Test traduzioni
   - Log errori

2. **Provider**
   - Provider dedicati
   - Caricamento ottimizzato
   - Pubblicazione
   - Cache

3. **Test**
   - Test unitari
   - Test integrazione
   - Test UI
   - Test performance

### Esempi

#### Provider Completo
```php
// CORRETTO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
        
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament'),
        ], 'filament-translations');
        
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');
        
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
    }
    
    public function register(): void
    {
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            
            $locale = $app['config']['app.locale'];
            
            $trans = new Translator($loader, $locale);
            
            $trans->setFallback($app['config']['app.fallback_locale']);
            
            return $trans;
        });
    }
    
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
        
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament'),
        ], 'filament-translations');
        
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');
        
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament');
    }
}

// ERRATO
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ❌ No caricamento traduzioni
        // ❌ No pubblicazione traduzioni
        // ❌ No caricamento JSON
    }
    
    public function register(): void
    {
        // ❌ No registrazione translator
    }
    
    protected function loadTranslations(): void
    {
        // ❌ No caricamento traduzioni
        // ❌ No pubblicazione traduzioni
        // ❌ No caricamento JSON
    }
}
```

## Checklist

### Per Ogni Traduzione
- [ ] File dedicato
- [ ] Chiavi standard
- [ ] Testata
- [ ] Loggata

### Per Provider
- [ ] Provider dedicato
- [ ] Caricamento ottimizzato
- [ ] Pubblicazione
- [ ] Cache

### Per Test
- [ ] Unitari
- [ ] Integrazione
- [ ] UI
- [ ] Performance
- [ ] Copertura
