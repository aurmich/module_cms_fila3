# Sistema di Sezioni

Il sistema di sezioni è un componente fondamentale del CMS che permette di gestire aree riutilizzabili del sito attraverso un componente Blade dedicato.

## Componente Section

### Panoramica
Il componente `Section` (`Modules\Cms\View\Components\Section`) è responsabile per:
- Caricare o creare sezioni dal database
- Gestire i blocchi di contenuto
- Renderizzare il template appropriato

### Utilizzo Base
```php
<x-section 
    slug="header"           // Identificatore univoco
    class="bg-white"        // Classi CSS opzionali
    id="main-header"        // ID HTML opzionale
/>
```

### Funzionamento
1. **Ricerca/Creazione Sezione**
   ```php
   $section = SectionModel::firstOrCreate(
       ['slug' => $slug],
       [
           'title' => $slug,
           'content_blocks' => [],
           'attributes' => [
               'class' => $class,
               'id' => $id
           ]
       ]
   );
   ```

2. **Caricamento Blocchi**
   ```php
   $blocks = BlockData::collect($section->content_blocks);
   ```

3. **Rendering Template**
   ```php
   return view('pub_theme::components.sections.'.$this->slug);
   ```

## Modello Section

### Schema
```php
Schema::create('sections', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('slug')->unique();
    $table->json('name');
    $table->json('content_blocks')->nullable();
    $table->json('attributes')->nullable();
    $table->timestamps();
});
```

### Relazioni
- Può contenere multipli blocchi di contenuto
- Può essere utilizzata in multiple pagine
- Supporta attributi personalizzati

## Template delle Sezioni

### Struttura Base
```blade
@props([
    'section' => null,
    'blocks' => [],
    'class' => ''
])

<div {{ $attributes->merge([
    'class' => ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    {{-- Rendering dei blocchi --}}
    @foreach($blocks as $block)
        <x-dynamic-component 
            :component="'cms::blocks.'.$block['type']"
            :data="$block['data']"
        />
    @endforeach
</div>
```

### Convenzioni
1. I template devono essere nella directory `components/sections/` del tema
2. Il nome del file deve corrispondere allo slug della sezione
3. Devono supportare i props standard (`section`, `blocks`, `class`)

## Best Practices

1. **Organizzazione**:
   - Una sezione per scopo specifico
   - Riutilizzo attraverso il sito
   - Mantenere la coerenza

2. **Blocchi**:
   - Utilizzare blocchi appropriati
   - Gestire stati vuoti
   - Validare i dati

3. **Performance**:
   - Cache delle sezioni
   - Lazy loading quando appropriato
   - Ottimizzazione query

4. **Manutenibilità**:
   - Documentare le sezioni
   - Versionare i template
   - Testing appropriato

## Collegamenti

- [Documentazione Temi](../../Themes/One/docs/sections.md)
- [Gestione Blocchi](blocks/README.md)
- [Componenti View](components.md)
- [Best Practices](best-practices/index.md) 

## Collegamenti tra versioni di sections.md
* [sections.md](docs/sections.md)
* [sections.md](laravel/Modules/Cms/docs/sections.md)
* [sections.md](laravel/Themes/One/docs/sections.md)

