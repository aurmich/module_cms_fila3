<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Modules\User\Models\Role;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStatesContract;
use Spatie\Permission\Contracts\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

/**
 * Modules\Xot\Contracts\SateContract.
 *
 * @property string $name
 */
interface StateContract 
{
    public function label(): string;
    public function color(): string;
    public function bgColor(): string;
    public function icon(): string;
    public function modalHeading(): string;
    public function modalDescription(): string;
    public function modalFormSchema(): array;
    public function modalFillFormByRecord(Model $record): array;
    public function modalActionByRecord(Model $record,array $data): void;

}
