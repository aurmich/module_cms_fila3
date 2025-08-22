<?php

declare(strict_types=1);

use Modules\UI\Enums\TableLayoutEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Stack;

it('has correct enum values', function (): void {
    expect(TableLayoutEnum::LIST->value)->toBe('list')
        ->and(TableLayoutEnum::GRID->value)->toBe('grid');
});

it('has correct default layout', function (): void {
    $default = TableLayoutEnum::init();
    expect($default)->toBe(TableLayoutEnum::LIST);
});

it('can toggle layout', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    expect($list->toggle())->toBe($grid)
        ->and($grid->toggle())->toBe($list);
});

it('can check layout types', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    expect($list->isListLayout())->toBeTrue()
        ->and($list->isGridLayout())->toBeFalse()
        ->and($grid->isGridLayout())->toBeTrue()
        ->and($grid->isListLayout())->toBeFalse();
});

it('has grid configuration', function (): void {
    $grid = TableLayoutEnum::GRID;
    $config = $grid->getTableContentGrid();

    expect($config)->toBeArray()
        ->toHaveKeys(['sm', 'md', 'lg', 'xl', '2xl']);
});

it('can get table columns', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listColumns = [
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];

    $gridColumns = [
        Stack::make([
            TextColumn::make('name'),
            TextColumn::make('email'),
        ]),
    ];

    expect($list->getTableColumns($listColumns, $gridColumns))->toEqual($listColumns)
        ->and($grid->getTableColumns($listColumns, $gridColumns))->toEqual($gridColumns);
});

it('can get options', function (): void {
    $options = TableLayoutEnum::getOptions();

    expect($options)->toBeArray()
        ->toHaveKeys(['list', 'grid'])
        ->and($options['list'])->toBe(TableLayoutEnum::LIST)
        ->and($options['grid'])->toBe(TableLayoutEnum::GRID);
});

it('has container classes', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listClasses = $list->getContainerClasses();
    $gridClasses = $grid->getContainerClasses();

    expect($listClasses)->toBeString()->not->toBeEmpty()
        ->and($gridClasses)->toBeString()->not->toBeEmpty();
});

it('supports translation', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listLabel = $list->getLabel();
    $gridLabel = $grid->getLabel();

    expect($listLabel)->toBeString()->not->toBeEmpty()
        ->and($gridLabel)->toBeString()->not->toBeEmpty();
});

it('has color and icon methods', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listColor = $list->getColor();
    $gridColor = $grid->getColor();
    $listIcon = $list->getIcon();
    $gridIcon = $grid->getIcon();

    expect($listColor)->toBeString()->not->toBeEmpty()
        ->and($gridColor)->toBeString()->not->toBeEmpty()
        ->and($listIcon)->toBeString()->not->toBeEmpty()
        ->and($gridIcon)->toBeString()->not->toBeEmpty();
}); 