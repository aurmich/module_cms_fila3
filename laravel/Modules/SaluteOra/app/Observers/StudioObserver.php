<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Observers;

use Illuminate\Support\Str;
use Modules\SaluteOra\Models\Studio;

/**
 * Observer per il modello Studio.
 * 
 * Si occupa di generare automaticamente lo slug e altre operazioni
 * prima della creazione o dell'aggiornamento di uno Studio.
 */
class StudioObserver
{
    /**
     * Handle events before a Studio is created.
     */
    public function creating(Studio $studio): void
    {
        // Genera lo slug dal nome se non è già impostato
        if (empty($studio->slug)) {
            $studio->slug = $this->generateUniqueSlug($studio->name);
        }
    }

    /**
     * Handle events before a Studio is updated.
     */
    public function updating(Studio $studio): void
    {
        // Aggiorna lo slug solo se il nome è cambiato e lo slug non è stato esplicitamente modificato
        $dirtyAttributes = $studio->getDirty();
        
        if (isset($dirtyAttributes['name']) && !isset($dirtyAttributes['slug'])) {
            $studio->slug = $this->generateUniqueSlug($studio->name, $studio->id);
        }
    }

    /**
     * Genera uno slug unico basato sul nome dello studio.
     *
     * @param string $name Il nome da cui generare lo slug
     * @param int|null $excludeId ID dello studio da escludere dalla verifica (per aggiornamenti)
     * @return string Slug univoco
     */
    protected function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Verifica se lo slug esiste già, escludendo l'ID corrente se specificato
        $query = Studio::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        // Se lo slug esiste già, aggiungi un contatore incrementale
        while ($query->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
            $query = Studio::where('slug', $slug);
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}
