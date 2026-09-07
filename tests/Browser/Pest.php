<?php

declare(strict_types=1);

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Browser suite bootstrap
|--------------------------------------------------------------------------
|
| Pest's BootFiles bootstrapper only auto-includes the root tests/Pest.php, so this file is
| pulled in from there with require_once. Every browser test gets the Laravel TestCase, joins
| the `browser` group (excluded from a bare run) and renders against the built manifest with
| Inertia SSR off, so the Amp HTTP server never reaches for an SSR process.
|
*/

pest()->extend(TestCase::class)
    ->group('browser')
    ->beforeEach(function (): void {
        config(['inertia.ssr.enabled' => false]);
    })
    ->in(__DIR__);
