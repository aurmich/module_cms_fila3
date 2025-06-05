<?php

namespace Modules\Notify\Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class JsonComponentsTest extends TestCase
{
    /**
     * Test che il file _components.json è un JSON valido e contiene i componenti attesi.
     */
    public function test_components_json_is_valid(): void
    {
        // Percorso del file
        $filePath = base_path('Modules/Notify/app/Console/Commands/_components.json');

        // Verifico che il file esiste
        $this->assertTrue(File::exists($filePath), 'Il file _components.json non esiste');

        // Leggo il contenuto del file
        $content = File::get($filePath);

        // Decodifico il JSON
        $json = json_decode($content, true);

        // Verifico che il JSON è valido
        $this->assertNotNull($json, 'Il file _components.json non contiene JSON valido: ' . json_last_error_msg());

        // Verifico che ci sono 2 componenti
        $this->assertCount(2, $json, 'Il file _components.json non contiene i 2 componenti attesi');

        // Verifico che ci sono i componenti SendMailCommand e TelegramWebhook
        $this->assertArrayHasKey('name', $json[0], 'Il primo componente non ha una chiave "name"');
        $this->assertArrayHasKey('class', $json[0], 'Il primo componente non ha una chiave "class"');
        $this->assertArrayHasKey('ns', $json[0], 'Il primo componente non ha una chiave "ns"');

        $this->assertArrayHasKey('name', $json[1], 'Il secondo componente non ha una chiave "name"');
        $this->assertArrayHasKey('class', $json[1], 'Il secondo componente non ha una chiave "class"');
        $this->assertArrayHasKey('ns', $json[1], 'Il secondo componente non ha una chiave "ns"');

        // Verifico i nomi specifici dei componenti
        $names = array_column($json, 'name');
        $this->assertContains('send-mail-command', $names, 'Componente "send-mail-command" non trovato');
        $this->assertContains('telegram-webhook', $names, 'Componente "telegram-webhook" non trovato');

        // Verifico le classi specifiche dei componenti
        $classes = array_column($json, 'class');
        $this->assertContains('SendMailCommand', $classes, 'Classe "SendMailCommand" non trovata');
        $this->assertContains('TelegramWebhook', $classes, 'Classe "TelegramWebhook" non trovata');
    }
}
