# Quick Reference - Regole Critiche

## ⚡ Regole da Ricordare SEMPRE

### 🧪 Testing (CRITICO)
```php
// ✅ CORRETTO: Testa comportamento business
test('user can login and see dashboard', function () {
    $user = User::factory()->create();
    
    $response = $this->post('/login', $credentials);
    
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

// ❌ SBAGLIATO: Testa implementazione
test('login calls auth service', function () {
    $mock = Mockery::mock(AuthService::class);
    $mock->shouldReceive('authenticate'); // MAI FARE
});
```

### 🏗️ Architettura (CRITICO)
```php
// ✅ CORRETTO: Specifico → Base
// SaluteOra/Models/Patient.php
use Modules\User\Models\User;

// ❌ SBAGLIATO: Base → Specifico
// User/Models/User.php
use Modules\SaluteOra\Enums\UserType; // MAI FARE
```

## 📝 Checklist Veloce

### Prima di Scrivere Test
- [ ] Testa risultato osservabile dall'utente?
- [ ] NON testa metodi interni?
- [ ] Fallisce solo se comportamento business cambia?

### Prima di Aggiungere Import
- [ ] Sto importando da modulo di livello uguale o inferiore?
- [ ] NON sto creando dipendenza inversa?
- [ ] Rispetto la gerarchia Base → Intermedi → Specifici?

### Prima di Commit
- [ ] Test esistenti funzionano (non cancellati)?
- [ ] Nessuna dipendenza inversa?
- [ ] Documentazione aggiornata?

## 🚨 Errori da Evitare

### Testing
- ❌ Mockare implementazioni interne
- ❌ Testare proprietà private/protected
- ❌ Cancellare test esistenti
- ❌ Testare "come" invece di "cosa"

### Architettura
- ❌ User dipende da SaluteOra
- ❌ Moduli base dipendono da specifici
- ❌ Import circolari tra moduli
- ❌ Logica specifica nei moduli base

## 🔧 Comandi Utili

### Verifica Dipendenze Inverse
```bash
grep -r "use Modules\\\\SaluteOra" Modules/User/ && echo "❌ ERRORE!" || echo "✅ OK"
```

### Test Behavior-Driven
```bash
php artisan test --filter="user_can_" # Test che iniziano con comportamento
```

### PHPStan Check
```bash
./vendor/bin/phpstan analyze --level=9 Modules/User/ # Moduli base
```

---

**💡 Ricorda**: Test il VALORE, rispetta le DIPENDENZE, aggiorna la DOCUMENTAZIONE!
