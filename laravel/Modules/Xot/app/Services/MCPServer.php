<?php

namespace Modules\Xot\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

abstract class MCPServer
{
    protected string $name;
    protected array $config;
    protected ?Process $process = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function start(): bool
    {
        try {
            $command = $this->config['command'];
            $args = $this->config['args'];

            $this->process = Process::start(array_merge([$command], $args));

            Log::info("Server MCP {$this->name} avviato", [
                'pid' => $this->process->id(),
                'command' => $command,
                'args' => $args
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Errore nell'avvio del server MCP {$this->name}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function stop(): bool
    {
        if (!$this->process) {
            return true;
        }

        try {
            $this->process->terminate();
            Log::info("Server MCP {$this->name} arrestato", [
                'pid' => $this->process->id()
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error("Errore nell'arresto del server MCP {$this->name}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function isRunning(): bool
    {
        return $this->process && $this->process->running();
    }

    public function getStatus(): array
    {
        return [
            'name' => $this->name,
            'running' => $this->isRunning(),
            'pid' => $this->process ? $this->process->id() : null,
            'config' => $this->config
        ];
    }

    abstract public function validate(): bool;
    abstract public function getContext(): array;
}
