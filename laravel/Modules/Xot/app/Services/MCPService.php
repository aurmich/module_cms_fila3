<?php

namespace Modules\Xot\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use ReflectionMethod;

class MCPService
{
    protected array $servers = [];
    protected array $contexts = [];

    public function __construct()
    {
        $this->loadServers();
        $this->loadContexts();
    }

    protected function loadServers(): void
    {
        $this->servers = Config::get('mcp.servers', [
            'filesystem' => [
                'command' => 'npx',
                'args' => ['-y', '@modelcontextprotocol/server-filesystem']
            ],
            'memory' => [
                'command' => 'npx',
                'args' => ['-y', '@modelcontextprotocol/server-memory']
            ],
            'fetch' => [
                'command' => 'npx',
                'args' => ['-y', '@modelcontextprotocol/server-fetch']
            ]
        ]);
    }

    protected function loadContexts(): void
    {
        $this->contexts = [
            'User' => [
                'type' => 'base',
                'traits' => ['HasFactory', 'Notifiable', 'HasParent'],
                'relationships' => ['doctor', 'patient'],
                'table' => 'users',
                'type_column' => 'type'
            ],
            'Doctor' => [
                'extends' => 'User',
                'type' => 'child',
                'traits' => ['HasParent'],
                'context' => 'medical',
                'validations' => ['medical_license', 'specialization']
            ]
        ];
    }

    public function validateModel(string $model): array
    {
        if (!isset($this->contexts[$model])) {
            return [
                'valid' => false,
                'errors' => ["Modello {$model} non trovato nei contesti."]
            ];
        }

        $context = $this->contexts[$model];
        $class = $this->getModelClass($model);

        if (!$class) {
            return [
                'valid' => false,
                'errors' => ["Classe {$model} non trovata."]
            ];
        }

        $errors = [];

        // Validazione trait
        if (isset($context['traits'])) {
            $traits = $class->getTraitNames();
            $missing = array_diff($context['traits'], $traits);
            if (!empty($missing)) {
                $errors[] = "Trait mancanti: " . implode(', ', $missing);
            }
        }

        // Validazione relazioni
        if (isset($context['relationships'])) {
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
            $relationships = array_map(fn($method) => $method->getName(), $methods);
            $missing = array_diff($context['relationships'], $relationships);
            if (!empty($missing)) {
                $errors[] = "Relazioni mancanti: " . implode(', ', $missing);
            }
        }

        // Validazione estensioni
        if (isset($context['extends'])) {
            $parent = $class->getParentClass();
            if (!$parent || $parent->getName() !== "Modules\\Patient\\Models\\{$context['extends']}") {
                $errors[] = "Deve estendere {$context['extends']}";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    protected function getModelClass(string $model): ?ReflectionClass
    {
        $namespace = "Modules\\Patient\\Models\\{$model}";
        return class_exists($namespace) ? new ReflectionClass($namespace) : null;
    }

    public function getServer(string $name): ?array
    {
        return $this->servers[$name] ?? null;
    }

    public function getContext(string $model): ?array
    {
        return $this->contexts[$model] ?? null;
    }

    public function addContext(string $model, array $context): void
    {
        $this->contexts[$model] = $context;
        Log::info("Aggiunto contesto per il modello {$model}", ['context' => $context]);
    }

    public function removeContext(string $model): void
    {
        if (isset($this->contexts[$model])) {
            unset($this->contexts[$model]);
            Log::info("Rimosso contesto per il modello {$model}");
        }
    }
}
