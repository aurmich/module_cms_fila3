# PRIORITÀ ASSOLUTA: SISTEMARE TEST ESISTENTI

## 🎯 REGOLA CRITICA: BUSINESS BEHAVIOR FIRST

**IL TESTING DEVE VERIFICARE IL COMPORTAMENTO BUSINESS, NON L'IMPLEMENTAZIONE!**

Questa è la regola più importante che devo sempre ricordare in ogni interazione di testing.

## PRIORITÀ OPERATIVE

### 1. PRIMA PRIORITÀ: Sistemare Test Esistenti
- **MAI cancellare test esistenti**
- **SEMPRE** farli funzionare correggendo l'approccio
- Convertire da test implementativi a test comportamentali
- Mantenere la copertura ma migliorarne la qualità

### 2. SECONDA PRIORITÀ: Nuovi Test Solo Se Necessari
- Solo dopo aver sistemato tutti i test esistenti
- Solo se mancano comportamenti business critici
- Sempre con focus su business logic, mai su dettagli implementativi

## MANTRA DA RICORDARE SEMPRE

🔥 **"COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE"** 🔥

## CHECKLIST OPERATIVA

### ❌ MAI TESTARE (Implementazione):
- Proprietà dei modelli ($fillable, $casts, $hidden)
- Struttura interna delle classi
- Se un metodo specifico viene chiamato internamente
- Dettagli di configurazione del framework
- Trait utilizzati nei modelli
- Relazioni Eloquent basilari (belongsTo, hasMany)

### ✅ SEMPRE TESTARE (Comportamento Business):
- Risultati visibili all'utente finale
- Regole di business e validazioni
- Flussi completi (input → elaborazione → output)
- Comportamenti attesi dal punto di vista funzionale
- Effetti collaterali business (notifiche, log, cambi di stato)
- Autorizzazioni e permessi business

## ESEMPI PRATICI

### ❌ SBAGLIATO (Test Implementativo):
```php
it('model has fillable attributes', function() {
    expect(User::class)->toHave('fillable');
});

it('uses specific trait', function() {
    expect(User::class)->toUse(SomeTrait::class);
});
```

### ✅ CORRETTO (Test Comportamentale):
```php
it('creates appointment when doctor and patient are available', function() {
    // Testa il comportamento business completo
});

it('prevents double booking for same time slot', function() {
    // Testa regola business importante
});
```

## FILOSOFIA DI SISTEMAZIONE

Quando sistemo un test esistente:

1. **Capire l'intenzione originale**: Cosa voleva verificare?
2. **Identificare il comportamento business**: Qual è il valore per l'utente?
3. **Riscrivere il test**: Focus sul comportamento, non sull'implementazione
4. **Mantenere la copertura**: Non perdere controlli importanti

## RESPONSABILITÀ

- I test devono essere **RESILIENTI ai refactor**
- Se cambio implementazione senza cambiare comportamento, i test NON devono rompersi
- I test devono documentare il comportamento atteso del sistema
- I test devono avere valore business, non essere solo esercizi tecnici

---

**Questa regola ha precedenza su qualsiasi altra considerazione di testing.**