<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;

it('returns immutable dates that do not mutate in place', function (): void {
    $now = now();
    $later = $now->addDay();

    expect($now->equalTo($later))->toBeFalse();
});

it('puts Eloquent models in strict mode', function (): void {
    expect(Model::preventsLazyLoading())->toBeTrue()
        ->and(Model::preventsSilentlyDiscardingAttributes())->toBeTrue()
        ->and(Model::preventsAccessingMissingAttributes())->toBeTrue();
});
