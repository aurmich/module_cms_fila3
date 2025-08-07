# Documentazione Gestione Permessi GDPR

## Panoramica
Il sistema di gestione dei permessi GDPR utilizza `spatie/laravel-permission` per gestire i permessi e i ruoli relativi alla protezione dei dati personali.

## Configurazione

### 1. Configurazione Base
```php
// config/permission.php
return [
    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],
    
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],
    
    'column_names' => [
        'role_pivot_key' => 'role_id',
        'permission_pivot_key' => 'permission_id',
        'model_morph_key' => 'model_id',
    ],
];
```

### 2. Database
```php
// database/migrations/2024_01_01_create_permission_tables.php
Schema::create('permissions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('model_has_permissions', function (Blueprint $table) {
    $table->unsignedBigInteger('permission_id');
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    $table->timestamps();
    
    $table->index(['model_type', 'model_id']);
});

Schema::create('model_has_roles', function (Blueprint $table) {
    $table->unsignedBigInteger('role_id');
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    $table->timestamps();
    
    $table->index(['model_type', 'model_id']);
});

Schema::create('role_has_permissions', function (Blueprint $table) {
    $table->unsignedBigInteger('permission_id');
    $table->unsignedBigInteger('role_id');
    $table->timestamps();
});
```

## Implementazione

### 1. Service
```php
class GdprPermissionService
{
    public function assignRole($user, string $role): void
    {
        $user->assignRole($role);
        $this->logRoleAssignment($user, $role);
    }
    
    public function revokeRole($user, string $role): void
    {
        $user->removeRole($role);
        $this->logRoleRevocation($user, $role);
    }
    
    public function hasPermission($user, string $permission): bool
    {
        return $user->hasPermissionTo($permission);
    }
    
    protected function logRoleAssignment($user, string $role): void
    {
        activity()
            ->performedOn($user)
            ->withProperties(['role' => $role])
            ->log('role_assigned');
    }
}
```

### 2. Controller
```php
class GdprPermissionController extends Controller
{
    public function index()
    {
        return view('gdpr::permissions.index', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all(),
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string',
            'permissions' => 'required|array',
        ]);
        
        $role = Role::findOrCreate($validated['role']);
        $role->syncPermissions($validated['permissions']);
        
        return response()->json(['success' => true]);
    }
}
```

## Interfaccia Utente

### 1. Template
```blade
<!-- resources/views/gdpr/permissions/index.blade.php -->
<div class="permissions-management">
    <div class="roles-section">
        <h2>Ruoli</h2>
        @foreach($roles as $role)
            <div class="role-card">
                <h3>{{ $role->name }}</h3>
                <div class="permissions-list">
                    @foreach($role->permissions as $permission)
                        <span class="permission-badge">{{ $permission->name }}</span>
                    @endforeach
                </div>
                <button class="edit-role" data-role="{{ $role->id }}">Modifica</button>
            </div>
        @endforeach
    </div>
    
    <div class="permissions-section">
        <h2>Permessi Disponibili</h2>
        @foreach($permissions as $permission)
            <div class="permission-item">
                <input type="checkbox" 
                       name="permissions[]" 
                       value="{{ $permission->id }}"
                       id="permission_{{ $permission->id }}">
                <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
        @endforeach
    </div>
</div>
```

### 2. JavaScript
```javascript
// resources/js/permissions.js
class PermissionsManager {
    constructor() {
        this.form = document.querySelector('.permissions-management');
        this.initialize();
    }
    
    initialize() {
        this.form.querySelectorAll('.edit-role').forEach(button => {
            button.addEventListener('click', this.handleEditRole.bind(this));
        });
    }
    
    async handleEditRole(event) {
        const roleId = event.target.dataset.role;
        const permissions = this.getSelectedPermissions();
        
        try {
            await fetch(`/gdpr/permissions/${roleId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ permissions }),
            });
            
            this.showSuccess();
        } catch (error) {
            this.showError(error);
        }
    }
}
```

## Sicurezza

### 1. Validazione
```php
class GdprPermissionValidator
{
    public function validateRoleAssignment($user, string $role): bool
    {
        if (!$this->isValidRole($role)) {
            return false;
        }
        
        if (!$this->hasRequiredPermissions($user, $role)) {
            return false;
        }
        
        return true;
    }
    
    protected function isValidRole(string $role): bool
    {
        return in_array($role, config('gdpr.roles'));
    }
}
```

### 2. Middleware
```php
class GdprPermissionMiddleware
{
    public function handle($request, Closure $next, string $permission)
    {
        if (!$request->user()->hasPermissionTo($permission)) {
            abort(403, 'Non autorizzato');
        }
        
        return $next($request);
    }
}
```

## Monitoraggio

### 1. Analytics
```php
class GdprPermissionAnalytics
{
    public function trackPermissionChanges($user, array $changes): void
    {
        $this->logChanges($user, $changes);
        $this->updateStatistics($changes);
    }
    
    protected function logChanges($user, array $changes): void
    {
        activity()
            ->performedOn($user)
            ->withProperties(['changes' => $changes])
            ->log('permissions_updated');
    }
}
```

## Manutenzione

### 1. Pulizia
```php
class GdprPermissionCleanup
{
    public function cleanupUnusedPermissions(): void
    {
        $unused = $this->getUnusedPermissions();
        
        foreach ($unused as $permission) {
            $this->deletePermission($permission);
        }
    }
}
```

## Best Practices

### 1. Implementazione
- Ruoli ben definiti
- Permessi granulari
- Logging delle modifiche
- Verifica regolare

### 2. Sicurezza
- Validazione dei permessi
- Controllo accessi
- Protezione CSRF
- Logging delle modifiche

### 3. UX
- Interfaccia intuitiva
- Feedback immediato
- Gestione semplice
- Documentazione chiara

## Collegamenti
- [Documentazione ufficiale](https://spatie.be/docs/laravel-permission)
- [Architettura](../architecture.md)
- [Sviluppo](../development.md) 

## Collegamenti tra versioni di permissions.md
* [permissions.md](../../../User/docs/permissions.md)
* [permissions.md](../../../Patient/docs/permissions.md)

