<?php

declare(strict_types=1);

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Browser suite bootstrap
|--------------------------------------------------------------------------
|
| Pest's BootFiles bootstrapper only auto-includes the root tests/Pest.php, so this file is
| pulled in from there with require_once. Every browser test gets the Laravel TestCase, the
| same deterministic baseline as the other suites (freezeDeterministicState(), defined in the
| root bootstrap), and joins the `browser` group, which a bare run excludes. Inertia SSR is
| forced off for the whole test run via phpunit.xml.
|
*/

pest()->extend(TestCase::class)
    ->group('browser')
    ->beforeEach(function (): void {
        freezeDeterministicState($this);
    })
    ->in(__DIR__);
