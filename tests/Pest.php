<?php

use Carbon\Carbon;
use Spatie\Sitemap\Test\TestCase;
use Spatie\TemporaryDirectory\TemporaryDirectory;

use function PHPUnit\Framework\assertXmlStringEqualsXmlString;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(TestCase::class)
    ->beforeEach(function () {
        $this->now = Carbon::create('2016', '1', '1', '0', '0', '0');

        Carbon::setTestNow($this->now);
    })
    ->in('.');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toEqualXmlString', function (string $expected_xml) {
    /** @var string */
    $value = $this->value;

    assertXmlStringEqualsXmlString($value, $expected_xml);

    return $this;
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function temporaryDirectory(): TemporaryDirectory
{
    return (new TemporaryDirectory)->force()->create();
}

register_shutdown_function(function () {
    $pidFile = __DIR__.'/.server-pid';

    if (file_exists($pidFile)) {
        $pid = (int) file_get_contents($pidFile);

        if ($pid > 0) {
            @exec("kill {$pid} 2>/dev/null");
        }

        @unlink($pidFile);
    }
});
