---
title: Scheduled generation
weight: 1
---

Your site will probably be updated from time to time. In order to let your sitemap reflect these changes, you can rebuild it periodically. The easiest way of doing this is to make use of Laravel's default scheduling capabilities.

You could set up an artisan command much like this one:

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        Sitemap::create()
            ->add(route('home'))
            ->writeToFile(public_path('sitemap.xml'));
    }
}
```

That command should then be scheduled in `routes/console.php`:

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('sitemap:generate')->daily();
```
