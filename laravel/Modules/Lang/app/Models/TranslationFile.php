<?php

declare(strict_types=1);

/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Models/Translation.php
 */

namespace Modules\Lang\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Actions\ReadTranslationFileAction;
use Modules\Lang\Actions\WriteTranslationFileAction;
use function Safe\json_encode;

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
class TranslationFile extends BaseModel
{
    use \Sushi\Sushi;

    protected $fillable = [
        'id',
        'name',
        'path',
        'content',
    ];

    protected array $schema = [
        'key' => "string",
        'path' => "string",
        'id' => "string",
        'name' => "string",
        'content' => 'json',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function getRows(): array
    {
        $files = app(GetAllTranslationAction::class)->execute();
        $rows = Arr::map($files, function($item) {
            $item['id'] = $item['key'];
            $item['name'] = basename($item['path'], '.php');


            $item['content']=json_encode(File::getRequire($item['path']));
            /*
            // Carica il contenuto del file
            try {
                $readAction = app(ReadTranslationFileAction::class);
                $item['content'] = $readAction->execute($item['path']);
            } catch (\Exception $e) {
                $item['content'] = [];
            }
            */
            //dddx($item);
            return $item;
        });
        return $rows;
    }

   
}