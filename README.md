# Laravel Sitemap Lite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/benbjurstrom/laravel-sitemap-lite.svg?style=flat-square)](https://packagist.org/packages/benbjurstrom/laravel-sitemap-lite)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A lightweight fork of [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap) designed for creating sitemaps manually without auto-discovery or crawling your site. The purpose of this fork is to lighten dependencies and code by removing the crawling functionality. If you need auto-discovery, please use the original package at [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap).

You can create your sitemap manually:

```php
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(Url::create('/home')
        ->setLastModificationDate(Carbon::yesterday())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
        ->setPriority(0.1))
   ->add(...)
   ->writeToFile($path);
```

You can also use one of your available filesystem disks to write the sitemap to:
```php
Sitemap::create()
    ->add(Url::create('/home'))
    ->writeToDisk('public', 'sitemap.xml');
```

You may need to set the file visibility on your sitemap. For example, if you are writing a sitemap to S3 that you want to be publicly available. You can set the third parameter to `true` to make it public:
```php
Sitemap::create()
    ->add(Url::create('/home'))
    ->writeToDisk('public', 'sitemap.xml', true);
```

You can also add your models directly by implementing the `\Spatie\Sitemap\Contracts\Sitemapable` interface:

```php
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable
{
    public function toSitemapTag(): Url | string | array
    {
        return Url::create(route('blog.post.show', $this))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1);
    }
}
```

Now you can add a single post model to the sitemap or even a whole collection:
```php
use Spatie\Sitemap\Sitemap;

Sitemap::create()
    ->add($post)
    ->add(Post::all());
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-sitemap.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-sitemap)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

First, install the package via composer:

``` bash
composer require benbjurstrom/laravel-sitemap-lite
```

The package will automatically register itself.

## Usage

### Adding alternates to links

Multilingual sites may have several alternate versions of the same page (one per language). Adding an alternate can be done as follows:

```php
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(
        Url::create('/extra-page')
            ->setPriority(0.5)
            ->addAlternate('/extra-pagina', 'nl')
    )
    ->writeToFile($sitemapPath);
```

Note the ```addAlternate``` function which takes an alternate URL and the locale it belongs to.

### Adding images to links

URLs can also have images. See also https://developers.google.com/search/docs/advanced/sitemaps/image-sitemaps

```php
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(
        Url::create('https://example.com')
            ->addImage('https://example.com/images/home.jpg', 'Home page image')
    )
    ->writeToFile($sitemapPath);
```

### Adding videos to links

As well as images, videos can be wrapped by URL tags. See https://developers.google.com/search/docs/crawling-indexing/sitemaps/video-sitemaps

You can set required attributes like so:

```php
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(
        Url::create('https://example.com')
            ->addVideo('https://example.com/images/thumbnail.jpg', 'Video title', 'Video Description', 'https://example.com/videos/source.mp4', 'https://example.com/video/123')
    )
    ->writeToFile($sitemapPath);
```

If you want to pass the optional parameters like `family_friendly`, `live`, or `platform`:

```php
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Tags\Video;

$options = ['family_friendly' => Video::OPTION_YES, 'live' => Video::OPTION_NO];
$allowOptions = ['platform' => Video::OPTION_PLATFORM_MOBILE];
$denyOptions = ['restriction' => 'CA'];

Sitemap::create()
    ->add(
        Url::create('https://example.com')
            ->addVideo('https://example.com/images/thumbnail.jpg', 'Video title', 'Video Description', 'https://example.com/videos/source.mp4', 'https://example.com/video/123', $options, $allowOptions, $denyOptions)
    )
    ->writeToFile($sitemapPath);
```

### Creating a sitemap index
You can create a sitemap index:
```php
use Spatie\Sitemap\SitemapIndex;

SitemapIndex::create()
    ->add('/pages_sitemap.xml')
    ->add('/posts_sitemap.xml')
    ->writeToFile($sitemapIndexPath);
```

You can pass a `Spatie\Sitemap\Tags\Sitemap` object to manually set the `lastModificationDate` property:

```php
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap;

SitemapIndex::create()
    ->add('/pages_sitemap.xml')
    ->add(Sitemap::create('/posts_sitemap.xml')
        ->setLastModificationDate(Carbon::yesterday()))
    ->writeToFile($sitemapIndexPath);
```

The generated sitemap index will look similar to this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <sitemap>
      <loc>http://www.example.com/pages_sitemap.xml</loc>
      <lastmod>2016-01-01T00:00:00+00:00</lastmod>
   </sitemap>
   <sitemap>
      <loc>http://www.example.com/posts_sitemap.xml</loc>
      <lastmod>2015-12-31T00:00:00+00:00</lastmod>
   </sitemap>
</sitemapindex>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)
- Fork maintained by [Ben Bjurstrom](https://github.com/benbjurstrom)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
