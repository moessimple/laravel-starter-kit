<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Controllers and Middleware
|--------------------------------------------------------------------------
|
| Controllers are single-action: __invoke() plus an optional __construct(),
| stricter than the laravel preset's full REST allowance. Nothing outside the
| routing layer references a controller class directly.
|
*/

arch('controllers stay single-action')
    ->expect('App\Http\Controllers')
    ->classes()
    ->not->toHavePublicMethodsBesides(['__construct', '__invoke']);

arch('controllers are only route targets, never referenced from other code')
    ->expect('App\Http\Controllers')
    ->not->toBeUsed();

arch('middleware handle the request')
    ->expect('App\Http\Middleware')
    ->toHaveMethod('handle');
