<?php

declare(strict_types=1);

namespace Modules\Predict\Filament\Resources\PredictResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Pages\EditRecord;
use Modules\Predict\Actions\Article\TranslateContentAction;
use Modules\Predict\Filament\Resources\PredictResource;
use Modules\Predict\Models\Predict;

class EditPredict extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PredictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('translate')
                ->label('Copia Blocchi nelle altre lingue')
                ->tooltip('translate')
                ->icon('heroicon-o-language')
                ->requiresConfirmation()
                ->modalDescription('Assicurati che la versione italiana sia stata settata e salvata')
                ->form([
                    Checkbox::make('content_blocks')->inline(),
                    Checkbox::make('sidebar_blocks')->inline(),
                    Checkbox::make('footer_blocks')->inline(),
                ])
                ->action(function (Predict $record, PredictResource $article_resource, array $data) {
                    app(TranslateContentAction::class)->execute(
                        'article',
                        $record->id, $article_resource->getTranslatableLocales(),
                        $data,
                        Predict::class
                    );
                }),
        ];
    }
}
