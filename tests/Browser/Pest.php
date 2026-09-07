<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Browser suite bootstrap
|--------------------------------------------------------------------------
|
| Pest's BootFiles bootstrapper only auto-includes the root tests/Pest.php, so this file is
| pulled in from there with require_once. Every browser test gets the Laravel TestCase (which
| already forces Inertia SSR off, see Tests\TestCase), the same deterministic baseline as the
| other suites, and joins the `browser` group, which a bare run excludes.
|
*/

pest()->extend(TestCase::class)
    ->group('browser')
    ->beforeEach(function (): void {
        Str::createRandomStringsNormally();
        Str::createUuidsNormally();
        Process::preventStrayProcesses();

        $this->freezeTime();
    })
    ->in(__DIR__);
