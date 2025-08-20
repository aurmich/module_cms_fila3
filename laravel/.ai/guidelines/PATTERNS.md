# PATTERNS.md - Pattern Architetturali PTVX

> **CENTRALIZZAZIONE PATTERN**: Tutti i pattern architetturali in un unico file per massima riusabilità e coerenza.

## 🏗️ **PATTERN ARCHITETTURALI**

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
    public function findByRole(string $role): Collection;
}

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {}
    
    public function findById(int $id): ?User
    {
        return $this->model->find($id);
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
        return $this->model->with(['profile', 'roles'])->paginate($perPage);
    }
    
    public function findByRole(string $role): Collection
    {
        return $this->model->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }
}
```

### Service Layer Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Services;

use Illuminate\Events\Dispatcher;
use Modules\NomeModulo\Repositories\UserRepositoryInterface;
use Modules\NomeModulo\Data\UserData;
use Modules\NomeModulo\Events\UserCreatedEvent;
use Modules\NomeModulo\Exceptions\UserNotFoundException;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleService $roleService,
        private readonly Dispatcher $dispatcher
    ) {}
    
    public function createUserWithRole(UserData $userData, string $roleName): User
    {
        // Verifica ruolo esistente
        $role = $this->roleService->findByName($roleName);
        if (!$role) {
            throw new RoleNotFoundException("Role {$roleName} not found");
        }
        
        // Creazione utente
        $user = $this->userRepository->create($userData->toArray());
        
        // Assegnazione ruolo
        $user->roles()->attach($role->id);
        
        // Dispatch evento
        $this->dispatcher->dispatch(new UserCreatedEvent($user));
        
        return $user;
    }
    
    public function updateUserProfile(int $userId, ProfileData $profileData): User
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new UserNotFoundException("User {$userId} not found");
        }
        
        // Aggiornamento profilo
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData->toArray()
        );
        
        return $user->load('profile');
    }
}
```

### Action Pattern (Spatie QueueableActions)

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
use Modules\NomeModulo\Repositories\UserRepositoryInterface;
use Modules\NomeModulo\Notifications\UserCreatedNotification;

class CreateUserAction implements ShouldQueue
{
    use QueueableAction;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    
    public function execute(UserData $userData, bool $sendNotification = true): User
    {
        // Elabora i dati dell'utente
        $user = $this->userRepository->create($userData->toArray());
        
        // Notifica il completamento se richiesto
        if ($sendNotification) {
            $user->notify(new UserCreatedNotification($user));
        }
        
        return $user;
    }
}
```

### Data Transfer Object Pattern (Spatie Laravel Data)

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class UserData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $name,
        
        #[Required, Email]
        public readonly string $email,
        
        #[WithCast(DateTimeInterfaceCast::class)]
        public readonly ?\DateTimeInterface $created_at = null,
        
        #[WithCast(DateTimeInterfaceCast::class)]
        public readonly ?\DateTimeInterface $updated_at = null,
        
        public readonly ?int $id = null,
    ) {
    }
    
    /**
     * Crea un nuovo UserData da un modello User.
     */
    public static function fromModel(\Modules\NomeModulo\Models\User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
            id: $user->id,
        );
    }
    
    /**
     * Crea un'istanza del modello User da questo Data Object.
     */
    public function toModel(): \Modules\NomeModulo\Models\User
    {
        $user = $this->id
            ? \Modules\NomeModulo\Models\User::findOrFail($this->id)
            : new \Modules\NomeModulo\Models\User();
            
        $user->name = $this->name;
        $user->email = $this->email;
        
        return $user;
    }
}
```

## 🎨 **FILAMENT PATTERN**

### Custom Action Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Actions;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;
use Filament\Forms;
use Modules\NomeModulo\Actions\ApproveUserAction;

class ApproveUserAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->label(__('nomemodulo::actions.approve.label'))
            ->icon('heroicon-o-check-circle')
            ->color(Color::GREEN)
            ->requiresConfirmation()
            ->modalHeading(__('nomemodulo::actions.approve.modal.heading'))
            ->modalDescription(__('nomemodulo::actions.approve.modal.description'))
            ->modalSubmitActionLabel(__('nomemodulo::actions.approve.modal.confirm'))
            ->form([
                Forms\Components\Textarea::make('note')
                    ->label(__('nomemodulo::actions.approve.fields.note.label'))
                    ->placeholder(__('nomemodulo::actions.approve.fields.note.placeholder'))
                    ->rows(3),
            ])
            ->action(function (array $data, $record): void {
                app(ApproveUserAction::class)->execute($record, $data['note'] ?? null);
            })
            ->successNotificationTitle(__('nomemodulo::actions.approve.notifications.success'));
    }
}
```

### Custom Widget Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Widgets;

use Modules\UI\Filament\Widgets\BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\NomeModulo\Models\User;

class UserStatsWidget extends BaseWidget
{
    protected static ?bool $isLazy = true;
    protected static ?string $pollingInterval = null;
    
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
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make(
                __('nomemodulo::widgets.stats.new_users.label'),
                fn (): string => number_format(
                    (User::where('created_at', '>=', now()->subWeek())->count() / User::count()) * 100
                ) . '%'
            )
                ->description(__('nomemodulo::widgets.stats.new_users.description'))
                ->color('warning'),
        ];
    }
}
```

### Custom Page Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Modules\NomeModulo\Models\User;

class UserDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static string $view = 'nomemodulo::filament.pages.user-dashboard';
    protected static ?string $title = null;
    
    protected function getTitle(): string
    {
        return __('nomemodulo::pages.user_dashboard.title');
    }
    
    protected function getViewData(): array
    {
        return [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'recentUsers' => User::latest()->limit(5)->get(),
        ];
    }
    
    public function render(): View
    {
        return view(
            static::$view,
            $this->getViewData()
        );
    }
}
```

## 🔄 **LARAVEL PATTERN**

### Event Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\NomeModulo\Models\User;

class UserCreatedEvent
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public readonly User $user
    ) {}
}

class UserUpdatedEvent
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public readonly User $user,
        public readonly array $changes
    ) {}
}
```

### Listener Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NomeModulo\Events\UserCreatedEvent;
use Modules\NomeModulo\Notifications\WelcomeNotification;

class SendWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;
    
    public function handle(UserCreatedEvent $event): void
    {
        $event->user->notify(new WelcomeNotification($event->user));
    }
}
```

### Notification Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\NomeModulo\Models\User;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function __construct(
        private readonly User $user
    ) {}
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('nomemodulo::notifications.welcome.subject'))
            ->greeting(__('nomemodulo::notifications.welcome.greeting', ['name' => $this->user->name]))
            ->line(__('nomemodulo::notifications.welcome.message'))
            ->action(__('nomemodulo::notifications.welcome.action'), route('dashboard'));
    }
    
    public function toArray($notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => __('nomemodulo::notifications.welcome.database_message'),
        ];
    }
}
```

### Policy Pattern

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
    
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view posts');
    }
    
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('view posts') || $user->id === $post->user_id;
    }
    
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posts');
    }
    
    public function update(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('edit posts') || $user->id === $post->user_id;
    }
    
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('delete posts') || $user->id === $post->user_id;
    }
}
```

## 🔧 **UTILITY PATTERN**

### Cache Pattern

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
    
    public function getUserById(int $id): ?User
    {
        $cacheKey = $this->getCacheKey('user', $id);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return User::find($id);
        });
    }
    
    public function getUsersByRole(string $role): Collection
    {
        $cacheKey = $this->getCacheKey('role', $role);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($role) {
            return User::whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            })->get();
        });
    }
    
    public function clearUserCache(int $userId): void
    {
        Cache::forget($this->getCacheKey('user', $userId));
        Cache::forget($this->getCacheKey('role', 'all'));
    }
    
    private function getCacheKey(string $type, mixed $identifier): string
    {
        return self::CACHE_PREFIX . ":{$type}:{$identifier}";
    }
}
```

### Queue Pattern

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
    
    public function __construct(
        private readonly array $userIds,
        private readonly string $subject,
        private readonly string $message
    ) {}
    
    public function handle(EmailService $emailService): void
    {
        $users = User::whereIn('id', $this->userIds)->get();
        
        foreach ($users as $user) {
            $emailService->sendEmail($user, $this->subject, $this->message);
        }
    }
    
    public function tags(): array
    {
        return ['bulk-email', 'users'];
    }
}
```

## 📋 **CHECKLIST PATTERN**

### Repository Pattern
- [ ] Interface definita con metodi chiari
- [ ] Implementazione con tipizzazione rigorosa
- [ ] Metodi per operazioni CRUD base
- [ ] Metodi per query complesse
- [ ] Eager loading per relazioni

### Service Pattern
- [ ] Logica di business centralizzata
- [ ] Dependency injection per repository
- [ ] Gestione eventi e notifiche
- [ ] Validazione e gestione errori
- [ ] Transazioni database quando necessario

### Action Pattern
- [ ] Estende Spatie QueueableAction
- [ ] Metodo execute con tipizzazione
- [ ] Gestione errori appropriata
- [ ] Notifiche quando necessario
- [ ] Possibilità di accodamento

### Data Pattern
- [ ] Estende Spatie Laravel Data
- [ ] Attributi di validazione appropriati
- [ ] Metodi fromModel e toModel
- [ ] Tipizzazione rigorosa
- [ ] Immutabilità garantita

### Filament Pattern
- [ ] Estende classi base Xot
- [ ] Metodi get*Schema implementati
- [ ] Traduzioni tramite file (no ->label())
- [ ] Azioni personalizzate in setUp()
- [ ] Testing appropriato

---

**Ultimo aggiornamento**: Giugno 2025  
**Versione**: 2.0 (Refactor DRY + KISS)  
**File**: PATTERNS.md - Pattern architetturali centralizzati
