# Testing Modulo GDPR

## Unit Tests

### ConsentTest
```php
namespace Modules\Gdpr\Tests\Unit;

use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;

class ConsentTest extends TestCase
{
    /** @test */
    public function it_can_create_consent(): void
    {
        $consent = Consent::factory()->create([
            'type' => 'marketing',
            'value' => true,
        ]);

        $this->assertDatabaseHas('consents', [
            'id' => $consent->id,
            'type' => 'marketing',
            'value' => true,
        ]);
    }

    /** @test */
    public function it_can_check_valid_consent(): void
    {
        $user = User::factory()->create();
        $consent = Consent::factory()->create([
            'user_id' => $user->id,
            'type' => 'marketing',
            'value' => true,
            'expires_at' => now()->addDays(30),
        ]);

        $this->assertTrue($user->hasValidConsent('marketing'));
    }
}
```

### ExportTest
```php
namespace Modules\Gdpr\Tests\Unit;

use Modules\Gdpr\Jobs\ProcessDataExport;
use Modules\Gdpr\Tests\TestCase;

class ExportTest extends TestCase
{
    /** @test */
    public function it_can_export_user_data(): void
    {
        $user = User::factory()->create();
        $format = 'json';

        $job = new ProcessDataExport($user, $format);
        $job->handle();

        $this->assertFileExists(
            storage_path("app/exports/user-{$user->id}.json")
        );
    }
}
```

## Feature Tests

### ConsentControllerTest
```php
namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Tests\TestCase;

class ConsentControllerTest extends TestCase
{
    /** @test */
    public function it_can_store_consent(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/gdpr/consent', [
                'type' => 'marketing',
                'value' => true,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'type' => 'marketing',
                'value' => true,
            ]);
    }

    /** @test */
    public function it_validates_consent_input(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/gdpr/consent', [
                'type' => 'invalid',
                'value' => 'not-boolean',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type', 'value']);
    }
}
```

## Browser Tests

### ConsentPageTest
```php
namespace Modules\Gdpr\Tests\Browser;

use Laravel\Dusk\Browser;
use Modules\Gdpr\Tests\DuskTestCase;

class ConsentPageTest extends DuskTestCase
{
    /** @test */
    public function it_can_display_consent_form(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit('/gdpr/consent')
                ->assertSee('Gestione Consensi')
                ->assertPresent('@consent-form');
        });
    }

    /** @test */
    public function it_can_submit_consent_form(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                ->visit('/gdpr/consent')
                ->check('@marketing-consent')
                ->press('Salva')
                ->waitForText('Consensi aggiornati con successo');
        });
    }
}
```

## Performance Tests

### ConsentBenchmarkTest
```php
namespace Modules\Gdpr\Tests\Performance;

use Modules\Gdpr\Tests\TestCase;

class ConsentBenchmarkTest extends TestCase
{
    /** @test */
    public function consent_validation_performance(): void
    {
        $user = User::factory()
            ->has(Consent::factory()->count(1000))
            ->create();

        $start = microtime(true);
        
        $user->hasValidConsent('marketing');
        
        $end = microtime(true);
        $executionTime = ($end - $start) * 1000;

        $this->assertLessThan(
            100, // ms
            $executionTime,
            "Consent validation took {$executionTime}ms"
        );
    }
}
```

## Security Tests

### GdprSecurityTest
```php
namespace Modules\Gdpr\Tests\Security;

use Modules\Gdpr\Tests\TestCase;

class GdprSecurityTest extends TestCase
{
    /** @test */
    public function it_prevents_unauthorized_access(): void
    {
        $response = $this->getJson('/gdpr/export');
        $response->assertStatus(401);
    }

    /** @test */
    public function it_validates_csrf_token(): void
    {
        $response = $this->post('/gdpr/consent', [
            'type' => 'marketing',
            'value' => true,
        ]);

        $response->assertStatus(419);
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Testing User](../User/docs/testing.md)
- [Testing Activity](../Activity/docs/testing.md)
- [Testing Xot](../Xot/docs/testing.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Bottlenecks](./bottlenecks.md)
- [Configurazione](./configuration.md) 
## Collegamenti tra versioni di testing.md
* [testing.md](../../Xot/docs/packages/testing.md)
* [testing.md](../../Xot/docs/development/testing.md)
* [testing.md](../../Cms/docs/frontoffice/testing.md)
* [testing.md](../../../Themes/One/docs/testing.md)

