<?php

declare(strict_types=1);

use Illuminate\Contracts\Validation\ValidationRule;

arch('validation rules implement the framework contract and nothing else')
    ->expect('App\Rules')
    ->toImplement(ValidationRule::class)
    ->toExtendNothing();
