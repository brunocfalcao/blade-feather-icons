<?php

declare(strict_types=1);

use BladeUI\Icons\BladeIconsServiceProvider;
use Brunocfalcao\BladeFeatherIcons\BladeFeatherIconsServiceProvider;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function (): void {
    expect($this->value)->toBe(1);
});
