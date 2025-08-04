# Code Quality Standards

## Data: 2025-01-06

## REGOLA CRITICA: MAI fare errori da deficiente cerebrale

### ❌ ERRORE - Test con valori hardcoded
```php
// ❌ ERRORE - Non fare mai questo
public function test_get_color_returns_valid_color(): void
{
    $listColor = TableLayoutEnum::LIST->getColor();
    $gridColor = TableLayoutEnum::GRID->getColor();
    
    $this->assertEquals('primary', $listColor);  // ERRORE!
    $this->assertEquals('secondary', $gridColor); // ERRORE!
}
```

### ✅ CORRETTO - Test con transClass()
```php
// ✅ CORRETTO - Testa che restituisca stringhe tradotte
public function test_get_color_returns_translated_string(): void
{
    $listColor = TableLayoutEnum::LIST->getColor();
    $gridColor = TableLayoutEnum::GRID->getColor();
    
    $this->assertIsString($listColor);
    $this->assertIsString($gridColor);
    $this->assertNotEmpty($listColor);
    $this->assertNotEmpty($gridColor);
}
```

### ❌ ERRORE - Esempi incompleti
```php
// ❌ ERRORE - Non mostrare come usare i metodi dell'enum
Action::make('toggleLayout')
    ->icon($this->layout->getIcon())
    ->color($this->layout->getColor())
    // MANCA ->tooltip($this->layout->getTooltip())
```

### ✅ CORRETTO - Esempi completi
```php
// ✅ CORRETTO - Mostra tutti i metodi disponibili
Action::make('toggleLayout')
    ->icon($this->layout->getIcon())
    ->color($this->layout->getColor())
    ->tooltip($this->layout->getTooltip())
    ->action(function () {
        $this->layout = $this->layout->toggle();
    }),
```

### ❌ ERRORE - Traduzioni incomplete
```php
// ❌ ERRORE - Struttura incompleta
'list' => [
    'label' => 'Lista',
    'description' => 'Visualizzazione a lista tradizionale',
    // MANCA color, icon, tooltip, helper_text
],
```

### ✅ CORRETTO - Struttura espansa completa
```php
// ✅ CORRETTO - Struttura espansa completa
'list' => [
    'label' => 'Lista',
    'description' => 'Visualizzazione a lista tradizionale',
    'tooltip' => 'Mostra elementi in formato lista',
    'helper_text' => 'Layout tradizionale con righe e colonne',
    'color' => 'primary',
    'icon' => 'heroicon-o-list-bullet',
],
```

## Regole Critiche per la Qualità del Codice

### 1. MAI usare ->label()
```php
// ❌ ERRORE - Non fare mai questo
TextColumn::make('name')->label('Nome')

// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
```

### 2. SEMPRE usa transClass() negli Enum
```php
// ✅ CORRETTO - Implementazione Enum con TransTrait
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}
```

### 3. MAI testare valori hardcoded
```php
// ❌ ERRORE
$this->assertEquals('primary', $listColor);
$this->assertEquals('heroicon-o-list-bullet', $listIcon);

// ✅ CORRETTO
$this->assertIsString($listColor);
$this->assertNotEmpty($listColor);
```

### 4. SEMPRE struttura espansa nelle traduzioni
```php
// ❌ ERRORE - Manca struttura espansa
'list' => 'Lista',

// ✅ CORRETTO - Struttura espansa
'list' => [
    'label' => 'Lista',
    'description' => 'Visualizzazione a lista tradizionale',
    'tooltip' => 'Mostra elementi in formato lista',
    'helper_text' => 'Layout tradizionale con righe e colonne',
    'color' => 'primary',
    'icon' => 'heroicon-o-list-bullet',
],
```

## Checklist per Evitare Errori da Deficiente Cerebrale

### Prima di scrivere codice:
- [ ] Studiare l'implementazione reale dell'enum
- [ ] Verificare tutti i metodi disponibili
- [ ] Controllare la struttura delle traduzioni
- [ ] Testare con transClass() non valori hardcoded

### Prima di scrivere test:
- [ ] Testare che restituisca stringhe tradotte
- [ ] NON testare valori hardcoded
- [ ] Verificare tutti i metodi dell'enum
- [ ] Controllare che i test riflettano l'implementazione reale

### Prima di scrivere esempi:
- [ ] Mostrare tutti i metodi disponibili
- [ ] Includere tooltip, helper_text, description
- [ ] Verificare che l'esempio sia completo
- [ ] Controllare che funzioni realmente

### Prima di scrivere traduzioni:
- [ ] Struttura espansa completa
- [ ] Tutti i campi necessari (label, color, icon, tooltip, helper_text)
- [ ] Sincronizzazione IT/EN/DE
- [ ] Verificare che le traduzioni esistano

## Errori Comuni da Deficiente Cerebrale

### 1. Test con valori hardcoded
```php
// ❌ ERRORE
$this->assertEquals('primary', $listColor);
$this->assertEquals('heroicon-o-list-bullet', $listIcon);

// ✅ CORRETTO
$this->assertIsString($listColor);
$this->assertNotEmpty($listColor);
```

### 2. Esempi incompleti
```php
// ❌ ERRORE - Manca tooltip
Action::make('toggleLayout')
    ->icon($this->layout->getIcon())
    ->color($this->layout->getColor());

// ✅ CORRETTO - Completo
Action::make('toggleLayout')
    ->icon($this->layout->getIcon())
    ->color($this->layout->getColor())
    ->tooltip($this->layout->getTooltip());
```

### 3. Traduzioni incomplete
```php
// ❌ ERRORE - Manca struttura espansa
'list' => 'Lista',

// ✅ CORRETTO - Struttura espansa
'list' => [
    'label' => 'Lista',
    'description' => 'Visualizzazione a lista tradizionale',
    'tooltip' => 'Mostra elementi in formato lista',
    'helper_text' => 'Layout tradizionale con righe e colonne',
    'color' => 'primary',
    'icon' => 'heroicon-o-list-bullet',
],
```

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare test con valori hardcoded
// Implementare in phpstan.neon
rules:
    - rule: Never test hardcoded values in enum tests
```

### Code Review Checklist
- [ ] Nessun test con valori hardcoded
- [ ] Tutti i metodi dell'enum testati
- [ ] Esempi completi e funzionanti
- [ ] Struttura espansa nelle traduzioni
- [ ] Sincronizzazione IT/EN/DE

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](translation_standards.md)
- [Filament Best Practices](filament_best_practices.md)
- [Enum Best Practices](enum_best_practices.md)
- [UI Module Rules](../Modules/UI/docs/transclass_rule.md)

## Memoria Permanente

**RICORDA SEMPRE**: 
- MAI testare valori hardcoded
- SEMPRE testare che restituisca stringhe tradotte
- SEMPRE mostrare esempi completi
- SEMPRE struttura espansa nelle traduzioni
- SEMPRE verificare l'implementazione reale
- MAI usare ->label()
- SEMPRE usa transClass() negli enum

*Ultimo aggiornamento: 2025-01-06* 