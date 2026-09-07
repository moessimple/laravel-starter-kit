<?php

declare(strict_types=1);

use Illuminate\Console\Command;

/*
|--------------------------------------------------------------------------
| Console commands
|--------------------------------------------------------------------------
|
| Commands are Command-suffixed, extend the framework base command, do their
| work in handle(), and are never referenced from other code (the scheduler
| and the CLI resolve them by name).
|
*/

arch('commands are shaped like framework commands')
    ->expect('App\Console\Commands')
    ->toExtend(Command::class)
    ->toHaveSuffix('Command')
    ->toHaveMethod('handle')
    ->not->toBeUsed();
