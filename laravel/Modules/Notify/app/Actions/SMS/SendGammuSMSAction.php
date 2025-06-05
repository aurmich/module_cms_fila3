<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Process\Process;

final class SendGammuSMSAction implements SmsActionContract
{
    use QueueableAction;

    private string $path;
    private string $config;
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $config = config('sms.drivers.gammu');
        if (!is_array($config)) {
            throw new Exception('Configurazione Gammu non trovata in sms.php');
        }

        $this->path = $config['path'] ?? '/usr/bin/gammu';
        if (!is_string($this->path)) {
            throw new Exception('Path Gammu non configurato in sms.php');
        }

        $this->config = $config['config'] ?? '/etc/gammurc';
        if (!is_string($this->config)) {
            throw new Exception('Config Gammu non configurato in sms.php');
        }

        // Parametri a livello di root
        $this->defaultSender = config('sms.from');
        $this->debug = (bool) config('sms.debug', false);
        $this->timeout = (int) config('sms.timeout', 30);
    }

    /**
     * Execute the action.
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array
    {
        // Normalizza il numero di telefono
        $smsData->to .= '';
        if (Str::startsWith($smsData->to, '00')) {
            $smsData->to = '+' . mb_substr($smsData->to, 2);
        }

        if (!Str::startsWith($smsData->to, '+')) {
            $smsData->to = '+39' . $smsData->to;
        }

        // Prepara il messaggio per Gammu
        $tempFile = tempnam(sys_get_temp_dir(), 'sms_');
        file_put_contents($tempFile, $smsData->body);

        // Esegue il comando Gammu per inviare l'SMS
        $process = new Process([
            $this->path,
            '-c', $this->config,
            'sendsms',
            'TEXT',
            $smsData->to,
            '-text',
            $tempFile
        ]);

        $process->setTimeout($this->timeout);

        try {
            $process->run();

            // Rimuove il file temporaneo
            @unlink($tempFile);

            if (!$process->isSuccessful()) {
                throw new Exception('Gammu error: ' . $process->getErrorOutput());
            }

            $this->vars['status_code'] = $process->getExitCode();
            $this->vars['status_txt'] = $process->getOutput();

            return $this->vars;
        } catch (Exception $exception) {
            // Rimuove il file temporaneo in caso di errore
            @unlink($tempFile);

            throw new Exception(
                $exception->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $exception->getCode(),
                $exception
            );
        }
    }
}
