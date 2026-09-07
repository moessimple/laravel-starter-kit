<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Finder\Finder;

/*
|--------------------------------------------------------------------------
| Baseline presets
|--------------------------------------------------------------------------
|
| php()/security() catch generic smells (debug output, eval, weak randomness).
| laravel() checks controller/request/middleware suffixes and model conventions;
| it allows __invoke-only controllers, so it fits a single-action controller style.
|
*/

arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();

arch('no class is final')
    ->expect('App')
    ->classes()
    ->not->toBeFinal();

arch('models extend the base Eloquent model')
    ->expect('App\Models')
    ->toExtend(Model::class);

/*
|--------------------------------------------------------------------------
| Mandatory isolated unit coverage
|--------------------------------------------------------------------------
|
| Every class under app/Actions, app/Support and app/Enums gets a unit test at the
| mirrored path under tests/Unit/. Controllers, requests and middleware are proven
| through tests/Http/ instead, so they are not scanned here. The folders may not
| exist yet in a fresh kit; the check activates as soon as they do.
|
*/

it('mirrors every business-logic class with its own unit test', function (): void {
    $root = dirname(__DIR__, 2);
    $missing = [];

    foreach (['Actions', 'Support', 'Enums'] as $folder) {
        $path = "{$root}/app/{$folder}";

        if (! is_dir($path)) {
            continue;
        }

        foreach (Finder::create()->files()->in($path)->name('*.php') as $file) {
            if (! preg_match('/^\s*(final\s+|readonly\s+|abstract\s+)*(class|enum|interface|trait)\s/m', $file->getContents())) {
                continue;
            }

            $testPath = "tests/Unit/{$folder}/".preg_replace('/\.php$/', 'Test.php', $file->getRelativePathname());

            if (! file_exists("{$root}/{$testPath}")) {
                $missing[] = $testPath;
            }
        }
    }

    expect($missing)->toBe([]);
});
