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

final class SendNexmoSMSAction implements SmsActionContract
{
    use QueueableAction;

    private string $key;
    private string $secret;
    private string $baseUrl = 'https://rest.nexmo.com/sms/json';
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $config = config('sms.drivers.nexmo');
        if (!is_array($config)) {
            throw new Exception('Configurazione Nexmo non trovata in sms.php');
        }

        $this->key = $config['key'] ?? null;
        if (!is_string($this->key)) {
            throw new Exception('Key Nexmo non configurata in sms.php');
        }

        $this->secret = $config['secret'] ?? null;
        if (!is_string($this->secret)) {
            throw new Exception('Secret Nexmo non configurato in sms.php');
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
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        // Normalizza il numero di telefono
        $smsData->to .= '';
        if (Str::startsWith($smsData->to, '00')) {
            $smsData->to = '+' . mb_substr($smsData->to, 2);
        }

        if (!Str::startsWith($smsData->to, '+')) {
            $smsData->to = '+39' . $smsData->to;
        }

        $from = $smsData->from ?? $this->defaultSender;

        $client = new Client([
            'timeout' => $this->timeout,
            'headers' => $headers
        ]);

        try {
            $response = $client->post($this->baseUrl, [
                'form_params' => [
                    'api_key' => $this->key,
                    'api_secret' => $this->secret,
                    'to' => $smsData->to,
                    'from' => $from,
                    'text' => $smsData->body,
                    'type' => 'unicode'
                ]
            ]);

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
