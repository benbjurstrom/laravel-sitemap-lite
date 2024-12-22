<?php

use Carbon\Carbon;
use function PHPUnit\Framework\assertXmlStringEqualsXmlString;
use Spatie\TemporaryDirectory\TemporaryDirectory;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(\Spatie\Sitemap\Test\TestCase::class)
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
    return (new TemporaryDirectory())->force()->create();
}
