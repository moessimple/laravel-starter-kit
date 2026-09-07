---
paths:
  - 'tests/Browser/**'
---

# Browser

## `tests/Browser` is a wiring canary; every test in it must be robust

The browser suite proves the real controller -> Inertia -> Vue wiring and a handful of full
journeys. Vitest and Pest-unit stay the behaviour workhorse and keep 100% line and type
coverage on `app/`. A browser test earns its place only when no unit-level test can catch
the regression.

- Run it with `composer test:browser`. A bare `vendor/bin/pest tests/Browser` runs nothing:
  `phpunit.xml` excludes the `browser` group globally, and only the explicit `--group=browser`
  in `test:browser` opts back in.
- End every browser test with `->assertNoJavaScriptErrors()` (or `->assertNoSmoke()`).
- A browser test must be deterministic. Flakiness is a defect in the test, not a CI knob:
  the CI browser job runs with no `--retry`. Fix it or delete it the same day; never add a
  retry flag to paper over it.
- Synchronise on the auto-waiting assertions, never on `sleep()` or a fixed wait. To observe
  async browser-side state, install a spy with `script()` before the interaction and read it
  back with `assertScript()`, which is retried up to the suite timeout.
- Determinism lives in `tests/Browser/Pest.php`: the Laravel `TestCase`, the `browser` group,
  and Inertia SSR forced off. Keep new setup there, not in individual tests.
