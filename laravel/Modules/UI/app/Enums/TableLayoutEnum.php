<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Webmozart\Assert\Assert;

enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    case GRID = 'grid';
    case LIST = 'list';

    public static function init(): self
    {
        return self::LIST;
    }

    public function getLabel(): string
    {
        return $this->name;
        // return trans('ui::corner-position.'.$this->value.'.label');
    }

    public function getColor(): string
    {
        return match ($this) {
            self::GRID => 'gray',
            self::LIST => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::LIST => 'heroicon-o-list-bullet',
            self::GRID => 'heroicon-o-squares-2x2',
        };
    }

    public function toggle(): self
    {
        // $res = self::LIST === $this ? self::GRID : self::LIST;
        $res = self::GRID === $this ? self::LIST : self::GRID;

        return $res;
    }

    public function isGridLayout(): bool
    {
        return self::GRID === $this;
    }

    /**
     * Undocumented function.
     *
     * @return array<string, int|null>|null
     */
    public function getTableContentGrid(): ?array
    {
        $res = $this->isGridLayout()
            ? [
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ]
            : null;

        return $res;
    }

    /**
     * Undocumented function.
     *
     * @param array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component> $listColumns
     * @param array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component> $gridColumns
     * @return array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component>
     */
    public function getTableColumns(array $listColumns, array $gridColumns): array
    {
        $columns = $this->isGridLayout() ? $gridColumns : $listColumns;

        Assert::isArray($columns);

        return $columns;
    }
}
