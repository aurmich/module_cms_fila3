<?php

namespace Modules\FormBuilder\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;



/**
 * @property string $id
 * @property array<array-key, mixed> $name
 * @property string|null $type
 * @property string|null $key
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
 * @mixin \Eloquent
 */
class FieldOption extends BaseModel
{
    use HasTranslations;
    public static ?string $type=null;

    public array $translatable = ['name'];

    /** @var list<string> */
    protected $fillable = ['name', 'key', 'type'];


    public static function setType(string $type): string
    {
        self::$type = $type;
        return self::class;
    }
    protected static function booted(): void
    {
        static::addGlobalScope('type_scope', function (Builder $builder) {
            if(self::$type){
                $builder->where('type', self::$type);
            }
        });
    }
}