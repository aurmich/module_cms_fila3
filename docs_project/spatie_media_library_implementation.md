# Spatie Media Library Integration Guide

This document outlines the implementation details and best practices for using Spatie Media Library in the SaluteOra module.

## 🚨 Critical Error Alert

**See**: [Array to String Conversion Error](./errori/array-to-string-conversion-patient-registration.md)

Il sistema di registrazione pazienti ha un errore critico dovuto a conflitto architetturale tra gestione attachments tramite colonne database vs Spatie Media Library.

## Overview

We've integrated Spatie Media Library for handling file uploads in the Patient module, specifically for:

- Health Card (Tessera Sanitaria)
- Identity Document (Documento di Identità)
- ISEE Certificate (Certificazione ISEE)
- Pregnancy Certificate (Certificato di Gravidanza)

## ⚠️ Known Issues

### Registration Action Conflict

**Problem**: The `RegisterAction` currently has a conflict between:
1. Database columns created for attachments (legacy approach)
2. Spatie Media Library collections (correct approach)

**Status**: 🚨 **BLOCKING** - Patient registration is currently broken

**Solution**: See [detailed error documentation](./errori/array-to-string-conversion-patient-registration.md#soluzioni-documentate)

## Implementation Details

### Patient Model

The Patient model has been updated to use the `HasMedia` trait and defines media collections for each document type.

**Important**: The `$fillable` property currently includes attachment fields that should be removed once the error is fixed.

```php
// Current (problematic) - includes attachment fields in fillable
protected $fillable = [
    'first_name',
    'last_name',
    // ...
    'health_card',              // 🚨 Should be removed
    'identity_document',        // 🚨 Should be removed
    'isee_certificate',         // 🚨 Should be removed  
    'pregnancy_certificate',    // 🚨 Should be removed
];

// Target (correct) - attachments handled by Media Library only
protected $fillable = [
    'first_name',
    'last_name',
    'date_of_birth',
    'gender',
    'address',
    'phone',
    'last_dental_visit',
    'dental_problems',
    // Attachment fields removed - handled by Media Library
];
```

### Collections

| Document Type | Collection Name | Required | File Types | Max Size | Status |
|--------------|----------------|----------|------------|----------|---------|
| Health Card | `health_card` | Yes | PDF, Images | 5MB | ⚠️ Conflicted |
| Identity Document | `identity_document` | Yes | PDF, Images | 5MB | ⚠️ Conflicted |
| ISEE Certificate | `isee_certificate` | No | PDF, Images | 5MB | ⚠️ Conflicted |
| Pregnancy Certificate | `pregnancy_certificate` | No | PDF, Images | 5MB | ⚠️ Conflicted |

### Configuration

All media is stored in the `private` disk by default. The following configuration is applied to all uploads:

- Preserve original filenames
- Allow downloading and previewing
- File type validation
- Size limit enforcement

## Usage in Forms

Example of document upload field implementation:

```php
Forms\Components\SpatieMediaLibraryFileUpload::make('health_card')
    ->collection('health_card')  // Use attachment name as collection
    ->downloadable()
    ->openable()
    ->preserveFilenames()
    ->acceptedFileTypes(['application/pdf', 'image/*'])
    ->maxSize(5120)
    ->required()
    ->columnSpanFull()
```

## ⚠️ Migration Conflict

The current migration creates database columns for attachments:

```php
// In 2025_04_01_000007_create_users_table.php (PROBLEMATIC)
foreach(Patient::$attachments as $attachment){
    if (! $this->hasColumn($attachment)) {
        $table->string($attachment)->nullable()->after('type');
    }
}
```

**This should be removed** once the Media Library implementation is complete.

## Best Practices

1. **Collections**: Always use descriptive collection names in snake_case
2. **Validation**: Validate file types and sizes at the form level
3. **Security**: Store sensitive documents in the private disk
4. **Performance**: Implement proper disk configuration for production
5. **Architecture**: 🚨 **NEVER mix database columns with Media Library for the same data**

## Action Integration

When implementing actions that handle attachments:

```php
// ✅ CORRECT: Filter attachment data from model data
public function execute(array $data): Patient
{
    $attachments = Patient::$attachments;
    $modelData = collect($data)->except($attachments)->toArray();
    $attachmentData = collect($data)->only($attachments)->toArray();
    
    // Create model without attachment data
    $patient = Patient::create($modelData);
    
    // Handle attachments separately
    foreach ($attachments as $attachment) {
        if (isset($attachmentData[$attachment])) {
            // Process attachment files...
        }
    }
}
```

```php
// ❌ WRONG: Pass all data including attachments to create()
public function execute(array $data): Patient
{
    // This will cause "Array to string conversion" error
    $patient = Patient::create($data);
}
```

## Related Documents

- 🚨 [Critical Error: Array to String Conversion](./errori/array-to-string-conversion-patient-registration.md)
- [Spatie Media Library Documentation](https://spatie.be/docs/laravel-medialibrary)
- [Filament Spatie Media Library Plugin](https://filamentphp.com/plugins/filament-spatie-media-library)
- [File Upload Security Guidelines](/docs/security/file-uploads.md)

## Roadmap

### Phase 1: Critical Fix (URGENT)
- [ ] Fix RegisterAction to filter attachment data
- [ ] Test patient registration functionality
- [ ] Update this documentation

### Phase 2: Architecture Cleanup
- [ ] Remove attachment columns from users table migration
- [ ] Remove attachment fields from Patient $fillable
- [ ] Migrate existing data to Media Library
- [ ] Update all related forms and actions

### Phase 3: Enhancement
- [ ] Implement proper file validation
- [ ] Add file preview functionality
- [ ] Implement secure file access

## Changelog

- **2025-06-26**: 🚨 **CRITICAL ERROR IDENTIFIED** - Array to string conversion in patient registration
- **2025-06-06**: Initial implementation of document uploads in Patient module
