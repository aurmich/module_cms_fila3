# DEVELOPMENT.md - Sviluppo e Qualità PTVX

> **CENTRALIZZAZIONE SVILUPPO**: Tutte le regole per sviluppo, testing e qualità del codice in un unico file.

## 🧪 **TESTING E QUALITÀ**

### PHPStan (Livello 10 OBBLIGATORIO)

```bash
# Esecuzione da directory Laravel
cd /var/www/html/ptvx/laravel

# Analisi completa
./vendor/bin/phpstan analyze --level=10 --memory-limit=2G

# Analisi modulo specifico
./vendor/bin/phpstan analyze Modules/NomeModulo --level=10

# Analisi file specifico
./vendor/bin/phpstan analyze Modules/NomeModulo/app/Models/User.php --level=10
```

**Regole PHPStan Critiche**:
- `declare(strict_types=1);` in tutti i file PHP
- Tipi di ritorno espliciti per tutti i metodi
- Tipi di parametri espliciti per tutti i metodi
- PHPDoc completo per tutte le proprietà
- Generics per Collection: `Collection<int, User>`
- Evitare `mixed` quando possibile
- **MAI usare `property_exists()` per proprietà magiche dei modelli Laravel** - usare sempre `isset()` invece

### Pest Testing - FOCUS ON BUSINESS LOGIC

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature;

use Tests\TestCase;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Actions\CreateUserAction;

class UserManagementTest extends TestCase
{
    /** @test */
    public function it_can_create_user_with_valid_data(): void
    {
        // Arrange - Focus on business data
        $userData = new UserData(
            name: 'John Doe',
            email: 'john@example.com'
        );
        
        // Act - Business logic execution
        $user = app(CreateUserAction::class)->execute($userData);
        
        // Assert - Verify business outcomes, not implementation details
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        
        // Verify data exists through business behavior, not direct DB checks
        $this->assertTrue(User::where('email', 'john@example.com')->exists());
    }
    
    /** @test */
    public function it_validates_required_fields(): void
    {
        // Arrange
        $userData = new UserData(
            name: '',  // Nome vuoto
            email: 'invalid-email'  // Email non valida
        );
        
        // Act & Assert
        $this->expectException(\InvalidArgumentException::class);
        app(CreateUserAction::class)->execute($userData);
    }
}
```

### Test Filament

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature\Filament;

use Livewire\Livewire;
use Modules\NomeModulo\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\NomeModulo\Filament\Resources\UserResource\Pages\ListUsers;
use Tests\TestCase;
use Modules\NomeModulo\Models\User;

class UserResourceTest extends TestCase
{
    /** @test */
    public function it_can_list_users(): void
    {
        $this->actingAs($this->user);
        
        $users = User::factory()->count(3)->create();
        
        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }
    
    /** @test */
    public function it_can_create_user(): void
    {
        $this->actingAs($this->user);
        
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
            ])
            ->call('create')
            ->assertNotified();
        
        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }
}
```

### Test Livewire

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Tests\Feature\Livewire;

use Livewire\Livewire;
use Modules\NomeModulo\Http\Livewire\UserForm;
use Tests\TestCase;
use Modules\NomeModulo\Models\User;

class UserFormTest extends TestCase
{
    /** @test */
    public function it_can_submit_user_form(): void
    {
        $this->actingAs($this->user);
        
        Livewire::test(UserForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSee('User created successfully');
    }
    
    /** @test */
    public function it_validates_required_fields(): void
    {
        $this->actingAs($this->user);
        
        Livewire::test(UserForm::class)
            ->set('name', '')
            ->set('email', '')
            ->call('submit')
            ->assertHasErrors(['name', 'email']);
    }
}
```

## 🔍 **CODE QUALITY**

### PSR-12 Compliance

```bash
# Verifica formattazione
./vendor/bin/pint --test

# Correzione automatica
./vendor/bin/pint --dirty
```

**Regole PSR-12 Critiche**:
- Spaziature corrette attorno agli operatori
- Parentesi graffe sempre per strutture di controllo
- Indentazione con 4 spazi
- Spazio dopo virgole in array
- Spazio dopo `use` statements

### PHPDoc Standards

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User model for authentication and user management.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\NomeModulo\Models\Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\NomeModulo\Models\Role> $roles
 */
class User extends Model
{
    /** @var list<string> */
    protected $fillable = ['name', 'email', 'password'];
    
    /** @var list<string> */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Get posts for this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\NomeModulo\Models\Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Get roles for this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\Modules\NomeModulo\Models\Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
```

### Type Safety

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Support\Collection;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Data\UserData;

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
     * Get users by role.
     *
     * @param string $roleName
     * @return \Illuminate\Support\Collection<int, \Modules\NomeModulo\Models\User>
     */
    public function getUsersByRole(string $roleName): Collection
    {
        return $this->userRepository->findByRole($roleName);
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
}
```

## 🚀 **PERFORMANCE E OTTIMIZZAZIONE**

### Database Optimization

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    /**
     * Scope for active users with eager loading.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
                    ->with(['profile', 'roles', 'permissions']);
    }
    
    /**
     * Scope for users with specific role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roleName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRole(Builder $query, string $roleName): Builder
    {
        return $query->whereHas('roles', function (Builder $query) use ($roleName) {
            $query->where('name', $roleName);
        });
    }
    
    /**
     * Get users with optimized queries.
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return static::query()
            ->active()
            ->withRole('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
```

### Cache Strategy

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Support\Facades\Cache;
use Modules\NomeModulo\Models\User;

class UserCacheService
{
    private const CACHE_TTL = 3600; // 1 ora
    private const CACHE_PREFIX = 'users';
    
    /**
     * Get user by ID with caching.
     *
     * @param int $id
     * @return \Modules\NomeModulo\Models\User|null
     */
    public function getUserById(int $id): ?User
    {
        $cacheKey = $this->getCacheKey('user', $id);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return User::with(['profile', 'roles'])->find($id);
        });
    }
    
    /**
     * Get users by role with caching.
     *
     * @param string $role
     * @return \Illuminate\Support\Collection<int, \Modules\NomeModulo\Models\User>
     */
    public function getUsersByRole(string $role): Collection
    {
        $cacheKey = $this->getCacheKey('role', $role);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($role) {
            return User::whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            })->with(['profile'])->get();
        });
    }
    
    /**
     * Clear user cache.
     *
     * @param int $userId
     * @return void
     */
    public function clearUserCache(int $userId): void
    {
        Cache::forget($this->getCacheKey('user', $userId));
        Cache::forget($this->getCacheKey('role', 'all'));
    }
    
    /**
     * Generate cache key.
     *
     * @param string $type
     * @param mixed $identifier
     * @return string
     */
    private function getCacheKey(string $type, mixed $identifier): string
    {
        return self::CACHE_PREFIX . ":{$type}:{$identifier}";
    }
}
```

### Queue Management

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\NomeModulo\Models\User;
use Modules\NomeModulo\Services\EmailService;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public int $tries = 3;
    public int $timeout = 300;
    
    public function __construct(
        private readonly array $userIds,
        private readonly string $subject,
        private readonly string $message
    ) {}
    
    public function handle(EmailService $emailService): void
    {
        $users = User::whereIn('id', $this->userIds)->chunk(100, function ($chunk) use ($emailService) {
            foreach ($chunk as $user) {
                $emailService->sendEmail($user, $this->subject, $this->message);
            }
        });
    }
    
    public function tags(): array
    {
        return ['bulk-email', 'users'];
    }
    
    public function failed(\Throwable $exception): void
    {
        \Log::error('Bulk email job failed', [
            'user_ids' => $this->userIds,
            'error' => $exception->getMessage(),
        ]);
    }
}
```

## 🔒 **SICUREZZA**

### Validation Rules

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }
    
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;
        
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'role_id' => ['sometimes', 'exists:roles,id'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
    
    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('nomemodulo::validation.name.required'),
            'email.required' => __('nomemodulo::validation.email.required'),
            'email.email' => __('nomemodulo::validation.email.email'),
            'email.unique' => __('nomemodulo::validation.email.unique'),
            'role_id.exists' => __('nomemodulo::validation.role_id.exists'),
        ];
    }
}
```

### Authorization Policies

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

## 📋 **CHECKLIST SVILUPPO**

### Prima di ogni Commit
- [ ] Codice passa PHPStan livello 10
- [ ] Tutti i test passano
- [ ] Formattazione PSR-12 corretta
- [ ] PHPDoc completo e aggiornato
- [ ] Tipizzazione rigorosa implementata
- [ ] Gestione errori appropriata
- [ ] Sicurezza e validazione implementate
- [ ] **Boy Scout Rule applicata** - Codice migliore di come è stato trovato

### Per Nuove Funzionalità
- [ ] Test unitari scritti
- [ ] Test di integrazione implementati
- [ ] Performance ottimizzata
- [ ] Cache strategy implementata
- [ ] Queue per operazioni pesanti
- [ ] Logging appropriato
- [ ] Documentazione aggiornata

### Per Bug Fix
- [ ] Test di regressione scritti
- [ ] Causa radice identificata
- [ ] Soluzione implementata
- [ ] Test passano
- [ ] Performance non degradata
- [ ] Sicurezza mantenuta

## 🧰 Organizzazione bashscripts

- Tutti gli script bash DEVONO stare in sottocartelle di `bashscripts/` (es. `bashscripts/docs/`).
- Nessuno script eseguibile alla radice di `bashscripts/`.
- Naming in minuscolo e descrittivo (kebab-case).
- Fornire sempre `--dry-run` per operazioni che mutano file e garantire idempotenza.

Checklist:
- [ ] Script in sottocartella `bashscripts/<domain>/`
- [ ] Nome file in minuscolo e descrittivo
- [ ] Opzione `--dry-run` presente se muta file
- [ ] Output riassuntivo/mapping delle modifiche

---

**Ultimo aggiornamento**: Giugno 2025  
**Versione**: 2.0 (Refactor DRY + KISS)  
**File**: DEVELOPMENT.md - Sviluppo e qualità centralizzati
