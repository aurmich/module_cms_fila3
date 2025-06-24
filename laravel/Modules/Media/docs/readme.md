# Media Module

File and media management system for handling uploads, storage, and delivery.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [File Uploads](#file-uploads)
  - [Image Processing](#image-processing)
  - [Media Library](#media-library)
  - [File Types](#file-types)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

## Overview
The Media module provides a comprehensive solution for handling file uploads, storage, and delivery. It includes features for image manipulation, file organization, and CDN integration.

## Features
- File upload and management
- Image processing (resize, crop, optimize)
- Multiple storage disk support (local, S3, etc.)
- Responsive image generation
- File type validation
- File organization with collections
- CDN support
- File access control

## Installation
```bash
composer require modules/media
```

Publish assets and run migrations:
```bash
php artisan vendor:publish --tag=media-assets
php artisan migrate
```

## Configuration
Add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    Modules\Media\Providers\MediaServiceProvider::class,
],
```

## Usage

### File Uploads
Handle file uploads with validation and automatic processing:

```php
use Modules\Media\Facades\MediaUploader;

$media = MediaUploader::fromSource($request->file('file'))
    ->toDestination('public', 'uploads')
    ->upload();
```

### Image Processing
Process images with various manipulations:

```php
$thumbnail = Media::find(1)->getUrl('thumb'); // Predefined conversion

// Or create on-the-fly
$image = Media::find(1);
$converted = $image->manipulate(['width' => 300, 'height' => 200]);
```

### Media Library
Organize files with collections:

```php
// Add to collection
$media->addToCollection('featured-images');

// Get collection items
$collection = Media::inCollection('featured-images')->get();
```

### File Types
Supported file types include:
- Images (jpg, png, gif, webp, svg)
- Documents (pdf, doc, docx, xls, xlsx, etc.)
- Archives (zip, rar, tar.gz)
- Audio/Video (mp3, mp4, mov, etc.)

## API Reference
See [API Documentation](api.md) for detailed class and method references.

## Contributing
Please see [CONTRIBUTING.md](contributing.md) for details.

## License
This module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
