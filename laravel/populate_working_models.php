<?php

declare(strict_types=1);

/**
 * Script per popolare i modelli funzionanti del progetto SaluteOra con 100 record ciascuno
 * Testa prima ogni factory per verificare che funzioni
 */

echo "🚀 Test e popolamento modelli funzionanti SaluteOra...\n\n";

// ============================================================================
// TEST FACTORY E POPOLAMENTO MODELLI SALUTEORA
// ============================================================================

echo "🏥 TEST E POPOLAMENTO MODELLI SALUTEORA...\n";

$saluteOraModels = [
    'User' => \Modules\SaluteOra\Models\User::class,
    'Doctor' => \Modules\SaluteOra\Models\Doctor::class,
    'Patient' => \Modules\SaluteOra\Models\Patient::class,
    'Admin' => \Modules\SaluteOra\Models\Admin::class,
    'Studio' => \Modules\SaluteOra\Models\Studio::class,
    'Profile' => \Modules\SaluteOra\Models\Profile::class,
    'Appointment' => \Modules\SaluteOra\Models\Appointment::class,
    'Report' => \Modules\SaluteOra\Models\Report::class,
    'StudioUser' => \Modules\SaluteOra\Models\StudioUser::class,
    'DoctorStudio' => \Modules\SaluteOra\Models\DoctorStudio::class,
    'PatientStudio' => \Modules\SaluteOra\Models\PatientStudio::class,
    'AdminStudio' => \Modules\SaluteOra\Models\AdminStudio::class,
    'TeamUser' => \Modules\SaluteOra\Models\TeamUser::class,
    'DoctorTeam' => \Modules\SaluteOra\Models\DoctorTeam::class,
    'PatientTeam' => \Modules\SaluteOra\Models\PatientTeam::class,
    'AdminTeam' => \Modules\SaluteOra\Models\AdminTeam::class,
];

foreach ($saluteOraModels as $name => $class) {
    try {
        echo "   🧪 Test factory per $name...\n";
        
        // Test factory
        $testModel = $class::factory()->make();
        echo "     ✅ Factory funziona per $name\n";
        
        // Popolamento con 100 record
        echo "     📊 Creazione 100 record per $name...\n";
        $models = $class::factory()->count(100)->create();
        echo "     ✅ $name: 100 record creati\n";
        
    } catch (Exception $e) {
        echo "     ❌ Errore per $name: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// ============================================================================
// TEST FACTORY E POPOLAMENTO MODELLI USER
// ============================================================================

echo "👥 TEST E POPOLAMENTO MODELLI USER...\n";

$userModels = [
    'Permission' => \Modules\User\Models\Permission::class,
    'Role' => \Modules\User\Models\Role::class,
    'RoleHasPermission' => \Modules\User\Models\RoleHasPermission::class,
    'Team' => \Modules\User\Models\Team::class,
    'Tenant' => \Modules\User\Models\Tenant::class,
    'Profile' => \Modules\User\Models\Profile::class,
    'Device' => \Modules\User\Models\Device::class,
    'DeviceProfile' => \Modules\User\Models\DeviceProfile::class,
    'Feature' => \Modules\User\Models\Feature::class,
    'Membership' => \Modules\User\Models\Membership::class,
    'Notification' => \Modules\User\Models\Notification::class,
    'OauthClient' => \Modules\User\Models\OauthClient::class,
    'OauthAuthCode' => \Modules\User\Models\OauthAuthCode::class,
    'OauthAccessToken' => \Modules\User\Models\OauthAccessToken::class,
    'OauthRefreshToken' => \Modules\User\Models\OauthRefreshToken::class,
    'OauthPersonalAccessClient' => \Modules\User\Models\OauthPersonalAccessClient::class,
    'SocialProvider' => \Modules\User\Models\SocialProvider::class,
    'SocialiteUser' => \Modules\User\Models\SocialiteUser::class,
    'Authentication' => \Modules\User\Models\Authentication::class,
    'AuthenticationLog' => \Modules\User\Models\AuthenticationLog::class,
    'PasswordReset' => \Modules\User\Models\PasswordReset::class,
    'PermissionUser' => \Modules\User\Models\PermissionUser::class,
    'PermissionRole' => \Modules\User\Models\PermissionRole::class,
    'ModelHasRole' => \Modules\User\Models\ModelHasRole::class,
    'ModelHasPermission' => \Modules\User\Models\ModelHasPermission::class,
    'TenantUser' => \Modules\User\Models\TenantUser::class,
    'DeviceUser' => \Modules\User\Models\DeviceUser::class,
    'ProfileTeam' => \Modules\User\Models\ProfileTeam::class,
    'TeamPermission' => \Modules\User\Models\TeamPermission::class,
    'TeamInvitation' => \Modules\User\Models\TeamInvitation::class,
];

foreach ($userModels as $name => $class) {
    try {
        echo "   🧪 Test factory per $name...\n";
        
        // Test factory
        $testModel = $class::factory()->make();
        echo "     ✅ Factory funziona per $name\n";
        
        // Popolamento con 100 record
        echo "     📊 Creazione 100 record per $name...\n";
        $models = $class::factory()->count(100)->create();
        echo "     ✅ $name: 100 record creati\n";
        
    } catch (Exception $e) {
        echo "     ❌ Errore per $name: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// ============================================================================
// TEST FACTORY E POPOLAMENTO MODELLI MEDIA
// ============================================================================

echo "📁 TEST E POPOLAMENTO MODELLI MEDIA...\n";

$mediaModels = [
    'Media' => \Modules\Media\Models\Media::class,
    'MediaConvert' => \Modules\Media\Models\MediaConvert::class,
    'TemporaryUpload' => \Modules\Media\Models\TemporaryUpload::class,
];

foreach ($mediaModels as $name => $class) {
    try {
        echo "   🧪 Test factory per $name...\n";
        
        // Test factory
        $testModel = $class::factory()->make();
        echo "     ✅ Factory funziona per $name\n";
        
        // Popolamento con 100 record
        echo "     📊 Creazione 100 record per $name...\n";
        $models = $class::factory()->count(100)->create();
        echo "     ✅ $name: 100 record creati\n";
        
    } catch (Exception $e) {
        echo "     ❌ Errore per $name: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// ============================================================================
// TEST FACTORY E POPOLAMENTO MODELLI XOT
// ============================================================================

echo "🔧 TEST E POPOLAMENTO MODELLI XOT...\n";

$xotModels = [
    'Module' => \Modules\Xot\Models\Module::class,
    'Extra' => \Modules\Xot\Models\Extra::class,
    'Cache' => \Modules\Xot\Models\Cache::class,
    'CacheLock' => \Modules\Xot\Models\CacheLock::class,
    'Session' => \Modules\Xot\Models\Session::class,
    'Log' => \Modules\Xot\Models\Log::class,
    'Feed' => \Modules\Xot\Models\Feed::class,
    'HealthCheckResultHistoryItem' => \Modules\Xot\Models\HealthCheckResultHistoryItem::class,
    'PulseEntry' => \Modules\Xot\Models\PulseEntry::class,
    'PulseValue' => \Modules\Xot\Models\PulseValue::class,
    'PulseAggregate' => \Modules\Xot\Models\PulseAggregate::class,
];

foreach ($xotModels as $name => $class) {
    try {
        echo "   🧪 Test factory per $name...\n";
        
        // Test factory
        $testModel = $class::factory()->make();
        echo "     ✅ Factory funziona per $name\n";
        
        // Popolamento con 100 record
        echo "     📊 Creazione 100 record per $name...\n";
        $models = $class::factory()->count(100)->create();
        echo "     ✅ $name: 100 record creati\n";
        
    } catch (Exception $e) {
        echo "     ❌ Errore per $name: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// ============================================================================
// TEST FACTORY E POPOLAMENTO MODELLI GEO (solo quelli funzionanti)
// ============================================================================

echo "🌍 TEST E POPOLAMENTO MODELLI GEO FUNZIONANTI...\n";

$geoModels = [
    'County' => \Modules\Geo\Models\County::class,
    'State' => \Modules\Geo\Models\State::class,
    'PlaceType' => \Modules\Geo\Models\PlaceType::class,
];

foreach ($geoModels as $name => $class) {
    try {
        echo "   🧪 Test factory per $name...\n";
        
        // Test factory
        $testModel = $class::factory()->make();
        echo "     ✅ Factory funziona per $name\n";
        
        // Popolamento con 100 record
        echo "     📊 Creazione 100 record per $name...\n";
        $models = $class::factory()->count(100)->create();
        echo "     ✅ $name: 100 record creati\n";
        
    } catch (Exception $e) {
        echo "     ❌ Errore per $name: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// ============================================================================
// RIEPILOGO FINALE
// ============================================================================

echo "🎉 TEST E POPOLAMENTO COMPLETATI!\n";
echo "================================\n\n";

// Conta record totali per ogni modello testato
echo "📊 RIEPILOGO RECORD CREATI:\n";
echo "--------------------------------\n";

$allModels = array_merge($saluteOraModels, $userModels, $mediaModels, $xotModels, $geoModels);

$totalRecords = 0;
$workingModels = 0;
foreach ($allModels as $name => $class) {
    try {
        $count = $class::count();
        echo sprintf("   %-30s: %3d record\n", $name, $count);
        $totalRecords += $count;
        $workingModels++;
    } catch (Exception $e) {
        echo sprintf("   %-30s: ❌ Errore\n", $name);
    }
}

echo "--------------------------------\n";
echo "   TOTALE RECORD: " . number_format($totalRecords) . "\n";
echo "   MODELLI FUNZIONANTI: " . $workingModels . "\n";
echo "   MODELLI TESTATI: " . count($allModels) . "\n\n";

echo "✅ Test e popolamento completati con successo!\n";
echo "🎯 Ogni modello funzionante ha ora 100 record per testing e sviluppo\n";
echo "🔍 Puoi utilizzare Tinker per esplorare i dati: php artisan tinker\n\n";
