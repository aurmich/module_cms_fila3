### Versione HEAD

# Correzioni PHPStan Livello 7 - Modulo User

Questo documento traccia gli errori PHPStan di livello 7 identificati nel modulo User e le relative soluzioni implementate.

## Errori Identificati

### 1. Errori in Profile.php

```
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::permission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::role() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withExtraAttributes() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutPermission() return type contains unknown class Modules\User\Models\Builder.
Line 49: PHPDoc tag @method for method Modules\User\Models\Profile::withoutRole() return type contains unknown class Modules\User\Models\Builder.
```

## Soluzioni Implementate

### 1. Correzione in Profile.php

Il problema è che i tag PHPDoc facevano riferimento a una classe `Builder` nel namespace `Modules\User\Models` che non esiste. Abbiamo corretto i riferimenti utilizzando il namespace completo per la classe Builder:

```php
/**
 * ...
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * ...
 */
```

Questo garantisce che PHPStan possa risolvere correttamente il tipo `Builder` utilizzando il namespace completo `\Illuminate\Database\Eloquent\Builder`. 
## Collegamenti tra versioni di phpstan_fixes.md
* [phpstan_fixes.md](../../../Xot/docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../User/docs/phpstan_fixes.md)
* [phpstan_fixes.md](../../../User/docs/fixes/phpstan_fixes.md)
* [phpstan_fixes.md](../../../Activity/docs/phpstan_fixes.md)


### Versione Incoming

# Correzioni PHPStan per il Modulo User

## Problemi Principali

### BaseUser.php

1. Proprietà non definite:
   - `$pivot`
   - `$email`
   - `$first_name`
   - `$last_name`
   - `$current_team_id`

2. Metodi non definiti:
   - `hasRole()`
   - `teams()`
   - `ownedTeams()`
   - `belongsToTeam()`
   - `teamRole()`
   - `ownsTeam()`
   - `hasTeamPermission()`
   - `belongsToManyX()`
   - `socialiteUsers()`
   - `authentications()`

3. Problemi di tipo:
   - Parametro `$role` in `hasRole()` senza tipo specificato
   - Parametro `$related` in `belongsToMany()` richiede `class-string<Model>`
   - Tipo template `TRelatedModel` non risolto in `belongsToMany()`

### Soluzioni Proposte

1. Definire le proprietà mancanti:
   ```php
   /**
    * @property string|null $email
    * @property string|null $first_name
    * @property string|null $last_name
    * @property string|null $current_team_id
    * @property \Illuminate\Database\Eloquent\Relations\Pivot|null $pivot
    */
   ```

2. Implementare i metodi mancanti:
   ```php
   public function hasRole(string $role): bool
   {
       return $this->roles()->where('name', $role)->exists();
   }

   public function teams(): BelongsToMany
   {
       return $this->belongsToMany(Team::class);
   }
   ```

3. Correggere i tipi:
   ```php
   public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null): BelongsToMany
   {
       /** @var class-string<Model> $related */
       return parent::belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey);
   }
   ```

### Altri File

1. Profile.php:
   - Correggere i riferimenti alle classi non esistenti nei PHPDoc
   - Aggiungere le classi mancanti o correggere i namespace

2. HasAuthenticationLogTrait.php:
   - Implementare il metodo `authentications()`
   - Gestire correttamente i tipi di ritorno

3. HasTeams.php:
   - Implementare i metodi mancanti
   - Correggere i tipi di ritorno

4. HasTenants.php:
   - Implementare i metodi mancanti
   - Correggere i tipi di ritorno

## Prossimi Passi

1. Correggere il modello `BaseUser.php`
2. Aggiornare i trait con i metodi mancanti
3. Correggere i tipi nei modelli e nelle relazioni
4. Aggiornare la documentazione delle classi
5. Eseguire nuovamente PHPStan per verificare le correzioni 

---

