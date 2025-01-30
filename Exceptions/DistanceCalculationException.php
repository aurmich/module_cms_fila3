<?php

declare(strict_types=1);

namespace Modules\Geo\Exceptions;

use RuntimeException;

/**
 * Eccezione lanciata quando si verificano errori durante il calcolo della distanza.
 */
class DistanceCalculationException extends RuntimeException
{
    /**
     * Crea una nuova istanza per coordinate non valide.
     */
    public static function invalidCoordinates(string $message = 'Coordinate non valide'): self
    {
        return new self($message);
    }

    /**
     * Crea una nuova istanza per errore di calcolo.
     */
    public static function calculationError(string $message, ?\Throwable $previous = null): self
    {
        return new self($message, 0, $previous);
    }
} 