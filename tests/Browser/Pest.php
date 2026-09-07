<?php

declare(strict_types=1);

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Browser suite bootstrap
|--------------------------------------------------------------------------
|
| Pest's BootFiles bootstrapper only auto-includes the root tests/Pest.php, so this file is
| pulled in from there with require_once. Every browser test gets the Laravel TestCase (which
| already forces Inertia SSR off, see Tests\TestCase) and joins the `browser` group, which a
| bare run excludes.
|
*/

pest()->extend(TestCase::class)
    ->group('browser')
    ->in(__DIR__);
