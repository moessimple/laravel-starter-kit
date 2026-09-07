---
paths:
  - '**/*'
  - composer.json
  - README.md
---

# General

## The quality bar

Green means: PHPStan at `level: max` with no baseline and no `ignoreErrors`, 100% type
coverage (`pest --type-coverage --min=100`), 100% line coverage (`pest --coverage
--exactly=100.0`), Pint and Rector reporting zero changes, ESLint and Prettier clean,
`vue-tsc` clean, Vitest at `lines: 100`, and the browser suite passing headless with no
`--retry`. Every one of these is a hard gate, in CI and locally. Do not lower a threshold,
add a suppression, create a baseline, or skip a test to reach green. If a gate cannot be
met honestly, stop and say so.

## Consistency beats personal style

Consistency of naming, structure, test style, mocking approach and route conventions is the
top quality bar, above cleverness or terseness. When a stylistic choice is ambiguous, check
how the nearest comparable case was already solved in this codebase (or a cited reference
project) before deciding; do not default to personal preference. Small deviations (a leading
slash on a route, `test()` vs `it()`, a name that leaks an internal collaborator) are worth
fixing, not "functionally identical, good enough".

## Full, isolated test coverage is mandatory

Every new or changed class under `app/Actions`, `app/Support`, `app/Enums` gets its own
isolated unit test proving its behaviour (see `tests.md`). A new or changed controller gets an
`tests/Http/` flow test instead. A new or changed Request or Middleware gets its own
`tests/Unit/` test. Every new or changed Vue component or JS module gets its own test. This
applies equally to PHP and JS, and includes plain enums, thin controllers and anything that
looks "too small to test". The only exception is pure framework-override glue with no
app-specific logic (e.g. `HandleInertiaRequests`, see `middleware.md`); do not invent any
other exception without flagging it first.

How to keep that coverage isolated and non-duplicated (mock a collaborator that already has
its own test, one behaviour per test, don't re-prove a lower layer) is in `tests.md` for PHP
and `js.md` for JS.

## No `final` classes anywhere

No class in `app/` is `final`. It blocks Mockery from creating a class double, which forces
awkward workarounds when a test needs to mock a class directly. Enforced by
`tests/ArchTest.php`. `readonly` classes and properties are fine.

## Don't keep single-implementation interfaces for mockability

Since classes aren't `final`, an interface with exactly one implementation and no second
caller has no reason to exist just to enable mocking. Mock the concrete class's own leaf
dependency instead. Check whether the class is even blocked from direct mocking before
adding an interface "for testability".

## Use `composer test` as the final verification gate

Before considering a change done, run `composer test`. It runs type coverage, unit tests,
lint, static analysis and the browser suite in one sequence and is less error-prone than
reassembling those commands by hand. This does not replace fast targeted
`php artisan test --compact --filter=X` runs while iterating; it is the gate before calling
the work finished.

## Themed `test:*` aliases span PHP and the frontend

`test:lint`, `test:types` and `test:unit` each run their theme's PHP checks and then the
matching `npm run <same>`. `test:type-coverage` is PHP-only. CI mirrors this one theme per
workflow: `lint.yml` = `test:lint` + `test:type-coverage`, `static.yml` = `test:types`,
`tests.yml` = `test:unit` plus the browser job.

## Dead-code sweeps: don't flag framework or starter-kit scaffolding

A file having no caller is not enough to call it dead if it ships as Laravel, Pest or
starter-kit scaffolding. Keep, even with zero references: `app/Http/Controllers/Controller.php`
(skeleton base controller), `tests/Pest.php`'s `toBeOne` expectation and `something()`
function (Pest `--init` scaffolding), and the auth baseline (`app/Models/User.php`,
`UserFactory`, `tests/Unit/Models/UserTest.php`, `config/auth.php`, the users-table
migration, the `auth.user` share in `HandleInertiaRequests`, `resources/js/types/auth.ts`),
even though there is no login route. Only propose removing code written for this app's own
logic that has lost its last caller.
