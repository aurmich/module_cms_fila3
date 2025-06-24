<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Pages;

use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Query\Builder;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

abstract class BaseListUsers extends XotBaseListRecords
{
    protected static string $resource = UserResource::class;

    /**
<<<<<<< HEAD
<<<<<<< HEAD
=======
     * Get table columns for user records.
     *
>>>>>>> aurmich/dev
=======
     * Get table columns for user records.
     *
>>>>>>> a3f7230 (.)
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            //'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name')
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable(),
            //'email_verified_at' => TextColumn::make('email_verified_at')
            //    ->dateTime(),
            //'created_at' => TextColumn::make('created_at')
            //    ->dateTime(),
        ];
    }

    /**
<<<<<<< HEAD
<<<<<<< HEAD
=======
     * Get table filters for user records.
     *
>>>>>>> aurmich/dev
=======
     * Get table filters for user records.
     *
>>>>>>> a3f7230 (.)
     * @return array<Tables\Filters\BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
<<<<<<< HEAD
<<<<<<< HEAD
=======
            /*
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
            Filter::make('verified')
                ->query(static fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            Filter::make('unverified')
                ->query(static fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
<<<<<<< HEAD
<<<<<<< HEAD
=======
            */
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
        ];
    }

    /**
<<<<<<< HEAD
<<<<<<< HEAD
     * @return array<Action|Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            ChangePasswordAction::make()
                ->tooltip('Cambio Password')
                ->iconButton(),
            ...parent::getTableActions(),
            Action::make('deactivate')
                ->tooltip(__('filament-actions::delete.single.label'))
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->action(static fn (UserContract $user) => $user->delete()),
        ];
    }

=======
=======
>>>>>>> a3f7230 (.)
     * Get table actions for user records.
     *
     * @return array<\Filament\Tables\Actions\Action|\Filament\Tables\Actions\ActionGroup>
     */
    public function getTableActions(): array
    {
        $actions = [
            ChangePasswordAction::make()
                ->tooltip('Cambio Password')
                ->iconButton(),
        ];
        
        // Add parent actions - filter to ensure type compatibility
        $parentActions = parent::getTableActions();
        foreach ($parentActions as $action) {
            if ($action instanceof \Filament\Tables\Actions\Action || $action instanceof \Filament\Tables\Actions\ActionGroup) {
                $actions[] = $action;
            }
        }
        
        // Add deactivate action
        $actions[] = Action::make('deactivate')
            ->tooltip(__('filament-actions::delete.single.label'))
            ->color('danger')
            ->icon('heroicon-o-trash')
            ->action(static fn (UserContract $user) => $user->delete());
            
        return $actions;
    }

    /**
     * Get header widgets for the user list page.
     *
     * @return array<class-string>
     */
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    protected function getHeaderWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    /**
<<<<<<< HEAD
<<<<<<< HEAD
     * @return array<string, Tables\Actions\BulkAction>
=======
     * Get table bulk actions for user records.
     *
     * @return array<Tables\Actions\BulkAction>
>>>>>>> aurmich/dev
=======
     * Get table bulk actions for user records.
     *
     * @return array<Tables\Actions\BulkAction>
>>>>>>> a3f7230 (.)
     */
    public function getTableBulkActions(): array
    {
        return [
<<<<<<< HEAD
<<<<<<< HEAD
            'delete' => Tables\Actions\DeleteBulkAction::make(),
            'export' => ExportBulkAction::make(),
=======
            Tables\Actions\DeleteBulkAction::make(),
            ExportBulkAction::make(),
>>>>>>> aurmich/dev
=======
            Tables\Actions\DeleteBulkAction::make(),
            ExportBulkAction::make(),
>>>>>>> a3f7230 (.)
        ];
    }
}
