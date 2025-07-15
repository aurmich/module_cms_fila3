<?php

// app/Filament/Components/TranslationEditor.php
namespace Modules\Lang\Filament\Forms\Components;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class TranslationEditor extends Field
{
    protected string $view = 'lang::filament.forms.components.translation-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslationEditor $component, $state) {
            $component->state($state ?? []);
        });
    }

    public function getChildComponents(): array
    {
        $components = [];
        $state = $this->getState() ?? [];
        if(!is_iterable($state)){
            return $components;
        }

        foreach ($state as $key => $value) {
            if (is_array($value)) {
                $components[] = Section::make($key)
                    ->schema([
                        TranslationEditor::make($key)
                            ->label('')
                            ->state($value)
                    ]);
            } else {
                $components[] = TextInput::make($key)
                    ->label(str_replace('_', ' ', $key))
                    ->default($value);
            }
        }

        return $components;
    }
}