<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Contracts\ProfileContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Modules\Chart\Models\MixedChart.
 *
 * @property Collection<int, \Modules\Chart\Models\Chart> $charts
 * @property int|null $charts_count
 * @method static \Modules\Chart\Database\Factories\MixedChartFactory factory($count = null, $state = [])
 * @method static Builder|MixedChart newModelQuery()
 * @method static Builder|MixedChart newQuery()
 * @method static Builder|MixedChart query()
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @phpstan-type MixedChartArray array{id: int|null, name: string|null, charts: Collection<int, \Modules\Chart\Models\Chart>}
 * @mixin \Eloquent
 */
class MixedChart extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany
    {
        /** @var array<string, class-string<\Illuminate\Database\Eloquent\Model>> $morphMap */
        $morphMap = [
            'mixed_chart' => self::class,
        ];
        
        Relation::morphMap($morphMap);

        return $this->morphMany(Chart::class, 'post');
    }
}
