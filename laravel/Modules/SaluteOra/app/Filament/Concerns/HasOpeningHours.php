<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Concerns;

use Spatie\OpeningHours\OpeningHours;
use DateTimeInterface;

trait HasOpeningHours
{
    public function initializeHasOpeningHours(): void
    {
        $this->casts['opening_hours'] = 'json';
    }
    
    public function getOpeningHoursAttribute($value)
    {
        return json_decode($value, true) ?? [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ];
    }
    
    public function setOpeningHoursAttribute($value)
    {
        $this->attributes['opening_hours'] = is_array($value) ? json_encode($value) : $value;
    }
    
    public function getOpeningHoursInstance(): OpeningHours
    {
        return OpeningHours::create($this->opening_hours);
    }
    
    public function isOpenAt(DateTimeInterface $dateTime): bool
    {
        return $this->getOpeningHoursInstance()->isOpenAt($dateTime);
    }
    
    public function isClosedAt(DateTimeInterface $dateTime): bool
    {
        return $this->getOpeningHoursInstance()->isClosedAt($dateTime);
    }
    
    public function isOpenNow(): bool
    {
        return $this->getOpeningHoursInstance()->isOpen();
    }
    
    public function isClosedNow(): bool
    {
        return $this->getOpeningHoursInstance()->isClosed();
    }
    
    public function nextOpen(?DateTimeInterface $from = null): ?DateTimeInterface
    {
        return $this->getOpeningHoursInstance()->nextOpen($from);
    }
    
    public function nextClose(?DateTimeInterface $from = null): ?DateTimeInterface
    {
        return $this->getOpeningHoursInstance()->nextClose($from);
    }
}