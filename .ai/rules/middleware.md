---
paths:
  - 'app/Http/Middleware/**'
---

# Middleware

## `HandleInertiaRequests` is framework glue, not tested on its own

`HandleInertiaRequests` only overrides `Inertia\Middleware`'s `version()` and `share()`
hooks with trivial pass-throughs (`parent::version()`, `config('app.name')`,
`$request->user()`). It carries no business logic; that base class and its contract are the
Inertia package's responsibility. It is exempt from `general.md`'s "every Middleware gets its
own `tests/Unit/` test" rule and is instead exercised incidentally by `tests/Http/`. If
`share()` or `version()` ever grow real branching or app-specific logic, give it a dedicated
test at that point.

## Every other middleware gets its own `tests/Unit/Middleware/` test

Prove a middleware's behaviour in isolation via a throwaway route (see `tests.md`), not only
through a controller's flow test. A controller's `tests/Http/` test asserts the middleware
is wired (`toUseMiddleware()`), not that it behaves correctly.
