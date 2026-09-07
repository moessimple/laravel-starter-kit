---
paths:
  - 'routes/**'
---

# Routes

## Frontend calls routes through Wayfinder, not `route()`

Frontend code references backend routes and controllers through Wayfinder's generated
functions (`@/actions/...`, `@/routes/...`), not hardcoded URLs or `route()`. Run
`php artisan wayfinder:generate --with-form` after adding or changing a route or controller
so the generated TypeScript stays in sync. A route still needs `->name(...)` for Wayfinder's
named-route helpers.

## Avoid the `Route::inertia()` macro

Larastan cannot resolve its return type (it resolves to `mixed`), which forces a
`phpstan.neon` ignore for any chained call. Use
`Route::get($uri, fn () => Inertia::render($component))->name(...)` instead; it is fully
typed and Wayfinder-compatible.

## No leading slash on route paths

Write `Route::get('dashboard', ...)`, not `Route::get('/dashboard', ...)`. Functionally
identical; only the bare root route is `/`.
