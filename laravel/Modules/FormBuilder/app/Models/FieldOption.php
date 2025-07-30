<?php

namespace Modules\FormBuilder\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;



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