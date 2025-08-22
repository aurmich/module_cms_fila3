# REGOLE XotBaseResource

## REGOLA CRITICA: Mai implementare table() in classi che estendono XotBaseResource

### Problema
Il metodo `table()` NON deve MAI essere implementato nelle classi che estendono `XotBaseResource`.

### Motivo
- `XotBaseResource` fornisce già la configurazione base per le tabelle
- Sovrascrivere il metodo `table()` causa errori e conflitti
- L'architettura XotBase gestisce automaticamente la configurazione delle tabelle

### Cosa NON fare
```php
class MyResource extends XotBaseResource 
{
    // ❌ MAI fare questo!
    public static function table(Table $table): Table
    {
        return $table->columns([
            // ...
        ]);
    }
}
```

### Cosa fare invece
```php
class MyResource extends XotBaseResource 
{
    // ✅ Lasciare che XotBaseResource gestisca la tabella
    // ✅ Concentrarsi su form(), infolist(), etc.
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Configurazione del form
        ]);
    }
}
```

### Principi da seguire
1. **Rispettare l'architettura XotBase**: Non sovrascrivere i metodi che XotBase gestisce automaticamente
2. **Controllare la documentazione**: Prima di implementare qualsiasi metodo, verificare se è già gestito da XotBase
3. **Seguire i pattern esistenti**: Guardare altri Resource nel progetto per vedere cosa implementano e cosa no
4. **Focus sul business logic**: Concentrarsi sulla logica specifica del Resource, non sulla configurazione base

### Note aggiuntive
- Questa regola si applica a tutti i metodi che XotBaseResource potrebbe gestire automaticamente
- Sempre verificare la documentazione e il codice sorgente di XotBase prima di aggiungere override
- In caso di dubbi, seguire il principio "less is more" - non aggiungere codice se non strettamente necessario