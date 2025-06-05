<?php

declare(strict_types=1);

namespace Modules\Xot\Interfaces;

interface HasTableFunctions
{
    /**
     * Get the table columns for the list view.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array;

    /**
     * Get the table actions.
     *
     * @return array<string, \Filament\Tables\Actions\Action>
     */
    public function getTableActions(): array;

    /**
     * Get the table bulk actions.
     *
     * @return array<string, \Filament\Tables\Actions\BulkAction>
     */
    public function getTableBulkActions(): array;
}
