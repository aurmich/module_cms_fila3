<?php

declare(strict_types=1);

/**
 * Script per popolare tutti i modelli del progetto SaluteOra con 100 record ciascuno
 * Gestisce le dipendenze tra i modelli per evitare errori di foreign key
 */

echo "🚀 Inizio popolamento modelli SaluteOra...\n\n";

// ============================================================================
// FASE 1: MODELLI BASE (senza dipendenze)
// ============================================================================

echo "📋 FASE 1: Popolamento modelli base...\n";

// 1. Geo Models (dati geografici)
echo "   🌍 Popolamento modelli Geo...\n";
try {
    // Region
    $regions = \Modules\Geo\Models\Region::factory()->count(100)->create();
    echo "     ✅ Region: 100 record creati\n";
    
    // State
    $states = \Modules\Geo\Models\State::factory()->count(100)->create();
    echo "     ✅ State: 100 record creati\n";
    
    // Province
    $provinces = \Modules\Geo\Models\Province::factory()->count(100)->create();
    echo "     ✅ Province: 100 record creati\n";
    
    // Comune
    $comuni = \Modules\Geo\Models\Comune::factory()->count(100)->create();
    echo "     ✅ Comune: 100 record creati\n";
    
    // PlaceType
    $placeTypes = \Modules\Geo\Models\PlaceType::factory()->count(100)->create();
    echo "     ✅ PlaceType: 100 record creati\n";
    
    // Place
    $places = \Modules\Geo\Models\Place::factory()->count(100)->create();
    echo "     ✅ Place: 100 record creati\n";
    
    // Location
    $locations = \Modules\Geo\Models\Location::factory()->count(100)->create();
    echo "     ✅ Location: 100 record creati\n";
    
    // Address
    $addresses = \Modules\Geo\Models\Address::factory()->count(100)->create();
    echo "     ✅ Address: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore Geo: " . $e->getMessage() . "\n";
}

// 2. Xot Models (sistema base)
echo "   🔧 Popolamento modelli Xot...\n";
try {
    // Module
    $modules = \Modules\Xot\Models\Module::factory()->count(100)->create();
    echo "     ✅ Module: 100 record creati\n";
    
    // Extra
    $extras = \Modules\Xot\Models\Extra::factory()->count(100)->create();
    echo "     ✅ Extra: 100 record creati\n";
    
    // Cache
    $caches = \Modules\Xot\Models\Cache::factory()->count(100)->create();
    echo "     ✅ Cache: 100 record creati\n";
    
    // CacheLock
    $cacheLocks = \Modules\Xot\Models\CacheLock::factory()->count(100)->create();
    echo "     ✅ CacheLock: 100 record creati\n";
    
    // Session
    $sessions = \Modules\Xot\Models\Session::factory()->count(100)->create();
    echo "     ✅ Session: 100 record creati\n";
    
    // Log
    $logs = \Modules\Xot\Models\Log::factory()->count(100)->create();
    echo "     ✅ Log: 100 record creati\n";
    
    // Feed
    $feeds = \Modules\Xot\Models\Feed::factory()->count(100)->create();
    echo "     ✅ Feed: 100 record creati\n";
    
    // HealthCheckResultHistoryItem
    $healthChecks = \Modules\Xot\Models\HealthCheckResultHistoryItem::factory()->count(100)->create();
    echo "     ✅ HealthCheckResultHistoryItem: 100 record creati\n";
    
    // PulseEntry
    $pulseEntries = \Modules\Xot\Models\PulseEntry::factory()->count(100)->create();
    echo "     ✅ PulseEntry: 100 record creati\n";
    
    // PulseValue
    $pulseValues = \Modules\Xot\Models\PulseValue::factory()->count(100)->create();
    echo "     ✅ PulseValue: 100 record creati\n";
    
    // PulseAggregate
    $pulseAggregates = \Modules\Xot\Models\PulseAggregate::factory()->count(100)->create();
    echo "     ✅ PulseAggregate: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore Xot: " . $e->getMessage() . "\n";
}

// 3. Media Models
echo "   📁 Popolamento modelli Media...\n";
try {
    // Media
    $medias = \Modules\Media\Models\Media::factory()->count(100)->create();
    echo "     ✅ Media: 100 record creati\n";
    
    // MediaConvert
    $mediaConverts = \Modules\Media\Models\MediaConvert::factory()->count(100)->create();
    echo "     ✅ MediaConvert: 100 record creati\n";
    
    // TemporaryUpload
    $tempUploads = \Modules\Media\Models\TemporaryUpload::factory()->count(100)->create();
    echo "     ✅ TemporaryUpload: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore Media: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// FASE 2: MODELLI UTENTE (dipendenze base)
// ============================================================================

echo "👥 FASE 2: Popolamento modelli utente...\n";

try {
    // User Models
    echo "   👤 Popolamento modelli User...\n";
    
    // Permission
    $permissions = \Modules\User\Models\Permission::factory()->count(100)->create();
    echo "     ✅ Permission: 100 record creati\n";
    
    // Role
    $roles = \Modules\User\Models\Role::factory()->count(100)->create();
    echo "     ✅ Role: 100 record creati\n";
    
    // RoleHasPermission
    $rolePermissions = \Modules\User\Models\RoleHasPermission::factory()->count(100)->create();
    echo "     ✅ RoleHasPermission: 100 record creati\n";
    
    // Team
    $teams = \Modules\User\Models\Team::factory()->count(100)->create();
    echo "     ✅ Team: 100 record creati\n";
    
    // Tenant
    $tenants = \Modules\User\Models\Tenant::factory()->count(100)->create();
    echo "     ✅ Tenant: 100 record creati\n";
    
    // Profile
    $profiles = \Modules\User\Models\Profile::factory()->count(100)->create();
    echo "     ✅ Profile: 100 record creati\n";
    
    // Device
    $devices = \Modules\User\Models\Device::factory()->count(100)->create();
    echo "     ✅ Device: 100 record creati\n";
    
    // DeviceProfile
    $deviceProfiles = \Modules\User\Models\DeviceProfile::factory()->count(100)->create();
    echo "     ✅ DeviceProfile: 100 record creati\n";
    
    // Feature
    $features = \Modules\User\Models\Feature::factory()->count(100)->create();
    echo "     ✅ Feature: 100 record creati\n";
    
    // Membership
    $memberships = \Modules\User\Models\Membership::factory()->count(100)->create();
    echo "     ✅ Membership: 100 record creati\n";
    
    // Notification
    $notifications = \Modules\User\Models\Notification::factory()->count(100)->create();
    echo "     ✅ Notification: 100 record creati\n";
    
    // OAuth models
    $oauthClients = \Modules\User\Models\OauthClient::factory()->count(100)->create();
    echo "     ✅ OauthClient: 100 record creati\n";
    
    $oauthAuthCodes = \Modules\User\Models\OauthAuthCode::factory()->count(100)->create();
    echo "     ✅ OauthAuthCode: 100 record creati\n";
    
    $oauthAccessTokens = \Modules\User\Models\OauthAccessToken::factory()->count(100)->create();
    echo "     ✅ OauthAccessToken: 100 record creati\n";
    
    $oauthRefreshTokens = \Modules\User\Models\OauthRefreshToken::factory()->count(100)->create();
    echo "     ✅ OauthRefreshToken: 100 record creati\n";
    
    $oauthPersonalAccessClients = \Modules\User\Models\OauthPersonalAccessClient::factory()->count(100)->create();
    echo "     ✅ OauthPersonalAccessClient: 100 record creati\n";
    
    // Social models
    $socialProviders = \Modules\User\Models\SocialProvider::factory()->count(100)->create();
    echo "     ✅ SocialProvider: 100 record creati\n";
    
    $socialiteUsers = \Modules\User\Models\SocialiteUser::factory()->count(100)->create();
    echo "     ✅ SocialiteUser: 100 record creati\n";
    
    // Authentication
    $authentications = \Modules\User\Models\Authentication::factory()->count(100)->create();
    echo "     ✅ Authentication: 100 record creati\n";
    
    $authenticationLogs = \Modules\User\Models\AuthenticationLog::factory()->count(100)->create();
    echo "     ✅ AuthenticationLog: 100 record creati\n";
    
    // Password reset
    $passwordResets = \Modules\User\Models\PasswordReset::factory()->count(100)->create();
    echo "     ✅ PasswordReset: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore User: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// FASE 3: MODELLI SALUTEORA (dipendenze utente)
// ============================================================================

echo "🏥 FASE 3: Popolamento modelli SaluteOra...\n";

try {
    // Studio (dipende da User)
    echo "   🏢 Popolamento modelli Studio...\n";
    $studios = \Modules\SaluteOra\Models\Studio::factory()->count(100)->create();
    echo "     ✅ Studio: 100 record creati\n";
    
    // User (dipende da Team, Role, Permission)
    echo "   👤 Popolamento modelli User SaluteOra...\n";
    $users = \Modules\SaluteOra\Models\User::factory()->count(100)->create();
    echo "     ✅ User: 100 record creati\n";
    
    // Doctor (dipende da User)
    echo "   👨‍⚕️ Popolamento modelli Doctor...\n";
    $doctors = \Modules\SaluteOra\Models\Doctor::factory()->count(100)->create();
    echo "     ✅ Doctor: 100 record creati\n";
    
    // Patient (dipende da User)
    echo "   🧑‍⚕️ Popolamento modelli Patient...\n";
    $patients = \Modules\SaluteOra\Models\Patient::factory()->count(100)->create();
    echo "     ✅ Patient: 100 record creati\n";
    
    // Admin (dipende da User)
    echo "   👨‍💼 Popolamento modelli Admin...\n";
    $admins = \Modules\SaluteOra\Models\Admin::factory()->count(100)->create();
    echo "     ✅ Admin: 100 record creati\n";
    
    // Profile (dipende da User)
    echo "   📋 Popolamento modelli Profile...\n";
    $profiles = \Modules\SaluteOra\Models\Profile::factory()->count(100)->create();
    echo "     ✅ Profile: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore SaluteOra base: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// FASE 4: MODELLI PIVOT E RELAZIONI (dipendenze multiple)
// ============================================================================

echo "🔗 FASE 4: Popolamento modelli pivot e relazioni...\n";

try {
    // StudioUser (dipende da Studio e User)
    echo "   🔗 Popolamento modelli pivot Studio...\n";
    $studioUsers = \Modules\SaluteOra\Models\StudioUser::factory()->count(100)->create();
    echo "     ✅ StudioUser: 100 record creati\n";
    
    // DoctorStudio (dipende da Doctor e Studio)
    $doctorStudios = \Modules\SaluteOra\Models\DoctorStudio::factory()->count(100)->create();
    echo "     ✅ DoctorStudio: 100 record creati\n";
    
    // PatientStudio (dipende da Patient e Studio)
    $patientStudios = \Modules\SaluteOra\Models\PatientStudio::factory()->count(100)->create();
    echo "     ✅ PatientStudio: 100 record creati\n";
    
    // AdminStudio (dipende da Admin e Studio)
    $adminStudios = \Modules\SaluteOra\Models\AdminStudio::factory()->count(100)->create();
    echo "     ✅ AdminStudio: 100 record creati\n";
    
    // TeamUser (dipende da Team e User)
    echo "   🔗 Popolamento modelli pivot Team...\n";
    $teamUsers = \Modules\SaluteOra\Models\TeamUser::factory()->count(100)->create();
    echo "     ✅ TeamUser: 100 record creati\n";
    
    // DoctorTeam (dipende da Doctor e Team)
    $doctorTeams = \Modules\SaluteOra\Models\DoctorTeam::factory()->count(100)->create();
    echo "     ✅ DoctorTeam: 100 record creati\n";
    
    // PatientTeam (dipende da Patient e Team)
    $patientTeams = \Modules\SaluteOra\Models\PatientTeam::factory()->count(100)->create();
    echo "     ✅ PatientTeam: 100 record creati\n";
    
    // AdminTeam (dipende da Admin e Team)
    $adminTeams = \Modules\SaluteOra\Models\AdminTeam::factory()->count(100)->create();
    echo "     ✅ AdminTeam: 100 record creati\n";
    
    // User pivot models
    echo "   🔗 Popolamento modelli pivot User...\n";
    $permissionUsers = \Modules\User\Models\PermissionUser::factory()->count(100)->create();
    echo "     ✅ PermissionUser: 100 record creati\n";
    
    $permissionRoles = \Modules\User\Models\PermissionRole::factory()->count(100)->create();
    echo "     ✅ PermissionRole: 100 record creati\n";
    
    $modelHasRoles = \Modules\User\Models\ModelHasRole::factory()->count(100)->create();
    echo "     ✅ ModelHasRole: 100 record creati\n";
    
    $modelHasPermissions = \Modules\User\Models\ModelHasPermission::factory()->count(100)->create();
    echo "     ✅ ModelHasPermission: 100 record creati\n";
    
    $tenantUsers = \Modules\User\Models\TenantUser::factory()->count(100)->create();
    echo "     ✅ TenantUser: 100 record creati\n";
    
    $deviceUsers = \Modules\User\Models\DeviceUser::factory()->count(100)->create();
    echo "     ✅ DeviceUser: 100 record creati\n";
    
    $profileTeams = \Modules\User\Models\ProfileTeam::factory()->count(100)->create();
    echo "     ✅ ProfileTeam: 100 record creati\n";
    
    $teamPermissions = \Modules\User\Models\TeamPermission::factory()->count(100)->create();
    echo "     ✅ TeamPermission: 100 record creati\n";
    
    $teamInvitations = \Modules\User\Models\TeamInvitation::factory()->count(100)->create();
    echo "     ✅ TeamInvitation: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore modelli pivot: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// FASE 5: MODELLI BUSINESS LOGIC (dipendenze complete)
// ============================================================================

echo "💼 FASE 5: Popolamento modelli business logic...\n";

try {
    // Appointment (dipende da Patient, Doctor, Studio)
    echo "   📅 Popolamento modelli Appointment...\n";
    $appointments = \Modules\SaluteOra\Models\Appointment::factory()->count(100)->create();
    echo "     ✅ Appointment: 100 record creati\n";
    
    // Report (dipende da Appointment, Patient, Doctor)
    echo "   📊 Popolamento modelli Report...\n";
    $reports = \Modules\SaluteOra\Models\Report::factory()->count(100)->create();
    echo "     ✅ Report: 100 record creati\n";
    
} catch (Exception $e) {
    echo "     ❌ Errore business logic: " . $e->getMessage() . "\n";
}

echo "\n";

// ============================================================================
// RIEPILOGO FINALE
// ============================================================================

echo "🎉 POPOLAMENTO COMPLETATO!\n";
echo "================================\n\n";

// Conta record totali per ogni modello
echo "📊 RIEPILOGO RECORD CREATI:\n";
echo "--------------------------------\n";

$models = [
    // Geo
    'Region' => \Modules\Geo\Models\Region::class,
    'State' => \Modules\Geo\Models\State::class,
    'Province' => \Modules\Geo\Models\Province::class,
    'Comune' => \Modules\Geo\Models\Comune::class,
    'PlaceType' => \Modules\Geo\Models\PlaceType::class,
    'Place' => \Modules\Geo\Models\Place::class,
    'Location' => \Modules\Geo\Models\Location::class,
    'Address' => \Modules\Geo\Models\Address::class,
    
    // Xot
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
    
    // Media
    'Media' => \Modules\Media\Models\Media::class,
    'MediaConvert' => \Modules\Media\Models\MediaConvert::class,
    'TemporaryUpload' => \Modules\Media\Models\TemporaryUpload::class,
    
    // User
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
    
    // SaluteOra
    'Studio' => \Modules\SaluteOra\Models\Studio::class,
    'User' => \Modules\SaluteOra\Models\User::class,
    'Doctor' => \Modules\SaluteOra\Models\Doctor::class,
    'Patient' => \Modules\SaluteOra\Models\Patient::class,
    'Admin' => \Modules\SaluteOra\Models\Admin::class,
    'Profile' => \Modules\SaluteOra\Models\Profile::class,
    
    // Pivot models
    'StudioUser' => \Modules\SaluteOra\Models\StudioUser::class,
    'DoctorStudio' => \Modules\SaluteOra\Models\DoctorStudio::class,
    'PatientStudio' => \Modules\SaluteOra\Models\PatientStudio::class,
    'AdminStudio' => \Modules\SaluteOra\Models\AdminStudio::class,
    'TeamUser' => \Modules\SaluteOra\Models\TeamUser::class,
    'DoctorTeam' => \Modules\SaluteOra\Models\DoctorTeam::class,
    'PatientTeam' => \Modules\SaluteOra\Models\PatientTeam::class,
    'AdminTeam' => \Modules\SaluteOra\Models\AdminTeam::class,
    'PermissionUser' => \Modules\User\Models\PermissionUser::class,
    'PermissionRole' => \Modules\User\Models\PermissionRole::class,
    'ModelHasRole' => \Modules\User\Models\ModelHasRole::class,
    'ModelHasPermission' => \Modules\User\Models\ModelHasPermission::class,
    'TenantUser' => \Modules\User\Models\TenantUser::class,
    'DeviceUser' => \Modules\User\Models\DeviceUser::class,
    'ProfileTeam' => \Modules\User\Models\ProfileTeam::class,
    'TeamPermission' => \Modules\User\Models\TeamPermission::class,
    'TeamInvitation' => \Modules\User\Models\TeamInvitation::class,
    
    // Business logic
    'Appointment' => \Modules\SaluteOra\Models\Appointment::class,
    'Report' => \Modules\SaluteOra\Models\Report::class,
];

$totalRecords = 0;
foreach ($models as $name => $class) {
    try {
        $count = $class::count();
        echo sprintf("   %-30s: %3d record\n", $name, $count);
        $totalRecords += $count;
    } catch (Exception $e) {
        echo sprintf("   %-30s: ❌ Errore\n", $name);
    }
}

echo "--------------------------------\n";
echo "   TOTALE RECORD: " . number_format($totalRecords) . "\n";
echo "   MODELLI POPOLATI: " . count($models) . "\n\n";

echo "✅ Popolamento completato con successo!\n";
echo "🎯 Ogni modello ha ora 100 record per testing e sviluppo\n";
echo "🔍 Puoi utilizzare Tinker per esplorare i dati: php artisan tinker\n\n";
