# Modulo Xot - Documentazione

## 🚀 Panoramica

Il modulo **Xot** è il **cuore architetturale** di tutto il framework Laraxot SaluteOra. Fornisce le classi base, i trait fondamentali, gli helper e l'infrastruttura comune utilizzata da tutti gli altri moduli.

## 🔧 Componenti Principali

### Models Base
- `XotBaseModel` - Classe base per tutti i modelli
- `BaseMorphPivot` - Pivot polimorfico base
- `BaseModel` specifici per ogni modulo

### Filament Base Classes
- `XotBaseResource` - Risorsa Filament base
- `XotBasePage` - Pagina Filament base  
- `XotBaseWidget` - Widget Filament base
- `XotBaseListRecords` - Lista record base

### Providers e Servizi
- `XotBaseServiceProvider` - Service provider base
- `XotBaseRouteServiceProvider` - Route provider base
- **XotComposer** - View composer globale (⚡ **Recentemente Corretto**)

### Migrations e Database
- `XotBaseMigration` - Classe base per migrazioni
- Helper per gestione schema database
- **Correzione Dependency Cycles** (🔧 **Fix Dicembre 2024**)

## 🚨 **Correzioni Critiche Recenti**

### **XotComposer Loop Infinito Fix** 
**Status**: ✅ **RISOLTO** (Dicembre 2024)

Il `XotComposer` aveva un dependency cycle critico che causava:
```
Xdebug has detected a possible infinite loop, and aborted your script with a stack depth of '256' frames
```

**Fix Implementato**:
- ✅ **Static Flag Guard** per prevenire chiamate ricorsive
- ✅ **isAuthenticationSafe()** per controlli Auth sicuri  
- ✅ **Try-Finally Pattern** per resource cleanup
- ✅ **Graceful Error Handling** senza bloccare rendering

**Impatto**: Sistema completamente funzionale, pagine di registrazione operative

**Documentazione**: [view-composer-loop-infinite-fix.md](view-composer-loop-infinite-fix.md)

### **Sushi Models Dependency Cycle Fix**
**Status**: ✅ **RISOLTO** (Dicembre 2024)

I modelli Sushi (es. `Modules\Geo\Models\Comune`) causavano loop infiniti con `module_path()`.

**Fix Implementato**:
- ✅ Sostituzione `module_path()` con `base_path()` 
- ✅ Prevenzione dependency cycles nel bootstrap
- ✅ Documentazione regole per modelli Sushi

**Documentazione**: [sushi-models-dependency-cycle-fix.md](../Geo/docs/sushi-models-dependency-cycle-fix.md)

## 🧬 **Architettura e Filosofia**

### **Principi Fondamentali**
- **DRY (Don't Repeat Yourself)**: Logica comune centralizzata nel modulo Xot
- **KISS (Keep It Simple Stupid)**: Semplicità prima di tutto
- **Single Responsibility**: Ogni classe ha un solo scopo ben definito
- **Dependency Injection**: Uso del container Laravel per dependency resolution

### **Pattern Architetturali**
- **STI (Single Table Inheritance)**: Per gestione tipi utente (Patient, Doctor, Admin)
- **Multi-Tenancy**: Isolamento dati per studi medici
- **Event-Driven**: Sistema di eventi per azioni cruciali
- **Modular Design**: Architettura modulare con namespace dedicati

### **Governance del Codice**
- **Prevenzione > Cura**: Controlli preventivi per evitare errori critici
- **Performance First**: Ottimizzazioni per ridurre latenza e memory usage  
- **Security by Design**: Sicurezza integrata dall'architettura
- **Monitoring & Logging**: Observability completa per debugging

## 📚 **Guide e Best Practices**

### **Development Guidelines**
- Estendere sempre le classi Xot appropriate (`XotBaseResource`, `XotBasePage`, etc.)
- Utilizzare i trait del modulo User per funzionalità comuni
- Seguire le convenzioni di naming e namespace
- Implementare sempre tipo safety con PHPStan livello 9+

### **Performance Best Practices**
- Eager loading per prevenire N+1 queries
- Caching strategico per operazioni costose
- Lazy loading per componenti non critici
- Database indexing appropriato

### **Security Guidelines**  
- Validazione input sempre tramite Form Requests
- Autorizzazione tramite Gates e Policies
- Sanitizzazione output per prevenire XSS
- CSRF protection per tutte le form

## 🔗 **Collegamenti e Documentazione**

### **Documentazione Tecnica**
- [View Composer Loop Prevention](view-composer-loop-infinite-fix.md)
- [Sushi Models Best Practices](../Geo/docs/sushi-models-dependency-cycle-fix.md)
- [Filament Base Classes](filament/README.md)
- [Migration Guidelines](migration-guidelines.md)

### **Regole di Sviluppo**
- [View Composer Rules](../../.cursor/rules/view-composer-infinite-loop-prevention.mdc)
- [Sushi Models Rules](../../.cursor/rules/sushi-models-dependency-cycle-prevention.mdc)
- [Filament Best Practices](../../.cursor/rules/filament-best-practices.mdc)

### **Collegamenti Root**
- [Documentazione Globale](../../../docs/README.md)
- [Architecture Overview](../../../docs/architecture.md)
- [Performance Guidelines](../../../docs/performance.md)

## ⚡ **Quick Start**

### **Estendere una Risorsa Filament**
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;
    
    // Solo metodi specifici, navigationGroup gestito dalla base
}
```

### **Creare una Migrazione**
```php
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
    // No down() method needed
};
```

### **Implementare un Widget**
```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyWidget extends XotBaseWidget
{
    protected static string $view = 'my-module::filament.widgets.my-widget';
    
    public static function canView(): bool
    {
        return auth()->user()?->can('view-widget');
    }
}
```

## 📊 **Metrics e Performance**

### **Performance Targets**
- View Composer execution: < 5ms
- Database queries: < 100ms per page
- Memory usage: < 128MB per request
- Page load time: < 2s

### **Error Prevention**
- ✅ Zero tolerance per loop infiniti
- ✅ Graceful degradation per servizi esterni
- ✅ Comprehensive error logging
- ✅ Automated testing per componenti critici

---

**Ultimo aggiornamento**: Dicembre 2024  
**Versione**: 2.1.0  
**Compatibilità**: Laravel 12+, PHP 8.3+  
**Status**: 🟢 **Production Ready** - Tutti i loop infiniti risolti 