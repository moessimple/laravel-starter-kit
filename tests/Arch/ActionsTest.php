<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
|
| Actions are Action-suffixed and expose exactly one entrypoint, execute(),
| so every caller sees the same shape.
|
*/

arch('actions are suffixed and expose only execute')
    ->expect('App\Actions')
    ->classes()
    ->toHaveSuffix('Action')
    ->not->toHavePublicMethodsBesides(['__construct', 'execute']);
