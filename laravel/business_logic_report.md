# Business Logic Analysis Report

Generated: 2025-08-26 14:46:25

## Module: Activity

### Models (6)
- Activity
- BaseActivity
- BaseSnapshot
- BaseStoredEvent
- Snapshot
- StoredEvent

### Factories (4)
- ActivityFactory
- BaseActivityFactory
- SnapshotFactory
- StoredEventFactory

### Seeders (2)
- ActivityDatabaseSeeder
- ActivityMassSeeder

### ❌ Missing Factories
- BaseSnapshotFactory
- BaseStoredEventFactory

---

## Module: Cms

### Models (8)
- BaseModelLang
- BaseTreeModel
- Conf
- Menu
- Module
- Page
- PageContent
- Section

### Factories (7)
- BaseModelFactory
- ConfFactory
- MenuFactory
- ModuleFactory
- PageContentFactory
- PageFactory
- SectionFactory

### Seeders (2)
- CmsDatabaseSeeder
- CmsMassSeeder

### ❌ Missing Factories
- BaseModelLangFactory
- BaseTreeModelFactory

---

## Module: Gdpr

### Models (4)
- Consent
- Event
- Profile
- Treatment

### Factories (4)
- ConsentFactory
- EventFactory
- ProfileFactory
- TreatmentFactory

### Seeders (1)
- GdprDatabaseSeeder

---

## Module: Geo

### Models (12)
- Address
- Comune
- ComuneJson
- County
- GeoJsonModel
- Locality
- Location
- Place
- PlaceType
- Province
- Region
- State

### Factories (10)
- AddressFactory
- ComuneFactory
- CountyFactory
- LocalityFactory
- LocationFactory
- PlaceFactory
- PlaceTypeFactory
- ProvinceFactory
- RegionFactory
- StateFactory

### Seeders (2)
- GeoDataMigrator
- GeoDatabaseSeeder

### ❌ Missing Factories
- ComuneJsonFactory
- GeoJsonModelFactory

---

## Module: Job

### Models (14)
- Export
- FailedImportRow
- FailedJob
- Frequency
- Import
- Job
- JobBatch
- JobManager
- JobsWaiting
- Parameter
- Result
- Schedule
- ScheduleHistory
- Task

### Factories (14)
- ExportFactory
- FailedImportRowFactory
- FailedJobFactory
- FrequencyFactory
- ImportFactory
- JobBatchFactory
- JobFactory
- JobManagerFactory
- JobsWaitingFactory
- ParameterFactory
- ResultFactory
- ScheduleFactory
- ScheduleHistoryFactory
- TaskFactory

### Seeders (1)
- JobDatabaseSeeder

---

## Module: Lang

### Models (4)
- BaseModelLang
- Post
- Translation
- TranslationFile

### Factories (3)
- PostFactory
- TranslationFactory
- TranslationFileFactory

### Seeders (1)
- LangDatabaseSeeder

### ❌ Missing Factories
- BaseModelLangFactory

---

## Module: Media

### Models (3)
- Media
- MediaConvert
- TemporaryUpload

### Factories (3)
- MediaConvertFactory
- MediaFactory
- TemporaryUploadFactory

### Seeders (1)
- MediaDatabaseSeeder

---

## Module: Notify

### Models (10)
- Contact
- MailTemplate
- MailTemplateLog
- MailTemplateVersion
- Notification
- NotificationTemplate
- NotificationTemplateVersion
- NotificationType
- NotifyTheme
- NotifyThemeable

### Factories (10)
- ContactFactory
- MailTemplateFactory
- MailTemplateLogFactory
- MailTemplateVersionFactory
- NotificationFactory
- NotificationTemplateFactory
- NotificationTemplateVersionFactory
- NotificationTypeFactory
- NotifyThemeFactory
- NotifyThemeableFactory

### Seeders (4)
- DatabaseSeeder
- MailTemplateSeeder
- MailTemplatesSeeder
- NotifyDatabaseSeeder

---

## Module: SaluteMo

### Models (0)

### Factories (0)

### Seeders (1)
- SaluteMoDatabaseSeeder

---

## Module: SaluteOra

### Models (16)
- Admin
- AdminStudio
- AdminTeam
- Appointment
- Doctor
- DoctorStudio
- DoctorTeam
- Patient
- PatientStudio
- PatientTeam
- Profile
- Report
- Studio
- StudioUser
- TeamUser
- User

### Factories (16)
- AdminFactory
- AdminStudioFactory
- AdminTeamFactory
- AppointmentFactory
- DoctorFactory
- DoctorStudioFactory
- DoctorTeamFactory
- PatientFactory
- PatientStudioFactory
- PatientTeamFactory
- ProfileFactory
- ReportFactory
- StudioFactory
- StudioUserFactory
- TeamUserFactory
- UserFactory

### Seeders (15)
- AppointmentSeeder
- DentalDatabaseSeeder
- MailTemplateSeeder
- MassDataSeeder
- PatientDatabaseSeeder
- PivotSeeder
- ProfileSeeder
- ReportSeeder
- ReportingDatabaseSeeder
- SaluteOraDatabaseSeeder
- SaluteOraSeeder
- StudioSeeder
- StudiosAttachDoctorCap66010Seeder
- StudiosCap66010Seeder
- UserSeeder

---

## Module: Tenant

### Models (3)
- BaseModelJsons
- Domain
- TestSushiModel

### Factories (2)
- DomainFactory
- TenantFactory

### Seeders (1)
- TenantDatabaseSeeder

### ❌ Missing Factories
- BaseModelJsonsFactory
- TestSushiModelFactory

---

## Module: UI

### Models (0)

### Factories (0)

### Seeders (1)
- UIDatabaseSeeder

---

## Module: User

### Models (42)
- Authentication
- AuthenticationLog
- BaseInteractsWithExtra
- BaseInteractsWithTenant
- BaseIsTenant
- BaseProfile
- BaseTeam
- BaseTeamUser
- BaseTenant
- BaseUser
- BaseUuidModel
- Device
- DeviceProfile
- DeviceUser
- Extra
- Feature
- Membership
- ModelHasPermission
- ModelHasRole
- Notification
- OauthAccessToken
- OauthAuthCode
- OauthClient
- OauthPersonalAccessClient
- OauthRefreshToken
- PasswordReset
- Permission
- PermissionRole
- PermissionUser
- Profile
- ProfileTeam
- Role
- RoleHasPermission
- SocialProvider
- SocialiteUser
- Team
- TeamInvitation
- TeamPermission
- TeamUser
- Tenant
- TenantUser
- User

### Factories (33)
- AuthenticationFactory
- AuthenticationLogFactory
- DeviceFactory
- DeviceProfileFactory
- DeviceUserFactory
- ExtraFactory
- FeatureFactory
- MembershipFactory
- ModelHasPermissionFactory
- ModelHasRoleFactory
- NotificationFactory
- OauthAccessTokenFactory
- OauthAuthCodeFactory
- OauthClientFactory
- OauthPersonalAccessClientFactory
- OauthRefreshTokenFactory
- PasswordResetFactory
- PermissionFactory
- PermissionRoleFactory
- PermissionUserFactory
- ProfileFactory
- ProfileTeamFactory
- RoleFactory
- RoleHasPermissionFactory
- SocialProviderFactory
- SocialiteUserFactory
- TeamFactory
- TeamInvitationFactory
- TeamPermissionFactory
- TeamUserFactory
- TenantFactory
- TenantUserFactory
- UserFactory

### Seeders (5)
- PermissionsSeeder
- RolesSeeder
- UserDatabaseSeeder
- UserMassSeeder
- UserSeeder

### ❌ Missing Factories
- BaseInteractsWithExtraFactory
- BaseInteractsWithTenantFactory
- BaseIsTenantFactory
- BaseProfileFactory
- BaseTeamFactory
- BaseTeamUserFactory
- BaseTenantFactory
- BaseUserFactory
- BaseUuidModelFactory

---

## Module: Xot

### Models (19)
- BaseComment
- BaseExtra
- BaseRating
- BaseRatingMorph
- BaseTreeModel
- Cache
- CacheLock
- Extra
- Feed
- HealthCheckResultHistoryItem
- InformationSchemaTable
- Log
- Module
- PulseAggregate
- PulseEntry
- PulseValue
- Session
- XotBaseModel
- XotBaseUuidModel

### Factories (13)
- CacheFactory
- CacheLockFactory
- ExtraFactory
- FeedFactory
- HealthCheckResultHistoryItemFactory
- InformationSchemaTableFactory
- LogFactory
- ModuleFactory
- PulseAggregateFactory
- PulseEntryFactory
- PulseValueFactory
- SessionFactory
- XotBaseModelFactory

### Seeders (1)
- XotDatabaseSeeder

### ❌ Missing Factories
- BaseCommentFactory
- BaseExtraFactory
- BaseRatingFactory
- BaseRatingMorphFactory
- BaseTreeModelFactory
- XotBaseUuidModelFactory

---

