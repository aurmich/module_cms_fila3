# UNUSED/BUSINESS-IRRELEVANT MODELS ANALYSIS

## Analysis Methodology
1. **Base Classes/Traits**: Models that are abstract, traits, or base classes not meant for direct use
2. **Policy Classes**: Authorization policy classes (not data models)
3. **Sushi/Json Models**: Models used for static data via Sushi/JSON
4. **Pivot Models**: Intermediate table models
5. **Unused Features**: Models for features not implemented in business logic
6. **Duplicates**: Models with similar functionality

## MODULE-BY-MODULE ANALYSIS

### Activity Module
**Potentially Unused/Irrelevant:**
- `BaseStoredEvent`, `BaseActivity`, `BaseSnapshot` - Abstract base classes
- These should not have factories/seeders as they're not concrete models

### Cms Module  
**Potentially Unused/Irrelevant:**
- `BaseTreeModel`, `HasBlocks`, `BasePivot`, `BaseMorphPivot`, `BaseModelLang` - Base classes/traits
- `Conf` - Configuration model (may be better as config files)

### Gdpr Module
**Potentially Unused/Irrelevant:**
- `HasGdpr` - Trait, not a model
- `BasePivot`, `BaseMorphPivot` - Base classes

### Geo Module
**Potentially Unused/Irrelevant:**
- `GeoTrait`, `HasAddress`, `HasPlaceTrait`, `GeographicalScopes` - Traits
- `SushiToJsons` - Interface/abstract class
- `BasePivot`, `BaseMorphPivot` - Base classes
- `GeoJsonModel`, `ComuneJson` - Sushi/JSON data models (static data)

### Job Module
**Potentially Unused/Irrelevant:**
- `FrontendSortable` - Trait
- `FailedJobPolicy`, `JobPolicy`, `JobBatchPolicy` - Policy classes (authorization)
- `BaseMorphPivot` - Base class

### Lang Module
**Potentially Unused/Irrelevant:**
- `LinkedTrait`, `HasStrictTranslations` - Traits
- `BaseMorphPivot`, `BaseModelLang` - Base classes
- `HasTranslationsContract` - Interface

### Media Module
**All models appear business-relevant**
- `Media`, `MediaConvert`, `TemporaryUpload` - Core media functionality

### Notify Module
**Potentially Unused/Irrelevant:**
- `BasePivot`, `BaseMorphPivot` - Base classes

### SaluteMo Module
**Potentially Unused/Irrelevant:**
- `BasePivot` - Base class

### SaluteOra Module
**Potentially Unused/Irrelevant:**
- `ReportPolicy`, `PatientPolicy`, `StudioPolicy`, `DoctorPolicy`, `AppointmentPolicy`, `DoctorStudioPolicy`, `UserPolicy` - Policy classes
- `BasePivot` - Base class

### Tenant Module
**Potentially Unused/Irrelevant:**
- `BaseModelJsons`, `SushiToCsv`, `SushiToJson`, `SushiToJsons`, `SushiToPhpArray` - Sushi/JSON interfaces

### UI Module
**No models found** - UI components only

### User Module
**Potentially Unused/Irrelevant:**
- Multiple base classes, traits, and policy classes:
  - `BaseUuidModel`, `BaseUser`, `BaseTeam`, `BaseTeamUser`, `BaseIsTenant`, `BasePivot`, `BaseMorphPivot`, `BaseProfile`, `BaseTenant`, `BaseInteractsWithExtra`
  - Various traits: `HasAuthenticationLogTrait`, `HasTenants`, `HasPasswordExpiry`, `IsProfileTrait`, `HasTeams`, `HasRoles`, `InteractsWithTenant`, `IsTenant`
  - Policy classes: `TeamPolicy`, `UserBasePolicy`, `PermissionPolicy`, `RolePolicy`, `UserPolicy`
  - OAuth models if not using OAuth: `OauthAuthCode`, `OauthClient`, `OauthAccessToken`, `OauthRefreshToken`, `OauthPersonalAccessClient`

### Xot Module
**Potentially Unused/Irrelevant:**
- `BaseTreeModel`, `BaseExtra`, `XotBaseUuidModel`, `HasExtraTrait`, `RelationX`, `XotBasePolicy`, `BaseComment`, `BaseMorphPivot`, `XotBaseModel`, `BaseRating`, `BaseRatingMorph` - Base classes/traits
- `CacheLock`, `InformationSchemaTable`, `HealthCheckResultHistoryItem`, `Session`, `PulseAggregate`, `PulseEntry`, `PulseValue`, `Feed`, `Log`, `Cache` - Infrastructure/models

## RECOMMENDATIONS

1. **Remove Factory/Seeder Requirements for:**
   - Abstract base classes
   - Traits and interfaces  
   - Policy classes (authorization)
   - Sushi/JSON static data models

2. **Focus on Concrete Business Models:**
   - Only require factories/seeders for models that represent business entities
   - Models that will be created during testing/seeding

3. **Cleanup Opportunities:**
   - Consider removing unused OAuth models if not using OAuth
   - Evaluate if some infrastructure models are needed
   - Consolidate duplicate base classes

4. **Documentation:** Each module's docs should clarify which models are:
   - Business entities (require factories/seeders)
   - Base classes/traits (no factories/seeders)
   - Infrastructure models (context-dependent)
   - Policy classes (authorization only)

## NEXT STEPS
1. Update module documentation with model classifications
2. Adjust factory/seeder expectations based on model type
3. Remove unnecessary factory/seeder requirements for non-entity models
4. Focus testing on business-relevant models only