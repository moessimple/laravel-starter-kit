<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
|
| Every model extends the base Eloquent model. Every column ending in `_at`
| (besides the timestamps Eloquent casts by default) declares an explicit
| datetime cast, otherwise it silently comes back as a string.
|
*/

arch('models extend the base Eloquent model')
    ->expect('App\Models')
    ->toExtend(Model::class);

it('casts every _at column to a datetime', function (): void {
    foreach (glob(dirname(__DIR__, 2).'/app/Models/*.php') ?: [] as $file) {
        /** @var class-string<Model> $model */
        $model = 'App\Models\\'.basename($file, '.php');

        $instance = Factory::factoryForModel($model)->makeOne();

        $columns = collect($instance->getAttributes())
            ->keys()
            ->filter(fn (string $key): bool => str_ends_with($key, '_at'))
            ->reject(fn (string $key): bool => in_array($key, ['created_at', 'updated_at'], true));

        foreach ($columns as $key) {
            expect($instance->getCasts())->toHaveKey($key, 'datetime', "{$model}'s {$key} is not cast to datetime.");
        }
    }
});
