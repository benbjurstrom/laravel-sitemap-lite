---
title: Introduction
weight: 1
---

Laravel Sitemap Lite creates sitemaps from URLs and tag objects you provide in code.

```php
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Sitemap::create()
    ->add(Url::create('/home')
        ->setLastModificationDate(Carbon::yesterday()))
    ->add('/contact')
    ->writeToFile($path);
```

You can also add your models directly by implementing the `Sitemapable` interface.

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

Now you can add a single post model to the sitemap or even a whole collection.

```php
use Spatie\Sitemap\Sitemap;

Sitemap::create()
    ->add($post)
    ->add(Post::all());
```
