# Architecture Overview

## Module Structure

```
SaluteMo/
├── app/                    # Application code
│   ├── Filament/          # Filament admin panel components
│   │   ├── Pages/         # Custom Filament pages
│   │   ├── Resources/     # Resource classes
│   │   └── Widgets/       # Dashboard widgets
│   ├── Http/              # HTTP Controllers
│   └── Providers/         # Service Providers
│       └── Filament/      # Filament-specific service providers
├── config/                # Configuration files
├── database/              # Database migrations and seeders
├── docs/                  # Documentation
├── resources/             # Views and assets
├── routes/                # Route definitions
└── tests/                 # Tests
```

## Missing Directory Structure

The following directories are required for Filament integration but are currently missing:

1. `app/Filament/` - Core Filament components
   - `Pages/` - For custom Filament pages
   - `Resources/` - For Filament resource classes
   - `Widgets/` - For dashboard widgets

2. `app/Providers/Filament/` - Filament service providers
   - Should contain `SaluteMoPanelProvider.php`
   - Any other Filament-specific service providers

These directories should be created to maintain consistency with other modules and to properly organize Filament-related code.

## Core Components

### 1. API Layer
- RESTful endpoints for mobile clients
- Versioned API routes
- JSON:API specification compliant

### 2. Services
- `NotificationService`: Handles push notifications
- `SyncService`: Manages offline data synchronization
- `AuthService`: Handles mobile authentication

### 3. Models
- Extend base models from core modules
- Define mobile-specific relationships and scopes
- Implement API resources for consistent responses

### 4. Events & Listeners
- `UserLoggedIn`: Triggered on mobile login
- `AppointmentReminder`: For appointment notifications
- `DataSyncCompleted`: After successful data synchronization

## Data Flow

1. **Authentication**
   - Mobile app authenticates and receives token
   - Token is used for subsequent requests
   - Refresh tokens for session management

2. **Data Synchronization**
   - Client sends last sync timestamp
   - Server returns only changed records
   - Conflicts are resolved based on timestamp

3. **Push Notifications**
   - Server sends notifications via FCM/APNs
   - Clients acknowledge receipt
   - Failed deliveries are queued for retry

## Security Considerations

1. **Data in Transit**
   - Enforce HTTPS
   - Certificate pinning
   - TLS 1.2+ required

2. **Data at Rest**
   - Encrypt sensitive data
   - Secure storage for tokens
   - Secure key management

3. **Authentication**
   - OAuth 2.0 with PKCE
   - Short-lived access tokens
   - Secure refresh token rotation

## Performance Optimization

1. **API Responses**
   - Sparse fieldsets
   - Compound documents
   - Pagination

2. **Caching**
   - Response caching
   - ETag support
   - Conditional requests

3. **Assets**
   - CDN distribution
   - Asset versioning
   - Image optimization

## Error Handling

### Standard Error Format
```json
{
    "error": {
        "code": "validation_error",
        "message": "The given data was invalid.",
        "details": {
            "email": ["The email field is required."]
        }
    }
}
```

### Common Error Codes
- `400`: Bad Request
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `429`: Too Many Requests
- `500`: Internal Server Error

## Dependencies

### Required
- Laravel Framework
- Laravel Sanctum (API Auth)
- GuzzleHTTP (HTTP Client)

### Development
- PHPUnit (Testing)
- PHP_CodeSniffer (Coding Standards)
- PHPStan (Static Analysis)

## Upgrade Guide

### From v1 to v2
1. Update dependencies in `composer.json`
2. Run database migrations
3. Clear application cache
4. Update mobile app to new API version

## Contributing

1. Fork the repository
2. Create a feature branch
3. Write tests for your changes
4. Submit a pull request

## License

This module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
