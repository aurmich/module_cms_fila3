<?php

declare(strict_types=1);

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum for managing table layout types in Filament UI components.
 *
 * This enum provides standardized layout options for tables and data grids,
 * allowing users to toggle between list and grid views with appropriate
 * styling and column configurations.
 *
 * @see \Modules\UI\docs\table-layout-enum-usage.md
 */
enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    /** Standard list layout with traditional table rows */
    case LIST = 'list';
    
    /** Grid layout with responsive card-based display */
    case GRID = 'grid';

    /**
     * Get the default layout type.
     *
     * @return self The default layout (LIST)
     */
    public static function init(): self
    {
        return self::LIST;
    }

    /**
     * Get the human-readable label for this layout.
     *
     * @return string The translated label for the layout
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::LIST => __('ui::table-layout.list.label'),
            self::GRID => __('ui::table-layout.grid.label'),
        };
    }

    /**
     * Get the color associated with this layout type.
     *
     * @return string The color identifier for UI components
     */
    public function getColor(): string
    {
        return match ($this) {
            self::LIST => 'primary',
            self::GRID => 'secondary',
        };
    }

    /**
     * Get the icon associated with this layout type.
     *
     * @return string The Heroicon identifier for the layout
     */
    public function getIcon(): string
    {
        return match ($this) {
            self::LIST => 'heroicon-o-list-bullet',
            self::GRID => 'heroicon-o-squares-2x2',
        };
    }

    /**
     * Toggle between layout types.
     *
     * @return self The opposite layout type
     */
    public function toggle(): self
    {
        return match ($this) {
            self::LIST => self::GRID,
            self::GRID => self::LIST,
        };
    }

    /**
     * Check if this is a grid layout.
     *
     * @return bool True if this is the GRID layout type
     */
    public function isGridLayout(): bool
    {
        return self::GRID === $this;
    }

    /**
     * Check if this is a list layout.
     *
     * @return bool True if this is the LIST layout type
     */
    public function isListLayout(): bool
    {
        return self::LIST === $this;
    }

    /**
     * Get the responsive grid configuration for table content.
     *
     * Returns the number of columns for different screen sizes when using
     * grid layout, or null for list layout.
     *
     * @return array<string, int>|null Grid configuration or null for list layout
     */
    public function getTableContentGrid(): ?array
    {
        return $this->isGridLayout()
            ? [
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
                '2xl' => 5,
            ]
            : null;
    }

    /**
     * Get the appropriate table columns for this layout type.
     *
     * This method replaces the old debug_backtrace approach with explicit
     * parameter passing for better type safety and testability.
     *
     * @param array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component> $listColumns Columns for list layout
     * @param array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component> $gridColumns Columns for grid layout
     *
     * @return array<\Filament\Tables\Columns\Column|\Filament\Tables\Columns\ColumnGroup|\Filament\Tables\Columns\Layout\Component>
     */
    public function getTableColumns(array $listColumns, array $gridColumns): array
    {
        return $this->isGridLayout() ? $gridColumns : $listColumns;
    }

    /**
     * Get all available layout options as an array.
     *
     * @return array<string, string> Array of layout values and labels
     */
    public static function getOptions(): array
    {
        return [
            self::LIST->value => self::LIST->getLabel(),
            self::GRID->value => self::GRID->getLabel(),
        ];
    }

    /**
     * Get the CSS classes for the layout container.
     *
     * @return string CSS classes for styling the layout
     */
    public function getContainerClasses(): string
    {
        return match ($this) {
            self::LIST => 'table-layout-list',
            self::GRID => 'table-layout-grid',
        };
    }
}
