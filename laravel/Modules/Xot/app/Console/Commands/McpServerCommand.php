<?php

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Services\MCPService;
use Modules\Xot\Services\MCPModelServer;

class McpServerCommand extends Command
{
    protected $signature = 'xot:mcp-server {action : Azione da eseguire (start|stop|status)} {server? : Nome del server}';
    protected $description = 'Gestisce i server MCP';

    public function __construct(
        private readonly MCPService $mcpService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $action = $this->argument('action');
        $server = $this->argument('server');

        switch ($action) {
            case 'start':
                $this->startServer($server);
                break;
            case 'stop':
                $this->stopServer($server);
                break;
            case 'status':
                $this->showStatus($server);
                break;
            default:
                $this->error("Azione non valida: {$action}");
                return 1;
        }

        return 0;
    }

    protected function startServer(?string $server): void
    {
        if ($server) {
            $this->startSingleServer($server);
        } else {
            $this->startAllServers();
        }
    }

    protected function startSingleServer(string $server): void
    {
        $config = $this->mcpService->getServer($server);
        if (!$config) {
            $this->error("Server {$server} non trovato");
            return;
        }

        $mcpServer = new MCPModelServer($config);
        if ($mcpServer->start()) {
            $this->info("Server {$server} avviato");
        } else {
            $this->error("Errore nell'avvio del server {$server}");
        }
    }

    protected function startAllServers(): void
    {
        $this->info('Avvio di tutti i server MCP...');
        foreach (config('mcp.servers', []) as $name => $config) {
            $this->startSingleServer($name);
        }
    }

    protected function stopServer(?string $server): void
    {
        if ($server) {
            $this->stopSingleServer($server);
        } else {
            $this->stopAllServers();
        }
    }

    protected function stopSingleServer(string $server): void
    {
        $config = $this->mcpService->getServer($server);
        if (!$config) {
            $this->error("Server {$server} non trovato");
            return;
        }

        $mcpServer = new MCPModelServer($config);
        if ($mcpServer->stop()) {
            $this->info("Server {$server} arrestato");
        } else {
            $this->error("Errore nell'arresto del server {$server}");
        }
    }

    protected function stopAllServers(): void
    {
        $this->info('Arresto di tutti i server MCP...');
        foreach (config('mcp.servers', []) as $name => $config) {
            $this->stopSingleServer($name);
        }
    }

    protected function showStatus(?string $server): void
    {
        if ($server) {
            $this->showSingleServerStatus($server);
        } else {
            $this->showAllServersStatus();
        }
    }

    protected function showSingleServerStatus(string $server): void
    {
        $config = $this->mcpService->getServer($server);
        if (!$config) {
            $this->error("Server {$server} non trovato");
            return;
        }

        $mcpServer = new MCPModelServer($config);
        $status = $mcpServer->getStatus();

        $this->table(
            ['Proprietà', 'Valore'],
            collect($status)->map(fn($value, $key) => [$key, is_array($value) ? json_encode($value) : $value])
        );
    }

    protected function showAllServersStatus(): void
    {
        $this->info('Stato di tutti i server MCP:');
        foreach (config('mcp.servers', []) as $name => $config) {
            $this->showSingleServerStatus($name);
        }
    }
}
