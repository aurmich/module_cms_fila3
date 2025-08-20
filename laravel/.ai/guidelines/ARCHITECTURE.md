# ARCHITECTURE.md - Architettura PTVX

> **CENTRALIZZAZIONE ARCHITETTURA**: Tutte le regole architetturali e di struttura in un unico file per massima coerenza e zero duplicazioni.

## 🏗️ **STRUTTURA PROGETTO**

### Directory Structure

```
/var/www/html/_bases/base_ptvx_fila3_mono/
├── laravel/                          # Root Laravel
│   ├── Modules/                      # Moduli Laravel
│   │   ├── Xot/                     # Modulo base Xot
│   │   │   ├── app/                 # Applicazione Xot
│   │   │   ├── config/              # Configurazione Xot
│   │   │   ├── database/            # Database Xot
│   │   │   ├── docs/                # Documentazione Xot
│   │   │   ├── resources/           # Risorse Xot
│   │   │   └── routes/              # Route Xot
│   │   ├── User/                    # Modulo User
│   │   ├── Performance/             # Modulo Performance
│   │   └── [AltriModuli]/           # Altri moduli
│   ├── Themes/                       # Temi
│   │   └── One/                     # Tema One
│   ├── config/                       # Configurazione Laravel
│   ├── database/                     # Database Laravel
│   ├── resources/                    # Risorse Laravel
│   └── routes/                       # Route Laravel
├── docs/                             # Documentazione root
└── .ai/                              # Linee guida AI
    └── guidelines/                   # Linee guida specifiche
```

### Namespace Structure

```php
// ✅ CORRETTO - Namespace modulare
namespace Modules\NomeModulo\Models;
namespace Modules\NomeModulo\Http\Controllers;
namespace Modules\NomeModulo\Filament\Resources;
namespace Modules\NomeModulo\Actions;
namespace Modules\NomeModulo\Data;

// ❌ ERRATO - Namespace con segmento 'app'
namespace Modules\NomeModulo\App\Models;
namespace Modules\NomeModulo\App\Http\Controllers;
```

## 🔧 **MODULI LARAVEL**

### Struttura Modulo

```
Modules/NomeModulo/
├── app/                              # Applicazione del modulo
│   ├── Actions/                      # Azioni (Spatie QueableActions)
│   ├── Data/                         # Data Objects (Spatie Laravel Data)
│   ├── Exceptions/                   # Eccezioni personalizzate
│   ├── Filament/                     # Componenti Filament
│   │   ├── Actions/                  # Azioni Filament
│   │   ├── Pages/                    # Pagine Filament
│   │   ├── Resources/                # Risorse Filament
│   │   └── Widgets/                  # Widget Filament
│   ├── Http/                         # HTTP Layer
│   │   ├── Controllers/              # Controller
│   │   ├── Livewire/                 # Componenti Livewire
│   │   ├── Middleware/               # Middleware
│   │   ├── Requests/                 # Form Requests
│   │   └── Resources/                # API Resources
│   ├── Models/                       # Modelli Eloquent
│   ├── Notifications/                # Notifiche
│   ├── Observers/                    # Model Observers
│   ├── Policies/                     # Authorization Policies
│   ├── Providers/                    # Service Providers
│   ├── Repositories/                 # Repository Pattern
│   ├── Services/                     # Servizi (se necessario)
│   └── Traits/                       # Traits riutilizzabili
├── config/                           # Configurazione modulo
├── database/                         # Database modulo
│   ├── factories/                    # Factory per testing
│   ├── migrations/                   # Migrazioni
│   └── seeders/                      # Seeder
├── docs/                             # Documentazione modulo
├── resources/                        # Risorse modulo
│   ├── lang/                         # File di traduzione
│   ├── views/                        # View Blade
│   └── assets/                       # Asset (CSS, JS, immagini)
└── routes/                           # Route modulo
```

### Service Provider Modulo

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Service provider for the NomeModulo module.
 * Extends XotBaseServiceProvider to inherit common functionality.
 */
class NomeModuloServiceProvider extends XotBaseServiceProvider
{
    /**
     * The module namespace.
     *
     * @var string
     */
    protected string $module_name = 'NomeModulo';

    /**
     * Boot the application events.
     * XotBaseServiceProvider already handles:
     * - Loading views, translations, factories, and migrations
     * - Setting up route model bindings
     * - Registering public assets
     * - Auto-discovering module components
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        
        // ONLY add module-specific customizations here
        // Do NOT duplicate functionality already provided by XotBaseServiceProvider
    }

    /**
     * Register the service provider.
     * XotBaseServiceProvider already handles:
     * - Repository bindings
     * - Config merging
     * - Service registration
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();
        
        // ONLY register module-specific services not handled by XotBaseServiceProvider
    }
}
```

## 🗄️ **DATABASE E MIGRAZIONI**

### Migrazioni Base

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     */
    protected string $table_name = 'users';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // Controllo se la tabella esiste già
        if ($this->hasTable($this->table_name)) {
            return;
        }

        // Creazione tabella
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Aggiunta commento alla tabella
        $this->tableComment($this->table_name, 'Tabella utenti del sistema');
    }
};
```

### Aggiornamento Tabelle Esistenti

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected string $table_name = 'users';

    public function up(): void
    {
        // 1. Prima crea la tabella se non esiste (codice originale)
        if (! $this->hasTable($this->table_name)) {
            Schema::create($this->table_name, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->boolean('is_active')->default(true);
                // Nuova colonna aggiunta qui
                $table->string('phone')->nullable();
                $table->timestamps();
            });
            
            $this->tableComment($this->table_name, 'Tabella utenti del sistema');
            return;
        }
        
        // 2. Se la tabella esiste, aggiungi solo la nuova colonna
        if (! $this->hasColumn($this->table_name, 'phone')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string('phone')->nullable()->after('is_active');
            });
        }
    }
};
```

## 🎯 **PATTERN ARCHITETTURALI**

### Repository Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\NomeModulo\Models\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function findByRole(string $roleName): Collection;
}

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {}

    public function findById(int $id): ?User
    {
        return $this->model->with(['roles', 'permissions'])->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['roles', 'permissions'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findByRole(string $roleName): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        })->with(['roles', 'permissions'])->get();
    }
}
```

### Service Layer

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Support\Collection;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Repositories\UserRepositoryInterface;
use Modules\NomeModulo\Exceptions\UserNotFoundException;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Create a new user.
     *
     * @param \Modules\NomeModulo\Data\UserData $userData
     * @return \Modules\NomeModulo\Models\User
     * @throws \Modules\NomeModulo\Exceptions\UserCreationException
     */
    public function createUser(UserData $userData): User
    {
        try {
            return $this->userRepository->create($userData->toArray());
        } catch (\Exception $e) {
            throw new UserCreationException(
                "Failed to create user: {$e->getMessage()}",
                previous: $e
            );
        }
    }

    /**
     * Update user profile.
     *
     * @param int $userId
     * @param \Modules\NomeModulo\Data\ProfileData $profileData
     * @return \Modules\NomeModulo\Models\User
     * @throws \Modules\NomeModulo\Exceptions\UserNotFoundException
     */
    public function updateUserProfile(int $userId, ProfileData $profileData): User
    {
        $user = $this->userRepository->findById($userId);
        
        if (!$user) {
            throw new UserNotFoundException("User {$userId} not found");
        }
        
        return $this->userRepository->update($user, $profileData->toArray());
    }

    /**
     * Get users by role.
     *
     * @param string $roleName
     * @return \Illuminate\Support\Collection<int, \Modules\NomeModulo\Models\User>
     */
    public function getUsersByRole(string $roleName): Collection
    {
        return $this->userRepository->findByRole($roleName);
    }
}
```

### Data Transfer Objects

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Confirmed;

class UserData extends Data
{
    public function __construct(
        #[Required, Min(2)]
        public readonly string $name,
        
        #[Required, Email]
        public readonly string $email,
        
        #[Required, Min(8), Confirmed]
        public readonly string $password,
        
        public readonly ?string $phone = null,
        
        public readonly bool $is_active = true,
        
        public readonly ?int $id = null,
    ) {
    }
    
    /**
     * Crea un nuovo UserData da un modello User.
     *
     * @param \Modules\NomeModulo\Models\User $user
     * @return self
     */
    public static function fromModel(\Modules\NomeModulo\Models\User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
            password: '', // Password non inclusa per sicurezza
            phone: $user->phone,
            is_active: $user->is_active,
            id: $user->id,
        );
    }
    
    /**
     * Crea un'istanza del modello User da questo Data Object.
     *
     * @return \Modules\NomeModulo\Models\User
     */
    public function toModel(): \Modules\NomeModulo\Models\User
    {
        $user = $this->id
            ? \Modules\NomeModulo\Models\User::findOrFail($this->id)
            : new \Modules\NomeModulo\Models\User();
            
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->is_active = $this->is_active;
        
        return $user;
    }
}
```

### Actions (Spatie QueableActions)

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Services\UserService;

class CreateUserAction implements ShouldQueue
{
    use QueueableAction;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    
    public int $tries = 3;
    public int $timeout = 300;
    
    public function __construct(
        private readonly UserService $userService
    ) {}
    
    /**
     * Esegue l'azione.
     *
     * @param \Modules\NomeModulo\Data\UserData $userData
     * @return \Modules\NomeModulo\Models\User
     */
    public function execute(UserData $userData): User
    {
        return $this->userService->createUser($userData);
    }
    
    public function tags(): array
    {
        return ['user-creation', 'users'];
    }
    
    public function failed(\Throwable $exception): void
    {
        \Log::error('User creation action failed', [
            'user_data' => $userData->toArray(),
            'error' => $exception->getMessage(),
        ]);
    }
}
```

## 🔐 **AUTENTICAZIONE E AUTORIZZAZIONE**

### Policies

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any posts.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view posts');
    }
    
    /**
     * Determine whether the user can view the post.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('view posts') || $user->id === $post->user_id;
    }
    
    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posts');
    }
    
    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('edit posts') || $user->id === $post->user_id;
    }
    
    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('delete posts') || $user->id === $post->user_id;
    }
}
```

### Middleware

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param string $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!$request->user() || !$request->user()->hasPermissionTo($permission)) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
```

## 🌐 **API E ROUTING**

### API Resources

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
```

### Route Groups

```php
<?php

declare(strict_types=1);

// routes/web.php del modulo
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});

// routes/api.php del modulo
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('v1')->name('api.v1.')->group(function () {
        Route::apiResource('users', UserApiController::class);
        Route::apiResource('roles', RoleApiController::class);
    });
});
```

## 📋 **CHECKLIST ARCHITETTURA**

### Per Nuovi Moduli
- [ ] Struttura directory corretta
- [ ] Namespace senza segmento 'app'
- [ ] Service Provider che estende XotBaseServiceProvider
- [ ] Modelli che estendono BaseModel del modulo
- [ ] Repository pattern implementato
- [ ] Data Objects per DTO
- [ ] Actions per logica di business
- [ ] Policies per autorizzazione
- [ ] Traduzioni complete
- [ ] Documentazione aggiornata

### Per Nuove Funzionalità
- [ ] Repository interface e implementazione
- [ ] Service layer per logica di business
- [ ] Data Objects per input/output
- [ ] Actions per operazioni complesse
- [ ] Policies per autorizzazione
- [ ] Test unitari e di integrazione
- [ ] Documentazione aggiornata

### Per Migrazioni
- [ ] Estende XotBaseMigration
- [ ] Classe anonima utilizzata
- [ ] Controlli di esistenza implementati
- [ ] Metodo down() NON implementato
- [ ] Commenti tabella/colonna aggiunti
- [ ] Documentazione aggiornata

---

**Ultimo aggiornamento**: Giugno 2025  
**Versione**: 2.0 (Refactor DRY + KISS)  
**File**: ARCHITECTURE.md - Architettura centralizzata
