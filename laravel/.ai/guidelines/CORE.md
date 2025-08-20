# 🎯 CORE - Regole Fondamentali PTVX

> **Contiene**: Architettura, Laravel, Database, Filament - **Principio**: DRY + KISS

## 🏗️ **ARCHITETTURA MODULARE**

### Struttura Base
```
laravel/
├── Modules/
│   ├── Xot/           # Core framework Laraxot
│   ├── User/          # Gestione utenti e autenticazione
│   ├── UI/            # Componenti UI condivisi
│   ├── Ptv/           # Modulo principale PTVX
│   └── Performance/   # Gestione performance
└── Themes/One/        # Tema frontend
```

### Regole Critiche
```php
// ✅ CORRETTO - Namespace moduli
namespace Modules\User\Models;
namespace Modules\Ptv\Filament\Resources;

// ❌ ERRATO - Namespace con 'app'
namespace Modules\User\App\Models;
```

### Estensioni Obbligatorie
```php
// ✅ CORRETTO - Service Provider
class UserServiceProvider extends XotBaseServiceProvider

// ✅ CORRETTO - Migrazioni
return new class extends XotBaseMigration

// ✅ CORRETTO - Modelli
class User extends BaseModel  // BaseModel del modulo User

// ✅ CORRETTO - Filament Resources
class UserResource extends XotBaseResource
}

## 🧰 **BASHSCRIPTS ORGANIZATION**

- All bash scripts must live inside a dedicated subfolder under `bashscripts/`.
- Do not place executable scripts at the root of `bashscripts/`.
- Use lowercase, descriptive names (kebab-case) for folders and files.
- Group by domain, e.g. `bashscripts/docs/`, `bashscripts/db/`, `bashscripts/cache/`.
- Provide `--dry-run` for scripts that mutate files and ensure idempotency.

Examples:

```
bashscripts/
├── docs/
│   └── normalize_docs_case.sh
├── db/
│   └── seed_helpers.sh
└── cache/
    └── clear_all.sh
```

Checklist:
- [ ] Script in a subfolder of `bashscripts/`
- [ ] Lowercase, descriptive name
- [ ] Dry-run option for mutating operations
- [ ] Outputs a summary/mapping of changes

## 🚀 **LARAVEL FRAMEWORK**

### Configurazione Base
```php
// ✅ CORRETTO - Strict types
declare(strict_types=1);

// ✅ CORRETTO - Service Provider
public string $name = 'User';  // Nome modulo

// ✅ CORRETTO - Configurazione
protected function register(): void
{
    parent::register();
    // Solo personalizzazioni specifiche
}
```

### Routing e Middleware
```php
// ✅ CORRETTO - Route modulari
Route::middleware(['auth', 'verified'])
    ->group(__DIR__.'/routes/web.php');

// ✅ CORRETTO - Controller con autorizzazione
public function update(Request $request, User $user): RedirectResponse
{
    $this->authorize('update', $user);
    // Logica controller
}
```

### Validazione e Requests
```php
// ✅ CORRETTO - Form Request
class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->user->id],
        ];
    }
}
```

## 🗄️ **DATABASE E MODELLI**

### Migrazioni
```php
// ✅ CORRETTO - Classe anonima
return new class extends XotBaseMigration
{
    protected string $table_name = 'users';
    
    public function up(): void
    {
        if ($this->hasTable($this->table_name)) {
            return;
        }
        
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
};
```

### Modelli
```php
// ✅ CORRETTO - Estensione BaseModel del modulo
class User extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['name', 'email'];
    
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Profile>
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
```

### Relazioni e Query
```php
// ✅ CORRETTO - Eager loading
$users = User::with(['profile', 'roles'])->get();

// ✅ CORRETTO - Query builder tipizzato
User::query()
    ->where('is_active', true)
    ->whereHas('roles', function (Builder $query): void {
        $query->where('name', 'admin');
    })
    ->get();

// ✅ CORRETTO - Verifica proprietà magiche
if (isset($user->magic_property)) {
    // Usa isset() per proprietà magiche
}

// ❌ ERRATO - Mai usare property_exists() per proprietà magiche
if (property_exists($user, 'magic_property')) {
    // property_exists() restituirà false per proprietà magiche
}
```

## 🎨 **FILAMENT UI**

### Resources
```php
// ✅ CORRETTO - Estensione XotBaseResource
class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
        ];
    }
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
        ];
    }
}
```

### Relation Managers
```php
// ✅ CORRETTO - Estensione XotBaseRelationManager
class TeamsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'teams';
    
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('role')
                ->required(),
        ];
    }
    
    /**
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
        ];
    }
}
```

### Actions
```php
// ✅ CORRETTO - Configurazione in setUp()
class ApproveAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('user::actions.approve.label'))
            ->icon('heroicon-o-check-circle')
            ->color(Color::GREEN)
            ->requiresConfirmation()
            ->action(fn (User $record): void => $this->approveUser($record));
    }
    
    protected function approveUser(User $record): void
    {
        $record->update(['status' => 'approved']);
    }
}
```

## 🔧 **SERVICE PROVIDER**

### Registrazione Moduli
```php
// ✅ CORRETTO - Estensione XotBaseServiceProvider
class UserServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'User';
    
    public function boot(): void
    {
        parent::boot();
        
        // Solo personalizzazioni specifiche
        $this->registerCustomIcons();
    }
    
    protected function registerCustomIcons(): void
    {
        FilamentIcon::register([
            'user-custom-icon' => Svg::make('custom-icon', __DIR__.'/../resources/svg/custom-icon.svg'),
        ]);
    }
}
```

### Caricamento Risorse
```php
// ✅ CORRETTO - XotBaseServiceProvider gestisce automaticamente:
// - Views: loadViewsFrom
// - Translations: loadTranslationsFrom  
// - Migrations: loadMigrationsFrom
// - Routes: loadRoutesFrom
// - Config: mergeConfigFrom
```

## 🌐 **TRADUZIONI**

### Struttura File
```php
// ✅ CORRETTO - Struttura espansa
// Modules/User/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome completo dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'email',
        'help' => 'Indirizzo email valido',
    ],
];

// ✅ CORRETTO - Azioni
// Modules/User/lang/it/actions.php
return [
    'create' => [
        'label' => 'Crea utente',
        'success' => 'Utente creato con successo',
        'error' => 'Errore nella creazione',
    ],
];
```

### Utilizzo in Filament
```php
// ✅ CORRETTO - Nessun ->label() esplicito
TextInput::make('name')  // Traduzione automatica
TextInput::make('email') // Traduzione automatica

// ❌ ERRATO - Mai usare ->label()
TextInput::make('name')->label('Nome')
```

## 📋 **CHECKLIST COMPLIANCE**

### Prima di ogni Commit
- [ ] `declare(strict_types=1);` presente
- [ ] Estende classi XotBase appropriate
- [ ] PHPDoc completo per proprietà e metodi
- [ ] Tipi di ritorno espliciti
- [ ] Nessun `->label()` hardcoded
- [ ] File traduzione strutturati correttamente

### Per Nuove Funzionalità
- [ ] Namespace corretto (`Modules\NomeModulo\...`)
- [ ] Estende classi base appropriate
- [ ] Traduzioni complete in tutte le lingue
- [ ] Service Provider estende XotBaseServiceProvider
- [ ] Migrazioni estendono XotBaseMigration

---

**🔗 Collegamenti**: [DEVELOPMENT.md](DEVELOPMENT.md) | [PATTERNS.md](PATTERNS.md) | [README.md](README.md)

## Regole Critiche per Modelli Eloquent

### ⚠️ DIVIETO ASSOLUTO: property_exists() con Modelli Eloquent

**MAI utilizzare `property_exists()` con modelli Eloquent o oggetti che implementano `__get()`/`__set()`.**

#### Motivazione
- **Proprietà dinamiche**: I modelli Eloquent creano proprietà dinamicamente quando si accede alle colonne del database
- **Lazy loading**: Le relazioni e alcune proprietà non esistono finché non vengono accesse
- **Accessors/Mutators**: Le proprietà calcolate possono non essere rilevate correttamente
- **Proprietà magiche**: Laravel usa `__get()` e `__set()` per gestire l'accesso alle proprietà
- **Comportamento imprevedibile**: Può causare bug difficili da debuggare e comportamenti inaspettati

#### ⚠️ ERRORE GRAVE IDENTIFICATO: property_exists() con Modelli Eloquent

**Utilizzare `property_exists()` con modelli Eloquent è un errore GRAVE che può causare:**
- Bug difficili da debuggare in produzione
- Comportamenti imprevedibili e inconsistenti
- Violazione dei principi fondamentali di Laravel
- Problemi di analisi statica con PHPStan
- Errori che si manifestano solo in determinate condizioni

#### Motivazione
- **Proprietà dinamiche**: I modelli Eloquent creano proprietà dinamicamente quando si accede alle colonne del database
- **Lazy loading**: Le relazioni e alcune proprietà non esistono finché non vengono accesse
- **Accessors/Mutators**: Le proprietà calcolate possono non essere rilevate correttamente
- **Proprietà magiche**: Laravel usa `__get()` e `__set()` per gestire l'accesso alle proprietà
- **Comportamento imprevedibile**: Può causare bug difficili da debuggare e comportamenti inaspettati

#### ❌ ANTI-PATTERN (DA EVITARE ASSOLUTAMENTE)
```php
// ❌ GRAVEMENTE ERRATO - MAI FARE QUESTO
if (property_exists($user, 'full_name') && $user->full_name) {
    return $user->full_name;
}

if (property_exists($model, 'email') && $model->email) {
    return $model->email;
}
```

#### ✅ PATTERN CORRETTO
```php
// ✅ CORRETTO - Usare isset per proprietà magiche
if (isset($user->full_name) && $user->full_name) {
    return $user->full_name;
}

if (isset($model->email) && $model->email) {
    return $model->email;
}

// ✅ CORRETTO - Usare null coalescing
if ($user->full_name ?? false) {
    return $user->full_name;
}

// ✅ CORRETTO - Usare hasAttribute per proprietà del database
if ($model->hasAttribute('email') && $model->email) {
    return $model->email;
}

// ✅ CORRETTO - Usare hasGetMutator per accessors
if ($model->hasGetMutator('full_name') && $model->full_name) {
    return $model->full_name;
}

// ✅ CORRETTO - Usare method_exists per metodi
if (method_exists($user, 'getFullName')) {
    return $user->getFullName();
}
```

#### Quando Usare property_exists
`property_exists()` può essere usato SOLO con:
1. **Classi standard PHP** (non modelli Eloquent)
2. **Oggetti senza metodi magici**
3. **Proprietà dichiarate esplicitamente**

#### Esempi di Correzione
**Prima (ERRATO):**
```php
if (is_object($notifiable) && property_exists($notifiable, 'full_name') && $notifiable->full_name) {
    return (string) ($notifiable->full_name ?? '');
}
```

**Dopo (CORRETTO):**
```php
if (is_object($notifiable) && isset($notifiable->full_name) && $notifiable->full_name) {
    return (string) $notifiable->full_name;
}
```

#### Checklist di Verifica
Prima di ogni suggerimento di codice, verificare:
- [ ] Nessun uso di `property_exists()` con modelli Eloquent
- [ ] Nessun uso di `property_exists()` con oggetti che implementano `__get()`/`__set()`
- [ ] Uso di `isset()` per verificare proprietà magiche
- [ ] Uso di `method_exists()` per verificare metodi
- [ ] Uso di `hasAttribute()` per proprietà database
- [ ] Uso di `hasGetMutator()` per accessors

#### Riferimenti
- [Regole Cursor](../../.cursor/rules/eloquent-properties.md)
- [Best Practices Xot](../../laravel/Modules/Xot/docs/eloquent-properties-best-practices.md)
- [Best Practices Notify](../../laravel/Modules/Notify/docs/eloquent-properties-best-practices.md)
- [Regole Windsurf](../../.windsurf/rules/model_property_rules.md)
