<?php

declare(strict_types=1);

use Illuminate\Contracts\Queue\ShouldQueue;

arch('jobs are queued and do their work in handle')
    ->expect('App\Jobs')
    ->toImplement(ShouldQueue::class)
    ->toExtendNothing()
    ->toHaveConstructor()
    ->toHaveMethod('handle');
