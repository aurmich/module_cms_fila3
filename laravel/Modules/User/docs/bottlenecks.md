# Colli di Bottiglia e Soluzioni - Modulo User

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo User e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Autenticazione Inefficiente

### Problema
Il modulo User utilizza un processo di autenticazione non ottimizzato, con troppi controlli e query al database durante ogni richiesta autenticata.

### Impatto
- Aumento del tempo di risposta per ogni richiesta autenticata
- Carico eccessivo sul database
- Scalabilità limitata con l'aumento degli utenti

### Soluzione Passo-Passo

1. **Implementare Cache delle Sessioni su Database**

```php
// In .env
SESSION_DRIVER=database
CACHE_STORE=database
```

2. **Ottimizzare la Tabella delle Sessioni**

```php
// Crea una migrazione per ottimizzare la tabella sessions
php artisan make:migration optimize_sessions_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Aggiungi indici per migliorare le performance
            $table->index(['user_id', 'last_activity']);
        });
    }
    
    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'last_activity']);
        });
    }
}
```

3. **Implementare Caching dei Dati Utente**

```php
// In Modules\User\Services\UserService.php
namespace Modules\User\Services;

use Illuminate\Support\Facades\Cache;
use Modules\User\Models\User;

class UserService
{
    public function findById($id)
    {
        return Cache::remember("user_{$id}", 3600, function () use ($id) {
            return User::find($id);
        });
    }
    
    public function invalidateCache($user)
    {
        Cache::forget("user_{$user->id}");
    }
}
```

4. **Creare un Observer per Invalidare la Cache**

```php
// In Modules\User\Observers\UserObserver.php
namespace Modules\User\Observers;

use Modules\User\Models\User;
use Modules\User\Services\UserService;

class UserObserver
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function saved(User $user)
    {
        $this->userService->invalidateCache($user);
    }
    
    public function deleted(User $user)
    {
        $this->userService->invalidateCache($user);
    }
}
```

5. **Registrare l'Observer**

```php
// In UserServiceProvider.php
use Modules\User\Models\User;
use Modules\User\Observers\UserObserver;

public function boot()
{
    // ...
    User::observe(UserObserver::class);
}
```

6. **Ottimizzare il Middleware di Autenticazione**

```php
// In Modules\User\Http\Middleware\OptimizedAuthenticate.php
namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Modules\User\Services\UserService;

class OptimizedAuthenticate extends BaseAuthenticate
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        
        // Se l'utente è autenticato, utilizza la versione cached
        if ($request->user()) {
            $cachedUser = $this->userService->findById($request->user()->id);
            $request->setUserResolver(function () use ($cachedUser) {
                return $cachedUser;
            });
        }
        
        return $next($request);
    }
}
```

7. **Sostituire il Middleware di Autenticazione**

```php
// In app/Http/Kernel.php
protected $routeMiddleware = [
    // Sostituisci il middleware auth standard
    'auth' => \Modules\User\Http\Middleware\OptimizedAuthenticate::class,
    // ...
];
```

## 2. Gestione Inefficiente dei Permessi

### Problema
Il modulo User verifica i permessi degli utenti con query multiple per ogni controllo di autorizzazione, causando un overhead significativo.

### Impatto
- Rallentamento delle operazioni che richiedono controlli di autorizzazione
- Carico eccessivo sul database
- Scalabilità limitata con l'aumento dei ruoli e permessi

### Soluzione Passo-Passo

1. **Implementare Cache dei Permessi**

```php
// In Modules\User\Services\PermissionService.php
namespace Modules\User\Services;

use Illuminate\Support\Facades\Cache;
use Modules\User\Models\User;

class PermissionService
{
    public function getUserPermissions(User $user)
    {
        return Cache::remember("user_permissions_{$user->id}", 3600, function () use ($user) {
            return $user->getAllPermissions()->pluck('name')->toArray();
        });
    }
    
    public function hasPermission(User $user, $permission)
    {
        $permissions = $this->getUserPermissions($user);
        return in_array($permission, $permissions);
    }
    
    public function invalidatePermissionsCache(User $user)
    {
        Cache::forget("user_permissions_{$user->id}");
    }
}
```

2. **Estendere il Modello User**

```php
// In Modules\User\Models\User.php
use Modules\User\Services\PermissionService;

class User extends Authenticatable
{
    // ...
    
    public function hasPermissionCached($permission)
    {
        return app(PermissionService::class)->hasPermission($this, $permission);
    }
}
```

3. **Creare Observer per Ruoli e Permessi**

```php
// In Modules\User\Observers\RoleObserver.php
namespace Modules\User\Observers;

use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Services\PermissionService;

class RoleObserver
{
    protected $permissionService;
    
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    
    public function saved(Role $role)
    {
        // Invalida la cache per tutti gli utenti con questo ruolo
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('id', $role->id);
        })->get();
        
        foreach ($users as $user) {
            $this->permissionService->invalidatePermissionsCache($user);
        }
    }
}
```

4. **Registrare gli Observer**

```php
// In UserServiceProvider.php
use Modules\User\Models\Role;
use Modules\User\Models\Permission;
use Modules\User\Observers\RoleObserver;
use Modules\User\Observers\PermissionObserver;

public function boot()
{
    // ...
    Role::observe(RoleObserver::class);
    Permission::observe(PermissionObserver::class);
}
```

5. **Ottimizzare il Middleware di Autorizzazione**

```php
// In Modules\User\Http\Middleware\OptimizedAuthorize.php
namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\User\Services\PermissionService;

class OptimizedAuthorize
{
    protected $permissionService;
    
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    
    public function handle($request, Closure $next, $permission)
    {
        if (!$request->user() || !$this->permissionService->hasPermission($request->user(), $permission)) {
            throw new AuthorizationException('This action is unauthorized.');
        }
        
        return $next($request);
    }
}
```

6. **Registrare il Middleware**

```php
// In app/Http/Kernel.php
protected $routeMiddleware = [
    // ...
    'permission' => \Modules\User\Http\Middleware\OptimizedAuthorize::class,
];
```

7. **Implementare Precaricamento dei Permessi**

```php
// In Modules\User\Http\Middleware\PreloadPermissions.php
namespace Modules\User\Http\Middleware;

use Closure;
use Modules\User\Services\PermissionService;

class PreloadPermissions
{
    protected $permissionService;
    
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    
    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            // Precarica i permessi dell'utente
            $this->permissionService->getUserPermissions($request->user());
        }
        
        return $next($request);
    }
}
```

## 3. Gestione Inefficiente dei Team

### Problema
Il modulo User esegue query inefficienti per recuperare i team degli utenti e i membri dei team, causando problemi di performance con team numerosi.

### Impatto
- Rallentamento delle operazioni relative ai team
- Carico eccessivo sul database
- Scalabilità limitata con l'aumento dei membri del team

### Soluzione Passo-Passo

1. **Ottimizzare la Struttura delle Tabelle**

```php
// Crea una migrazione per ottimizzare le tabelle dei team
php artisan make:migration optimize_team_tables

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeTeamTables extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Aggiungi indici per migliorare le performance
            $table->index('owner_id');
        });
        
        Schema::table('team_user', function (Blueprint $table) {
            // Aggiungi indici compositi
            $table->index(['team_id', 'user_id']);
            $table->index(['user_id', 'team_id']);
        });
        
        Schema::table('team_invitations', function (Blueprint $table) {
            $table->index(['team_id', 'email']);
        });
    }
    
    public function down()
    {
        // Rimuovi gli indici
    }
}
```

2. **Implementare Eager Loading nei Repository**

```php
// In Modules\User\Repositories\TeamRepository.php
namespace Modules\User\Repositories;

use Modules\User\Models\Team;

class TeamRepository
{
    public function findWithMembers($id)
    {
        return Team::with(['owner', 'users', 'users.roles'])->find($id);
    }
    
    public function getUserTeams($userId)
    {
        return Team::with(['owner'])
            ->where('owner_id', $userId)
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->get();
    }
}
```

3. **Implementare Caching per i Team**

```php
// In Modules\User\Services\TeamService.php
namespace Modules\User\Services;

use Illuminate\Support\Facades\Cache;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Repositories\TeamRepository;

class TeamService
{
    protected $teamRepository;
    
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }
    
    public function findTeamWithMembers($id)
    {
        return Cache::remember("team_{$id}_with_members", 3600, function () use ($id) {
            return $this->teamRepository->findWithMembers($id);
        });
    }
    
    public function getUserTeams($userId)
    {
        return Cache::remember("user_{$userId}_teams", 3600, function () use ($userId) {
            return $this->teamRepository->getUserTeams($userId);
        });
    }
    
    public function invalidateTeamCache($team)
    {
        Cache::forget("team_{$team->id}_with_members");
        
        // Invalida anche la cache dei team per ogni membro
        $team->users->each(function ($user) {
            Cache::forget("user_{$user->id}_teams");
        });
        
        Cache::forget("user_{$team->owner_id}_teams");
    }
}
```

4. **Creare Observer per Team**

```php
// In Modules\User\Observers\TeamObserver.php
namespace Modules\User\Observers;

use Modules\User\Models\Team;
use Modules\User\Services\TeamService;

class TeamObserver
{
    protected $teamService;
    
    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }
    
    public function saved(Team $team)
    {
        $this->teamService->invalidateTeamCache($team);
    }
    
    public function deleted(Team $team)
    {
        $this->teamService->invalidateTeamCache($team);
    }
}
```

5. **Registrare l'Observer**

```php
// In UserServiceProvider.php
use Modules\User\Models\Team;
use Modules\User\Observers\TeamObserver;

public function boot()
{
    // ...
    Team::observe(TeamObserver::class);
}
```

6. **Ottimizzare le Query per Membri del Team**

```php
// In Modules\User\Repositories\TeamUserRepository.php
namespace Modules\User\Repositories;

use Modules\User\Models\Team;
use Modules\User\Models\User;

class TeamUserRepository
{
    public function addMember(Team $team, User $user, $role = null)
    {
        $team->users()->attach($user, ['role' => $role]);
        
        // Invalida le cache
        app(TeamService::class)->invalidateTeamCache($team);
        app(UserService::class)->invalidateCache($user);
    }
    
    public function removeMember(Team $team, User $user)
    {
        $team->users()->detach($user);
        
        // Invalida le cache
        app(TeamService::class)->invalidateTeamCache($team);
        app(UserService::class)->invalidateCache($user);
    }
    
    public function getTeamMembers(Team $team, $perPage = 15)
    {
        return $team->users()
            ->with(['roles'])
            ->paginate($perPage);
    }
}
```

7. **Implementare Paginazione Efficiente**

```php
// In Modules\User\Http\Controllers\TeamController.php
namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Repositories\TeamUserRepository;

class TeamController extends Controller
{
    protected $teamUserRepository;
    
    public function __construct(TeamUserRepository $teamUserRepository)
    {
        $this->teamUserRepository = $teamUserRepository;
    }
    
    public function members(Request $request, $teamId)
    {
        $team = app(TeamService::class)->findTeamWithMembers($teamId);
        
        $perPage = $request->input('per_page', 15);
        $members = $this->teamUserRepository->getTeamMembers($team, $perPage);
        
        return view('user::teams.members', compact('team', 'members'));
    }
}
```

## 4. Gestione Inefficiente delle Notifiche

### Problema
Il modulo User invia notifiche in modo sincrono, causando rallentamenti nelle operazioni che generano notifiche multiple.

### Impatto
- Aumento del tempo di risposta per operazioni che generano notifiche
- Timeout nelle richieste che inviano molte notifiche
- Esperienze utente degradate durante operazioni batch

### Soluzione Passo-Passo

1. **Configurare Code per Notifiche**

```php
// In .env
QUEUE_CONNECTION=database
```

2. **Implementare Notifiche in Coda**

```php
// In Modules\User\Notifications\BaseNotification.php
namespace Modules\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    // Imposta la coda per le notifiche
    public $queue = 'notifications';
    
    // Imposta il numero di tentativi
    public $tries = 3;
    
    // Imposta il timeout
    public $timeout = 60;
}
```

3. **Estendere le Notifiche Esistenti**

```php
// In Modules\User\Notifications\TeamInvitation.php
namespace Modules\User\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class TeamInvitation extends BaseNotification
{
    protected $invitation;
    
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }
    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invito al Team')
            ->line('Sei stato invitato a unirti al team.')
            ->action('Accetta Invito', url('/team-invitations/'.$this->invitation->id))
            ->line('Se non ti aspettavi questo invito, puoi ignorare questa email.');
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'invitation_id' => $this->invitation->id,
            'team_id' => $this->invitation->team_id,
            'team_name' => $this->invitation->team->name,
        ];
    }
}
```

4. **Implementare Batch Notifications**

```php
// In Modules\User\Services\NotificationService.php
namespace Modules\User\Services;

use Illuminate\Support\Collection;
use Modules\User\Models\User;
use Modules\User\Notifications\BaseNotification;

class NotificationService
{
    public function sendToUser(User $user, BaseNotification $notification)
    {
        $user->notify($notification);
    }
    
    public function sendToUsers(Collection $users, BaseNotification $notification)
    {
        // Utilizza chunk per evitare di sovraccaricare la coda
        $users->chunk(100)->each(function ($chunk) use ($notification) {
            foreach ($chunk as $user) {
                $this->sendToUser($user, $notification);
            }
        });
    }
    
    public function sendToTeam($team, BaseNotification $notification)
    {
        // Invia a tutti i membri del team
        $this->sendToUsers($team->users, $notification);
        
        // Invia anche al proprietario se non è già incluso
        if (!$team->users->contains($team->owner)) {
            $this->sendToUser($team->owner, $notification);
        }
    }
}
```

5. **Ottimizzare la Tabella delle Notifiche**

```php
// Crea una migrazione per ottimizzare la tabella notifications
php artisan make:migration optimize_notifications_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeNotificationsTable extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Aggiungi indici per migliorare le performance
            $table->index(['notifiable_type', 'notifiable_id', 'read_at']);
            $table->index(['created_at']);
        });
    }
    
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['notifiable_type', 'notifiable_id', 'read_at']);
            $table->dropIndex(['created_at']);
        });
    }
}
```

6. **Implementare Pulizia Automatica delle Notifiche**

```php
// Crea un nuovo comando
php artisan make:command CleanOldNotifications

// Implementazione
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanOldNotifications extends Command
{
    protected $signature = 'notifications:clean {--days=30}';
    
    protected $description = 'Clean old notifications from the database';
    
    public function handle()
    {
        $days = $this->option('days');
        $date = Carbon::now()->subDays($days);
        
        $count = DB::table('notifications')
            ->where('created_at', '<', $date)
            ->where('read_at', '!=', null)
            ->delete();
        
        $this->info("Deleted {$count} old notifications.");
    }
}
```

7. **Aggiungere il Comando allo Scheduler**

```php
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command('notifications:clean')->daily();
}
```

## 5. Gestione Inefficiente dei Log di Autenticazione

### Problema
Il modulo User registra ogni tentativo di autenticazione in modo sincrono, causando rallentamenti durante i picchi di login.

### Impatto
- Rallentamento del processo di login durante i picchi di traffico
- Carico eccessivo sul database
- Possibili timeout nelle richieste di login

### Soluzione Passo-Passo

1. **Implementare Logging Asincrono**

```php
// In Modules\User\Jobs\LogAuthenticationAttempt.php
namespace Modules\User\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\AuthenticationLog;

class LogAuthenticationAttempt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function handle()
    {
        AuthenticationLog::create($this->data);
    }
}
```

2. **Modificare il Listener di Login**

```php
// In Modules\User\Listeners\LogSuccessfulLogin.php
namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Login;
use Modules\User\Jobs\LogAuthenticationAttempt;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        LogAuthenticationAttempt::dispatch([
            'user_id' => $event->user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'login_at' => now(),
            'login_successful' => true,
        ]);
    }
}
```

3. **Modificare il Listener di Login Fallito**

```php
// In Modules\User\Listeners\LogFailedLogin.php
namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Failed;
use Modules\User\Jobs\LogAuthenticationAttempt;
use Modules\User\Models\User;

class LogFailedLogin
{
    public function handle(Failed $event)
    {
        $userId = null;
        
        if ($event->user instanceof User) {
            $userId = $event->user->id;
        }
        
        LogAuthenticationAttempt::dispatch([
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'login_at' => now(),
            'login_successful' => false,
        ]);
    }
}
```

4. **Ottimizzare la Tabella dei Log**

```php
// Crea una migrazione per ottimizzare la tabella authentication_logs
php artisan make:migration optimize_authentication_logs_table

// Implementazione
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptimizeAuthenticationLogsTable extends Migration
{
    public function up()
    {
        Schema::table('authentication_logs', function (Blueprint $table) {
            // Aggiungi indici per migliorare le performance
            $table->index(['user_id', 'login_at']);
            $table->index(['ip_address', 'login_at']);
            $table->index(['login_successful', 'login_at']);
        });
    }
    
    public function down()
    {
        Schema::table('authentication_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'login_at']);
            $table->dropIndex(['ip_address', 'login_at']);
            $table->dropIndex(['login_successful', 'login_at']);
        });
    }
}
```

5. **Implementare Pulizia Automatica dei Log**

```php
// Crea un nuovo comando
php artisan make:command CleanAuthenticationLogs

// Implementazione
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Models\AuthenticationLog;
use Carbon\Carbon;

class CleanAuthenticationLogs extends Command
{
    protected $signature = 'auth:clean-logs {--days=90}';
    
    protected $description = 'Clean old authentication logs from the database';
    
    public function handle()
    {
        $days = $this->option('days');
        $date = Carbon::now()->subDays($days);
        
        $count = AuthenticationLog::where('login_at', '<', $date)->delete();
        
        $this->info("Deleted {$count} old authentication logs.");
    }
}
```

6. **Aggiungere il Comando allo Scheduler**

```php
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command('auth:clean-logs')->monthly();
}
```

7. **Implementare Aggregazione dei Log per Analisi**

```php
// In Modules\User\Services\AuthLogAnalyticsService.php
namespace Modules\User\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthLogAnalyticsService
{
    public function getLoginStatsByDay($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        
        return DB::table('authentication_logs')
            ->select(
                DB::raw('DATE(login_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN login_successful = 1 THEN 1 ELSE 0 END) as successful'),
                DB::raw('SUM(CASE WHEN login_successful = 0 THEN 1 ELSE 0 END) as failed')
            )
            ->where('login_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
    
    public function getLoginStatsByIp($limit = 10, $days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        
        return DB::table('authentication_logs')
            ->select(
                'ip_address',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN login_successful = 1 THEN 1 ELSE 0 END) as successful'),
                DB::raw('SUM(CASE WHEN login_successful = 0 THEN 1 ELSE 0 END) as failed')
            )
            ->where('login_at', '>=', $startDate)
            ->groupBy('ip_address')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();
    }
}
```

## Conclusione

Implementando queste soluzioni, il modulo User potrà superare i principali colli di bottiglia e migliorare significativamente le performance dell'applicazione. È consigliabile implementare le soluzioni in modo incrementale, misurando l'impatto di ciascuna modifica per garantire miglioramenti effettivi.

## Collegamenti
- [Roadmap Principale](./roadmap.md)
- [Best Practices Filament](./FILAMENT_BEST_PRACTICES.md)
- [Best Practices Widget](./best-practices/filament-widgets.md)
- [Struttura Moduli](../Xot/docs/MODULE_STRUCTURE.md)

## Collegamenti tra versioni di BOTTLENECKS.md
* [BOTTLENECKS.md](../../../Xot/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../User/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Media/docs/BOTTLENECKS.md)
* [BOTTLENECKS.md](../../../Cms/docs/BOTTLENECKS.md)


## Collegamenti tra versioni di bottlenecks.md
* [bottlenecks.md](../../../../bashscripts/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/bottlenecks.md)
* [bottlenecks.md](../../Chart/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/bottlenecks.md)
* [bottlenecks.md](../../Gdpr/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Xot/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Dental/docs/bottlenecks.md)
* [bottlenecks.md](roadmap/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/bottlenecks.md)
* [bottlenecks.md](../../UI/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/bottlenecks.md)
* [bottlenecks.md](../../Lang/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Job/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/bottlenecks.md)
* [bottlenecks.md](../../Media/docs/performance/bottlenecks.md)
* [bottlenecks.md](../../Activity/docs/bottlenecks.md)
* [bottlenecks.md](../../Patient/docs/roadmap/bottlenecks.md)
* [bottlenecks.md](../../Cms/docs/bottlenecks.md)

