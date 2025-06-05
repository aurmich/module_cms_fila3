# Best Practices per la Riusabilità dei Temi

## Principio Fondamentale: Indipendenza dal Progetto

I temi devono essere completamente indipendenti dal progetto specifico in cui vengono utilizzati. Questo permette il loro riutilizzo in diversi progetti senza modifiche.

## ❌ Errori Comuni da Evitare

### 1. Riferimenti Diretti al Progetto

**SBAGLIATO:**
```php
// Themes/One/resources/views/components/layouts/footer.blade.php
<footer>
    <p>© {{ date('Y') }} il progetto. Tutti i diritti riservati.</p> // ❌ Riferimento hardcoded al progetto
    <nav>
        <a href="{{ route('saluteora.privacy') }}">Privacy</a> // ❌ Route specifica del progetto
    </nav>
</footer>
```

**CORRETTO:**
```php
// Themes/One/resources/views/components/layouts/footer.blade.php
<footer>
    <p>© {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p> // ✅ Utilizzo di configurazione
    <nav>
        @foreach($links ?? [] as $link)
            <x-filament::link :href="$link['url']">{{ $link['title'] }}</x-filament::link> // ✅ Link Filament
        @endforeach
    </nav>
</footer>
```

### 2. Configurazioni Specifiche del Progetto

**SBAGLIATO:**
```php
// Themes/One/config/theme.php
return [
    'social_links' => [
        'facebook' => 'https://facebook.com/saluteora', // ❌ URL hardcoded
    ],
];
```

**CORRETTO:**
```php
// Themes/One/config/theme.php
return [
    'social_links' => [
        'facebook' => config('services.facebook.url'), // ✅ Utilizzo di configurazione
    ],
];
```

## Best Practices

### 1. Utilizzo di Componenti Filament
- Utilizzare `x-filament::link` per i link
- Utilizzare `x-filament::icon-button` per i pulsanti con icone
- Utilizzare `x-filament::button` per i pulsanti standard
- Sfruttare i componenti Filament per mantenere la coerenza UI

### 2. Gestione dei Link
```php
@props([
    'links' => [], // Array vuoto come default
    'socialLinks' => [], // Configurabile dall'applicazione
])
```

### 3. Struttura dei Componenti
- Mantenere i componenti generici e configurabili
- Utilizzare props per passare dati specifici
- Evitare dipendenze da funzionalità specifiche del progetto
- Utilizzare i componenti Filament quando disponibili

### 4. Override dei Componenti
```php
// Nel progetto specifico
// App/Providers/ThemeServiceProvider.php
public function boot()
{
    Theme::override('one::layouts.footer', 'components.theme.footer');
}
```

## Implementazione Corretta

### 1. Struttura del Componente
```php
// Themes/One/resources/views/components/layouts/footer.blade.php
@props([
    'links' => [],
    'copyrightText' => null,
    'showSocial' => false,
    'socialLinks' => [],
])

<footer {{ $attributes->class(['theme-footer']) }}>
    <div class="container">
        <p>{{ $copyrightText ?? '© ' . date('Y') . ' ' . config('app.name') }}</p>
        
        @if($links)
            <nav>
                @foreach($links as $link)
                    <x-filament::link :href="$link['url']">{{ $link['title'] }}</x-filament::link>
                @endforeach
            </nav>
        @endif
        
        @if($showSocial)
            <div class="social-links">
                @foreach($socialLinks as $social)
                    <x-filament::icon-button
                        :icon="$social['icon']"
                        :href="$social['url']"
                        :aria-label="$social['title']"
                        color="gray"
                    />
                @endforeach
            </div>
        @endif
    </div>
</footer>
```

### 2. Utilizzo nel Progetto
```php
// Nel progetto specifico
<x-one::layouts.footer 
    :links="config('project.footer.links')"
    :social-links="config('project.social.links')"
    show-social
/>
```

## Vantaggi della Riusabilità

1. **Manutenibilità**
   - Aggiornamenti più semplici
   - Bug fix centralizzati
   - Miglior gestione delle versioni
   - Coerenza con Filament

2. **Scalabilità**
   - Facilità di riutilizzo in nuovi progetti
   - Personalizzazione senza modificare il tema
   - Separazione delle responsabilità
   - Integrazione con Filament

3. **Standardizzazione**
   - Coerenza tra progetti diversi
   - Best practices condivise
   - Documentazione standardizzata
   - UI/UX uniforme

## Checklist di Verifica

- [ ] Nessun riferimento hardcoded al progetto specifico
- [ ] Tutte le stringhe sono configurabili
- [ ] I link sono passati come props
- [ ] Le route sono gestite dall'applicazione
- [ ] Le configurazioni sono generiche
- [ ] Il tema è testabile in isolamento
- [ ] La documentazione non contiene riferimenti al progetto
- [ ] Utilizzo dei componenti Filament quando disponibili

## Collegamenti

- [Documentazione Tema One](../README.md)
- [Configurazione del Tema](../config.md)
- [Override dei Componenti](../components.md)
- [Testing](../testing.md)
- [Documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/button) 

## Collegamenti tra versioni di theme-reusability.md
* [theme-reusability.md](laravel/Modules/Cms/docs/best-practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/best_practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/theme-reusability.md)

