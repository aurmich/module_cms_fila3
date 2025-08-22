# MODULE ANALYSIS REPORT

Generated on: 2025-08-22 14:28:48

## Activity

- **Models found**: 6
- **Factories found**: 3
- **Seeders found**: 1

### ❌ Missing Factories:
  - BaseStoredEvent
  - BaseActivity
  - BaseSnapshot

### ❌ Missing Seeders:
  - Snapshot
  - StoredEvent
  - BaseStoredEvent
  - BaseActivity
  - BaseSnapshot
  - Activity

---

## Cms

- **Models found**: 11
- **Factories found**: 6
- **Seeders found**: 1

### ❌ Missing Factories:
  - BaseTreeModel
  - HasBlocks
  - BasePivot
  - BaseMorphPivot
  - BaseModelLang

### ❌ Missing Seeders:
  - BaseTreeModel
  - Module
  - Section
  - HasBlocks
  - BasePivot
  - PageContent
  - BaseMorphPivot
  - BaseModelLang
  - Menu
  - Page
  - Conf

---

## Gdpr

- **Models found**: 7
- **Factories found**: 4
- **Seeders found**: 1

### ❌ Missing Factories:
  - HasGdpr
  - BasePivot
  - BaseMorphPivot

### ❌ Missing Seeders:
  - Profile
  - Consent
  - HasGdpr
  - BasePivot
  - BaseMorphPivot
  - Treatment
  - Event

---

## Geo

- **Models found**: 19
- **Factories found**: 10
- **Seeders found**: 1

### ❌ Missing Factories:
  - GeoTrait
  - HasAddress
  - HasPlaceTrait
  - GeographicalScopes
  - SushiToJsons
  - BasePivot
  - BaseMorphPivot
  - GeoJsonModel
  - ComuneJson

### ❌ Missing Seeders:
  - Place
  - County
  - Province
  - Address
  - Location
  - Comune
  - GeoTrait
  - HasAddress
  - HasPlaceTrait
  - GeographicalScopes
  - SushiToJsons
  - PlaceType
  - Region
  - BasePivot
  - BaseMorphPivot
  - Locality
  - State
  - GeoJsonModel
  - ComuneJson

---

## Job

- **Models found**: 19
- **Factories found**: 14
- **Seeders found**: 1

### ❌ Missing Factories:
  - FrontendSortable
  - FailedJobPolicy
  - JobPolicy
  - JobBatchPolicy
  - BaseMorphPivot

### ❌ Missing Seeders:
  - Import
  - FrontendSortable
  - FailedJobPolicy
  - JobPolicy
  - JobBatchPolicy
  - JobManager
  - Schedule
  - Frequency
  - JobsWaiting
  - FailedJob
  - Result
  - JobBatch
  - FailedImportRow
  - BaseMorphPivot
  - Parameter
  - ScheduleHistory
  - Task
  - Job
  - Export

---

## Lang

- **Models found**: 8
- **Factories found**: 3
- **Seeders found**: 1

### ❌ Missing Factories:
  - LinkedTrait
  - HasStrictTranslations
  - BaseMorphPivot
  - BaseModelLang
  - HasTranslationsContract

### ❌ Missing Seeders:
  - Translation
  - LinkedTrait
  - HasStrictTranslations
  - Post
  - BaseMorphPivot
  - BaseModelLang
  - TranslationFile
  - HasTranslationsContract

---

## Media

- **Models found**: 3
- **Factories found**: 3
- **Seeders found**: 1

### ❌ Missing Seeders:
  - MediaConvert
  - TemporaryUpload
  - Media

---

## Notify

- **Models found**: 12
- **Factories found**: 10
- **Seeders found**: 4

### ❌ Missing Factories:
  - BasePivot
  - BaseMorphPivot

### ❌ Missing Seeders:
  - Notification
  - MailTemplateLog
  - NotificationTemplateVersion
  - Contact
  - NotifyTheme
  - MailTemplateVersion
  - BasePivot
  - NotificationType
  - BaseMorphPivot
  - NotificationTemplate
  - NotifyThemeable

---

## SaluteMo

- **Models found**: 1
- **Factories found**: 0
- **Seeders found**: 1

### ❌ Missing Factories:
  - BasePivot

### ❌ Missing Seeders:
  - BasePivot

---

## SaluteOra

- **Models found**: 24
- **Factories found**: 16
- **Seeders found**: 14

### ❌ Missing Factories:
  - ReportPolicy
  - PatientPolicy
  - StudioPolicy
  - DoctorPolicy
  - AppointmentPolicy
  - DoctorStudioPolicy
  - UserPolicy
  - BasePivot

### ❌ Missing Seeders:
  - TeamUser
  - AdminTeam
  - StudioUser
  - Doctor
  - DoctorStudio
  - PatientStudio
  - ReportPolicy
  - PatientPolicy
  - StudioPolicy
  - DoctorPolicy
  - AppointmentPolicy
  - DoctorStudioPolicy
  - UserPolicy
  - BasePivot
  - Admin
  - AdminStudio
  - Patient
  - DoctorTeam
  - PatientTeam

---

## Tenant

- **Models found**: 6
- **Factories found**: 1
- **Seeders found**: 1

### ❌ Missing Factories:
  - BaseModelJsons
  - SushiToCsv
  - SushiToJson
  - SushiToJsons
  - SushiToPhpArray

### ❌ Missing Seeders:
  - BaseModelJsons
  - Domain
  - SushiToCsv
  - SushiToJson
  - SushiToJsons
  - SushiToPhpArray

---

## UI

- **Models found**: 0
- **Factories found**: 0
- **Seeders found**: 1

### ✅ Complete: All models have factories and seeders

---

## User

- **Models found**: 59
- **Factories found**: 33
- **Seeders found**: 4

### ❌ Missing Factories:
  - BaseUuidModel
  - BaseUser
  - BaseTeam
  - BaseUser
  - BaseInteractsWithTenant
  - BaseTeamUser
  - BaseIsTenant
  - HasAuthenticationLogTrait
  - HasTenants
  - HasPasswordExpiry
  - IsProfileTrait
  - HasTeams
  - HasRoles
  - InteractsWithTenant
  - IsTenant
  - TenantScope
  - TeamPolicy
  - UserBasePolicy
  - PermissionPolicy
  - RolePolicy
  - UserPolicy
  - BasePivot
  - BaseMorphPivot
  - BaseProfile
  - BaseTenant
  - BaseInteractsWithExtra

### ❌ Missing Seeders:
  - TeamUser
  - OauthAuthCode
  - SocialProvider
  - PasswordReset
  - BaseUuidModel
  - BaseUser
  - OauthClient
  - Notification
  - ModelHasPermission
  - RoleHasPermission
  - OauthAccessToken
  - SocialiteUser
  - Profile
  - AuthenticationLog
  - Authentication
  - Feature
  - BaseTeam
  - BaseUser
  - OauthRefreshToken
  - PermissionRole
  - Extra
  - DeviceProfile
  - BaseInteractsWithTenant
  - Permission
  - Team
  - BaseTeamUser
  - DeviceUser
  - TenantUser
  - BaseIsTenant
  - ModelHasRole
  - TeamPermission
  - HasAuthenticationLogTrait
  - HasTenants
  - HasPasswordExpiry
  - IsProfileTrait
  - HasTeams
  - HasRoles
  - InteractsWithTenant
  - IsTenant
  - TenantScope
  - PermissionUser
  - TeamPolicy
  - UserBasePolicy
  - PermissionPolicy
  - RolePolicy
  - UserPolicy
  - BasePivot
  - Device
  - BaseMorphPivot
  - ProfileTeam
  - Role
  - TeamInvitation
  - BaseProfile
  - BaseTenant
  - Membership
  - Tenant
  - BaseInteractsWithExtra
  - OauthPersonalAccessClient

---

## Xot

- **Models found**: 23
- **Factories found**: 12
- **Seeders found**: 1

### ❌ Missing Factories:
  - BaseTreeModel
  - BaseExtra
  - XotBaseUuidModel
  - HasExtraTrait
  - RelationX
  - XotBasePolicy
  - BaseComment
  - BaseMorphPivot
  - XotBaseModel
  - BaseRating
  - BaseRatingMorph

### ❌ Missing Seeders:
  - CacheLock
  - BaseTreeModel
  - Module
  - BaseExtra
  - InformationSchemaTable
  - HealthCheckResultHistoryItem
  - XotBaseUuidModel
  - Extra
  - HasExtraTrait
  - RelationX
  - Session
  - XotBasePolicy
  - PulseAggregate
  - PulseEntry
  - BaseComment
  - PulseValue
  - BaseMorphPivot
  - XotBaseModel
  - Feed
  - BaseRating
  - BaseRatingMorph
  - Log
  - Cache

---

