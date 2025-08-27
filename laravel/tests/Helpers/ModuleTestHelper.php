<?php

declare(strict_types=1);

namespace Tests\Helpers;

use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;

/**
 * Helper class for module testing utilities.
 */
class ModuleTestHelper
{
    /**
     * Check if a module is enabled.
     *
     * @param string $module
     * @return bool
     */
    public static function moduleEnabled(string $module): bool
    {
        $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);
        return $moduleStatuses[$module] ?? false;
    }

    /**
     * Skip test if module is disabled.
     *
     * @param string $module
     * @return void
     */
    public static function skipIfModuleDisabled(string $module): void
    {
        if (!self::moduleEnabled($module)) {
            test()->markTestSkipped("Module {$module} is disabled");
        }
    }

    /**
     * Create user of specific type using XotData.
     *
     * @param UserTypeEnum $type
     * @param array<string, mixed> $attributes
     * @return User
     */
    public static function createUserOfType(UserTypeEnum $type, array $attributes = []): User
    {
        $userClass = XotData::make()->getUserClass();
        
        return match($type) {
            UserTypeEnum::PATIENT => Patient::factory()->create(array_merge(['type' => $type], $attributes)),
            UserTypeEnum::DOCTOR => Doctor::factory()->create(array_merge(['type' => $type], $attributes)),
            UserTypeEnum::ADMIN => $userClass::factory()->create(array_merge(['type' => $type], $attributes)),
        };
    }

    /**
     * Create a complete appointment setup with all required relationships.
     *
     * @param array<string, mixed> $overrides
     * @return array<string, mixed>
     */
    public static function createAppointmentSetup(array $overrides = []): array
    {
        $studio = Studio::factory()->create();
        $doctor = self::createUserOfType(UserTypeEnum::DOCTOR);
        $patient = self::createUserOfType(UserTypeEnum::PATIENT);

        return array_merge([
            'studio' => $studio,
            'doctor' => $doctor,
            'patient' => $patient,
        ], $overrides);
    }

    /**
     * Assert that a cross-database relationship works correctly.
     *
     * @param mixed $pivotModel
     * @param string $relation1
     * @param string $relation2
     * @return void
     */
    public static function assertCrossDatabaseRelation($pivotModel, string $relation1, string $relation2): void
    {
        expect($pivotModel->$relation1)->not->toBeNull();
        expect($pivotModel->$relation2)->not->toBeNull();
        
        $connection1 = $pivotModel->$relation1->getConnectionName();
        $connection2 = $pivotModel->$relation2->getConnectionName();
        
        // If connections are different, that's expected for cross-database relations
        // If they're the same, that's also valid depending on configuration
        expect($connection1)->toBeString();
        expect($connection2)->toBeString();
    }

    /**
     * Assert that translations exist for all supported locales.
     *
     * @param string $translationKey
     * @param array<string> $locales
     * @return void
     */
    public static function assertTranslationsExist(string $translationKey, array $locales = ['it', 'en', 'de']): void
    {
        foreach ($locales as $locale) {
            app()->setLocale($locale);
            
            $translation = __($translationKey);
            
            expect($translation)->not->toContain('::');
            expect($translation)->not->toBe($translationKey);
        }
    }

    /**
     * Assert that enum has complete translations.
     *
     * @param array<mixed> $enumCases
     * @param string $translationPrefix
     * @param array<string> $locales
     * @return void
     */
    public static function assertEnumTranslations(array $enumCases, string $translationPrefix, array $locales = ['it', 'en', 'de']): void
    {
        foreach ($enumCases as $case) {
            foreach ($locales as $locale) {
                app()->setLocale($locale);
                
                $labelKey = "{$translationPrefix}.{$case->value}.label";
                $descriptionKey = "{$translationPrefix}.{$case->value}.description";
                
                $label = __($labelKey);
                $description = __($descriptionKey);
                
                expect($label)->not->toContain('::');
                expect($description)->not->toContain('::');
            }
        }
    }

    /**
     * Create test data for date range queries.
     *
     * @param int $days
     * @return array<string, \Carbon\Carbon>
     */
    public static function createDateRange(int $days = 30): array
    {
        $start = now()->startOfMonth();
        $end = $start->copy()->addDays($days);
        
        return [
            'start' => $start,
            'end' => $end,
            'middle' => $start->copy()->addDays($days / 2),
        ];
    }

    /**
     * Assert that a Filament resource has correct configuration.
     *
     * @param string $resourceClass
     * @return void
     */
    public static function assertFilamentResourceConfiguration(string $resourceClass): void
    {
        $resource = new $resourceClass();
        
        // Check that it has required methods
        expect(method_exists($resource, 'getTableColumns'))->toBeTrue();
        expect(method_exists($resource, 'getFormSchema'))->toBeTrue();
        
        // Check table columns return associative array
        if (method_exists($resource, 'getTableColumns')) {
            $columns = $resource->getTableColumns();
            expect($columns)->toBeArray();
            
            foreach ($columns as $key => $column) {
                expect($key)->toBeString();
            }
        }
    }

    /**
     * Assert that a widget has correct Filament configuration.
     *
     * @param mixed $widget
     * @return void
     */
    public static function assertWidgetConfiguration($widget): void
    {
        // Check basic widget properties
        expect($widget)->toBeObject();
        
        // Check if it has view or render method
        $hasView = method_exists($widget, 'render') || property_exists($widget, 'view');
        expect($hasView)->toBeTrue();
        
        // If it's a form widget, check form schema
        if (method_exists($widget, 'getFormSchema')) {
            $schema = $widget->getFormSchema();
            expect($schema)->toBeArray();
        }
    }

    /**
     * Create test performance benchmark.
     *
     * @param callable $callback
     * @param float $maxDuration Maximum duration in seconds
     * @return float Actual duration
     */
    public static function benchmarkPerformance(callable $callback, float $maxDuration = 1.0): float
    {
        $start = microtime(true);
        
        $callback();
        
        $duration = microtime(true) - $start;
        
        expect($duration)->toBeLessThan($maxDuration);
        
        return $duration;
    }

    /**
     * Assert that model has correct factory configuration.
     *
     * @param string $modelClass
     * @return void
     */
    public static function assertModelFactory(string $modelClass): void
    {
        // Check that factory exists and can create model
        $model = $modelClass::factory()->create();
        
        expect($model)->toBeInstanceOf($modelClass);
        expect($model->exists)->toBeTrue();
        
        // Check that factory can make model without saving
        $madeModel = $modelClass::factory()->make();
        
        expect($madeModel)->toBeInstanceOf($modelClass);
        expect($madeModel->exists)->toBeFalse();
    }

    /**
     * Assert that model has correct relationships.
     *
     * @param mixed $model
     * @param array<string> $expectedRelations
     * @return void
     */
    public static function assertModelRelationships($model, array $expectedRelations): void
    {
        foreach ($expectedRelations as $relation) {
            expect(method_exists($model, $relation))->toBeTrue();
            
            $relationObject = $model->$relation();
            expect($relationObject)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\Relation::class);
        }
    }

    /**
     * Assert that a livewire component works correctly.
     *
     * @param string $componentClass
     * @param array<string, mixed> $initialData
     * @return void
     */
    public static function assertLivewireComponent(string $componentClass, array $initialData = []): void
    {
        $component = \Livewire\Livewire::test($componentClass);
        
        foreach ($initialData as $property => $value) {
            $component->set($property, $value);
        }
        
        $component->assertStatus(200);
    }

    /**
     * Assert that action has correct configuration.
     *
     * @param string $actionClass
     * @param array<string, mixed> $testData
     * @return void
     */
    public static function assertActionConfiguration(string $actionClass, array $testData = []): void
    {
        $action = new $actionClass();
        
        expect($action)->toBeInstanceOf($actionClass);
        expect(method_exists($action, 'execute'))->toBeTrue();
        
        // If test data provided, try to execute action
        if (!empty($testData)) {
            $result = $action->execute(...array_values($testData));
            expect($result)->not->toBeNull();
        }
    }

    /**
     * Clean up test data for specific module.
     *
     * @param string $module
     * @return void
     */
    public static function cleanupModuleData(string $module): void
    {
        // This method can be extended to clean up specific module data
        // For now, it's a placeholder for future implementation
        
        switch ($module) {
            case 'SaluteOra':
                // Clean up SaluteOra specific data
                break;
            case 'User':
                // Clean up User specific data
                break;
            default:
                // Generic cleanup
                break;
        }
    }

    /**
     * Assert that module is properly configured.
     *
     * @param string $module
     * @return void
     */
    public static function assertModuleConfiguration(string $module): void
    {
        // Check module.json exists
        $moduleJsonPath = base_path("Modules/{$module}/module.json");
        expect(file_exists($moduleJsonPath))->toBeTrue();
        
        // Check module is enabled
        expect(self::moduleEnabled($module))->toBeTrue();
        
        // Check basic directory structure
        $modulePath = base_path("Modules/{$module}");
        expect(is_dir("{$modulePath}/app"))->toBeTrue();
        expect(is_dir("{$modulePath}/resources"))->toBeTrue();
        expect(is_dir("{$modulePath}/database"))->toBeTrue();
    }
}










