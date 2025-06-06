<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Components;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

/**
 * Componente specifico per l'upload della tessera sanitaria.
 * 
 * Filosofia: Modularità e specificità per il contesto paziente.
 * Politica: GDPR compliance, audit trail, validazione specifica.
 * Zen: Ogni modulo gestisce i propri componenti specifici.
 */
class HealthCardUpload
{
    /**
     * Configurazione specifica per l'upload della tessera sanitaria.
     *
     * @return SpatieMediaLibraryFileUpload
     */
    public static function make(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('health_card')
            ->label('Tessera sanitaria, STP o ENI')
            ->collection('tessere_sanitarie')
            ->disk('private')
            ->preserveFilenames()
            ->openable()
            ->downloadable()
            ->previewable()
            ->maxSize(5120) // 5MB per documenti leggeri
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
            ->imagePreviewHeight('150')
            ->loadingIndicatorPosition('left')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('left')
            ->uploadProgressIndicatorPosition('left')
            ->columnSpanFull();
    }
} 