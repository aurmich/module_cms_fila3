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

final class SendPlivoSMSAction implements SmsActionContract
{
    use QueueableAction;

    private string $authId;
    private string $authToken;
    private string $baseUrl = 'https://api.plivo.com/v1/Account/';
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $config = config('sms.drivers.plivo');
        if (!is_array($config)) {
            throw new Exception('Configurazione Plivo non trovata in sms.php');
        }

        $this->authId = $config['auth_id'] ?? null;
        if (!is_string($this->authId)) {
            throw new Exception('Auth ID Plivo non configurato in sms.php');
        }

        $this->authToken = $config['auth_token'] ?? null;
        if (!is_string($this->authToken)) {
            throw new Exception('Auth Token Plivo non configurato in sms.php');
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

        $from = $smsData->from ?? $this->defaultSender;

        // Plivo richiede l'autenticazione Basic
        $client = new Client([
            'timeout' => $this->timeout,
            'auth' => [$this->authId, $this->authToken],
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $endpoint = $this->baseUrl . $this->authId . '/Message/';

        try {
            $response = $client->post($endpoint, [
                'json' => [
                    'src' => $from,
                    'dst' => $smsData->to,
                    'text' => $smsData->body,
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
