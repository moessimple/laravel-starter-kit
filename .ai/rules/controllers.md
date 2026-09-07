---
paths:
  - 'app/Http/Controllers/**'
---

# Controllers

## Inject dependencies via `__invoke()`, not the constructor

Write controllers as single-action invokable classes (`__invoke()` only). A constructor
property only earns its place if state is shared across multiple methods, which never
happens in a single-action class, so it is pure overhead. Inject dependencies (queries,
services) directly as `__invoke()` parameters, the same way route params and FormRequests
already are; the container resolves them identically. Order: FormRequest first (if any),
then service dependencies, then route params last.

## JSON responses: no Resources for trivial shapes, failures via `abort()`

For a small payload, return `response()->json(...)` directly. A mutation endpoint with
nothing to return responds with `response()->noContent()` (204). A domain-level failure
(missing or conflicting resource) uses `abort()` / `abort_if()` / `abort_unless()` with the
matching status code and a message, not a hand-built `['ok' => false, ...]` body. This keeps
the failure shape (`{"message": "..."}`) consistent with Laravel's validation-error
responses. Because `APP_DEBUG=true` locally adds `exception`/`file`/`line`/`trace` to the
body, assert `assertJsonPath('message', '...')`, not `assertExactJson()`.

Reach for an Eloquent API Resource once a payload has real shape, relations or versioning
concerns.

## Use `Response::HTTP_*` constants in `abort()`, not bare status codes

Pass `Response::HTTP_NOT_FOUND`, `Response::HTTP_CONFLICT`, etc., not `404` / `409`. A
controller returning `Illuminate\Http\Response` already has the constants in scope via that
class; one returning `Inertia\Response` imports
`Symfony\Component\HttpFoundation\Response as HttpResponse` and uses `HttpResponse::HTTP_*`.
