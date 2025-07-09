<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Trait Modules\Xot\Models\Traits\RelationX.
 */
trait RelationX
{
    /**
     * @param class-string<Model>             $related         aaa
     * @param class-string<Model>|string|null $table           aaa
     * @param string|null                     $foreignPivotKey aaa
     * @param string|null                     $relatedPivotKey aaa
     * @param string|null                     $parentKey       aaa
     * @param string|null                     $relatedKey      aaa
     * @param string|null                     $relation        aaa
     */
    public function belongsToManyX(
        string $related,
        ?string $table = null,
        ?string $foreignPivotKey = null,
        ?string $relatedPivotKey = null,
        ?string $parentKey = null,
        ?string $relatedKey = null,
        ?string $relation = null,
    ): BelongsToMany {
        Assert::isInstanceOf($related_model = app($related), Model::class, '['.__LINE__.']['.class_basename($this).']');
        $pivot = $this->guessPivot($related);
        $table = $pivot->getTable();
        $pivotFields = $pivot->getFillable();

        $pivotDbName = $pivot->getConnection()->getDatabaseName();
        $dbName = $this->getConnection()->getDatabaseName();
        $relatedDbName = $related_model->getConnection()->getDatabaseName();
        // if ($pivotDbName !== $dbName) {
        if ($pivotDbName != $dbName || $relatedDbName != $dbName) {
            $table = $pivotDbName.'.'.$table;
        }
        // }
        
        return $this->belongsToMany(
            related: $related,
            table: $table,
            foreignPivotKey: $foreignPivotKey,
            relatedPivotKey: $relatedPivotKey,
            parentKey: $parentKey,
            relatedKey: $relatedKey,
            relation: $relation,
        )
            ->using($pivot::class)
            ->withPivot($pivotFields)
            ->withTimestamps();
    }


    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TRelatedModel>  $related
     * @param  string  $name
     * @param  string|null  $table
     * @param  string|null  $foreignPivotKey
     * @param  string|null  $relatedPivotKey
     * @param  string|null  $parentKey
     * @param  string|null  $relatedKey
     * @param  string|null  $relation
     * @param  bool  $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany<TRelatedModel, $this>
     */
    public function morphToManyX($related, $name, $table = null, $foreignPivotKey = null,
                                $relatedPivotKey = null, $parentKey = null,
                                $relatedKey = null, $relation = null, $inverse = false)
    {
       
        $pivot = $this->guessMorphPivot($related);
        $table = $pivot->getTable();
        $pivotFields = $pivot->getFillable();

        $pivotDbName = $pivot->getConnection()->getDatabaseName();
        $dbName = $this->getConnection()->getDatabaseName();
        //$relatedDbName = $related_model->getConnection()->getDatabaseName();
        if($table==null){
            $table = $pivot->getTable();
        }
        return $this->morphToMany(
            related: $related,
            name: $name,
            table: $table,
            foreignPivotKey: $foreignPivotKey,
            relatedPivotKey: $relatedPivotKey,
            parentKey: $parentKey,
            relatedKey: $relatedKey,
            relation: $relation,
            inverse: $inverse,
        )
        ->using($pivot::class)
        ->withPivot($pivotFields)
        ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphPivot
     */
    public function guessMorphPivot(string $related,?string $class = null)
    {
        $class = $this::class;
        $pivot_name = class_basename($related).'Morph';
        /*
        $pivot_class = Str::of($this::class)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        if (! class_exists($pivot_class)) {
            $pivot_class = Str::of($related)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        }
        */
        $pivot_class = $this->guessPivotFullClass($pivot_name, $related, $class);
        $pivot = app($pivot_class);
        Assert::isInstanceOf($pivot,\Illuminate\Database\Eloquent\Relations\MorphPivot::class);
        return $pivot;
    }

    /**
     * Guess the pivot class for a many-to-many relationship.
     *
     * @param string $related The related model class name
     * @param string|class-string|null $class The class to use for parent class lookup (used internally)
     * @return \Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function guessPivot(string $related, ?string $class = null)
    {
        $class = $class ?? $this::class;
        $model_names = [
            class_basename($class),
            class_basename($related),
        ];
        sort($model_names);
        $pivot_name = implode('', $model_names);
        /*
        $pivot_class = Str::of($this::class)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        if (! class_exists($pivot_class)) {
            $pivot_class = Str::of($related)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        }
        if (! class_exists($pivot_class)) {
            if(get_parent_class($class)!==false){
                return $this->guessPivot($related, get_parent_class($class));
            }
        }
        */
        $pivot_class = $this->guessPivotFullClass($pivot_name, $related, $class);
        
        $pivot = app($pivot_class);
        Assert::isInstanceOf($pivot, \Illuminate\Database\Eloquent\Relations\Pivot::class);

        return $pivot;
    }

    public function guessPivotFullClass(string $pivot_name, string $related, ?string $class = null):string{
        $class = $class ?? $this::class;
        $pivot_class = Str::of($class)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        if (! class_exists($pivot_class)) {
            $pivot_class = Str::of($related)
            ->beforeLast('\\')
            ->append('\\'.$pivot_name)
            ->toString();
        }
        if (! class_exists($pivot_class)) {
            if(get_parent_class($class)!==false){
                return $this->guessPivotFullClass($pivot_name, $related, get_parent_class($class));
            }
        }
        return $pivot_class;
    }
}
