# Factory Audit 2025 - SaluteOra

## Situazione Critica Identificata

**Data audit**: 2025-01-06  
**Gravità**: CRITICA - 35+ factory mancanti su 13 moduli

## Errore Gravissimo

Ogni modello deve avere la sua factory per i test e la generazione di dati. È un errore gravissimo da non ripetere mai più.

## Situazione Completa per Modulo

### 🚨 MODULI CRITICI (Priorità Massima)

#### 1. Modulo User - GRAVISSIMO
- **Models**: 33 totali
- **Factory Presenti**: 16
- **Factory Mancanti**: 17
- **Stato**: 🚨 CRITICO
- **Doc**: [Modules/User/docs/missing-factories-audit.md](../laravel/Modules/User/docs/missing-factories-audit.md)

**Factory mancanti critiche:**
- AuthenticationFactory ✅ CREATA
- MembershipFactory ✅ CREATA  
- TeamUserFactory ✅ CREATA
- NotificationFactory
- OauthAccessTokenFactory
- OauthClientFactory
- PermissionRoleFactory
- RoleHasPermissionFactory
- TeamPermissionFactory
- TenantUserFactory
- DeviceProfileFactory
- DeviceUserFactory
- OauthAuthCodeFactory
- OauthPersonalAccessClientFactory
- OauthRefreshTokenFactory
- ProfileTeamFactory
- SocialiteUserFactory

#### 2. Modulo Geo - CRITICO
- **Models**: 11 totali
- **Factory Presenti**: 3
- **Factory Mancanti**: 8
- **Stato**: 🚨 CRITICO
- **Doc**: [Modules/Geo/docs/missing-factories-audit.md](../laravel/Modules/Geo/docs/missing-factories-audit.md)

**Factory mancanti critiche:**
- AddressFactory ✅ CREATA
- PlaceFactory ✅ CREATA
- LocationFactory
- StateFactory
- CountyFactory
- GeoNamesCapFactory
- LocalityFactory
- PlaceTypeFactory

#### 3. Modulo Media - CRITICO
- **Models**: 3 totali
- **Factory Presenti**: 1
- **Factory Mancanti**: 2
- **Stato**: 🚨 CRITICO

**Factory mancanti:**
- MediaFactory
- TemporaryUploadFactory

### ⚠️ MODULI CON PROBLEMI (Priorità Alta)

#### 4. Modulo Activity
- **Factory Mancanti**: 2
- **Stato**: ⚠️ MEDIO
- SnapshotFactory
- StoredEventFactory

#### 5. Modulo Cms  
- **Factory Mancanti**: 1
- **Stato**: ⚠️ BASSO
- ConfFactory

#### 6. Modulo Lang
- **Factory Mancanti**: 1
- **Stato**: ⚠️ BASSO
- PostFactory

#### 7. Modulo Notify
- **Factory Mancanti**: 1
- **Stato**: ⚠️ BASSO
- NotifyThemeableFactory

#### 8. Modulo Xot
- **Factory Mancanti**: 2
- **Stato**: ⚠️ MEDIO
- HealthCheckResultHistoryItemFactory
- ModuleFactory

### ✅ MODULI COMPLETI

- **Gdpr**: 4/4 factory ✅
- **Job**: 14/14 factory ✅
- **SaluteOra**: 16/16 factory ✅
- **SaluteMo**: 1/1 factory ✅
- **Tenant**: 1/1 factory ✅

## Impatto Sistemico

### Test Compromessi
- **CI/CD fallimentare** per moduli senza factory
- **Seeding impossibile** per dati demo
- **Test di integrazione** non eseguibili
- **Coverage insufficiente** per PHPStan

### Sviluppo Bloccato
- **Ambiente locale** non funzionante
- **Demo data** non generabili
- **Testing manuale** compromesso
- **Onboarding sviluppatori** impossibile

### Funzionalità Critiche Compromesse
- **Sistema geografico** (Address, Place) - CRITICO per SaluteOra
- **Sistema utenti** (Authentication, Teams) - CRITICO per tutto
- **Sistema media** (Upload file) - CRITICO per documenti medici

## Piano di Recupero

### Fase 1 - IMMEDIATA (Oggi)
1. ✅ **User**: AuthenticationFactory, MembershipFactory, TeamUserFactory
2. ✅ **Geo**: AddressFactory, PlaceFactory
3. **Media**: MediaFactory, TemporaryUploadFactory
4. **User**: Completare le 14 factory rimanenti

### Fase 2 - URGENTE (Questa settimana)
1. **Geo**: Completare le 6 factory rimanenti
2. **Activity**: SnapshotFactory, StoredEventFactory
3. **Xot**: HealthCheckResultHistoryItemFactory, ModuleFactory

### Fase 3 - IMPORTANTE (Prossima settimana)
1. **Cms**: ConfFactory
2. **Lang**: PostFactory  
3. **Notify**: NotifyThemeableFactory

## Checklist Globale

### Moduli Critici
- [ ] **User** - 17 factory mancanti (3/17 completate)
- [ ] **Geo** - 8 factory mancanti (2/8 completate)
- [ ] **Media** - 2 factory mancanti

### Moduli Medi
- [ ] **Activity** - 2 factory mancanti
- [ ] **Xot** - 2 factory mancanti

### Moduli Bassi
- [ ] **Cms** - 1 factory mancante
- [ ] **Lang** - 1 factory mancante
- [ ] **Notify** - 1 factory mancante

## Prevenzione Futura

### Automazione
1. **CI/CD Check**: Verificare factory per ogni model
2. **Pre-commit Hook**: Controllo factory mancanti
3. **PHPStan Rule**: Custom rule per factory obbligatorie

### Documentazione
1. **Regole Obbligatorie**: Factory per ogni model
2. **Template Factory**: Standard per nuove factory
3. **Checklist Modulo**: Verifica factory nella checklist modulo

### Monitoraggio
1. **Dashboard Factory**: Stato factory per modulo
2. **Alert Sistema**: Notifica factory mancanti
3. **Metriche Qualità**: Factory coverage per modulo

## Responsabilità

### Sviluppatori
- **MAI** creare un model senza factory
- **SEMPRE** testare la factory dopo creazione
- **DOCUMENTARE** ogni factory nel modulo

### Code Review
- **BLOCCARE** PR senza factory per nuovi model
- **RICHIEDERE** test per ogni factory
- **VERIFICARE** conformità agli standard

### Deployment
- **FALLIRE** deployment se factory mancanti
- **TESTARE** seeding in staging
- **VERIFICARE** demo data funzionanti

## Collegamenti

### Documentazione Moduli
- [User Factory Audit](../laravel/Modules/User/docs/missing-factories-audit.md)
- [Geo Factory Audit](../laravel/Modules/Geo/docs/missing-factories-audit.md)
- [Media Factory Issues](../laravel/Modules/Media/docs/)
- [Activity Factory Status](../laravel/Modules/Activity/docs/)

### Standard e Regole
- [Laravel Factory Best Practices](./laravel-factory-best-practices.md)
- [Testing Standards](./testing-standards.md)
- [PHPStan Factory Rules](./phpstan-factory-rules.md)

---

**⚠️ ERRORE GRAVISSIMO DA NON RIPETERE MAI PIÙ**

Ogni model DEVE avere la sua factory. Non è opzionale, è obbligatorio per:
- Testing corretto
- Seeding database  
- Demo data
- Sviluppo locale
- CI/CD funzionante
- Onboarding sviluppatori
- Qualità del codice

*Ultimo aggiornamento: 2025-01-06*
