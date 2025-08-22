# Testing: Comportamento Business vs Implementazione

## Regola Fondamentale
**I test devono SEMPRE verificare il comportamento business, MAI l'implementazione.**

## Principi Chiave

### 1. Testare COSA, non COME
- ✅ **CORRETTO**: Verificare che l'utente sia autenticato dopo il login
- ❌ **SBAGLIATO**: Verificare che venga chiamato il metodo `Auth::login()`

### 2. Focus sul Valore per l'Utente
- ✅ **CORRETTO**: "Dopo aver compilato il form, l'appuntamento viene creato e l'utente riceve una conferma"
- ❌ **SBAGLIATO**: "Il metodo `createAppointment()` viene chiamato con i parametri corretti"

### 3. Resistenza ai Refactoring
- I test devono continuare a funzionare anche se cambia l'implementazione interna
- Se un refactoring rompe i test senza cambiare il comportamento, i test sono sbagliati

### 4. Contratti Pubblici
- Testare solo ciò che è osservabile dall'esterno del sistema
- API endpoints, UI, database state, file system, email inviate, ecc.

## Esempi Pratici

### Login System ✅
```php
test('user can login with valid credentials', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    // Testare il COMPORTAMENTO BUSINESS
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
    expect(session()->has('user_logged_in_at'))->toBeTrue();
});
```

### Appointment Creation ✅
```php
test('doctor can create appointment for patient', function () {
    $doctor = User::factory()->doctor()->create();
    $patient = User::factory()->patient()->create();
    
    $this->actingAs($doctor)
        ->post('/appointments', [
            'patient_id' => $patient->id,
            'date' => '2024-01-15',
            'time' => '10:00',
            'type' => 'consultation',
        ]);
    
    // Testare il RISULTATO BUSINESS
    $this->assertDatabaseHas('appointments', [
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'scheduled_at' => '2024-01-15 10:00:00',
        'type' => 'consultation',
        'status' => 'scheduled',
    ]);
    
    // Verificare effetti collaterali business
    expect($patient->fresh()->appointments()->count())->toBe(1);
    Mail::assertSent(AppointmentConfirmation::class);
});
```

### Widget Test ✅
```php
test('patient calendar shows only patient appointments', function () {
    $patient = User::factory()->patient()->create();
    $otherPatient = User::factory()->patient()->create();
    
    $patientAppointment = Appointment::factory()->create(['patient_id' => $patient->id]);
    $otherAppointment = Appointment::factory()->create(['patient_id' => $otherPatient->id]);
    
    $this->actingAs($patient);
    
    Livewire::test(PatientCalendarWidget::class)
        ->assertSee($patientAppointment->title)
        ->assertDontSee($otherAppointment->title);
});
```

## Anti-Pattern da Evitare ❌

### Non Testare Implementazione Interna
```php
// ❌ SBAGLIATO - testa l'implementazione
test('login calls auth service', function () {
    $authService = Mockery::mock(AuthService::class);
    $authService->shouldReceive('authenticate')->once();
    
    // Questo test è fragile e non testa il valore business
});

// ❌ SBAGLIATO - testa dettagli interni
test('widget sets correct properties', function () {
    $widget = new PatientCalendarWidget();
    
    expect($widget->appointments)->toBeArray();
    expect($widget->currentMonth)->toBe(now()->month);
});
```

### Non Testare Metodi Privati
```php
// ❌ SBAGLIATO - i metodi privati sono implementazione
test('private method formats date correctly', function () {
    $widget = new PatientCalendarWidget();
    $reflection = new ReflectionClass($widget);
    $method = $reflection->getMethod('formatDate');
    $method->setAccessible(true);
    
    // Se è privato, non dovrebbe essere testato direttamente
});
```

## Gestione Test Esistenti

### Regola: NON Cancellare, Sistemare
1. **Analizzare** cosa il test vuole verificare a livello business
2. **Riscrivere** il test per testare il comportamento, non l'implementazione
3. **Mantenere** la copertura dei casi d'uso importanti
4. **Migliorare** la leggibilità e la manutenibilità

### Processo di Sistemazione
```php
// PRIMA (test implementazione)
test('widget loads appointments', function () {
    $widget = new PatientCalendarWidget();
    $widget->mount();
    
    expect($widget->appointments)->toHaveCount(5);
});

// DOPO (test comportamento)
test('patient sees their scheduled appointments in calendar', function () {
    $patient = User::factory()->patient()->create();
    Appointment::factory()->count(5)->create(['patient_id' => $patient->id]);
    Appointment::factory()->count(3)->create(); // Altri pazienti
    
    $this->actingAs($patient);
    
    Livewire::test(PatientCalendarWidget::class)
        ->assertViewHas('appointments', function ($appointments) {
            return $appointments->count() === 5;
        });
});
```

## Benefici di Questa Approccio

1. **Stabilità**: I test non si rompono per refactoring interni
2. **Documentazione**: I test documentano il comportamento atteso
3. **Fiducia**: Maggiore confidenza che il sistema funzioni per gli utenti
4. **Manutenibilità**: Meno test da aggiornare quando cambia l'implementazione
5. **Focus**: Concentrazione sui requisiti business reali

## Checklist per Ogni Test

- [ ] Il test verifica un comportamento osservabile dall'utente?
- [ ] Il test continuerebbe a funzionare se cambiassi l'implementazione interna?
- [ ] Il test documenta un requisito business reale?
- [ ] Il test fallisce solo quando il comportamento business cambia?
- [ ] Il test è leggibile e comprensibile senza conoscere l'implementazione?

## Collegamenti
- [Testing Guidelines](./testing-guidelines.md)
- [Business Requirements](../docs/business-requirements.md)
- [User Stories](../docs/user-stories.md)

---
**Ultima modifica**: 2025-01-06  
**Priorità**: CRITICA  
**Applicazione**: SEMPRE, TUTTI I TEST