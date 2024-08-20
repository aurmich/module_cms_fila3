<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;

// --- services
// --- TRAITS ---
/**
 * Modules\Xot\Models\Feed.
 *
 * @method static \Modules\Xot\Database\Factories\FeedFactory factory($count = null, $state = [])
<<<<<<< HEAD
 * @method static Builder|Feed newModelQuery()
 * @method static Builder|Feed newQuery()
 * @method static Builder|Feed query()
 * @method static Builder|Feed newModelQuery()
 * @method static Builder|Feed newQuery()
 * @method static Builder|Feed query()
 *
 * @property string|null $id
 * @property string|null $name
 * @property int|null $size
=======
 * @method static Builder|Feed                                newModelQuery()
 * @method static Builder|Feed                                newQuery()
 * @method static Builder|Feed                                query()
 * @method static Builder|Feed                                newModelQuery()
 * @method static Builder|Feed                                newQuery()
 * @method static Builder|Feed                                query()
 *
 * @property string|null $id
 * @property string|null $name
 * @property int|null    $size
>>>>>>> 35d9347 (.)
 * @property string|null $file_content
 *
 * @method static Builder|Log whereId($value)
 * @method static Builder|Log whereName($value)
 * @method static Builder|Log whereSize($value)
 *
<<<<<<< HEAD
 * @property-read \Modules\Fixcity\Models\Profile|null $creator
 * @property-read \Modules\Fixcity\Models\Profile|null $updater
 *
=======
>>>>>>> 35d9347 (.)
 * @mixin \Eloquent
 */
class Log extends BaseModel
{
    use \Sushi\Sushi;

    protected $fillable = ['id', 'name', 'size'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'size' => 'integer',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',

            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }

    public function getRows(): array
    {
        $rows = [];
        $files = File::files(storage_path('logs'));

        foreach ($files as $file) {
<<<<<<< HEAD
            if ($file->getExtension() == 'log') {
=======
            if ('log' == $file->getExtension()) {
>>>>>>> 35d9347 (.)
                $rows[] = [
                    'id' => $file->getFilenameWithoutExtension(),
                    'name' => $file->getFilenameWithoutExtension(),
                    'size' => $file->getSize(),
                ];
            }
        }

        return $rows;
    }

    public function getFileContentAttribute(?string $value): ?string
    {
        return File::get(storage_path('logs/'.$this->id.'.log'));
    }
}

/*
           dddx([
               'getRelativePath' => $file->getRelativePath(), // ""
               'getRelativePathname' => $file->getRelativePathname(),
               'getFilenameWithoutExtension' => $file->getFilenameWithoutExtension(),
               // 'getContents' => $file->getContents(),
               'getPath' => $file->getPath(),
               'getFilename' => $file->getFilename(),
               'getExtension' => $file->getExtension(), // log
               'getBasename' => $file->getBasename(),
               'getPathname' => $file->getPathname(),
               'getPerms' => $file->getPerms(),
               'getInode' => $file->getInode(),
               'getSize' => $file->getSize(), // 12497
               'getOwner' => $file->getOwner(),
               'getGroup' => $file->getGroup(),
               'getATime' => $file->getATime(),
               'getMTime' => $file->getMTime(),
               'getCTime' => $file->getCTime(),
               'getType' => $file->getType(),
               'isWritable' => $file->isWritable(),
               'isReadable' => $file->isReadable(),
               'isExecutable' => $file->isExecutable(),
               'isFile' => $file->isFile(),
               'isDir' => $file->isDir(),
               'isLink' => $file->isLink(),
               'getLinkTarget' => $file->getLinkTarget(),
               'getRealPath' => $file->getRealPath(),
               'getFileInfo' => $file->getFileInfo(),
               'getPathInfo' => $file->getPathInfo(),
               'get_class_methods' => get_class_methods($file),
           ]);

           "getRelativePath" => ""
   "getRelativePathname" => "laravel-2024-03-01.log"
   "getFilenameWithoutExtension" => "laravel-2024-03-01"
   "getPath" => "C:\var\www\_bases\base_camping_fila3\laravel\storage\logs"
   "getFilename" => "laravel-2024-03-01.log"
   "getExtension" => "log"
   "getBasename" => "laravel-2024-03-01.log"
   "getPathname" => "C:\var\www\_bases\base_camping_fila3\laravel\storage\logs\laravel-2024-03-01.log"
   "getPerms" => 33206
   "getInode" => 32369622322094035
   "getSize" => 12497
   "getOwner" => 0
   "getGroup" => 0
   "getATime" => 1709646780
   "getMTime" => 1709314074
   "getCTime" => 1709313704
   "getType" => "file"
   "isWritable" => true
   "isReadable" => true
   "isExecutable" => false
   "isFile" => true
   "isDir" => false
   "isLink" => false
   "getLinkTarget" => "C:\var\www\_bases\base_camping_fila3\laravel\storage\logs\laravel-2024-03-01.log"
   "getRealPath" => "C:\var\www\_bases\base_camping_fila3\laravel\storage\logs\laravel-2024-03-01.log"
   */
