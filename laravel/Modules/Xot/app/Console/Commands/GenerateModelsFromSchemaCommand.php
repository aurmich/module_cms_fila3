<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Safe\Exceptions\DatetimeException;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\PcreException;
use function Safe\date;
use function Safe\json_decode;
use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Class GenerateModelsFromSchemaCommand.
 */
class GenerateModelsFromSchemaCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'db:models:generate {--schema=database/schema.json} {--output=app/Models} {--namespace=App\\Models}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Generate Eloquent models from database schema';

    /**
     * Tipi di dati SQL e loro corrispondenze in PHP/Laravel.
     *
     * @var array<string, string>
     */
    protected $typeMappings = [
        'int' => 'integer',
        'tinyint' => 'boolean',
        'smallint' => 'integer',
        'mediumint' => 'integer',
        'bigint' => 'integer',
        'float' => 'float',
        'double' => 'double',
        'decimal' => 'decimal',
        'char' => 'string',
        'varchar' => 'string',
        'tinytext' => 'string',
        'text' => 'string',
        'mediumtext' => 'string',
        'longtext' => 'string',
        'json' => 'json',
        'binary' => 'binary',
        'varbinary' => 'binary',
        'blob' => 'binary',
        'tinyblob' => 'binary',
        'mediumblob' => 'binary',
        'longblob' => 'binary',
        'date' => 'date',
        'datetime' => 'datetime',
        'timestamp' => 'timestamp',
        'time' => 'time',
        'year' => 'integer',
        'enum' => 'string',
        'set' => 'string',
        'bit' => 'boolean',
    ];

    /**
     * Esegui il comando console.
     *
     * @throws JsonException
     * @throws PcreException
     * @throws DatetimeException
     */
    public function handle(): void
    {
        $schemaPath = $this->option('schema');
        $outputPath = $this->option('output');
        $namespace = $this->option('namespace');

        if (! File::exists($schemaPath)) {
            $this->error("Schema file not found: {$schemaPath}");

            return;
        }

        $schema = json_decode(File::get($schemaPath), true);

        if (! File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }

        foreach ($schema['tables'] as $tableName => $table) {
            $this->generateModel($tableName, $table, $outputPath, $namespace);
        }

        $this->info('Models generated successfully!');
    }

    /**
     * Generate a model class from table schema.
     *
     * @param array<string, mixed> $table
     * @throws PcreException
     * @throws DatetimeException
     */
    protected function generateModel(string $tableName, array $table, string $outputPath, string $namespace): void
    {
        $modelName = $this->getModelName($tableName);
        $fillable = $this->getFillableFields($table['columns']);
        $casts = $this->getCasts($table['columns']);
        $relations = $this->getRelations($table['foreign_keys'] ?? []);

        $template = $this->getModelTemplate(
            $modelName,
            $namespace,
            $tableName,
            $fillable,
            $casts,
            $relations
        );

        $filePath = $outputPath.'/'.$modelName.'.php';
        File::put($filePath, $template);

        $this->info("Generated model: {$modelName}");
    }

    /**
     * Get the model class name from table name.
     */
    protected function getModelName(string $tableName): string
    {
        return Str::studly(Str::singular($tableName));
    }

    /**
     * Get fillable fields from columns.
     *
     * @param array<string, array<string, mixed>> $columns
     * @return array<int, string>
     */
    protected function getFillableFields(array $columns): array
    {
        $fillable = [];
        foreach ($columns as $name => $column) {
            if (! in_array($name, ['id', 'created_at', 'updated_at', 'deleted_at'], true)) {
                $fillable[] = $name;
            }
        }

        return $fillable;
    }

    /**
     * Get casts from columns.
     *
     * @param array<string, array<string, mixed>> $columns
     * @return array<string, string>
     */
    protected function getCasts(array $columns): array
    {
        $casts = [];
        foreach ($columns as $name => $column) {
            $type = $column['type'];
            $cast = match ($type) {
                'integer', 'bigint', 'smallint' => 'integer',
                'decimal', 'float' => 'float',
                'boolean' => 'boolean',
                'date' => 'date',
                'datetime', 'timestamp' => 'datetime',
                'json' => 'array',
                default => null,
            };

            if (null !== $cast) {
                $casts[$name] = $cast;
            }
        }

        return $casts;
    }

    /**
     * Get relations from foreign keys.
     *
     * @param array<string, array<string, mixed>> $foreignKeys
     * @return array<string, array{type: string, model: string, key: string, foreignKey: string}>
     */
    protected function getRelations(array $foreignKeys): array
    {
        $relations = [];
        foreach ($foreignKeys as $name => $fk) {
            $relatedTable = $fk['references_table'];
            $relatedModel = $this->getModelName($relatedTable);
            $methodName = Str::camel($relatedTable);

            if (preg_match('/^(.+)_id$/', $fk['column'], $matches)) {
                $methodName = Str::camel($matches[1]);
            }

            $relations[$methodName] = [
                'type' => 'belongsTo',
                'model' => $relatedModel,
                'key' => $fk['column'],
                'foreignKey' => $fk['references_column'],
            ];
        }

        return $relations;
    }

    /**
     * Get the model class template.
     *
     * @param array<int, string> $fillable
     * @param array<string, string> $casts
     * @param array<string, array{type: string, model: string, key: string, foreignKey: string}> $relations
     * @throws DatetimeException
     */
    protected function getModelTemplate(
        string $modelName,
        string $namespace,
        string $tableName,
        array $fillable,
        array $casts,
        array $relations
    ): string {
        $fillableStr = preg_replace(
            '/^/m',
            '        ',
            var_export($fillable, true)
        );

        $castsStr = preg_replace(
            '/^/m',
            '        ',
            var_export($casts, true)
        );

        $relationsStr = '';
        foreach ($relations as $methodName => $relation) {
            $relationsStr .= $this->getRelationMethod($methodName, $relation);
        }

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class {$modelName}
 * @package {$namespace}
 *
 * @property-read int \$id
 * @property \Carbon\Carbon \$created_at
 * @property \Carbon\Carbon \$updated_at
 * Generated on: {$this->getCurrentDate()}
 */
class {$modelName} extends Model
{
    protected \$table = '{$tableName}';

    protected \$fillable = {$fillableStr};

    protected \$casts = {$castsStr};
{$relationsStr}
}

PHP;
    }

    /**
     * Get the relation method template.
     *
     * @param array{type: string, model: string, key: string, foreignKey: string} $relation
     */
    protected function getRelationMethod(string $methodName, array $relation): string
    {
        return <<<PHP

    public function {$methodName}(): BelongsTo
    {
        return \$this->belongsTo({$relation['model']}::class, '{$relation['key']}', '{$relation['foreignKey']}');
    }
PHP;
    }

    /**
     * Get the current date formatted.
     *
     * @throws DatetimeException
     */
    protected function getCurrentDate(): string
    {
        return date('Y-m-d H:i:s');
    }
}
