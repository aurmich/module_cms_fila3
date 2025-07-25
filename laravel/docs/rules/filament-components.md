# Utilizzo dei Componenti Filament in il progetto

## Regola Fondamentale

In il progetto, **privilegiare sempre i componenti Blade nativi di Filament** rispetto a componenti UI personalizzati.

> ⚠️ **Collegamenti alla documentazione correlata**:
> - [Documentazione nel modulo CMS](../../Modules/Cms/docs/filament-components.md)
> - [Documentazione nel tema](../../Themes/One/docs/FILAMENT_COMPONENTS.md)
> - [Indice generale dei collegamenti](../../docs/collegamenti-documentazione.md)

## Motivazione

1. **Coerenza UI/UX**: I componenti Filament garantiscono uniformità visiva tra l'area pubblica e l'area amministrativa
2. **Manutenibilità**: Gli aggiornamenti di Filament si propagano automaticamente a tutti i componenti
3. **Accessibilità**: I componenti Filament sono progettati con standard di accessibilità elevati
4. **Dark Mode**: Supporto nativo per tema chiaro/scuro
5. **Documentazione**: Ampia documentazione ufficiale e community attiva
6. **Sviluppo più rapido**: Meno codice da scrivere e mantenere

## Esempi Corretti e Incorretti

### ❌ Non Utilizzare Componenti UI Personalizzati

```blade
<!-- Approccio SCORRETTO -->
<a href="{{ route('register.type', ['type'=>$type]) }}">
    <x-ui.button class="w-full">{{ ucfirst($type) }}</x-ui.button>
</a>
```

### ✅ Utilizzare Componenti Filament

```blade
<!-- Approccio CORRETTO -->
<x-filament::button size="sm" href="{{ route('register.type', ['type'=>$type]) }}" tag="a">
    {{ ucfirst($type) }}
</x-filament::button>
```

## Componenti Filament Disponibili

Filament offre una vasta gamma di componenti Blade riutilizzabili. Di seguito i principali:

### 1. Button

```blade
<x-filament::button>
    Pulsante Base
</x-filament::button>

<x-filament::button 
    color="success"           {{-- primary, secondary, success, warning, danger --}}
    size="md"                {{-- xs, sm, md, lg, xl --}}
    icon="heroicon-o-plus"   {{-- qualsiasi icona Heroicon --}}
    icon-position="before"   {{-- before, after --}}
    href="/path"             {{-- trasforma il bottone in un link --}}
    tag="a"                  {{-- necessario per i link --}}
    outlined                 {{-- stile outline --}}
>
    Pulsante Avanzato
</x-filament::button>
```

### 2. Badge

```blade
<x-filament::badge>
    Base
</x-filament::badge>

<x-filament::badge 
    color="success"         {{-- primary, secondary, success, warning, danger --}}
    size="md"              {{-- xs, sm, md, lg --}}
    icon="heroicon-o-check" {{-- qualsiasi icona Heroicon --}}
>
    Completato
</x-filament::badge>
```

### 3. Card

```blade
<x-filament::card>
    <x-slot name="header">
        Intestazione Card
    </x-slot>

    Contenuto Card

    <x-slot name="footer">
        Footer Card
    </x-slot>
</x-filament::card>
```

### 4. Form Components

```blade
<x-filament::input.wrapper>
    <x-filament::input 
        type="text" 
        wire:model="name" 
        placeholder="Nome" 
    />
</x-filament::input.wrapper>

<x-filament::input.wrapper>
    <x-filament::input.select wire:model="country">
        <option value="IT">Italia</option>
        <option value="US">Stati Uniti</option>
    </x-filament::input.select>
</x-filament::input.wrapper>
```

## Best Practices

1. **Mai Sovrascrivere gli Stili Base**: Estendere i componenti Filament aggiungendo classi CSS, non sovrascrivendo quelle esistenti
2. **Utilizzare Props Documentate**: Consultare la [documentazione ufficiale](https://filamentphp.com/docs/3.x/support/blade-components/overview) per le props disponibili
3. **Dark Mode**: Utilizzare le funzionalità native di dark mode invece di implementazioni personalizzate
4. **Estensibilità**: Sfruttare gli slot per personalizzare sezioni specifiche dei componenti

## Gestione Eccezioni

Se in casi specifici e limitati è necessario utilizzare componenti personalizzati:

1. Documentare la motivazione
2. Assicurarsi che il componente replichi fedelmente il design system di Filament
3. Mantenere un registro delle eccezioni per future revisioni

## Riferimenti

- [Documentazione ufficiale](https://filamentphp.com/docs/3.x/support/blade-components/overview)
- [Demo dei componenti](https://demo.filamentphp.com/)

## Collegamenti tra versioni di filament-components.md
* [filament-components.md](laravel/Modules/User/docs/best-practices/filament-components.md)
* [filament-components.md](laravel/Modules/Cms/docs/best-practices/filament-components.md)
* [filament-components.md](laravel/Modules/Cms/docs/filament-components.md)
* [filament-components.md](laravel/docs/rules/filament-components.md)

