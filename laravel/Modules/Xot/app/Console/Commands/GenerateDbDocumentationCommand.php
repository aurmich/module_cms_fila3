<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Class GenerateDbDocumentationCommand.
 */
class GenerateDbDocumentationCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'db:docs:generate {--schema=database/schema.json} {--output=docs/database.md}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Generate database documentation from schema file';

    /**
     * Execute the console command.
     *
     * @throws JsonException
     */
    public function handle(): void
    {
        $schemaPath = $this->option('schema');
        $outputPath = $this->option('output');

        if (! File::exists($schemaPath)) {
            $this->error("Schema file not found: {$schemaPath}");

            return;
        }

        $schema = json_decode(File::get($schemaPath), true);
        $documentation = $this->generateDocumentation($schema);

        File::put($outputPath, $documentation);
        $this->info("Documentation generated at: {$outputPath}");
    }

    /**
     * Generate documentation from schema.
     *
     * @param array<string, mixed> $schema
     */
    protected function generateDocumentation(array $schema): string
    {
        $doc = "# Database Documentation\n\n";
        $doc .= "Generated on: ".now()->format('Y-m-d H:i:s')."\n\n";

        foreach ($schema['tables'] as $tableName => $table) {
            $doc .= $this->generateTableDocumentation($tableName, $table);
        }

        if (isset($schema['relationships']) && ! empty($schema['relationships'])) {
            $doc .= "\n## Relationships\n\n";
            foreach ($schema['relationships'] as $relationship) {
                $doc .= $this->generateRelationshipDocumentation($relationship);
            }
        }

        return $doc;
    }

    /**
     * Generate documentation for a table.
     *
     * @param array<string, mixed> $table
     */
    protected function generateTableDocumentation(string $tableName, array $table): string
    {
        $doc = "## Table: `{$tableName}`\n\n";

        if (isset($table['comment']) && ! empty($table['comment'])) {
            $doc .= "{$table['comment']}\n\n";
        }

        $doc .= "### Columns\n\n";
        $doc .= "| Column | Type | Nullable | Default | Comment |\n";
        $doc .= "|--------|------|----------|---------|----------|\n";

        foreach ($table['columns'] as $columnName => $column) {
            $doc .= sprintf(
                "| `%s` | %s | %s | %s | %s |\n",
                $columnName,
                $column['type'],
                $column['nullable'] ? 'Yes' : 'No',
                $column['default'] ?? 'NULL',
                $column['comment'] ?? ''
            );
        }

        if (isset($table['indices']) && ! empty($table['indices'])) {
            $doc .= "\n### Indices\n\n";
            $doc .= "| Name | Columns | Type | Unique |\n";
            $doc .= "|------|---------|------|--------|\n";

            foreach ($table['indices'] as $index) {
                $columns = implode(', ', array_column($index['columns'], 'name'));
                $doc .= sprintf(
                    "| `%s` | %s | %s | %s |\n",
                    $index['name'],
                    $columns,
                    $index['type'],
                    $index['unique'] ? 'Yes' : 'No'
                );
            }
        }

        if (isset($table['foreign_keys']) && ! empty($table['foreign_keys'])) {
            $doc .= "\n### Foreign Keys\n\n";
            $doc .= "| Column | References |\n";
            $doc .= "|--------|------------|\n";

            foreach ($table['foreign_keys'] as $fk) {
                $doc .= sprintf(
                    "| `%s` | `%s`.`%s` |\n",
                    $fk['column'],
                    $fk['references_table'],
                    $fk['references_column']
                );
            }
        }

        return $doc."\n";
    }

    /**
     * Generate documentation for a relationship.
     *
     * @param array<string, string> $relationship
     */
    protected function generateRelationshipDocumentation(array $relationship): string
    {
        return sprintf(
            "- `%s`.`%s` %s `%s`.`%s` (Constraint: `%s`)\n",
            $relationship['local_table'],
            $relationship['local_column'],
            $this->getRelationshipArrow($relationship['type']),
            $relationship['foreign_table'],
            $relationship['foreign_column'],
            $relationship['constraint_name']
        );
    }

    /**
     * Get arrow representation for relationship type.
     */
    protected function getRelationshipArrow(string $type): string
    {
        return match ($type) {
            'belongsTo' => '→',
            'hasMany' => '←',
            'hasOne' => '⟶',
            default => '↔',
        };
    }
}
