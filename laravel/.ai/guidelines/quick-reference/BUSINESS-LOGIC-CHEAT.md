# Business Logic Focus - Quick Reference

## 🎯 PRINCIPIO FONDAMENTALE
**CONCENTRARSI SEMPRE sulla logica di business, NON sui dettagli implementativi.**

## ✅ COSA TESTARE (Business Logic)

### Comportamento Business
```php
// Revenue calculation
it('calculates appointment revenue correctly', function () {
    $appointment = Appointment::factory()->create([
        'duration' => 2.5,
        'hourly_rate' => 100
    ]);
    
    expect($appointment->calculateRevenue())->toBe(250.0);
});

// State transitions
it('transitions appointment to confirmed state', function () {
    $appointment = Appointment::factory()->create(['status' => 'pending']);
    
    $appointment->confirm();
    
    expect($appointment->status)->toBe('confirmed');
});

// Business rules validation
it('validates doctor availability', function () {
    $doctor = Doctor::factory()->create();
    $timeSlot = '2024-01-15 10:00';
    
    expect($doctor->isAvailable($timeSlot))->toBeTrue();
});
```

### Flussi Business Completi
```php
// End-to-end business flow
it('completes appointment booking flow', function () {
    $doctor = Doctor::factory()->create();
    $patient = Patient::factory()->create();
    
    $appointment = $doctor->bookAppointment($patient, '2024-01-15 10:00');
    
    expect($appointment->status)->toBe('booked');
    expect($appointment->doctor_id)->toBe($doctor->id);
    expect($appointment->patient_id)->toBe($patient->id);
});
```

## ❌ COSA NON TESTARE (Implementation Details)

### Dettagli Implementativi
```php
// ❌ NO - Fillable fields
it('has correct fillable fields', function () {
    $model = new Appointment();
    expect($model->getFillable())->toContain('duration', 'hourly_rate');
});

// ❌ NO - Table names
it('uses correct table name', function () {
    expect((new Appointment())->getTable())->toBe('appointments');
});

// ❌ NO - Primary keys  
it('has correct primary key', function () {
    expect((new Appointment())->getKeyName())->toBe('id');
});

// ❌ NO - Basic relationships
it('has doctor relationship', function () {
    $appointment = new Appointment();
    expect($appointment->doctor())->toBeInstanceOf(BelongsTo::class);
});
```

## 🎪 DOMINI BUSINESS ESEMPLIFICATIVI

### Medicina (Healthcare)
```php
// ✅ Business logic: Appointment scheduling rules
it('prevents overlapping appointments', function () {
    $doctor = Doctor::factory()->create();
    
    // First appointment
    Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'start_time' => '2024-01-15 10:00',
        'end_time' => '2024-01-15 11:00'
    ]);
    
    // Overlapping appointment should fail
    expect(fn() => Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'start_time' => '2024-01-15 10:30',
        'end_time' => '2024-01-15 11:30'
    ]))->toThrow(OverlappingAppointmentException::class);
});
```

### E-commerce (Retail)
```php
// ✅ Business logic: Discount calculations
it('applies loyalty discounts correctly', function () {
    $customer = Customer::factory()->loyalty()->create();
    $order = Order::factory()->create(['customer_id' => $customer->id]);
    
    $discount = $order->calculateLoyaltyDiscount();
    
    expect($discount)->toBe(0.1); // 10% loyalty discount
});
```

## 🔍 DOMANDE DA PORSI SEMPRE

1. **Perché?** Perché stiamo implementando questa feature?
2. **Chi?** Chi è l'utente finale e quali problemi risolve?
3. **Cosa?** Cosa deve accadere nel sistema quando...?
4. **Come?** Come viene risolto il problema business?

## 📋 CHECKLIST CODE REVIEW

- [ ] La feature risolve un problema business reale?
- [ ] I test verificano comportamento business, non dettagli tecnici?
- [ ] La logica è separata dai dettagli implementativi?
- [ ] I nomi delle funzioni riflettono concetti business?
- [ ] Le dipendenze sono orientate al dominio, non al framework?

## 🚀 REGOLE D'ORO

1. **Business First**: Prima il problema business, poi la soluzione tecnica
2. **Test Behavior**: Testare cosa fa il sistema, non come lo fa  
3. **Domain Language**: Usare il linguaggio del dominio nel codice
4. **Implementation Last**: I dettagli tecnici vengono per ultimi
5. **Value Focus**: Concentrarsi sul valore delivered, non sulla perfezione tecnica

---

**📚 Riferimenti**: 
- [Business Logic First](../../business-logic-first.md)
- [Testing Guidelines](../../testing-guidelines.md)
- [Core Guidelines](../../CORE.md)

*Questa regola è FONDAMENTALE e deve essere applicata in TUTTO il codice e i test.*