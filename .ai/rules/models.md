---
paths:
  - 'app/Models/**'
---

# Models

## Every `*_at` column needs an explicit datetime cast

Any attribute ending in `_at` beyond the `created_at` / `updated_at` timestamps Eloquent
casts by default must declare an explicit `'datetime'` cast in `casts()`, otherwise it comes
back as a plain string.

## Models carry a `@property` block and a `@use HasFactory<...>` generic

The class docblock lists every column as `@property`, and the `HasFactory` trait use carries
its factory generic (`/** @use HasFactory<UserFactory> */`). Both are load-bearing for
larastan at `level: max` and for type coverage; do not let Rector or Pint strip them.

## Strict models are on

`nunomaduro/essentials` enables `Model::shouldBeStrict()`: lazy loading, silently discarding
attributes and accessing missing attributes all throw. Write code and factories that set
only real columns, and eager-load relations you traverse.
