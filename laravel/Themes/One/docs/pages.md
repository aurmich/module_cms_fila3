# Pagine del Tema One

## Pagine di Autenticazione

### Logout (logout.blade.php)

Con Folio + Volt, la pagina di logout è estremamente semplice e gestisce solo il redirect dopo il logout. Folio gestisce automaticamente il routing basandosi sulla struttura delle cartelle.

```php
<?php

use Illuminate\Support\Facades\Auth;

Auth::logout();

return redirect()->route('home');
```

#### Note di Implementazione

1. **Funzionamento**:
   - Il logout viene gestito automaticamente da Laravel
   - La pagina esegue solo il redirect alla home
   - Non è necessaria una vista dedicata
   - Folio gestisce automaticamente il routing basato sulla struttura delle cartelle

2. **Struttura delle Cartelle**:
   ```
   resources/
   └── views/
       └── pages/
           └── auth/
               └── logout.blade.php
   ```

3. **Collegamento nel Menu**:
   ```php
   <a href="/auth/logout" 
      class="text-gray-700 hover:text-gray-900">
      {{ __('Logout') }}
   </a>
   ```

#### Best Practices

1. **Sicurezza**:
   - Session handling gestito da Laravel
   - Middleware auth gestito tramite Folio

2. **UX**:
   - Redirect immediato
   - Nessuna conferma necessaria
   - Feedback tramite redirect

#### Collegamenti
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Documentazione Volt](https://laravel.com/docs/volt)
- [Documentazione Autenticazione Laravel](https://laravel.com/docs/authentication)

```php
@extends('pub_theme::layouts.app')

@section('title', __('Logout'))

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ __('Stai per effettuare il logout') }}
            </h2>
            
            <p class="text-gray-600 mb-6">
                {{ __('Sei sicuro di voler effettuare il logout?') }}
            </p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    {{ __('Conferma Logout') }}
                </button>
            </form>

            <div class="mt-4">
                <a href="{{ url()->previous() }}" 
                   class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Annulla e torna indietro') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### Caratteristiche

1. **Layout**:
   - Estende il layout base del tema
   - Centrato verticalmente e orizzontalmente
   - Card con ombra e bordi arrotondati

2. **Contenuto**:
   - Titolo chiaro
   - Messaggio di conferma
   - Pulsante di logout in rosso (colore di avvertimento)
   - Link per annullare e tornare indietro

3. **Sicurezza**:
   - Utilizza il token CSRF
   - POST method per il logout
   - Route protetta

4. **Accessibilità**:
   - Testi tradotti
   - Focus states per tastiera
   - Contrasto adeguato

5. **Responsive**:
   - Layout fluido
   - Padding e margini adattivi
   - Dimensioni dei testi responsive

#### Best Practices

1. **UX**:
   - Conferma esplicita richiesta
   - Possibilità di annullare
   - Feedback visivo chiaro

2. **Performance**:
   - Caricamento immediato
   - Nessun asset pesante
   - CSS ottimizzato

3. **SEO**:
   - Meta title appropriato
   - No-index per motori di ricerca
   - Struttura semantica

#### Note di Implementazione

1. **Traduzioni**:
   ```php
   // lang/it/auth.php
   return [
       'logout' => 'Logout',
       'confirm_logout' => 'Sei sicuro di voler effettuare il logout?',
       'cancel' => 'Annulla e torna indietro',
   ];
   ```

2. **Routes**:
   ```php
   // routes/web.php
   Route::post('logout', [AuthController::class, 'logout'])
       ->name('logout')
       ->middleware('auth');
   ```

3. **Controller**:
   ```php
   public function logout(Request $request)
   {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();
       
       return redirect('/');
   }
   ```

#### Test

1. **Test da Eseguire**:
   - Verifica del logout effettivo
   - Test del token CSRF
   - Verifica dei redirect
   - Test responsive
   - Verifica accessibilità

2. **Casi d'Uso**:
   - Logout normale
   - Logout con sessioni multiple
   - Logout dopo timeout
   - Logout forzato

#### Collegamenti
- [Documentazione Autenticazione Laravel](https://laravel.com/docs/authentication)
- [Best Practices Security](https://laravel.com/docs/security)
- [Accessibilità WCAG](https://www.w3.org/WAI/standards-guidelines/wcag/) 
## Collegamenti tra versioni di pages.md
* [pages.md](docs/tecnico/filament/pages.md)
* [pages.md](laravel/Themes/One/docs/pages.md)

