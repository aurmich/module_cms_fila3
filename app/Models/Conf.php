<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

/**
 * Modules\Cms\Models\Conf.
 *
 * @property int $id
 * @property string|null $name
 *
 * @method static Builder|Conf newModelQuery()
 * @method static Builder|Conf newQuery()
 * @method static Builder|Conf query()
 * @method static Builder|Conf whereId($value)
 * @method static Builder|Conf whereName($value)
 * @method static Conf|null first()
 * @method static \Illuminate\Database\Eloquent\Collection<int, Conf> get()
 * @method static Conf create(array $attributes = [])
 * @method static Conf firstOrCreate(array $attributes = [], array $values = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conf where(string|\Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conf whereNotNull(string|\Illuminate\Contracts\Database\Query\Expression $columns)
 * @method static int count(string $columns = '*')
 *
 * @mixin IdeHelperConf
 * @mixin \Eloquent
 */
class Conf extends Model
{
    use Sushi;

    /** @var list<string> */
    protected $fillable = [
        'id', 'name',
    ];

    public function getRows(): array
    {
        //  local/ptvx

        return TenantService::getConfigNames();
    }

    /*
    protected function sushiShouldCache() {
        return false;
    }
    */
    /**
     * Undocumented function.
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
