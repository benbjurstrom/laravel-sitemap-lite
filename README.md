# Laravel Sitemap Lite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/laravel-sitemap-lite.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/laravel-sitemap-lite)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A lightweight fork of [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap) for creating sitemaps programmatically without crawling or auto-discovery. If you need site crawling, use the original package.

```bash
composer require benbjurstrom/laravel-sitemap-lite
```

## Usage

```php
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(
        Url::create('/home')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.8)
    )
    ->add('/contact')
    ->sort()
    ->writeToFile(public_path('sitemap.xml'));
```

You can add models by implementing the `Sitemapable` interface.

```php
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable
{
    public function toSitemapTag(): Url|string|array
    {
        return route('blog.post.show', $this);
    }
}
```

## Sitemap Indexes

```php
use Spatie\Sitemap\SitemapIndex;

SitemapIndex::create()
    ->add('/post-sitemap.xml')
    ->add('/page-sitemap.xml')
    ->writeToFile(public_path('sitemap-index.xml'));
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
