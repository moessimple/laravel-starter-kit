<?php

declare(strict_types=1);

use Illuminate\Notifications\Notification;

arch('notifications extend the framework base and take their payload in the constructor')
    ->expect('App\Notifications')
    ->toExtend(Notification::class)
    ->toHaveConstructor();
