<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Plain value enums
|--------------------------------------------------------------------------
|
| Enums stay plain domain nouns: they carry no behaviour, extend nothing and
| use no traits.
|
*/

arch('enums stay plain value types')
    ->expect('App\Enums')
    ->toBeEnums()
    ->toExtendNothing()
    ->toUseNothing();
