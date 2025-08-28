<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\Tenant;
use Tests\TestCase;

class TenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_tenant_with_minimal_data(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Tenant',
        ]);
    }

    public function test_can_create_tenant_with_all_fields(): void
    {
        $tenantData = [
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'settings' => ['theme' => 'dark', 'features' => ['chat', 'analytics']],
            'is_active' => true,
            'trial_ends_at' => now()->addDays(30),
        ];

        $tenant = Tenant::factory()->create($tenantData);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Full Tenant',
            'slug' => 'full-tenant',
            'domain' => 'fulltenant.com',
            'database' => 'fulltenant_db',
            'is_active' => true,
        ]);

        // Verifica campi JSON
        $this->assertEquals(['theme' => 'dark', 'features' => ['chat', 'analytics']], $tenant->settings);
    }

    public function test_tenant_has_soft_deletes(): void
    {
        $tenant = Tenant::factory()->create();
        $tenantId = $tenant->id;

        $tenant->delete();

        $this->assertSoftDeleted('tenants', ['id' => $tenantId]);
        $this->assertDatabaseMissing('tenants', ['id' => $tenantId]);
    }

    public function test_can_restore_soft_deleted_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $tenantId = $tenant->id;

        $tenant->delete();
        $this->assertSoftDeleted('tenants', ['id' => $tenantId]);

        $restoredTenant = Tenant::withTrashed()->find($tenantId);
        $restoredTenant->restore();

        $this->assertDatabaseHas('tenants', ['id' => $tenantId]);
        $this->assertNull($restoredTenant->deleted_at);
    }

    public function test_can_find_tenant_by_name(): void
    {
        $tenant = Tenant::factory()->create(['name' => 'Unique Tenant Name']);

        $foundTenant = Tenant::where('name', 'Unique Tenant Name')->first();

        $this->assertNotNull($foundTenant);
        $this->assertEquals($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_slug(): void
    {
        $tenant = Tenant::factory()->create(['slug' => 'unique-tenant']);

        $foundTenant = Tenant::where('slug', 'unique-tenant')->first();

        $this->assertNotNull($foundTenant);
        $this->assertEquals($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_domain(): void
    {
        $tenant = Tenant::factory()->create(['domain' => 'uniquetenant.com']);

        $foundTenant = Tenant::where('domain', 'uniquetenant.com')->first();

        $this->assertNotNull($foundTenant);
        $this->assertEquals($tenant->id, $foundTenant->id);
    }

    public function test_can_find_tenant_by_database(): void
    {
        $tenant = Tenant::factory()->create(['database' => 'unique_db']);

        $foundTenant = Tenant::where('database', 'unique_db')->first();

        $this->assertNotNull($foundTenant);
        $this->assertEquals($tenant->id, $foundTenant->id);
    }

    public function test_can_find_active_tenants(): void
    {
        Tenant::factory()->create(['is_active' => true]);
        Tenant::factory()->create(['is_active' => false]);
        Tenant::factory()->create(['is_active' => true]);

        $activeTenants = Tenant::where('is_active', true)->get();

        $this->assertCount(2, $activeTenants);
        $this->assertTrue($activeTenants->every(fn ($tenant) => $tenant->is_active));
    }

    public function test_can_find_tenants_by_name_pattern(): void
    {
        Tenant::factory()->create(['name' => 'Development Company']);
        Tenant::factory()->create(['name' => 'Marketing Agency']);
        Tenant::factory()->create(['name' => 'Sales Corporation']);

        $companyTenants = Tenant::where('name', 'like', '%Company%')->get();

        $this->assertCount(1, $companyTenants);
        $this->assertTrue($companyTenants->every(fn ($tenant) => str_contains($tenant->name, 'Company')));
    }

    public function test_can_find_tenants_by_domain_pattern(): void
    {
        Tenant::factory()->create(['domain' => 'dev.example.com']);
        Tenant::factory()->create(['domain' => 'staging.example.com']);
        Tenant::factory()->create(['domain' => 'prod.example.com']);

        $exampleTenants = Tenant::where('domain', 'like', '%.example.com')->get();

        $this->assertCount(3, $exampleTenants);
        $this->assertTrue($exampleTenants->every(fn ($tenant) => str_ends_with($tenant->domain, '.example.com')));
    }

    public function test_can_update_tenant(): void
    {
        $tenant = Tenant::factory()->create(['name' => 'Old Name']);

        $tenant->update(['name' => 'New Name']);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_handle_null_values(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
            'slug' => null,
            'domain' => null,
            'database' => null,
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'slug' => null,
            'domain' => null,
            'database' => null,
        ]);
    }

    public function test_can_find_tenants_by_multiple_criteria(): void
    {
        Tenant::factory()->create([
            'name' => 'Active Company',
            'is_active' => true,
            'domain' => 'active.com',
        ]);

        Tenant::factory()->create([
            'name' => 'Inactive Company',
            'is_active' => false,
            'domain' => 'inactive.com',
        ]);

        $tenants = Tenant::where('is_active', true)
            ->where('domain', 'like', '%.com')
            ->get();

        $this->assertCount(1, $tenants);
        $this->assertEquals('Active Company', $tenants->first()->name);
        $this->assertTrue($tenants->first()->is_active);
    }

    public function test_tenant_has_users_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertTrue(method_exists($tenant, 'users'));
    }

    public function test_tenant_has_members_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertTrue(method_exists($tenant, 'members'));
    }

    public function test_tenant_has_media_relationship(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertTrue(method_exists($tenant, 'media'));
    }

    public function test_tenant_has_factory(): void
    {
        $tenant = Tenant::factory()->create();

        $this->assertNotNull($tenant->id);
        $this->assertInstanceOf(Tenant::class, $tenant);
    }

    public function test_can_find_tenants_by_trial_status(): void
    {
        $activeTenant = Tenant::factory()->create([
            'trial_ends_at' => now()->addDays(30),
        ]);

        $expiredTenant = Tenant::factory()->create([
            'trial_ends_at' => now()->subDays(1),
        ]);

        $activeTrials = Tenant::where('trial_ends_at', '>', now())->get();

        $this->assertCount(1, $activeTrials);
        $this->assertEquals($activeTenant->id, $activeTrials->first()->id);
    }

    public function test_can_find_tenants_by_settings_value(): void
    {
        Tenant::factory()->create([
            'settings' => ['theme' => 'dark', 'features' => ['chat']],
        ]);

        Tenant::factory()->create([
            'settings' => ['theme' => 'light', 'features' => ['analytics']],
        ]);

        $darkThemeTenants = Tenant::whereJsonContains('settings->theme', 'dark')->get();

        $this->assertCount(1, $darkThemeTenants);
        $this->assertEquals('dark', $darkThemeTenants->first()->settings['theme']);
    }
}
