<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Modules\Activity\Models{
/**
 * Class Activity.
 * 
 * This class extends the BaseActivity model to represent activities in the application.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property string $causer_id
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $properties
 * @property string|null $batch_uuid
 * @property string|null $event
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $causer
 * @property-read \Illuminate\Support\Collection<int, mixed> $changes
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forBatch(string $batchUuid)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forEvent(string $event)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity hasBatch()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity inLog(...$logNames)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereBatchUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Activity extends \Eloquent {}
}

namespace Modules\Activity\Models{
/**
 * Modules\Activity\Models\Snapshot.
 *
 * @property int $id
 * @property string $aggregate_uuid
 * @property int $aggregate_version
 * @property array $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereAggregateUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereAggregateVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Snapshot extends \Eloquent {}
}

namespace Modules\Activity\Models{
/**
 * Class StoredEvent.
 * 
 * Represents a stored event in the activity module.
 *
 * @property int $id
 * @property string|null $aggregate_uuid
 * @property int|null $aggregate_version
 * @property int $event_version
 * @property string $event_class
 * @property array<array-key, mixed> $event_properties
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $meta_data
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read \Spatie\EventSourcing\StoredEvents\ShouldBeStored|null $event
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent afterVersion(int $version)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<EloquentStoredEvent> all()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<EloquentStoredEvent> get()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent lastEvent(string ...$eventClasses)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent newModelQuery()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent newQuery()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent query()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent startingFrom(int $storedEventId)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateRoot(string $uuid)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateUuid($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateVersion($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedAt($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedBy($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEvent(string ...$eventClasses)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventClass($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventProperties($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventVersion($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereId($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereMetaData($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIs(string $property, ?mixed $value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIsNot(string $property, ?mixed $value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereUpdatedBy($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent withMetaDataAttributes()
 * @mixin \Eloquent
 */
	class StoredEvent extends \Eloquent {}
}

namespace Modules\Chart\Models{
/**
 * Modules\Chart\Models\Chart.
 *
 * @property int|null $height
 * @property string|null $type
 * @property int|null $width
 * @property string|null $color
 * @property string|null $bg_color
 * @property int|null $font_family
 * @property int|null $font_size
 * @property int|null $font_style
 * @property int|null $y_grace
 * @property bool|null $yaxis_hide
 * @property string|null $list_color
 * @property int|null $grace
 * @property int|null $x_label_angle
 * @property bool|null $show_box
 * @property int|null $x_label_margin
 * @property int|null $plot_perc_width
 * @property int|null $plot_value_show
 * @property string|null $plot_value_format
 * @property int|null $plot_value_pos
 * @property string|null $plot_value_color
 * @property string|null $group_by
 * @property string|null $sort_by
 * @property int|null $transparency
 * @property array<string, mixed>|null $colors
 * @property string|null $post_id
 * @property string|null $post_type
 * @property string|null $chart_type
 * @property array<string, mixed>|null $totali
 * @method static \Modules\Chart\Database\Factories\ChartFactory factory($count = null, $state = [])
 * @method static Builder|Chart newModelQuery()
 * @method static Builder|Chart newQuery()
 * @method static Builder|Chart query()
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Chart extends \Eloquent {}
}

namespace Modules\Chart\Models{
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
 * @mixin \Eloquent
 */
	class MixedChart extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Conf.
 *
 * @property int         $id
 * @property string|null $name
 * @method static Builder|Conf newModelQuery()
 * @method static Builder|Conf newQuery()
 * @method static Builder|Conf query()
 * @method static Builder|Conf whereId($value)
 * @method static Builder|Conf whereName($value)
 * @mixin IdeHelperConf
 * @mixin \Eloquent
 */
	class Conf extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Menu.
 *
 * @property int                             $id
 * @property string                          $name
 * @property array|null                      $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu withoutTrashed()
 * @property string                                                                                                     $title
 * @property int|null                                                                                                   $parent_id
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $children
 * @property int|null                                                                                                   $children_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null                                                                                                   $media_count
 * @property Menu|null                                                                                                  $parent
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $ancestors                  The model's recursive parents.
 * @property int|null                                                                                                   $ancestors_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $ancestorsAndSelf           The model's recursive parents and itself.
 * @property int|null                                                                                                   $ancestors_and_self_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $bloodline                  The model's ancestors, descendants and itself.
 * @property int|null                                                                                                   $bloodline_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $childrenAndSelf            The model's direct children and itself.
 * @property int|null                                                                                                   $children_and_self_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $descendants                The model's recursive children.
 * @property int|null                                                                                                   $descendants_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $descendantsAndSelf         The model's recursive children and itself.
 * @property int|null                                                                                                   $descendants_and_self_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $parentAndSelf              The model's direct parent and itself.
 * @property int|null                                                                                                   $parent_and_self_count
 * @property Menu|null                                                                                                  $rootAncestor               The model's topmost parent.
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $siblings                   The parent's other children.
 * @property int|null                                                                                                   $siblings_count
 * @property \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection|Menu[]                                               $siblingsAndSelf            All the parent's children.
 * @property int|null                                                                                                   $siblings_and_self_count
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            whereTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu            withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Modules\Cms\Database\Factories\MenuFactory factory($count = null, $state = [])
 * @property-read int $depth
 * @property-read string $path
 * @mixin \Eloquent
 */
	class Menu extends \Eloquent implements \Modules\Xot\Contracts\HasRecursiveRelationshipsContract {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Module.
 *
 * @property int                  $id
 * @property string|null          $name
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static ModuleFactory  factory($count = null, $state = [])
 * @method static Builder|Module newModelQuery()
 * @method static Builder|Module newQuery()
 * @method static Builder|Module query()
 * @method static Builder|Module whereId($value)
 * @method static Builder|Module whereName($value)
 * @mixin IdeHelperModule
 * @mixin \Eloquent
 */
	class Module extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Page.
 *
 * @property string                          $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string                          $slug
 * @property string                          $title
 * @property string                          $content
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @property array|null                      $content_blocks
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContentBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page withoutTrashed()
 * @property array|null $sidebar_blocks
 * @property array      $footer_blocks
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFooterBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSidebarBlocks($value)
 * @property mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereJsonContainsLocale(string $column, string $locale, ?mixed $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereJsonContainsLocales(string $column, array $locales, ?mixed $value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static \Modules\Cms\Database\Factories\PageFactory factory($count = null, $state = [])
 * @property array<array-key, mixed>|null $middleware
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereMiddleware($value)
 * @mixin \Eloquent
 */
	class Page extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\PageContent.
 *
 * @property array|null                                  $blocks
 * @property string|null                                 $id
 * @property array|null                                  $name
 * @property string|null                                 $slug
 * @property \Illuminate\Support\Carbon|null             $created_at
 * @property \Illuminate\Support\Carbon|null             $updated_at
 * @property string|null                                 $created_by
 * @property string|null                                 $updated_by
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property mixed                                       $translations
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Cms\Database\Factories\PageContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class PageContent extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Section
 *
 * @property array|null                                  $blocks
 * @property string|null                                 $id
 * @property array|null                                  $name
 * @property string|null                                 $slug
 * @property \Illuminate\Support\Carbon|null             $created_at
 * @property \Illuminate\Support\Carbon|null             $updated_at
 * @property string|null                                 $created_by
 * @property string|null                                 $updated_by
 * @property mixed                                       $translations
 * @method static \Modules\Cms\Database\Factories\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Section  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section  query()
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Section extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property int $ordering
 * @property int $is_active
 * @property array<array-key, mixed>|null $description
 * @property string $slug
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Form> $forms
 * @property-read int|null $forms_count
 * @property-read string $last_updated
 * @property-read mixed $logo_url
 * @property-read mixed $translations
 * @method static \LaraZeus\Bolt\Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property string $name
 * @property int|null $ordering
 * @property int $is_active
 * @property string|null $description
 * @property string|null $slug
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read string $last_updated
 * @property-read string|null $values_list
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \LaraZeus\Bolt\Database\Factories\CollectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection withoutTrashed()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $values
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Collection whereValues($value)
 */
	class Collection extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property int|null $section_id
 * @property array<array-key, mixed> $name
 * @property string|null $description
 * @property string $type
 * @property int $ordering
 * @property array<array-key, mixed>|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldResponses
 * @property-read int|null $field_responses_count
 * @property-read \Modules\FormBuilder\Models\Section|null $section
 * @property-read mixed $translations
 * @method static \LaraZeus\Bolt\Database\Factories\FieldFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Field withoutTrashed()
 * @mixin \Eloquent
 */
	class Field extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property string $id
 * @property array<array-key, mixed> $name
 * @property string|null $key
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read mixed $translations
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\FormBuilder\Database\Factories\FieldOptionFactory factory($count = null, $state = [])
 * @method static Builder<static>|FieldOption newModelQuery()
 * @method static Builder<static>|FieldOption newQuery()
 * @method static Builder<static>|FieldOption query()
 * @method static Builder<static>|FieldOption whereCreatedAt($value)
 * @method static Builder<static>|FieldOption whereCreatedBy($value)
 * @method static Builder<static>|FieldOption whereDeletedAt($value)
 * @method static Builder<static>|FieldOption whereDeletedBy($value)
 * @method static Builder<static>|FieldOption whereId($value)
 * @method static Builder<static>|FieldOption whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|FieldOption whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|FieldOption whereKey($value)
 * @method static Builder<static>|FieldOption whereLocale(string $column, string $locale)
 * @method static Builder<static>|FieldOption whereLocales(string $column, array $locales)
 * @method static Builder<static>|FieldOption whereName($value)
 * @method static Builder<static>|FieldOption whereType($value)
 * @method static Builder<static>|FieldOption whereUpdatedAt($value)
 * @method static Builder<static>|FieldOption whereUpdatedBy($value)
 * @property string|null $type
 * @mixin \Eloquent
 */
	class FieldOption extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\FormBuilder\Models\Field|null $field
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read \Modules\FormBuilder\Models\Response|null $parentResponse
 * @method static \LaraZeus\Bolt\Database\Factories\FieldResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FieldResponse withoutTrashed()
 * @mixin \Eloquent
 */
	class FieldResponse extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * Form model for the FormBuilder module.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property array|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property int|null $user_id
 * @property int|null $category_id
 * @property int $ordering
 * @property array<array-key, mixed>|null $details
 * @property string|null $start_at
 * @property string|null $end_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property-read \Modules\FormBuilder\Models\Category|null $category
 * @property-read mixed $date_available
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Field> $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldsResponses
 * @property-read int|null $fields_responses_count
 * @property-read string $is_active_desc
 * @property-read string $last_updated
 * @property-read mixed $need_login
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Response> $responses
 * @property-read int|null $responses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Section> $sections
 * @property-read int|null $sections_count
 * @property-read mixed $slug_url
 * @property-read mixed $translations
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \LaraZeus\Bolt\Database\Factories\FormFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $extensions
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Form whereExtensions($value)
 */
	class Form extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $formTemplate
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormField query()
 * @mixin \Eloquent
 */
	class FormField extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $form
 * @property-read \Modules\FormBuilder\Models\FormTemplate|null $formTemplate
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission query()
 * @mixin \Eloquent
 */
	class FormSubmission extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FormField> $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormTemplate query()
 * @mixin \Eloquent
 */
	class FormTemplate extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $user_id
 * @property string|null $status
 * @property string|null $notes
 * @property int|null $extension_item_id
 * @property int|null $grades
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\FieldResponse> $fieldsResponses
 * @property-read int|null $fields_responses_count
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read string $last_updated
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \LaraZeus\Bolt\Database\Factories\ResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereExtensionItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereGrades($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Response withoutTrashed()
 * @mixin \Eloquent
 */
	class Response extends \Eloquent {}
}

namespace Modules\FormBuilder\Models{
/**
 * @property int $id
 * @property int|null $form_id
 * @property int|null $field_id
 * @property int|null $response_id
 * @property string|null $response
 * @property int|null $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property array<array-key, mixed> $name
 * @property int $ordering
 * @property int $columns
 * @property string|null $description
 * @property string|null $icon
 * @property int $aside
 * @property int $compact
 * @property array<array-key, mixed>|null $options
 * @property int $borderless
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\FormBuilder\Models\Field> $fields
 * @property-read int|null $fields_count
 * @property-read \Modules\FormBuilder\Models\Form|null $form
 * @property-read mixed $translations
 * @method static \LaraZeus\Bolt\Database\Factories\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereAside($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereBorderless($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereColumns($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCompact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withoutTrashed()
 * @mixin \Eloquent
 */
	class Section extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Consent.
 *
 * @property string $id
 * @property string $treatment_id
 * @property string $subject_id
 * @property string $id
 * @property string $treatment_id
 * @property string $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @property Treatment|null                  $treatment
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedBy($value)
 * @property Treatment|null $treatment
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string $user_type
 * @property int $user_id
 * @property string|null $type
 * @property string|null $accepted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consent whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consent whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consent whereUserType($value)
 * @mixin \Eloquent
 */
	class Consent extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string $id
 * @property string|null                     $treatment_id
 * @property string|null                     $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Consent|null                    $consent
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereConsentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereUpdatedAt($value)
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedBy($value)
 * @property string $id
 * @property string|null                     $treatment_id
 * @property string|null                     $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @property Consent|null                    $consent
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereConsentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Event extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Profile.
 *
 * @property int                                                                                                           $id
 * @property string|null                                                                                                   $type
 * @property string|null                                                                                                   $first_name
 * @property string|null                                                                                                   $last_name
 * @property string|null                                                                                                   $full_name
 * @property string|null                                                                                                   $email
 * @property \Illuminate\Support\Carbon|null                                                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                                                               $updated_at
 * @property string|null                                                                                                   $user_id
 * @property string|null                                                                                                   $updated_by
 * @property string|null                                                                                                   $created_by
 * @property \Illuminate\Support\Carbon|null                                                                               $deleted_at
 * @property string|null                                                                                                   $deleted_by
 * @property bool                                                                                                          $is_active
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes                                                             $extra
 * @property string $avatar
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser>                                $deviceUsers
 * @property int|null                                                                                                      $device_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                    $devices
 * @property int|null                                                                                                      $devices_count
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media>    $media
 * @property int|null                                                                                                      $media_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser>                                $mobileDeviceUsers
 * @property int|null                                                                                                      $mobile_device_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                    $mobileDevices
 * @property int|null                                                                                                      $mobile_devices_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property int|null                                                                                                      $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission>                                $permissions
 * @property int|null                                                                                                      $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role>                                      $roles
 * @property int|null                                                                                                      $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                      $teams
 * @property int|null                                                                                                      $teams_count
 * @property \Modules\Xot\Contracts\UserContract|null                                                                      $user
 * @property string|null                                                                                                   $user_name
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory   factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutRole($roles, $guard = null)
 * @property string|null $deleted_by
 * @property int         $is_active
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory   factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile     whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseProfile withoutRole($roles, $guard = null)
 * @property string|null $deleted_by
 * @property int         $is_active
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile   whereUserId($value)
 * @property \Modules\User\Models\DeviceUser             $pivot
 * @property \Modules\User\Models\Membership             $membership
 * @property string $credits
 * @property string|null                                 $slug
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereSlug($value)
 * @property int $oauth_enable
 * @property int $credentials_enable
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCredentialsEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereOauthEnable($value)
 * @property string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUuid($value)
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $bio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePostalCode($value)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Treatment.
 *
 * @property string $id
 * @property int                             $active
 * @property int                             $required
 * @property string $name
 * @property string $description
 * @property string|null                     $documentVersion
 * @property string|null                     $documentUrl
 * @property int                             $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Modules\Gdpr\Database\Factories\TreatmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDocumentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereWeight($value)
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDocumentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment whereUpdatedBy($value)
 * @property string|null $deleted_by
 * @method static \Modules\Gdpr\Database\Factories\TreatmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereDocumentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Treatment   whereWeight($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Treatment extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Class Address
 * 
 * Implementazione di Schema.org PostalAddress
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $route
 * @property string|null $street_number
 * @property string|null $locality
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_1
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $formatted_address
 * @property string|null $place_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $type
 * @property bool $is_primary
 * @property array|null $extra_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * // implements HasGeolocation
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $addressable
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read string $full_address
 * @property-read string $street_address
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $model
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Geo\Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address nearby(float $latitude, float $longitude, float $radiusKm = '10')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address primary()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereExtraData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereFormattedAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Modello per i comuni italiani con Sushi.
 * 
 * Implementa il pattern Facade per fornire un'interfaccia unificata a tutti i dati geografici:
 * regioni, province, città, CAP, codici ISTAT, ecc.
 * Tutti i dati sono estratti da file JSON e gestiti tramite Sushi.
 *
 * @property int $id
 * @property string $nome
 * @property string $codice
 * @property string $regione
 * @property string $provincia
 * @property string $sigla_provincia
 * @property string $cap
 * @property string $codice_catastale
 * @property int $popolazione
 * @property string $zona_altimetrica
 * @property int $altitudine
 * @property float $superficie
 * @property float $lat
 * @property float $lng
 * @property array<array-key, mixed>|null $zona
 * @property string|null $sigla
 * @property string|null $codiceCatastale
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCodice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCodiceCatastale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune wherePopolazione($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereProvincia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereRegione($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereSigla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereZona($value)
 * @mixin \Eloquent
 */
	class Comune extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder|County newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|County newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|County query()
 * @mixin \Eloquent
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 */
	class County extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Modules\Geo\Models\GeoNamesCap.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GeoNamesCap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeoNamesCap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeoNamesCap query()
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class GeoNamesCap extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property int|null $region_id
 * @property int|null $province_id
 * @property string|null $name
 * @property int $id
 * @property string|null $postal_code
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereRegionId($value)
 * @mixin \Eloquent
 */
	class Locality extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Class Location.
 *
 * @property int                  $id
 * @property string|null          $model_type
 * @property string|null          $model_id
 * @property string|null          $name
 * @property float|null           $lat
 * @property float|null           $lng
 * @property string|null          $street
 * @property string|null          $city
 * @property string|null          $state
 * @property string|null          $zip
 * @property string|null          $formatted_address
 * @property string|null          $description
 * @property bool|null            $processed
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property string|null          $deleted_at
 * @property string|null          $deleted_by
 * @property array                $location
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCity(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLat(float $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLng(float $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereProcessed(bool $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereState(string $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereZip(string $value)
 * @method static Builder<static>|Location newModelQuery()
 * @method static Builder<static>|Location newQuery()
 * @method static Builder<static>|Location withinDistance(float $latitude, float $longitude, float $distanceInKm)
 * @method static Builder<static>|Location whereCreatedAt($value)
 * @method static Builder<static>|Location whereCreatedBy($value)
 * @method static Builder<static>|Location whereDeletedAt($value)
 * @method static Builder<static>|Location whereDeletedBy($value)
 * @method static Builder<static>|Location whereDescription($value)
 * @method static Builder<static>|Location whereFormattedAddress($value)
 * @method static Builder<static>|Location whereId($value)
 * @method static Builder<static>|Location whereModelId($value)
 * @method static Builder<static>|Location whereModelType($value)
 * @method static Builder<static>|Location whereName($value)
 * @method static Builder<static>|Location whereStreet($value)
 * @method static Builder<static>|Location whereUpdatedAt($value)
 * @method static Builder<static>|Location whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Location extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property-read \Modules\Geo\Models\Address|null $address
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read string $formatted_address
 * @property-read float|null $latitude
 * @property-read float|null $longitude
 * @property-read \Illuminate\Database\Eloquent\Model $linked
 * @property-read \Modules\Geo\Models\PlaceType|null $placeType
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Geo\Database\Factories\PlaceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place query()
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $nearest_street
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $post_type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereFormattedAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereNearestStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Place extends \Eloquent implements \Modules\Geo\Contracts\HasGeolocation {}
}

namespace Modules\Geo\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType query()
 * @mixin \Eloquent
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 */
	class PlaceType extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property int|null $region_id
 * @property int $id
 * @property string|null $name
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Locality> $localities
 * @property-read int|null $localities_count
 * @property-read \Modules\Geo\Models\Region|null $region
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereRegionId($value)
 * @mixin \Eloquent
 */
	class Province extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Province> $provinces
 * @property-read int|null $provinces_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @mixin \Eloquent
 */
	class Region extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @mixin \Eloquent
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 */
	class State extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @method static \Modules\Job\Database\Factories\ExportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Export newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Export newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Export query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string $file_disk
 * @property string|null $file_name
 * @property string $exporter
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereExporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereFileDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereProcessedRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereSuccessfulRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereTotalRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUserId($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property \Illuminate\Database\Eloquent\Model|Eloquent|null $user
 * @property string|null $user_type
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUserType($value)
 * @mixin \Eloquent
 * @mixin Eloquent
 */
	class Export extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @method static \Modules\Job\Database\Factories\FailedImportRowFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow query()
 * @property int $id
 * @property array $data
 * @property int $import_id
 * @property string|null $validation_error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereImportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedImportRow whereValidationError($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class FailedImportRow extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\FailedJob.
 *
 * @method static \Modules\Job\Database\Factories\FailedJobFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob query()
 * @property int $id
 * @property string $uuid
 * @property string $connection
 * @property string $queue
 * @property array $payload
 * @property string $exception
 * @property string $failed_at
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereConnection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereException($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereFailedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FailedJob whereUuid($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class FailedJob extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Frequency.
 *
 * @property int $id
 * @property int $task_id
 * @property string $label
 * @property string $interval
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, \Modules\Job\Models\Parameter> $parameters
 * @property int|null $parameters_count
 * @property Task|null $task
 * @method static \Modules\Job\Database\Factories\FrequencyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frequency whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Frequency extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @method static \Modules\Job\Database\Factories\ImportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Import newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Import newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Import query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string $file_name
 * @property string $file_path
 * @property string $importer
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereImporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereProcessedRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereSuccessfulRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereTotalRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereUserId($value)
 * @property string|null $user_type
 * @method static \Illuminate\Database\Eloquent\Builder|Import whereUserType($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Import extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Job.
 *
 * @property int $id
 * @property string $queue
 * @property array $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property Carbon $created_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $updated_at
 * @method static \Modules\Job\Database\Factories\JobFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedBy($value)
 * @property mixed $display_name
 * @property mixed $status
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Job extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\JobBatch.
 *
 * @property string $id
 * @property string $name
 * @property int $total_jobs
 * @property int $pending_jobs
 * @property int $failed_jobs
 * @property string $failed_job_ids
 * @property Collection|null $options
 * @property Carbon|null $cancelled_at
 * @property Carbon $created_at
 * @property Carbon|null $finished_at
 * @method static \Modules\Job\Database\Factories\JobBatchFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereFailedJobIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereFailedJobs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch wherePendingJobs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobBatch whereTotalJobs($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class JobBatch extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\JobManager.
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string $id
 * @property string $job_id
 * @property string|null $name
 * @property string|null $queue
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $finished_at
 * @property bool $failed
 * @property int $attempt
 * @property int|null $progress
 * @property string|null $exception_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @method static \Modules\Job\Database\Factories\JobManagerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereExceptionMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereFailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobManager whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class JobManager extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\JobsWaiting.
 *
 * @property int $id
 * @property string $queue
 * @property array $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $display_name
 * @method static \Modules\Job\Database\Factories\JobsWaitingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereUpdatedBy($value)
 * @property mixed $status
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class JobsWaiting extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Parameter.
 *
 * @property int $id
 * @property int $frequency_id
 * @property string $name
 * @property string $value
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Frequency|null $task
 * @method static \Modules\Job\Database\Factories\ParameterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereFrequencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parameter whereValue($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Parameter extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Result.
 *
 * @property int $id
 * @property int $task_id
 * @property Carbon $ran_at
 * @property string $duration
 * @property string $result
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Task|null $task
 * @method static \Illuminate\Database\Eloquent\Builder|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereRanAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Result extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Schedule.
 *
 * @property Status $status
 * @property array $options
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\ScheduleHistory> $histories
 * @property int|null $histories_count
 * @property int $id
 * @property string $command
 * @property string|null $command_custom
 * @property array|null $params
 * @property string $expression
 * @property array|null $environments
 * @property array|null $options_with_value
 * @property string|null $log_filename
 * @property bool $even_in_maintenance_mode
 * @property bool $without_overlapping
 * @property bool $on_one_server
 * @property string|null $webhook_before
 * @property string|null $webhook_after
 * @property string|null $email_output
 * @property bool $sendmail_error
 * @property bool $log_success
 * @property bool $log_error
 * @property bool $run_in_background
 * @property bool $sendmail_success
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule active()
 * @method static \Modules\Job\Database\Factories\ScheduleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCommandCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEmailOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEnvironments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEvenInMaintenanceMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereExpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereLogError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereLogFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereLogSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereOnOneServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereOptionsWithValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereRunInBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSendmailError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSendmailSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWebhookAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWebhookBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWithoutOverlapping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule withoutTrashed()
 * @mixin \Eloquent
 */
	class Schedule extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\ScheduleHistory.
 *
 * @property Schedule|null $command
 * @method static \Modules\Job\Database\Factories\ScheduleHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory query()
 * @property int $id
 * @property array|null $params
 * @property string $output
 * @property array|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $schedule_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class ScheduleHistory extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Task.
 *
 * @property string $id
 * @property string $description
 * @property string $command
 * @property string|null $parameters
 * @property string|null $expression
 * @property string $timezone
 * @property int $is_active
 * @property int $dont_overlap
 * @property int $run_in_maintenance
 * @property string|null $notification_email_address
 * @property string|null $notification_phone_number
 * @property string $notification_slack_webhook
 * @property int $auto_cleanup_num
 * @property string|null $auto_cleanup_type
 * @property int $run_on_one_server
 * @property int $run_in_background
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property int $order_column
 * @property string $status
 * @property string $priority_id
 *                               property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\Frequency> $frequencies
 * @property int|null $frequencies_count
 * @property bool $activated
 * @property float $average_runtime
 * @property Result|null $last_result
 * @property string $upcoming
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property int|null $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\Result> $results
 * @property int|null $results_count
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task sortableBy(array $sortableColumns, array $defaultSort = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereAutoCleanupNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereAutoCleanupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDontOverlap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereExpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationSlackWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunInBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunInMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunOnOneServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedBy($value)
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @mixin \Eloquent
 */
	class Task extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * Modules\Lang\Models\Post.
 *
 * @property int             $id
 * @property int|null        $user_id
 * @property string|null     $post_type
 * @property int|null        $post_id
 * @property string|null     $lang
 * @property string|null     $title
 * @property string|null     $subtitle
 * @property string|null     $guid
 * @property string|null     $txt
 * @property string|null     $image_src
 * @property string|null     $image_alt
 * @property string|null     $image_title
 * @property string|null     $meta_description
 * @property string|null     $meta_keywords
 * @property int|null        $author_id
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @property int|null        $category_id
 * @property string|null     $image
 * @property string|null     $content
 * @property int|null        $published
 * @property string|null     $created_by
 * @property string|null     $updated_by
 * @property string|null     $url
 * @property array|null      $url_lang
 * @property array|null      $image_resize_src
 * @property string|null     $linked_count
 * @property string|null     $related_count
 * @property string|null     $relatedrev_count
 * @property string|null     $linkable_type
 * @property int|null        $views_count
 * @property Model|\Eloquent $linkable
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImageAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImageResizeSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImageSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLinkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLinkedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRelatedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRelatedrevCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUrlLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViewsCount($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 * @mixin Eloquent
 */
	class Post extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * Modules\Lang\Models\Translation.
 *
 * @property int         $id
 * @property string|null $lang
 * @property string|null $key
 * @property string|null $value
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string      $namespace
 * @property string      $group
 * @property string|null $item
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   ofTranslatedGroup(string $group)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   orderByGroupKeys(bool $ordered)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   selectDistinctGroup()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereNamespace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation   whereValue($value)
 * @method static \Modules\Lang\Database\Factories\TranslationFactory factory($count = null, $state = [])
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Translation extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * @property string|null $key
 * @property string|null $path
 * @property string|null $id
 * @property string|null $name
 * @property array<array-key, mixed>|null $content
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\Lang\Database\Factories\TranslationFileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TranslationFile wherePath($value)
 * @mixin \Eloquent
 */
	class TranslationFile extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * Modules\Media\Models\Media.
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array|null $manipulations
 * @property array|null $custom_properties
 * @property array|null $generated_conversions
 * @property array|null $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property string $directory
 * @property string|null $path
 * @property int|null $width
 * @property int|null $height
 * @property string|null $type
 * @property string|null $ext
 * @property string|null $alt
 * @property string|null $title
 * @property string|null $description
 * @property string|null $caption
 * @property string|null $exif
 * @property string|null $curations
 * @property \Modules\Xot\Contracts\UserContract|null $creator
 * @property \Illuminate\Database\Eloquent\Model|Eloquent $model
 * @property TemporaryUpload|null $temporaryUpload
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCollectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereConversionsDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCurations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCustomProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDirectory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereExif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereGeneratedConversions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereManipulations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereResponsiveImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereWidth($value)
 * @property mixed $extension
 * @property mixed $human_readable_size
 * @property mixed $original_url
 * @property mixed $preview_url
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedBy($value)
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @property array $entry_conversions
 * @property EloquentCollection<int, \Modules\Media\Models\MediaConvert> $mediaConverts
 * @property int|null $media_converts_count
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @mixin \Eloquent
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @mixin Eloquent
 */
	class Media extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * @property int $id
 * @property int $media_id
 * @property string|null $codec_video
 * @property string|null $codec_audio
 * @property string|null $preset
 * @property string|null $bitrate
 * @property int|null $width
 * @property int|null $height
 * @property int|null $threads
 * @property int|null $speed
 * @property string|null $percentage
 * @property string|null $remaining
 * @property string|null $rate
 * @property string|null $execution_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $format
 * @property string|null $converted_file
 * @property string|null $disk
 * @property string|null $file
 * @property Media|null $media
 * @method static \Modules\Media\Database\Factories\MediaConvertFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereBitrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereCodecAudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereCodecVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereExecutionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert wherePreset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereRemaining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereThreads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConvert whereWidth($value)
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class MediaConvert extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * Modules\Media\Models\TemporaryUpload.
 *
 * @property int $id
 * @property string $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereUpdatedAt($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TemporaryUpload whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class TemporaryUpload extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\Contact.
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $contact_type
 * @property string|null $value
 * @property string|null $user_id
 * @property string|null $verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $token
 * @property string|null $sms_sent_at
 * @property int|null $sms_count
 * @property string|null $mail_sent_at
 * @property int|null $mail_count
 * @property string|null $survey_pdf_id
 * @property string|null $token
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $attribute_1
 * @property string|null $attribute_2
 * @property string|null $attribute_3
 * @property string|null $attribute_4
 * @property string|null $attribute_5
 * @property string|null $attribute_6
 * @property string|null $attribute_7
 * @property string|null $attribute_8
 * @property string|null $attribute_9
 * @property string|null $attribute_10
 * @property string|null $attribute_11
 * @property string|null $attribute_12
 * @property string|null $attribute_13
 * @property string|null $attribute_14
 * @property string|null $usesleft
 * @property string|null $sms_status_code
 * @property string|null $sms_status_txt
 * @property int|null $duplicate_count
 * @property int|null $order_column
 * @method static \Modules\Notify\Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereContactType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMailCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMailSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMobilePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSmsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSmsSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSmsStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSmsStatusTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSurveyPdfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereVerifiedAt($value)
 * @mixin Eloquent
 * @property string|null $email
 * @property string|null $mobile_phone
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute14($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAttribute9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDuplicateCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUsesleft($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property int|null $media_count
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereDeletedBy($value)
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property int $id
 * @property string $mailable
 * @property string|null $subject
 * @property string $html_template
 * @property string|null $text_template
 * @property int $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Notify\Models\MailTemplateVersion> $versions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Notify\Models\MailTemplateLog> $logs
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property string $name
 * @property string $slug
 * @property-read array $variables
 * @property-read mixed $translations
 * @method static Builder<static>|MailTemplate forMailable(\Illuminate\Contracts\Mail\Mailable $mailable)
 * @method static Builder<static>|MailTemplate newModelQuery()
 * @method static Builder<static>|MailTemplate newQuery()
 * @method static Builder<static>|MailTemplate query()
 * @method static Builder<static>|MailTemplate whereCreatedAt($value)
 * @method static Builder<static>|MailTemplate whereCreatedBy($value)
 * @method static Builder<static>|MailTemplate whereDeletedAt($value)
 * @method static Builder<static>|MailTemplate whereDeletedBy($value)
 * @method static Builder<static>|MailTemplate whereHtmlTemplate($value)
 * @method static Builder<static>|MailTemplate whereId($value)
 * @method static Builder<static>|MailTemplate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereLocale(string $column, string $locale)
 * @method static Builder<static>|MailTemplate whereLocales(string $column, array $locales)
 * @method static Builder<static>|MailTemplate whereMailable($value)
 * @method static Builder<static>|MailTemplate whereName($value)
 * @method static Builder<static>|MailTemplate whereSlug($value)
 * @method static Builder<static>|MailTemplate whereSubject($value)
 * @method static Builder<static>|MailTemplate whereTextTemplate($value)
 * @method static Builder<static>|MailTemplate whereUpdatedAt($value)
 * @method static Builder<static>|MailTemplate whereUpdatedBy($value)
 * @property string|null $params
 * @method static Builder<static>|MailTemplate whereParams($value)
 * @property array<array-key, mixed>|null $sms_template
 * @property int $counter
 * @method static Builder<static>|MailTemplate whereCounter($value)
 * @method static Builder<static>|MailTemplate whereSmsTemplate($value)
 * @mixin \Eloquent
 */
	class MailTemplate extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $mailable
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Notify\Models\MailTemplate|null $template
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Notify\Database\Factories\MailTemplateLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateLog query()
 * @mixin \Eloquent
 */
	class MailTemplateLog extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property int $id
 * @property int $mail_template_id
 * @property int $version
 * @property string|null $subject
 * @property string $html_template
 * @property string|null $text_template
 * @property array|null $metadata
 * @property string|null $created_by
 * @property string|null $change_notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Notify\Models\MailTemplate|null $template
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Notify\Database\Factories\MailTemplateVersionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereChangeNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereHtmlTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereMailTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereTextTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion withoutTrashed()
 * @mixin \Eloquent
 */
	class MailTemplateVersion extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Notification model for the Notify module.
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array<string, mixed>|string $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property int|null $tenant_id
 * @property int|null $user_id
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property array<string>|string|null $channels
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property-read \Illuminate\Database\Eloquent\Model|null $creator
 * @property-read \Illuminate\Database\Eloquent\Model|null $updater
 * @method static \Modules\Notify\Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Class NotificationTemplate.
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $subject
 * @property string|null $body_html
 * @property string|null $body_text
 * @property array $channels
 * @property array $variables
 * @property array|null $conditions
 * @property array|null $preview_data
 * @property array|null $metadata
 * @property string|null $category
 * @property bool $is_active
 * @property int $version
 * @property int|null $tenant_id
 * @property array|null $grapesjs_data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read string $channels_label
 * @property NotificationTypeEnum $type
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read int|null $logs_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $translations
 * @property-read \Modules\User\Models\Profile|null $updater
 * @property-read int|null $versions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate active()
 * @method static \Modules\Notify\Database\Factories\NotificationTemplateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate forCategory(string $category)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate forChannel(string $channel)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplate whereLocales(string $column, array $locales)
 * @mixin \Eloquent
 */
	class NotificationTemplate extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Notify\Models\NotificationTemplate|null $template
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Notify\Database\Factories\NotificationTemplateVersionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion query()
 * @mixin \Eloquent
 */
	class NotificationTemplateVersion extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType query()
 * @mixin \Eloquent
 */
	class NotificationType extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\NotifyTheme.
 *
 * @property int $id
 * @property string|null $lang
 * @property string|null $type
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $from
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $post_type
 * @property int|null $post_id
 * @property string|null $body_html
 * @property string|null $theme
 * @property string|null $from_email
 * @property string|null $logo_src
 * @property int|null $logo_width
 * @property int|null $logo_height
 * @property array $view_params
 * @property array $logo
 * @property Model|\Eloquent $linkable
 * @property MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null $media_count
 * @method static \Modules\Notify\Database\Factories\NotifyThemeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereBodyHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereFromEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereLogoHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereLogoSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereLogoWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyTheme whereViewParams($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyTheme whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyTheme whereDeletedBy($value)
 * @mixin Eloquent
 */
	class NotifyTheme extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\NotifyThemeable.
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property int|null $notify_theme_id
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereNotifyThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyThemeable whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyThemeable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotifyThemeable whereDeletedBy($value)
 * @mixin \Eloquent
 */
	class NotifyThemeable extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Class Admin
 * 
 * NOTA: Il trait HasFactory è stato rimosso perché già incluso nella catena di ereditarietà (BaseUser -> User -> Admin).
 * Dichiararlo qui è ridondante e può causare warning o confusione.
 * Vedi docs/DRY-model-traits.md
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserId($value)
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $city
 * @property string|null $registration_number
 * @property string|null $status
 * @property array<array-key, mixed>|null $certifications
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Modules\SaluteOra\States\User\UserState|null $state
 * @property array<array-key, mixed>|null $moderation_data
 * @property string|null $lang
 * @property \Modules\SaluteOra\Enums\UserTypeEnum|null $type
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Illuminate\Support\Carbon|null $password_expires_at
 * @property string|null $uuid
 * @property string|null $full_name
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $activeConsents
 * @property-read int|null $active_consents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication> $authentications
 * @property-read int|null $authentications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $consents
 * @property-read int|null $consents_count
 * @property-read \Modules\User\Models\Team|null $currentTeam
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User> $all_team_users
 * @property-read \Modules\User\Models\AuthenticationLog|null $latestAuthentication
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser> $socialiteUsers
 * @property-read int|null $socialite_users_count
 * @property-read \Modules\SaluteOra\Models\AdminStudio|\Modules\SaluteOra\Models\AdminTeam|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property string|null $dental_problems
 * @property string|null $last_dental_visit
 * @property string|null $pregnancy_certificate
 * @property string|null $isee_certificate
 * @property string|null $identity_document
 * @property string|null $health_card
 * @property string|null $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin wherePregnancyCertificate($value)
 * @property string|null $country_code
 * @property string|null $children_count
 * @property string|null $family_members
 * @property string|null $years_in_italy
 * @property string|null $nationality
 * @property string|null $fiscal_code
 * @property string|null $data_privacy_form
 * @property string|null $doctor_certificate
 * @property array<array-key, mixed>|null $certification
 * @property string|null $last_dental_visit_period
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereYearsInItaly($value)
 * @mixin \Eloquent
 * @property string|null $age_range
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
 * @property-read int|null $studios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereAgeRange($value)
 */
	class Admin extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property string|null $type
 * @property string $user_id
 * @property string $studio_id
 * @property array<array-key, mixed>|null $schedule Orari del dottore in questo studio
 * @property bool $is_primary Indica se è lo studio principale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminStudio whereUserId($value)
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property-read User|null $user
 * @mixin \Eloquent
 */
	class AdminStudio extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property int $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminTeam whereUserId($value)
 * @mixin \Eloquent
 */
	class AdminTeam extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Appointment Model for the SaluteOra Module.
 * 
 * Represents an appointment booked by a patient with a doctor in a studio.
 * Supports FullCalendar widgets with multi-tenancy and user type filtering.
 *
 * @property int $id
 * @property int $patient_id
 * @property AppointmentState $state
 * @property int $doctor_id
 * @property int $dentist_id Alias for doctor_id (legacy compatibility)
 * @property int $studio_id
 * @property int|null $tenant_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property AppointmentTypeEnum $type
 * @property AppointmentStatusEnum $status
 * @property string|null $notes
 * @property string|null $treatment_plan
 * @property bool $emergency
 * @property bool $is_emergency Alias for emergency
 * @property bool $eligibility_confirmed
 * @property bool $reminder_sent
 * @property \Illuminate\Support\Carbon|null $reminder_sent_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read Patient $patient
 * @property-read Doctor $doctor
 * @property-read Studio $studio
 * @property string $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $start_datetime
 * @property string|null $end_datetime
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read int $duration
 * @property-read string $formatted_title
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment emergency()
 * @method static \Modules\SaluteOra\Database\Factories\AppointmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forDoctor(int $doctorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forPatient(int $patientId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forStudio(int $studioId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment inDateRange(string $start, string $end)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDentistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEmergency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUserId($value)
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereState($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $invoice File fattura
 * @property-read string $time_range
 * @property-read \Modules\SaluteOra\Models\Report|null $report
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment ofYearMonth(string $yearMonth)
 * @mixin \Eloquent
 */
	class Appointment extends \Eloquent implements \Spatie\ModelStates\HasStatesContract {}
}

namespace Modules\SaluteOra\Models{
/**
 * Doctor model for the SaluteOra module.
 * 
 * Extends the User model to provide doctor-specific functionality.
 *
 * @property string                                                                                                     $id
 * @property string|null                                                                                                $name
 * @property string|null                                                                                                $first_name
 * @property string|null                                                                                                $last_name
 * @property string                                                                                                     $email
 * @property string|null                                                                                                $phone
 * @property string|null                                                                                                $country_code
 * @property string|null                                                                                                $children_count
 * @property string|null                                                                                                $family_members
 * @property string|null                                                                                                $years_in_italy
 * @property string|null                                                                                                $nationality
 * @property Address|null                                                                                               $address
 * @property string|null                                                                                                $city
 * @property string|null                                                                                                $registration_number
 * @property string|null                                                                                                $fiscal_code
 * @property string|null                                                                                                $dental_problems
 * @property string|null                                                                                                $last_dental_visit
 * @property string|null                                                                                                $status
 * @property array<array-key, mixed>|null                                                                               $certifications
 * @property \Illuminate\Support\Carbon|null                                                                            $email_verified_at
 * @property string|null                                                                                                $password
 * @property string|null                                                                                                $remember_token
 * @property int|null                                                                                                   $current_team_id
 * @property string|null                                                                                                $profile_photo_path
 * @property \Illuminate\Support\Carbon|null                                                                            $deleted_at
 * @property string|null                                                                                                $lang
 * @property UserTypeEnum|null                                                                                          $type
 * @property string|null                                                                                                $data_privacy_form
 * @property string|null                                                                                                $doctor_certificate
 * @property array<array-key, mixed>|null                                                                               $certification
 * @property string|null                                                                                                $pregnancy_certificate
 * @property string|null                                                                                                $isee_certificate
 * @property string|null                                                                                                $identity_document
 * @property string|null                                                                                                $health_card
 * @property string|null                                                                                                $date_of_birth
 * @property string|null                                                                                                $gender
 * @property bool|null                                                                                                  $is_active
 * @property bool|null                                                                                                  $is_otp
 * @property \Illuminate\Support\Carbon|null                                                                            $password_expires_at
 * @property \Illuminate\Support\Carbon|null                                                                            $created_at
 * @property \Illuminate\Support\Carbon|null                                                                            $updated_at
 * @property string|null                                                                                                $updated_by
 * @property string|null                                                                                                $created_by
 * @property string|null                                                                                                $deleted_by
 * @property UserState|null                                                                                             $state
 * @property array<array-key, mixed>|null                                                                               $moderation_data
 * @property string|null                                                                                                $uuid
 * @property string|null                                                                                                $full_name
 * @property string|null                                                                                                $certificates
 * @property string|null                                                                                                $last_dental_visit_period
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent>                                $activeConsents
 * @property int|null                                                                                                   $active_consents_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity>                           $activities
 * @property int|null                                                                                                   $activities_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Appointment>                                                 $appointments
 * @property int|null                                                                                                   $appointments_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication>                         $authentications
 * @property int|null                                                                                                   $authentications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client>                                    $clients
 * @property int|null                                                                                                   $clients_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent>                                $consents
 * @property int|null                                                                                                   $consents_count
 * @property \Modules\User\Models\Team|null                                                                             $currentTeam
 * @property \Modules\User\Models\Membership|DoctorStudio|\Modules\User\Models\DeviceUser|null                          $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device>                                 $devices
 * @property int|null                                                                                                   $devices_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User>                                   $all_team_users
 * @property \Modules\User\Models\AuthenticationLog|null                                                                $latestAuthentication
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null                                                                                                   $media_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification>           $notifications
 * @property int|null                                                                                                   $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                   $ownedTeams
 * @property int|null                                                                                                   $owned_teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission>                             $permissions
 * @property int|null                                                                                                   $permissions_count
 * @property Profile|null                                                                                               $profile
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role>                                   $roles
 * @property int|null                                                                                                   $roles_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser>                          $socialiteUsers
 * @property int|null                                                                                                   $socialite_users_count
 * @property Studio|null                                                                                                $studio
 * @property \Illuminate\Database\Eloquent\Collection<int, Studio>                                                      $studios
 * @property int|null                                                                                                   $studios_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership>                             $teamUsers
 * @property int|null                                                                                                   $team_users_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team>                                   $teams
 * @property int|null                                                                                                   $teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Studio>                                                      $tenants
 * @property int|null                                                                                                   $tenants_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token>                                     $tokens
 * @property int|null                                                                                                   $tokens_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment>                              $treatments
 * @property int|null                                                                                                   $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor doctors()
 * @method static \Modules\SaluteOra\Database\Factories\DoctorFactory  factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor wherePregnancyCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereYearsInItaly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 * @property string|null $age_range
 * @property-read array $schedule
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereAgeRange($value)
 */
	class Doctor extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Modello pivot per la relazione many-to-many tra Doctor e Studio.
 * 
 * IMPORTANTE: Questa relazione attraversa database differenti:
 * - Doctor risiede nel database 'user'
 * - Studio risiede nel database 'salute_ora'
 * - DoctorStudio deve utilizzare la stessa connessione di Studio
 * 
 * Estende BasePivot per garantire compatibilità con belongsToManyX e policy Xot.
 *
 * @property int $id
 * @property string $doctor_id
 * @property string $studio_id
 * @property array|null $schedule
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\SaluteOra\Models\Doctor $doctor
 * @property-read \Modules\SaluteOra\Models\Studio $studio
 * @property string|null $type
 * @property string $user_id
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorStudio whereUserId($value)
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read int|null $appointments_count
 * @mixin \Eloquent
 */
	class DoctorStudio extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property int $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorTeam whereUserId($value)
 * @mixin \Eloquent
 */
	class DoctorTeam extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Class Patient
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property \Carbon\Carbon|null $birth_date Alias for date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $fiscal_code
 * @property string|null $pregnancy_status
 * @property int|null $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $city
 * @property string|null $registration_number
 * @property string|null $status
 * @property array<array-key, mixed>|null $certifications
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Modules\SaluteOra\States\User\UserState|null $state
 * @property array<array-key, mixed>|null $moderation_data
 * @property string|null $lang
 * @property \Modules\SaluteOra\Enums\UserTypeEnum|null $type
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Illuminate\Support\Carbon|null $password_expires_at
 * @property string|null $uuid
 * @property string|null $full_name
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $activeConsents
 * @property-read int|null $active_consents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication> $authentications
 * @property-read int|null $authentications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $consents
 * @property-read int|null $consents_count
 * @property-read \Modules\User\Models\Team|null $currentTeam
 * @property-read \Modules\User\Models\AuthenticationLog|null $latestAuthentication
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser> $socialiteUsers
 * @property-read int|null $socialite_users_count
 * @property-read \Modules\SaluteOra\Models\PatientStudio|\Modules\SaluteOra\Models\PatientTeam|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property string|null $dental_problems
 * @property string|null $last_dental_visit
 * @property string|null $pregnancy_certificate
 * @property string|null $isee_certificate
 * @property string|null $identity_document
 * @property string|null $health_card
 * @property string|null $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePregnancyCertificate($value)
 * @property string|null $country_code
 * @property string|null $children_count
 * @property string|null $family_members
 * @property string|null $years_in_italy
 * @property string|null $nationality
 * @property string|null $data_privacy_form
 * @property string|null $doctor_certificate
 * @property array<array-key, mixed>|null $certification
 * @property string|null $last_dental_visit_period
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User> $all_team_users
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereYearsInItaly($value)
 * @mixin \Eloquent
 * @property null|\Modules\SaluteOra\Enums\PatientAgeRangeEnum $age_range
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $studios
 * @property-read int|null $studios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAgeRange($value)
 */
	class Patient extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property string|null $type
 * @property string $user_id
 * @property string $studio_id
 * @property array<array-key, mixed>|null $schedule Orari del dottore in questo studio
 * @property bool $is_primary Indica se è lo studio principale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStudio whereUserId($value)
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property-read User|null $user
 * @mixin \Eloquent
 */
	class PatientStudio extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property int $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientTeam whereUserId($value)
 * @mixin \Eloquent
 */
	class PatientTeam extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $postal_code
 * @property string $avatar
 * @property string|null $bio
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra
 * @property-read Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $deviceUsers
 * @property-read int|null $device_users_count
 * @property-read \Modules\User\Models\DeviceProfile|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read string|null $full_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $mobileDeviceUsers
 * @property-read int|null $mobile_device_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $mobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read Profile|null $updater
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read string|null $user_name
 * @method static \Modules\SaluteOra\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Modello Report.
 *
 * @property int $id
 * @property int $patient_id
 * @property int $appointment_id
 * @property int $doctor_id
 * @property string $status
 * @property bool $has_mouth_or_teeth_pain
 * @property string $mouth_teeth_pain_frequency
 * @property int $pregnancy_month
 * @property int $pregnancy_week
 * @property string $teeth_brushing_frequency
 * @property bool $smokes
 * @property bool $visits_dentist_yearly
 * @property bool $has_diseases
 * @property array<int, MedicalConditionEnum> $specify_diseases
 * @property bool $follows_diet_rules
 * @property bool $uses_asl_clinic_for_dental_care
 * @property bool $missing_teeth
 * @property array $specify_missing_teeth
 * @property string|null $more_info_missing_teeth
 * @property bool $decayed_teeth
 * @property array $specify_decayed_teeth
 * @property string|null $more_info_decayed_teeth
 * @property bool $has_fixed_prosthesis_or_implants
 * @property array $specify_prosthesis_or_implants
 * @property string|null $more_info_prosthesis
 * @property bool $has_tartar
 * @property array $specify_tartar
 * @property string|null $more_info_tartar
 * @property bool $has_plaque
 * @property array $specify_plaque
 * @property string|null $more_info_plaque
 * @property bool $needs_more_dental_care
 * @property string|null $further_notes
 * @property string|null $invoice
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @property-read \Modules\SaluteOra\Models\Doctor|null $doctor
 * @property-read \Modules\SaluteOra\Models\Appointment|null $appointment
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property string|null $period_start
 * @property string|null $period_end
 * @property string|null $parameters
 * @property string|null $last_generated_at
 * @property string|null $created_by
 * @property string|null $tenant_id
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\SaluteOra\Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static Builder<static>|Report newModelQuery()
 * @method static Builder<static>|Report newQuery()
 * @method static Builder<static>|Report query()
 * @method static Builder<static>|Report whereAppointmentId($value)
 * @method static Builder<static>|Report whereCreatedAt($value)
 * @method static Builder<static>|Report whereCreatedBy($value)
 * @method static Builder<static>|Report whereDecayedTeeth($value)
 * @method static Builder<static>|Report whereDeletedAt($value)
 * @method static Builder<static>|Report whereDeletedBy($value)
 * @method static Builder<static>|Report whereDescription($value)
 * @method static Builder<static>|Report whereFollowsDietRules($value)
 * @method static Builder<static>|Report whereFurtherNotes($value)
 * @method static Builder<static>|Report whereHasDiseases($value)
 * @method static Builder<static>|Report whereHasFixedProsthesisOrImplants($value)
 * @method static Builder<static>|Report whereHasMouthOrTeethPain($value)
 * @method static Builder<static>|Report whereHasPlaque($value)
 * @method static Builder<static>|Report whereHasTartar($value)
 * @method static Builder<static>|Report whereId($value)
 * @method static Builder<static>|Report whereInvoice($value)
 * @method static Builder<static>|Report whereLastGeneratedAt($value)
 * @method static Builder<static>|Report whereMissingTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoDecayedTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoMissingTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoPlaque($value)
 * @method static Builder<static>|Report whereMoreInfoProsthesis($value)
 * @method static Builder<static>|Report whereMoreInfoTartar($value)
 * @method static Builder<static>|Report whereMouthTeethPainFrequency($value)
 * @method static Builder<static>|Report whereName($value)
 * @method static Builder<static>|Report whereNeedsMoreDentalCare($value)
 * @method static Builder<static>|Report whereParameters($value)
 * @method static Builder<static>|Report wherePatientId($value)
 * @method static Builder<static>|Report wherePeriodEnd($value)
 * @method static Builder<static>|Report wherePeriodStart($value)
 * @method static Builder<static>|Report wherePregnancyMonth($value)
 * @method static Builder<static>|Report wherePregnancyWeek($value)
 * @method static Builder<static>|Report whereSmokes($value)
 * @method static Builder<static>|Report whereSpecifyDecayedTeeth($value)
 * @method static Builder<static>|Report whereSpecifyDiseases($value)
 * @method static Builder<static>|Report whereSpecifyMissingTeeth($value)
 * @method static Builder<static>|Report whereSpecifyPlaque($value)
 * @method static Builder<static>|Report whereSpecifyProsthesisOrImplants($value)
 * @method static Builder<static>|Report whereSpecifyTartar($value)
 * @method static Builder<static>|Report whereStatus($value)
 * @method static Builder<static>|Report whereTeethBrushingFrequency($value)
 * @method static Builder<static>|Report whereTenantId($value)
 * @method static Builder<static>|Report whereType($value)
 * @method static Builder<static>|Report whereUpdatedAt($value)
 * @method static Builder<static>|Report whereUpdatedBy($value)
 * @method static Builder<static>|Report whereUsesAslClinicForDentalCare($value)
 * @method static Builder<static>|Report whereVisitsDentistYearly($value)
 * @mixin \Eloquent
 */
	class Report extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Studio model for the SaluteOra module.
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $slug
 * @property string|null $website
 * @property string|null $registration_number
 * @property string|null $vat_number
 * @property string|null $description
 * @property array|null $opening_hours
 * @property array|null $services
 * @property bool $active
 * @property bool $is_active
 * @property int $owner_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Doctor> $doctors
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Address> $addresses
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read int|null $addresses_count
 * @property-read int|null $appointments_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\StudioUser|\Modules\SaluteOra\Models\DoctorStudio|null $pivot
 * @property-read int|null $doctors_count
 * @property-read string $services_string
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio active()
 * @method static \Modules\SaluteOra\Database\Factories\StudioFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inCity(string $city)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inPostalCode(string $postalCode)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inProvince(string $province)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio inRegion(string $region)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereOpeningHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Studio whereWebsite($value)
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $province
 * @property string|null $region
 * @property string $country
 * @property string|null $tax_code
 * @property string|null $settings
 * @property string|null $business_hours
 * @property string|null $model_type
 * @property string|null $model_id
 * @property-read string|null $full_address
 * @method static Builder<static>|Studio ofCap(string|int|null $cap)
 * @method static Builder<static>|Studio whereAddress($value)
 * @method static Builder<static>|Studio whereBusinessHours($value)
 * @method static Builder<static>|Studio whereCity($value)
 * @method static Builder<static>|Studio whereCountry($value)
 * @method static Builder<static>|Studio whereModelId($value)
 * @method static Builder<static>|Studio whereModelType($value)
 * @method static Builder<static>|Studio wherePostalCode($value)
 * @method static Builder<static>|Studio whereProvince($value)
 * @method static Builder<static>|Studio whereRegion($value)
 * @method static Builder<static>|Studio whereSettings($value)
 * @method static Builder<static>|Studio whereTaxCode($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Admin> $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Patient> $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Report> $reports
 * @property-read int|null $reports_count
 */
	class Studio extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * @property string $id
 * @property string|null $type
 * @property string $user_id
 * @property string $studio_id
 * @property array<array-key, mixed>|null $schedule Orari del dottore in questo studio
 * @property bool $is_primary Indica se è lo studio principale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereSchedule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudioUser whereUserId($value)
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @mixin \Eloquent
 */
	class StudioUser extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Modules\SaluteOra\Models\TeamUser.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser query()
 * @property int $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUuid($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class TeamUser extends \Eloquent {}
}

namespace Modules\SaluteOra\Models{
/**
 * Modello User per il modulo Patient.
 * 
 * Questo modello estende BaseUser e implementa Single Table Inheritance
 * per gestire i tipi di utente (doctor, patient).
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property UserTypeEnum $type
 * @property UserState $state
 * @property string|null $first_name
 * @property string|null $last_name
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $city
 * @property string|null $phone
 * @property string|null $lang
 * @property int|null $current_team_id
 * @property bool $is_active
 * @property bool $is_otp
 * @property \Carbon\Carbon|null $password_expires_at
 * @property int|null $studio_id
 * @property string|null $continuation_token
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @see \Modules\User\Models\BaseUser
 * @see \Modules\SaluteOra\Models\Doctor
 * @see \Modules\SaluteOra\Models\Patient
 * @property string|null $registration_number
 * @property string|null $status
 * @property array<array-key, mixed>|null $certifications
 * @property string|null $remember_token
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property array<array-key, mixed>|null $moderation_data
 * @property string|null $uuid
 * @property string|null $full_name
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $activeConsents
 * @property-read int|null $active_consents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Authentication> $authentications
 * @property-read int|null $authentications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Consent> $consents
 * @property-read int|null $consents_count
 * @property-read \Modules\User\Models\Team|null $currentTeam
 * @property-read \Modules\SaluteOra\Models\StudioUser|\Modules\SaluteOra\Models\TeamUser|\Modules\User\Models\DeviceUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read \Modules\User\Models\AuthenticationLog|null $latestAuthentication
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Modules\User\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser> $socialiteUsers
 * @property-read int|null $socialite_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Studio> $tenants
 * @property-read int|null $tenants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Gdpr\Models\Treatment> $treatments
 * @property-read int|null $treatments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User doctors()
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User patients()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @property string|null $dental_problems
 * @property string|null $last_dental_visit
 * @property string|null $pregnancy_certificate
 * @property string|null $isee_certificate
 * @property string|null $identity_document
 * @property string|null $health_card
 * @property string|null $certificates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertificates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDentalProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHealthCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdentityDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIseeCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastDentalVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePregnancyCertificate($value)
 * @property string|null $country_code
 * @property string|null $children_count
 * @property string|null $family_members
 * @property string|null $years_in_italy
 * @property string|null $nationality
 * @property string|null $fiscal_code
 * @property string|null $data_privacy_form
 * @property string|null $doctor_certificate
 * @property array<array-key, mixed>|null $certification
 * @property string|null $last_dental_visit_period
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User> $all_team_users
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereChildrenCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDataPrivacyForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDoctorCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFamilyMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastDentalVisitPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereYearsInItaly($value)
 * @mixin \Eloquent
 * @property string|null $age_range
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAgeRange($value)
 */
	class User extends \Eloquent implements \Spatie\ModelStates\HasStatesContract {}
}

namespace Modules\Tenant\Models{
/**
 * @property int|null $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Domain extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Authentication Model
 * 
 * Tracks user authentication attempts and sessions.
 *
 * @property int $id
 * @property string $type Type of authentication (e.g., 'login', 'logout')
 * @property string|null $ip_address IP address used for authentication
 * @property string|null $user_agent User agent string from the request
 * @property string|null $location Geographic location derived from IP
 * @property bool $login_successful Whether the login attempt was successful
 * @property Carbon|null $login_at When the login attempt occurred
 * @property Carbon|null $logout_at When the logout occurred
 * @property string $authenticatable_type The class name of the authenticatable model
 * @property string $authenticatable_id The ID of the authenticatable model
 * @property Carbon|null $created_at When the record was created
 * @property Carbon|null $updated_at When the record was last updated
 * @property-read Model|\Eloquent $authenticatable The authenticatable model instance
 * @method static Builder<static>|Authentication newModelQuery()
 * @method static Builder<static>|Authentication newQuery()
 * @method static Builder<static>|Authentication query()
 * @method static Builder<static>|Authentication whereCreatedAt($value)
 * @method static Builder<static>|Authentication whereId($value)
 * @method static Builder<static>|Authentication whereIpAddress($value)
 * @method static Builder<static>|Authentication whereLocation($value)
 * @method static Builder<static>|Authentication whereType($value)
 * @method static Builder<static>|Authentication whereUpdatedAt($value)
 * @method static Builder<static>|Authentication whereUserAgent($value)
 * @method static Builder<static>|Authentication whereLoginAt($value)
 * @method static Builder<static>|Authentication whereLogoutAt($value)
 * @method static Builder<static>|Authentication whereLoginSuccessful($value)
 * @method static Builder<static>|Authentication whereAuthenticatableType($value)
 * @method static Builder<static>|Authentication whereAuthenticatableId($value)
 * @mixin \Eloquent
 */
	class Authentication extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property int $id
 * @property string $authenticatable_type
 * @property int $authenticatable_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property bool $login_successful
 * @property \Illuminate\Support\Carbon|null $logout_at
 * @property bool $cleared_by_user
 * @property array|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $authenticatable
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\AuthenticationLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereAuthenticatableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereAuthenticatableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereClearedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLoginSuccessful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereLogoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationLog whereUserAgent($value)
 * @mixin \Eloquent
 */
	class AuthenticationLog extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Device model representing a user's device in the system.
 *
 * @property EloquentCollection<int, \Illuminate\Database\Eloquent\Model&UserContract> $users
 * @property int|null $users_count
 * @method static DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsRobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereIsTablet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereMobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereRobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereVersion($value)
 * @property DeviceUser $pivot
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string $id
 * @property string|null $mobile_id
 * @property array|null $languages
 * @property string|null $device
 * @property string|null $platform
 * @property string|null $browser
 * @property string|null $version
 * @property bool|null $is_robot
 * @property string|null $robot
 * @property bool|null $is_desktop
 * @property bool|null $is_mobile
 * @property bool|null $is_tablet
 * @property bool|null $is_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUuid($value)
 * @mixin \Eloquent
 */
	class Device extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * DeviceProfile Model
 * 
 * Represents the relationship between a device and a user profile.
 * Extends the base DeviceUser model to add specific functionality.
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property Device|null $device
 * @property \Modules\Xot\Contracts\ProfileContract|null $profile
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile query()
 * @mixin \Eloquent
 */
	class DeviceProfile extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\DeviceUser.
 *
 * @property Device|null $device
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser query()
 * @property string $id
 * @property string $device_id
 * @property string $user_id
 * @property Carbon|null $login_at
 * @property Carbon|null $logout_at
 * @property string|null $push_notifications_token
 * @property bool|null $push_notifications_enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereLogoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser wherePushNotificationsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser wherePushNotificationsToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceUser whereUserId($value)
 * @property ProfileContract|null $profile
 * @property UserContract|null $user
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class DeviceUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 * @method static \Illuminate\Database\Eloquent\Builder|Extra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extra query()
 * @method static \Illuminate\Database\Eloquent\Builder|Extra withExtraAttributes()
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\ExtraFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Extra extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\FeatureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @property string $id
 * @property string $name
 * @property string $scope
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereValue($value)
 * @mixin \Eloquent
 */
	class Feature extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Membership.
 *
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Membership query()
 * @property int $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUuid($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Membership whereDeletedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Membership extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\ModelHasPermission.
 *
 * @property int $id
 * @property int $permission_id
 * @property string $model_type
 * @property string $model_id
 * @method static ModelHasPermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission wherePermissionId($value)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string|null $team_id
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereTeamId($value)
 * @mixin \Eloquent
 */
	class ModelHasPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\ModelHasRole.
 *
 * @property string $id
 * @property string $role_id
 * @property string $model_type
 * @property string $model_id
 * @property int|null $team_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static ModelHasRoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereUpdatedBy($value)
 * @property string $uuid (DC2Type:guid)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasRole whereUuid($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class ModelHasRole extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification read()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification unread()
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\OauthAccessToken.
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $client_id
 * @property string|null $name
 * @property array|null $scopes
 * @property bool $revoked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property OauthClient|null $client
 * @property \Modules\Xot\Contracts\UserContract|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAccessToken whereUserId($value)
 * @property OauthRefreshToken|null $refreshToken
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthAccessToken whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthAccessToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthAccessToken whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OauthAccessToken whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class OauthAccessToken extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\OauthAuthCode.
 *
 * @property OauthClient|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode query()
 * @property string $id
 * @property string|null $user_id
 * @property string|null $client_id
 * @property string|null $scopes
 * @property bool $revoked
 * @property Carbon|null $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthAuthCode whereUserId($value)
 * @mixin \Eloquent
 */
	class OauthAuthCode extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\OauthClient.
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $name
 * @property string|null $secret
 * @property string|null $provider
 * @property string $redirect
 * @property bool $personal_access_client
 * @property bool $password_client
 * @property bool $revoked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<int, OauthAuthCode> $authCodes
 * @property int|null $auth_codes_count
 * @property array|null $grant_types
 * @property string|null $plain_secret
 * @property array|null $scopes
 * @property \Illuminate\Database\Eloquent\Collection<int, OauthAccessToken> $tokens
 * @property int|null $tokens_count
 * @property \Modules\Xot\Contracts\UserContract|null $user
 * @method static \Laravel\Passport\Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient wherePasswordClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient wherePersonalAccessClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereRedirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereUserId($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthClient whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class OauthClient extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\OauthPersonalAccessClient.
 *
 * @property string $uuid
 * @property string $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property OauthClient|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereUuid($value)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereId($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthPersonalAccessClient whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class OauthPersonalAccessClient extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\OauthRefreshToken.
 *
 * @property OauthAccessToken|null $accessToken
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken query()
 * @property string $id
 * @property string $access_token_id
 * @property bool $revoked
 * @property Carbon|null $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken whereAccessTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OauthRefreshToken whereRevoked($value)
 * @mixin \Eloquent
 */
	class OauthRefreshToken extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\PasswordReset.
 *
 * @property int $id
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static PasswordResetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUserId($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PasswordReset whereUuid($value)
 * @mixin \Eloquent
 */
	class PasswordReset extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Class Permission.
 * 
 * Extends Spatie's Permission model to interact with the permission system.
 *
 * @property string $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Collection<int, Role> $roles
 * @property int|null $roles_count
 * @property EloquentCollection<int, \Illuminate\Database\Eloquent\Model&UserContract> $users
 * @property int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @property EloquentCollection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission withoutRole($roles, $guard = null)
 * @property PermissionRole|null $pivot
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole query()
 * @property string $id
 * @property string|null $permission_id
 * @property string|null $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class PermissionRole extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\PermissionUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PermissionUser query()
 * @mixin \Eloquent
 */
	class PermissionUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * User Profile Model
 * 
 * Represents a user profile with relationships to devices, teams, and roles.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $bio
 * @property string|null $avatar
 * @property string|null $timezone
 * @property string|null $locale
 * @property array $preferences
 * @property string $status
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra
 * @property-read string $avatar
 * @property-read ProfileContract|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $deviceUsers
 * @property-read int|null $device_users_count
 * @property-read \Modules\User\Models\ProfileTeam|\Modules\User\Models\DeviceProfile|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read string|null $first_name
 * @property-read string|null $full_name
 * @property-read string|null $last_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $mobileDeviceUsers
 * @property-read int|null $mobile_device_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $mobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read ProfileContract|null $updater
 * @property-read UserContract|null $user
 * @property-read string|null $user_name
 * @method static \Modules\User\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * ProfileTeam Model
 * 
 * Represents the relationship between a profile and a team, including the user's role.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string $id
 * @property int $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfileTeam whereUserId($value)
 * @mixin \Eloquent
 */
	class ProfileTeam extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Role.
 *
 * @property string $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property Team|null $team
 * @property EloquentCollection<int, Model&UserContract> $users
 * @property int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUuid($value)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedBy($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 * @property PermissionRole|null $pivot
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\RoleHasPermission.
 *
 * @property int $id
 * @property int $permission_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereRoleId($value)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class RoleHasPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property int|null $id
 * @property string|null $name
 * @property array|null $scopes
 * @property array|null $parameters
 * @property bool|null $stateless
 * @property bool|null $active
 * @property bool|null $socialite
 * @property string|null $svg
 * @property string|null $client_id
 * @property string|null $client_secret
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\SocialProviderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereClientSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereSocialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereStateless($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereSvg($value)
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class SocialProvider extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\SocialiteUser.
 *
 * @property int $id
 * @property string $user_id
 * @property string $provider
 * @property string $provider_id
 * @property string|null $token
 * @property string|null $name
 * @property string|null $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Modules\Xot\Contracts\UserContract|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUserId($value)
 * @property string $uuid (DC2Type:guid)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialiteUser whereUuid($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class SocialiteUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Class Modules\User\Models\Team.
 *
 * @property string $id
 * @property string $user_id (DC2Type:guid)
 * @property string $name
 * @property int $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property TeamUser $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, User> $members
 * @property int|null $members_count
 * @property User|null $owner
 * @property \Illuminate\Database\Eloquent\Collection<int, TeamInvitation> $teamInvitations
 * @property int|null $team_invitations_count
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property int|null $users_count
 * @method static \Modules\User\Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePersonalTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUserId($value)
 * @property string|null $code
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCode($value)
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUuid($value)
 * @property string|null $owner_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereOwnerId($value)
 * @mixin \Eloquent
 */
	class Team extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TeamInvitation.
 *
 * @property int $id
 * @property string|null $team_id
 * @property string $email
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Team|null $team
 * @property TeamContract|null $team
 * @method static TeamInvitationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedAt($value)
 * @property string $uuid
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamInvitation whereUuid($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class TeamInvitation extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Team Permission Model
 * 
 * Represents a permission assigned to a user within a team context.
 *
 * @property string $id
 * @property string $team_id
 * @property string $user_id
 * @property string $permission
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property Team $team
 * @property User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamPermission query()
 * @mixin \Eloquent
 */
	class TeamPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TeamUser.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser query()
 * @property int $id
 * @property string $uuid
 * @property string|null $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUuid($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereDeletedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class TeamUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Tenant.
 *
 * @method static \Modules\User\Database\Factories\TenantFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant query()
 * @property EloquentCollection<int, Model&UserContract> $members
 * @property int|null $members_count
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property int|null $media_count
 * @property TenantUser $pivot
 * @property EloquentCollection<int, User> $users
 * @property int|null $users_count
 * @mixin \Eloquent
 */
	class Tenant extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TenantUser.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser query()
 * @property int $id
 * @property string|null $tenant_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamUser whereUuid($value)
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereTenantId($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class TenantUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Class Modules\User\Models\User.
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $password_expires_at
 * @property string|null $lang
 * @property bool $is_active
 * @property bool $is_otp
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property \Illuminate\Database\Eloquent\Collection<int, AuthenticationLog> $authentications
 * @property int|null $authentications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, OauthClient> $clients
 * @property int|null $clients_count
 * @property TenantUser $pivot
 * @property \Illuminate\Database\Eloquent\Collection<int, Device> $devices
 * @property int|null $devices_count
 * @property string|null $full_name
 * @property AuthenticationLog|null $latestAuthentication
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, Notification> $notifications
 * @property int|null $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Team> $ownedTeams
 * @property int|null $owned_teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property ProfileContract|null $profile
 * @property \Illuminate\Database\Eloquent\Collection<int, Role> $roles
 * @property int|null $roles_count
 * @property Membership $membership
 * @property \Illuminate\Database\Eloquent\Collection<int, Team> $teams
 * @property int|null $teams_count
 * @property \Illuminate\Database\Eloquent\Collection<int, Tenant> $tenants
 * @property int|null $tenants_count
 * @property \Illuminate\Database\Eloquent\Collection<int, OauthAccessToken> $tokens
 * @property int|null $tokens_count
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @property string $last_name
 * @property-read \Modules\User\Models\Team|null $currentTeam
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\SocialiteUser> $socialiteUsers
 * @property-read int|null $socialite_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Membership> $teamUsers
 * @property-read int|null $team_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\User> $all_team_users
 * @mixin \Eloquent
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $registration_number
 * @property string|null $status
 * @property string|null $state
 * @property string|null $moderation_data
 * @property string|null $certifications
 * @property string|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereModerationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 */
	class User extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Cache.
 *
 * @property string $key
 * @property string $value
 * @property int    $expiration
 * @method static \Modules\Xot\Database\Factories\CacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereValue($value)
 * @property int $expiration
 * @method static \Modules\Xot\Database\Factories\CacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cache  whereValue($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Cache extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\CacheLock.
 *
 * @property string $key
 * @property string $owner
 * @property int    $expiration
 * @method static \Modules\Xot\Database\Factories\CacheLockFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  query()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereOwner($value)
 * @property int $expiration
 * @method static \Modules\Xot\Database\Factories\CacheLockFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  query()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheLock  whereOwner($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class CacheLock extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Model Extra.
 *
 * @property int                                               $id
 * @property int|null                                          $model_id
 * @property string|null                                       $model_type
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel       disableCache()
 * @method static \Modules\Xot\Database\Factories\ExtraFactory          factory($count = null, $state = [])
 * @method static \Illuminate\Contracts\Database\Eloquent\Builder|Extra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extra           newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extra           query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel       withCacheCooldownSeconds(?int $seconds = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra           withExtraAttributes()
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extra whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Extra extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Feed.
 *
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Feed extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property int                             $id
 * @property string $check_name
 * @property string $check_label
 * @property string $status
 * @property string|null                     $notification_message
 * @property string|null                     $short_summary
 * @property array                           $meta
 * @property string $ended_at
 * @property string $batch
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereCheckLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereCheckName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereNotificationMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereShortSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereUpdatedAt($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HealthCheckResultHistoryItem whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class HealthCheckResultHistoryItem extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Represents a table in the INFORMATION_SCHEMA.TABLES.
 * 
 * Provides metadata and statistics about database tables.
 *
 * @property string|null $TABLE_CATALOG
 * @property string|null $TABLE_SCHEMA
 * @property string|null $TABLE_NAME
 * @property string|null $TABLE_TYPE
 * @property string|null $ENGINE
 * @property int|null $VERSION
 * @property string|null $ROW_FORMAT
 * @property int|null $TABLE_ROWS
 * @property int|null $AVG_ROW_LENGTH
 * @property int|null $DATA_LENGTH
 * @property int|null $MAX_DATA_LENGTH
 * @property int|null $INDEX_LENGTH
 * @property int|null $DATA_FREE
 * @property int|null $AUTO_INCREMENT
 * @property \Illuminate\Support\Carbon|null $CREATE_TIME
 * @property \Illuminate\Support\Carbon|null $UPDATE_TIME
 * @property \Illuminate\Support\Carbon|null $CHECK_TIME
 * @property string|null $TABLE_COLLATION
 * @property int|null $CHECKSUM
 * @property string|null $CREATE_OPTIONS
 * @property string|null $TABLE_COMMENT
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereAUTOINCREMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereAVGROWLENGTH($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereCHECKSUM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereCHECKTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereCREATEOPTIONS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereCREATETIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereDATAFREE($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereDATALENGTH($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereENGINE($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereINDEXLENGTH($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereMAXDATALENGTH($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereROWFORMAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLECATALOG($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLECOLLATION($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLECOMMENT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLENAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLEROWS($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLESCHEMA($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereTABLETYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereUPDATETIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformationSchemaTable whereVERSION($value)
 * @mixin \Eloquent
 */
	class InformationSchemaTable extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Feed.
 *
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feed  query()
 * @property string|null $id
 * @property string|null $name
 * @property int|null    $size
 * @property string|null $file_content
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereSize($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Log extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property int         $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null   $status
 * @property int|null    $priority
 * @property string|null $path
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereStatus($value)
 * @property string|null $icon
 * @property array<string, string>|null $colors
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereColors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereIcon($value)
 * @mixin \Eloquent
 */
	class Module extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Xot\Database\Factories\PulseAggregateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate  query()
 * @property int         $id
 * @property int         $bucket
 * @property int         $period
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property string $aggregate
 * @property string $value
 * @property int|null    $count
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereAggregate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereBucket($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereKeyHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseAggregate whereValue($value)
 * @mixin \Eloquent
 */
	class PulseAggregate extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Xot\Database\Factories\PulseEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry  query()
 * @property int         $id
 * @property int         $timestamp
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property int|null    $value
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereKeyHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseEntry whereValue($value)
 * @mixin \Eloquent
 */
	class PulseEntry extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Xot\Database\Factories\PulseValueFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue  query()
 * @property int         $id
 * @property int         $timestamp
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereKeyHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PulseValue whereValue($value)
 * @mixin \Eloquent
 */
	class PulseValue extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Session.
 *
 * @property int                             $id
 * @property int|null                        $user_id
 * @property string|null                     $ip_address
 * @property string|null                     $user_agent
 * @property string $payload
 * @property int                             $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @method static \Modules\Xot\Database\Factories\SessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Session  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUserId($value)
 * @property int                             $id
 * @property int|null                        $user_id
 * @property string|null                     $ip_address
 * @property string|null                     $user_agent
 * @property string $payload
 * @property int                             $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $created_by
 * @property string|null                     $updated_by
 * @method static \Modules\Xot\Database\Factories\SessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Session  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  query()
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session  whereUserId($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Session whereDeletedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Session extends \Eloquent {}
}

