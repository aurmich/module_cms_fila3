# Regole per i Percorsi e i Namespace in Moduli Laravel

## Percorsi del Filesystem

1. **Directory Standard SEMPRE in Lowercase**
   - `app/` (✅ CORRETTO)
   - `App/` (❌ ERRATO)
   - `config/` (✅ CORRETTO)
   - `Config/` (❌ ERRATO)
   - `resources/` (✅ CORRETTO)
   - `Resources/` (❌ ERRATO)

2. **Struttura dei Moduli**
   - `/var/www/html/saluteora/laravel/Modules/Notify/app/` (✅ CORRETTO)
   - `/var/www/html/saluteora/laravel/Modules/Notify/App/` (❌ ERRATO)

## Namespace PHP

1. **Mapping PSR-4 nei Moduli**
   ```json
   "autoload": {
       "psr-4": {
           "Modules\\Notify\\": "app/"
       }
   }
   ```

2. **Namespace Corretti**
   - `namespace Modules\Notify\Actions;` (✅ CORRETTO)
   - `namespace Modules\Notify\App\Actions;` (❌ ERRATO)
   - `namespace Modules\Notify\Datas;` (✅ CORRETTO)
   - `namespace Modules\Notify\App\Datas;` (❌ ERRATO)

## Errori Critici da Evitare

1. **MAI usare `App` maiuscola nei percorsi fisici**
   - Anche se in PHP i namespace possono usare PascalCase, le directory devono seguire le convenzioni standard di Laravel

2. **MAI inserire il segmento `App` nei namespace dei moduli**
   - Il mapping PSR-4 già definisce correttamente la radice del namespace

3. **SEMPRE verificare il composer.json del modulo**
   - Prima di definire namespace, verificare sempre come è configurato l'autoload PSR-4

4. **MAI assumere che il namespace segua esattamente la struttura delle directory**
   - Verificare sempre il mapping PSR-4 specifico del modulo
