<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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
| Test Case
|--------------------------------------------------------------------------
|
| Bind the Laravel TestCase to every suite that boots the framework. Http tests additionally
| get LazilyRefreshDatabase, which only migrates when a test actually touches the database.
|
*/

pest()->extend(TestCase::class)->in('Arch', 'Unit');
pest()->extend(TestCase::class)->use(LazilyRefreshDatabase::class)->in('Http');

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
