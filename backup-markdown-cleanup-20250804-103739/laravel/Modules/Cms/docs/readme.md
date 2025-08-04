# CMS Module

Content Management System for handling pages, menus, and frontend presentation.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Pages](#pages)
  - [Menus](#menus)
  - [Themes](#themes)
  - [Blocks](#blocks)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

## Overview
The CMS module provides a flexible content management system with support for multiple themes, page templates, and content blocks. It integrates with Filament for the admin interface and supports multi-language content.

## Features
- Page management with WYSIWYG editor
- Menu management
- Theme system
- Content blocks
- Multi-language support
- SEO tools
- Media library integration

## Installation
```bash
composer require modules/cms
```

Publish assets and run migrations:
```bash
php artisan vendor:publish --tag=cms-assets
php artisan migrate
```

## Configuration
Add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    Modules\Cms\Providers\CmsServiceProvider::class,
],
```

## Usage

### Pages
Create and manage content pages with the built-in editor. Pages support:
- Custom templates
- SEO metadata
- Scheduled publishing
- Versioning

### Menus
Easily create and manage navigation menus with drag-and-drop interface.

### Themes
Themes are stored in `Themes/` directory. Each theme can have its own:
- Templates
- Assets (CSS/JS)
- Partials
- Layouts

### Blocks
Reusable content blocks that can be placed on any page.

## API Reference
See [API Documentation](api.md) for detailed class and method references.

## Contributing
Please see [CONTRIBUTING.md](contributing.md) for details.

## License
This module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Adding Content

You can write your content using a [variety of file types](http://jigsaw.tighten.co/docs/content-other-file-types/). By default, this starter template expects your content to be located in the `source/docs` folder. If you change this, be sure to update the URL references in `navigation.php`.

The first section of each content page contains a YAML header that specifies how it should be rendered. The `title` attribute is used to dynamically generate HTML `title` and OpenGraph tags for each page. The `extends` attribute defines which parent Blade layout this content file will render with (e.g. `_layouts.documentation` will render with `source/_layouts/documentation.blade.php`), and the `section` attribute defines the Blade "section" that expects this content to be placed into it.

```yaml
---
title: Navigation
description: Building a navigation menu for your site
extends: _layouts.documentation
section: content
---
```

[Read more about Jigsaw layouts.](https://jigsaw.tighten.co/docs/content-blade/)

---

### Adding Assets

Any assets that need to be compiled (such as JavaScript, Less, or Sass files) can be added to the `source/_assets/` directory, and Laravel Mix will process them when running `npm run dev` or `npm run prod`. The processed assets will be stored in `/source/assets/build/` (note there is no underscore on this second `assets` directory).

Then, when Jigsaw builds your site, the entire `/source/assets/` directory containing your built files (and any other directories containing static assets, such as images or fonts, that you choose to store there) will be copied to the destination build folders (`build_local`, on your local machine).

Files that don't require processing (such as images and fonts) can be added directly to `/source/assets/`.

[Read more about compiling assets in Jigsaw using Laravel Mix.](http://jigsaw.tighten.co/docs/compiling-assets/)

---

## Building Your Site

Now that you’ve edited your configuration variables and know how to customize your styles and content, let’s build the site.

```bash
# build static files with Jigsaw
./vendor/bin/jigsaw build

# compile assets with Laravel Mix
# options: dev, prod
npm run dev
```

## Collegamenti tra versioni di readme.md
* [readme.md](laravel/Modules/Gdpr/docs/readme.md)
* [readme.md](laravel/Modules/UI/docs/readme.md)
* [readme.md](laravel/Modules/Lang/docs/readme.md)
* [readme.md](laravel/Modules/Activity/docs/readme.md)
* [readme.md](laravel/Modules/Cms/docs/readme.md)

