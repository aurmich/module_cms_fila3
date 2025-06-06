# Spatie Media Library Integration Guide

This document outlines the implementation details and best practices for using Spatie Media Library in the SaluteOra module.

## Overview

We've integrated Spatie Media Library for handling file uploads in the Patient module, specifically for:

- Health Card (Tessera Sanitaria)
- Identity Document (Documento di Identità)
- ISEE Certificate (Certificazione ISEE)
- Pregnancy Certificate (Certificato di Gravidanza)

## Implementation Details

### Patient Model

The Patient model has been updated to use the `HasMedia` trait and defines media collections for each document type.

### Collections

| Document Type | Collection Name | Required | File Types | Max Size |
|--------------|----------------|----------|------------|----------|
| Health Card | `tessera_sanitaria` | Yes | PDF, Images | 5MB |
| Identity Document | `documento_identita` | Yes | PDF, Images | 5MB |
| ISEE Certificate | `certificazione_isee` | No | PDF, Images | 5MB |
| Pregnancy Certificate | `certificato_gravidanza` | No | PDF, Images | 5MB |

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
    ->collection('tessera_sanitaria')
    ->downloadable()
    ->openable()
    ->preserveFilenames()
    ->acceptedFileTypes(['application/pdf', 'image/*'])
    ->maxSize(5120)
    ->required()
    ->columnSpanFull()
```

## Best Practices

1. **Collections**: Always use descriptive collection names in snake_case
2. **Validation**: Validate file types and sizes at the form level
3. **Security**: Store sensitive documents in the private disk
4. **Performance**: Implement proper disk configuration for production

## Related Documents

- [Spatie Media Library Documentation](https://spatie.be/docs/laravel-medialibrary)
- [Filament Spatie Media Library Plugin](https://filamentphp.com/plugins/filament-spatie-media-library)
- [File Upload Security Guidelines](/docs/security/file-uploads.md)

## Changelog

- **2025-06-06**: Initial implementation of document uploads in Patient module
