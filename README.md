# Laravel Starter Kit (Inertia & Vue)

[![tests](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml)
[![lint](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml)
[![static analysis](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml)

A blank [Laravel](https://laravel.com) skeleton for PHP 8.5 and Laravel 13, with the
quality and development workflow decided and enforced in CI from the first commit. Inertia
v3, Vue 3, TypeScript and Tailwind CSS 4 on the frontend. No auth, no UI kit, no example
code.

## Why This Starter Kit?

A new project is where the quality bar is cheapest to set and easiest to lose. This kit
sets it on an empty repository and enforces it in CI, so it cannot quietly decay as the
code grows.

- **PHPStan at `level: max`**: no baseline, no ignored errors. A type error fails a check
  instead of accumulating.
- **100% coverage, enforced**: the build fails below 100% line coverage on both sides, PHP
  (Pest) and frontend (Vitest), plus a 100% type-coverage gate on the PHP side.
- **Real-browser tests**: the app runs for real in headless Chromium as part of the normal
  test run.
- **Deterministic test baseline**: every test starts from the same fixed state, so a result
  never depends on the clock, the filesystem, the network, or the machine it runs on
  ([`tests/Pest.php`](tests/Pest.php)).
- **Auto-modernization**: Rector and a hardened Pint ruleset keep PHP on current idioms and
  one style; `vp fmt` / `vp lint` ([vite-plus](https://viteplus.dev)) and `vue-tsc` do the
  same for the frontend. `composer lint` applies all of it in place. One deliberate
  boundary: it never makes classes `final`, so they stay open to extension.
- **Vulnerable dependencies never install**:
  [`roave/security-advisories`](https://github.com/Roave/SecurityAdvisories) blocks any
  package with a known CVE, and npm install scripts are turned off.
- **Better Laravel defaults** via
  [Essentials](https://github.com/nunomaduro/essentials): strict models, automatic eager
  loading, immutable dates, prohibited destructive commands, forced HTTPS in production.
  Under these, a missing eager load or a mutated date fails a test instead of reaching
  production.
- **Typed routes**: [Wayfinder](https://github.com/laravel/wayfinder) generates TypeScript
  functions for every route and controller, regenerated on build.
- **Split CI**: `lint`, `static analysis` and `tests` are three separate checks, alongside
  weekly Dependabot, grouped by ecosystem with a 5-day cooldown on new releases.
- **AI-agent environment, wired in**: Laravel Boost's MCP server, a curated set of skills
  under [`.claude/skills/`](.claude/skills/), and project conventions in
  [`.ai/rules/`](.ai/rules/), so an agent picks up the house style on the first prompt.

Nothing above is documentation-only: it all runs on every push.

## Getting Started

> **Requires PHP 8.5+, Node 24+, and a code coverage driver like
> [Xdebug](https://xdebug.org/docs/install).**

Use the **Use this template** button on GitHub, or clone this repository, then:

```bash
composer setup
```

`composer setup` takes a fresh checkout to a running app: dependencies, `.env` and app key,
migrations, the headless Chromium the browser tests need, and a first frontend build.

### Dev Servers

```bash
composer dev
```

Starts the Laravel server, queue worker, log viewer and Vite dev server together. SSR runs
inside Vite in development, so there is no separate Node process to manage.

### Verify Installation

```bash
composer test
```

Runs the full gate in order: lint, type coverage, static analysis, unit tests, browser
tests. On a fresh checkout everything passes, at 100% line and type coverage.

### Daily Workflow

Add PHP under `app/` and pages under `resources/js/pages/`; business logic goes in
`app/Actions` (see [`.ai/rules/`](.ai/rules/)). Every runtime line needs test coverage, or
`composer test` fails. Before committing, run `composer lint` to apply Rector, Pint and the
frontend fixers in place.

## Available Tooling

### Development

- `composer dev`: Laravel server, queue worker, log viewer and Vite, together.

### Code Quality

- `composer lint`: Rector, Pint and `vp fmt` / `vp lint`, fixing in place.
- `composer test:lint`: the same checks read-only (Rector `--dry-run`, Pint `--test`,
  frontend in check mode).

### Testing

- `composer test:types`: PHPStan at `level: max`, then `vue-tsc`.
- `composer test:type-coverage`: fails under 100% type coverage (Pest).
- `composer test:unit`: Pest under a 100% line-coverage gate, then Vitest.
- `composer test:browser`: the headless-Chromium suite.
- `composer test`: the full gate, in order.

### Maintenance

- `composer update:dependencies`: bumps Composer and npm packages within their version
  constraints.

## Credits

Structure and tooling choices are adapted from
**[Nuno Maduro](https://github.com/nunomaduro)**'s
[laravel-starter-kit-inertia-vue](https://github.com/nunomaduro/laravel-starter-kit-inertia-vue).

## License

Released under the [MIT License](LICENSE).
