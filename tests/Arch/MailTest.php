<?php

declare(strict_types=1);

use Illuminate\Mail\Mailable;

arch('mailables extend the framework base and take their payload in the constructor')
    ->expect('App\Mail')
    ->toExtend(Mailable::class)
    ->toHaveConstructor();
