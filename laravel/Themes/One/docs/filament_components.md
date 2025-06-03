# Utilizzo dei Componenti Filament in il progetto
> **Collegamenti correlati**
> - [filament-components.md modulo CMS](../../../../Modules/Cms/docs/filament-components.md)

# Utilizzo dei Componenti Filament in SaluteOra

## Regola Fondamentale

In il progetto, **privilegiare sempre i componenti Blade nativi di Filament** rispetto a componenti UI personalizzati.



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

## Componenti Comuni

I più utilizzati nel Theme One:

```blade
<!-- Button -->
<x-filament::button>Pulsante</x-filament::button>

<!-- Badge -->
<x-filament::badge>Status</x-filament::badge>

<!-- Card -->
<x-filament::card>Contenuto</x-filament::card>

<!-- Alert -->
<x-filament::alert color="success">Messaggio</x-filament::alert>
```

Per la documentazione completa e altri componenti, consultare il documento principale in `/docs/rules/filament-components.md`.

## Link alla Documentazione

- [Documentazione principale](/docs/rules/filament-components.md)
- [Documentazione ufficiale Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)

## Collegamenti tra versioni di FILAMENT_COMPONENTS.md
* [FILAMENT_COMPONENTS.md](laravel/Modules/Xot/docs/FILAMENT_COMPONENTS.md)
* [FILAMENT_COMPONENTS.md](laravel/Themes/One/docs/FILAMENT_COMPONENTS.md)

