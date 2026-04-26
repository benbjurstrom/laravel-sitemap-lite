---
title: Installation & setup
weight: 2
---

You can install the package via composer:

```bash
composer require benbjurstrom/laravel-sitemap-lite
```

The package will automatically register itself.

## Publishing the config file

Optionally, you can publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Sitemap\SitemapServiceProvider" --tag=sitemap-config
```

This will copy the default config to `config/sitemap.php` where you can edit it.

```php
return [
    //
];
```
