<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

final class SendSmsFactorSMSAction implements SmsActionContract
{
    use QueueableAction;

    private string $token;
    private string $baseUrl;
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $config = config('sms.drivers.smsfactor');
        if (!is_array($config)) {
            throw new Exception('Configurazione SMSFactor non trovata in sms.php');
        }

        $this->token = $config['token'] ?? null;
        if (!is_string($this->token)) {
            throw new Exception('Token SMSFactor non configurato in sms.php');
        }

        $this->baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';

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
        $headers = [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        // Normalizza il numero di telefono
        $smsData->to .= '';
        if (Str::startsWith($smsData->to, '00')) {
            $smsData->to = '+' . mb_substr($smsData->to, 2);
        }

        if (!Str::startsWith($smsData->to, '+')) {
            $smsData->to = '+39' . $smsData->to;
        }

        $body = [
            'text' => $smsData->body,
            'sender' => $smsData->from ?? $this->defaultSender,
            'recipients' => [
                [
                    'phone' => $smsData->to,
                ],
            ],
            'type' => 'sms',
        ];

        $client = new Client([
            'timeout' => $this->timeout,
            'headers' => $headers
        ]);

        try {
            $response = $client->post($this->baseUrl . '/messages', ['json' => $body]);
            $this->vars['status_code'] = $response->getStatusCode();
            $this->vars['status_txt'] = $response->getBody()->getContents();

            return $this->vars;
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException
            );
        }
    }
}
