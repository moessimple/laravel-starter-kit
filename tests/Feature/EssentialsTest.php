<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

it('returns immutable dates from the date helpers', function (): void {
    expect(now())->toBeInstanceOf(CarbonImmutable::class)
        ->and(today())->toBeInstanceOf(CarbonImmutable::class);
});

it('puts Eloquent models in strict mode', function (): void {
    expect(Model::preventsLazyLoading())->toBeTrue()
        ->and(Model::preventsSilentlyDiscardingAttributes())->toBeTrue()
        ->and(Model::preventsAccessingMissingAttributes())->toBeTrue();
});
