<?php

declare(strict_types=1);

namespace Tests\Unit\Console\Commands;

use Illuminate\Support\Facades\File;
use Modules\Xot\Console\Commands\GenerateDbDocumentationCommand;
use Tests\TestCase;

class GenerateDbDocumentationCommandTest extends TestCase
{
    private string $testSchemaPath;
    private string $testOutputDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testSchemaPath = storage_path('tests/schema.json');
        $this->testOutputDir = storage_path('tests/docs');

        // Crea la directory dei test se non esiste
        if (!File::exists(dirname($this->testSchemaPath))) {
            File::makeDirectory(dirname($this->testSchemaPath), 0755, true);
        }

        // Crea un file schema di test
        $testSchema = [
            'database' => 'test_db',
            'connection' => 'mysql',
            'tables' => [
                'users' => [
                    'columns' => [
                        'id' => [
                            'type' => 'bigint',
                            'nullable' => false,
                            'default' => null,
                            'extra' => 'auto_increment',
                        ],
                        'name' => [
                            'type' => 'varchar(255)',
                            'nullable' => false,
                            'default' => null,
                        ],
                    ],
                    'primary_key' => [
                        'columns' => ['id'],
                    ],
                    'indexes' => [
                        'name_index' => [
                            'columns' => ['name'],
                            'type' => 'index',
                        ],
                    ],
                    'foreign_keys' => [],
                    'record_count' => 10,
                ],
            ],
            'relationships' => [],
        ];

        File::put($this->testSchemaPath, json_encode($testSchema, JSON_PRETTY_PRINT));
    }

    protected function tearDown(): void
    {
        // Pulisci i file di test
        if (File::exists($this->testSchemaPath)) {
            File::delete($this->testSchemaPath);
        }
        if (File::exists($this->testOutputDir)) {
            File::deleteDirectory($this->testOutputDir);
        }

        parent::tearDown();
    }

    /** @test */
    public function it_generates_documentation_successfully(): void
    {
        $this->artisan('xot:generate-db-documentation', [
            'schema_file' => $this->testSchemaPath,
            'output_dir' => $this->testOutputDir,
        ])->assertExitCode(0);

        // Verifica che i file siano stati creati
        $this->assertTrue(File::exists($this->testOutputDir . '/README.md'));
        $this->assertTrue(File::exists($this->testOutputDir . '/users.md'));

        // Verifica il contenuto del README
        $readmeContent = File::get($this->testOutputDir . '/README.md');
        $this->assertStringContainsString('test_db', $readmeContent);
        $this->assertStringContainsString('mysql', $readmeContent);
        $this->assertStringContainsString('users.md', $readmeContent);

        // Verifica il contenuto del file della tabella
        $tableContent = File::get($this->testOutputDir . '/users.md');
        $this->assertStringContainsString('Tabella: users', $tableContent);
        $this->assertStringContainsString('bigint', $tableContent);
        $this->assertStringContainsString('varchar(255)', $tableContent);
        $this->assertStringContainsString('name_index', $tableContent);
    }

    /** @test */
    public function it_fails_with_invalid_schema_file(): void
    {
        $this->artisan('xot:generate-db-documentation', [
            'schema_file' => 'non_existent_file.json',
            'output_dir' => $this->testOutputDir,
        ])->assertExitCode(1);
    }

    /** @test */
    public function it_fails_with_invalid_json_content(): void
    {
        // Crea un file JSON non valido
        File::put($this->testSchemaPath, 'invalid json content');

        $this->artisan('xot:generate-db-documentation', [
            'schema_file' => $this->testSchemaPath,
            'output_dir' => $this->testOutputDir,
        ])->assertExitCode(1);
    }

    /** @test */
    public function it_fails_with_invalid_schema_structure(): void
    {
        // Crea un file JSON con struttura non valida
        $invalidSchema = [
            'database' => 'test_db',
            'tables' => 'not_an_array', // Dovrebbe essere un array
        ];

        File::put($this->testSchemaPath, json_encode($invalidSchema));

        $this->artisan('xot:generate-db-documentation', [
            'schema_file' => $this->testSchemaPath,
            'output_dir' => $this->testOutputDir,
        ])->assertExitCode(1);
    }
}
