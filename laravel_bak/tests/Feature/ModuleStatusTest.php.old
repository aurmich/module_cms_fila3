<?php

use function Pest\Laravel\get;

test('l\'homepage si carica correttamente con il modulo Chart disabilitato', function () {
    // Visita l'homepage
    get('/')
        ->assertStatus(200)
        ->assertSee('il progetto');
});

test('verifica che il modulo Chart sia disabilitato nel file modules_statuses.json', function () {
    // Legge il file modules_statuses.json
    $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);

    // Verifica che il modulo Chart sia presente e disabilitato
    expect($moduleStatuses)
        ->toHaveKey('Chart')
        ->and($moduleStatuses['Chart'])
        ->toBeFalse();
});

test('verifica che altri moduli essenziali siano abilitati', function () {
    // Legge il file modules_statuses.json
    $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);

    // Verifica che alcuni moduli essenziali siano abilitati
    expect($moduleStatuses)
        ->toHaveKey('Cms')
        ->and($moduleStatuses['Cms'])
        ->toBeTrue()

        ->toHaveKey('Xot')
        ->and($moduleStatuses['Xot'])
        ->toBeTrue()

        ->toHaveKey('User')
        ->and($moduleStatuses['User'])
        ->toBeTrue();
});

test('verifica che il sistema non cerchi di caricare il modulo Chart', function () {
    // Visita una pagina del sistema
    $response = get('/');

    // Verifica che non ci sia l'errore "Class Modules\Chart\Providers\ChartServiceProvider not found"
    expect($response->status())->not->toBe(500);

    // Verifica nei log se c'è menzione dell'errore
    // Nota: questo è solo un esempio, il percorso esatto del log potrebbe variare
    $logPath = storage_path('logs/laravel.log');

    if (file_exists($logPath)) {
        $logContent = file_get_contents($logPath);
        expect($logContent)->not->toContain('Modules\\Chart\\Providers\\ChartServiceProvider');
    }
});
