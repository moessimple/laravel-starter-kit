<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| App\ namespace ownership
|--------------------------------------------------------------------------
|
| laravel/pint is a Laravel Zero CLI tool that registers its own App\ PSR-4 directory
| (vendor/laravel/pint/app) into the shared autoloader, alongside this project's App\.
| Run non-parallel the duplicate is tolerated; under `pest --parallel` a worker can resolve
| an App\ class to the path-less vendor copy and crash. Nothing in the suite loads pint's
| App\ classes (it only ever runs as a subprocess), so pin App\ back to this project's app/
| for the whole test run, workers included.
|
*/

/** @var ClassLoader $loader */
$loader = require dirname(__DIR__).'/vendor/autoload.php';
$loader->setPsr4('App\\', [dirname(__DIR__).'/app']);

/*
|--------------------------------------------------------------------------
| Test Case and deterministic state
|--------------------------------------------------------------------------
|
| Every test starts from a known baseline: real random strings and UUIDs (undoing a fake a
| previous test forgot to reset), a hard failure on any unfaked outbound process (the twin of
| essentials' PreventStrayRequests), and frozen time so time-based assertions do not race the
| clock. Http tests additionally get LazilyRefreshDatabase, which only migrates when a test
| actually touches the database.
|
*/

pest()->extend(TestCase::class)
    ->beforeEach(function (): void {
        Str::createRandomStringsNormally();
        Str::createUuidsNormally();
        Process::preventStrayProcesses();

        $this->freezeTime();
    })
    ->in('Arch', 'Unit', 'Http');

pest()->use(LazilyRefreshDatabase::class)->in('Http');

// Pest's BootFiles bootstrapper only auto-includes this root file, never a nested one.
require_once __DIR__.'/Browser/Pest.php';

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', fn () => $this->toBe(1));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function something(): void
{
    // ..
}
