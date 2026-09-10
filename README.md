# Laravel Starter Kit (Inertia & Vue)

[![tests](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml)
[![lint](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml)
[![static analysis](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml)

A blank [Laravel](https://laravel.com) skeleton for PHP 8.5 and Laravel 13, with the whole
quality and development workflow already decided and enforced from the first commit. Inertia
v3, Vue 3, TypeScript and Tailwind CSS 4 on the frontend; a full test gate, automatic code
modernization, supply-chain hardening and a ready-to-use AI-agent setup behind it. No auth,
no UI kit, no example code.

## Why This Starter Kit?

A new project is where the quality bar is cheapest to set and easiest to lose. This kit
sets it on an empty repository and enforces it in CI, so it cannot quietly decay as the
code grows.

- **PHPStan at `level: max`**: no baseline, no ignored errors. A type error fails a check
  instead of accumulating.
- **100% coverage, enforced**: PHP (Pest, `--exactly=100.0`) and the frontend (Vitest)
  both fail the build below 100% line coverage, and Pest enforces 100% type coverage on
  top.
- **Real-browser tests**: `pest-plugin-browser` runs the app in headless Chromium,
  in-process through the same container and database transaction as the test, with no
  `--retry`.
- **Deterministic test baseline**: every test starts with frozen time, a faked filesystem,
  no stray processes or HTTP requests, and a lazily-migrated database
  ([`tests/Pest.php`](tests/Pest.php)).
- **Auto-modernization**: Rector (all Laravel and quality sets) and a hardened Pint ruleset
  rewrite PHP to current idioms; `vp fmt` and `vp lint`
  ([vite-plus](https://viteplus.dev)) do the same for the frontend, with `vue-tsc` for
  types. One deliberate limit: neither adds `final`, and Rector marks properties
  `readonly` but never whole classes, so the kit's classes stay open to extension.
- **Vulnerable dependencies never install**:
  [`roave/security-advisories`](https://github.com/Roave/SecurityAdvisories) blocks any
  package with a known CVE, and npm lifecycle scripts are disabled.
- **Better Laravel defaults** via
  [Essentials](https://github.com/nunomaduro/essentials): strict models, automatic eager
  loading, immutable dates, prohibited destructive commands, forced HTTPS in production.
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

`composer setup` installs the Composer and npm dependencies, creates `.env`, generates the
app key, runs the migrations, installs the headless Chromium the browser suite needs, and
builds the frontend.

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

### How You Work In It

Add PHP under `app/` and pages under `resources/js/pages/`; business logic goes in
`app/Actions` (see [`.ai/rules/`](.ai/rules/)). Every runtime line needs test coverage, or
`composer test` fails. Before committing, run `composer lint` to apply Rector, Pint and the
frontend fixers in place.

## Available Tooling

### Development

- `composer dev` — Laravel server, queue worker, log viewer and Vite, together.

### Code Quality

- `composer lint` — Rector, Pint and `vp fmt` / `vp lint`, fixing in place.
- `composer test:lint` — the same checks read-only (Rector `--dry-run`, Pint `--test`,
  frontend in check mode).

### Testing

- `composer test:types` — PHPStan at `level: max`, then `vue-tsc`.
- `composer test:type-coverage` — fails under 100% type coverage (Pest).
- `composer test:unit` — Pest under a 100% line-coverage gate, then Vitest.
- `composer test:browser` — the headless-Chromium suite.
- `composer test` — the full gate, in order.

### Maintenance

- `composer update:dependencies` — bumps Composer and npm packages within their version
  constraints.

## Credits

Structure and tooling choices are adapted from
**[Nuno Maduro](https://github.com/nunomaduro)**'s
[laravel-starter-kit-inertia-vue](https://github.com/nunomaduro/laravel-starter-kit-inertia-vue).

## License

Released under the [MIT License](LICENSE).
