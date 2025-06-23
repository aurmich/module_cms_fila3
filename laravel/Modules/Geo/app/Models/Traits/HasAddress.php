<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Modules\Geo\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasAddress
 * 
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Address> $addresses
 */
trait HasAddress
{
    /**
     * Ottiene gli indirizzi associati al modello.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }
    
    /**
     * Ottiene indirizzo associato al modello.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }
    
    /**
     * Ottiene l'indirizzo principale del modello.
     *
     * @return \Modules\Geo\Models\Address|null
     */
    public function primaryAddress(): ?Address
    {
        return $this->addresses()->where('is_primary', true)->first();
    }
    
    /**
     * Ottiene l'indirizzo completo formattato.
     *
     * @return string|null
     */
    public function getFullAddress(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->getFullAddress() : null;
    }
    
    /**
     * Ottiene la località dell'indirizzo principale.
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->locality : null;
    }
    
    /**
     * Ottiene il CAP dell'indirizzo principale.
     *
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->postal_code : null;
    }
    
    /**
     * Ottiene la provincia dell'indirizzo principale.
     *
     * @return string|null
     */
    public function getProvince(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->administrative_area_level_3 : null;
    }
    
    /**
     * Ottiene la regione dell'indirizzo principale.
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->administrative_area_level_2 : null;
    }
    
    /**
     * Ottiene il paese dell'indirizzo principale.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        $address = $this->primaryAddress();
        return $address ? $address->country : null;
    }
    
    /**
     * Imposta un indirizzo come principale e rimuove il flag da tutti gli altri.
     *
     * @param \Modules\Geo\Models\Address $address
     * @return bool
     */
    public function setAsPrimaryAddress(Address $address): bool
    {
        // Verifica che l'indirizzo appartenga a questo modello
        if ($address->model_id != $this->id || $address->model_type != get_class($this)) {
            return false;
        }
        
        // Rimuovi il flag is_primary da tutti gli altri indirizzi
        $this->addresses()
            ->where('id', '!=', $address->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
        
        // Imposta questo indirizzo come principale
        return $address->update(['is_primary' => true]);
    }
    
    /**
     * Ottiene gli indirizzi di un determinato tipo.
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAddressesByType(string $type)
    {
        return $this->addresses()->where('type', $type)->get();
    }
    
    /**
     * Aggiunge un nuovo indirizzo al modello.
     *
     * @param array<string, mixed> $data
     * @param bool $setPrimary Se impostare questo indirizzo come principale
     * @return \Modules\Geo\Models\Address
     */
    public function addAddress(array $data, bool $setPrimary = false): Address
    {
        // Se è il primo indirizzo o è richiesto esplicitamente, impostalo come principale
        if ($setPrimary || $this->addresses()->count() === 0) {
            $data['is_primary'] = true;
            
            // Rimuovi il flag is_primary da tutti gli altri indirizzi
            if ($this->addresses()->count() > 0) {
                $this->addresses()->update(['is_primary' => false]);
            }
        }
        
        return $this->addresses()->create($data);
    }
    
    /**
     * Aggiorna l'indirizzo principale.
     *
     * @param array<string, mixed> $data
     * @return \Modules\Geo\Models\Address|null
     */
    public function updatePrimaryAddress(array $data): ?Address
    {
        $primaryAddress = $this->primaryAddress();
        
        if (!$primaryAddress) {
            return $this->addAddress($data, true);
        }
        
        $primaryAddress->update($data);
        return $primaryAddress;
    }
    
    /**
     * Scope per filtrare i modelli in base alla città dell'indirizzo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $city
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCity($query, string $city)
    {
        return $query->whereHas('addresses', function ($q) use ($city) {
            $q->where('locality', $city);
        });
    }
    
    /**
     * Scope per filtrare i modelli in base alla provincia dell'indirizzo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $province
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProvince($query, string $province)
    {
        return $query->whereHas('addresses', function ($q) use ($province) {
            $q->where('administrative_area_level_3', $province);
        });
    }
    
    /**
     * Scope per filtrare i modelli in base alla regione dell'indirizzo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $region
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->whereHas('addresses', function ($q) use ($region) {
            $q->where('administrative_area_level_2', $region);
        });
    }
    
    /**
     * Scope per filtrare i modelli in base al CAP dell'indirizzo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $postalCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPostalCode($query, string $postalCode)
    {
        return $query->whereHas('addresses', function ($q) use ($postalCode) {
            $q->where('postal_code', $postalCode);
        });
    }
}