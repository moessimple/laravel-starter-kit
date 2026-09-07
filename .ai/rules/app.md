---
paths:
  - 'app/**'
---

# App

## Flat per type, no area subfolders

Business classes are not grouped into a domain-area subfolder: `App\Actions\PublishPost`,
not `App\Actions\Posts\PublishPost`. Each type folder (`Actions`, `Http/Controllers`,
`Http/Requests`, `Http/Middleware`) stays flat as long as it is easy to scan at a glance.
Reintroduce area subfolders for a type folder only once it grows too large or spans too many
areas to scan flat.

## Suffix classes by build type

Suffix by type: `Action`, `Controller`, `Query`, `Request`, `Resource`, `Job`. Models,
Enums and Middleware are the exception, no suffix: a plain domain noun (`Post`, not
`PostModel`; `EnsureRequestIsLocal`, not `EnsureRequestIsLocalMiddleware`), matching
Laravel's own middleware naming and the `pest-plugin-laravel` arch preset.

## Every Action / Support / Enum class needs a 1:1 mirrored unit test

Each class in `app/Actions`, `app/Support`, `app/Enums` gets a matching test at the same
relative path under `tests/Unit/` (`app/Actions/PublishPost.php` mirrors
`tests/Unit/Actions/PublishPostTest.php`). Mandatory, enforced by `tests/Arch/ArchTest.php`.

Controllers do not get this mandatory mirror: they are proven through `tests/Http/` flow
tests (see `tests.md`). Requests and Middleware are not scanned by the arch check either,
but each still gets its own `tests/Unit/` file in practice, with the documented glue
exception for pure framework overrides (see `middleware.md`).

The mirrored file only guarantees the class is not forgotten. `tests.md`'s "every public
method gets its own isolated test" is what closes the coverage gap.
