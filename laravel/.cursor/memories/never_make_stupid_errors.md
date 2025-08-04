# REGOLA CRITICA: MAI fare errori da deficiente cerebrale

## Data: 2025-01-06

## Errori da Deficiente Cerebrale da EVITARE SEMPRE

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

## Memoria Permanente

**RICORDA SEMPRE**: 
- MAI testare valori hardcoded
- SEMPRE testare che restituisca stringhe tradotte
- SEMPRE mostrare esempi completi
- SEMPRE struttura espansa nelle traduzioni
- SEMPRE verificare l'implementazione reale

*Ultimo aggiornamento: 2025-01-06* 