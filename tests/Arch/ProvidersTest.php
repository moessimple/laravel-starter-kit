<?php

declare(strict_types=1);

use Illuminate\Support\ServiceProvider;

arch('service providers extend the framework base and are never referenced from code')
    ->expect('App\Providers')
    ->toExtend(ServiceProvider::class)
    ->not->toBeUsed();
