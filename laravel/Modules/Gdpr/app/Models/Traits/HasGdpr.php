<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Enums\ConsentType;

/**
 * Trait HasGdpr
 * 
 * Provides GDPR-related functionality for Eloquent models.
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Consent> $consents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Consent> $activeConsents
 */
trait HasGdpr
{
    /**
     * Get all consents for the model (polymorphic).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\Modules\Gdpr\Models\Consent, $this>
     */
    public function consents(): MorphMany
    {
        return $this->morphMany(Consent::class, 'user');
    }

    /**
     * Get only active (non-revoked) consents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<\Modules\Gdpr\Models\Consent, $this>
     */
    public function activeConsents(): MorphMany
    {
        return $this->consents()->whereNull('revoked_at');
    }
    
    /**
     * Get the treatments associated with the user through consents.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<\Modules\Gdpr\Models\Treatment, \Modules\Gdpr\Models\Consent, $this>
     */
    public function treatments()
    {
        return $this->hasManyThrough(
            Treatment::class,
            Consent::class,
            'user_id', // Foreign key on consents table
            'id', // Foreign key on treatments table
            'id', // Local key on users table
            'treatment_id' // Local key on consents table
        )->where('consents.user_type', get_class($this));
    }

    /**
     * Check if the user has given a specific consent.
     * 
     * @param  ConsentType|string  $type
     * @param  bool  $cached  Use cached version if available
     * @return bool
     */
    public function hasGivenConsent(ConsentType|string $type, bool $cached = true): bool
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        $cacheKey = 'user_' . (string) $this->getKey() . '_consent_' . $type;
        
        if ($cached && Cache::has($cacheKey)) {
            return (bool) Cache::get($cacheKey);
        }

        $hasConsent = $this->activeConsents()
            ->where('type', $type)
            ->exists();

        Cache::put($cacheKey, $hasConsent, now()->addDay());

        return $hasConsent;
    }

    /**
     * Give consent for a specific type.
     * 
     * @param  ConsentType|string  $type
     * @param  array<string, mixed>  $metadata
     * @return \Modules\Gdpr\Models\Consent
     */
    public function giveConsent(ConsentType|string $type, array $metadata = []): Consent
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        
        /** @var \Modules\Gdpr\Models\Consent $consent */
        $consent = $this->consents()->create([
            'type' => $type,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'accepted_at' => now(),
        ]);

        $this->clearConsentCache($type);
        
        return $consent;
    }

    /**
     * Revoke a specific consent.
     * 
     * @param  ConsentType|string  $type
     * @return bool
     */
    public function revokeConsent(ConsentType|string $type): bool
    {
        $type = $type instanceof ConsentType ? $type->value : $type;
        
        $updated = $this->activeConsents()
            ->where('type', $type)
            ->update([
                'revoked_at' => now(),
                'revoked_ip_address' => request()->ip(),
            ]);

        if ($updated > 0) {
            $this->clearConsentCache($type);
            return true;
        }

        return false;
    }

    /**
     * Clear cached consent status.
     * 
     * @param  string  $type
     * @return void
     */
    protected function clearConsentCache(string $type): void
    {
        $cacheKey = 'user_' . (string) $this->getKey() . '_consent_' . $type;
        Cache::forget($cacheKey);
    }

    /**
     * Get all required consents that the user hasn't given yet.
     * 
     * @return array<string, string>
     */
    public function getMissingRequiredConsents(): array
    {
        $givenConsents = $this->activeConsents()
            ->pluck('type')
            ->toArray();

        return array_diff(
            ConsentType::getRequiredConsentTypes(),
            $givenConsents
        );
    }

    /**
     * Check if user has given all required consents.
     * 
     * @return bool
     */
    public function hasAllRequiredConsents(): bool
    {
        return empty($this->getMissingRequiredConsents());
    }
}
