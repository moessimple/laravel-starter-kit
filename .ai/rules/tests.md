---
paths:
  - 'tests/**'
  - 'tests/Arch/**'
---

# Tests

## Suites: Arch / Unit / Http / Browser

- `tests/Arch/` holds the arch presets and project-wide structural rules.
- `tests/Http/` holds controller tests only, flat. They prove a public endpoint: routing,
  controller wiring (right FormRequest / Middleware / collaborator used), and response
  shaping.
- Everything else (Actions, Support classes, Enums, FormRequests, Middleware) is not a
  public endpoint and belongs under `tests/Unit/` in a folder named after the component type
  (`tests/Unit/Requests`, `tests/Unit/Middleware`, `tests/Unit/Support`, `tests/Unit/Actions`,
  `tests/Unit/Enums`, `tests/Unit/Models`), not mirroring the full `App\Http\` namespace
  depth. The Unit test carries the component's full behaviour matrix, even when proving it
  needs a real request cycle (a FormRequest via `createFormRequest()`, a Middleware via a
  throwaway route). The mechanism used to invoke a component does not decide which folder its
  test lives in; only whether the component is itself a public endpoint does.
- `tests/Browser/` is the wiring canary (see `browser.md`).

## `it()`, not `test()`; one behaviour per test

Reads more naturally ("it renders the page"). Applies to every test. A test proving a mocked
collaborator was used and a test proving the actual response are two different claims; do not
blend them into one test whose name only covers half.

## Every public method gets its own isolated test

Coverage is measured per public method, not per "is it called by something today". If a
class declares a public method, it gets a test proving that method's behaviour in isolation,
whether or not a current caller exercises it.

## Mock only collaborators that already have their own test

Once a class has its own complete test, mock it in callers' tests instead of re-proving its
behaviour. A caller's test proves only its own responsibility: delegation, wiring, its own
transformation. Split delegation wiring (strict `->once()->with(...)`, assert nothing about
the response) from response shaping (loose `->andReturn(...)`, assert status and body) into
separate tests. Skip the split only when there is no separate collaborator to mock.

## Name tests with plain words

Prefer "uses" over "delegates"; the plainest accurate verb over pattern jargon
(orchestration, composition, ...).

## Custom expectations for wiring proofs

`tests/Pest.php` may define `expect($class)->toUseType($type)` /
`->toUseFormRequest($type)` / `->toUseMiddleware($middleware)`: reflection- and
router-based checks that a dependency is wired, with no instantiation or mocking. Use them
when a test only needs to prove wiring. Pair with a behaviour-level test when the actual
usage also needs proving.

## FormRequest validation: `rules()` array first, `createFormRequest()` for edges

A plain `expect((new XRequest)->rules())->toEqual([...])` check pins the declared contract
and is usually enough. Reach for `createFormRequest($requestClass, $payload)` (posts to a
throwaway route, returns a real `TestResponse`) only when the array check cannot secure a
specific edge: a regex/format rule, conditional or cross-field rules, a custom Rule object,
or `authorize()` / `prepareForValidation()` logic. Never use
`Validator::make($data, (new XRequest)->rules())`; it bypasses the FormRequest and silently
stops proving anything once the request gains `authorize()` or `prepareForValidation()`.
This coverage lives in the FormRequest's own test, not the controller test.

## Load-bearing for `pest --parallel`

`test:unit` runs `pest --parallel`. `tests/Pest.php` resets the `App\` PSR-4 map to `app/`
only, because `laravel/pint` (a Laravel Zero CLI tool) also registers `App\` into the shared
autoloader, and a `--parallel` worker can resolve an `App\` class to the path-less vendor
copy and crash the arch preset. The line is commented at its site; do not remove it.

## Inertia SSR is disabled for the browser suite

`config('inertia.ssr.enabled')` is `true` in config. `tests/Browser/Pest.php` forces it off
per test so the Amp HTTP server never reaches for an SSR process (which `PreventStrayRequests`
would fail). Do not drop that override.
