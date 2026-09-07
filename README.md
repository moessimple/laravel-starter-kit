# Laravel Starter Kit (Inertia & Vue)

A blank [Laravel](https://laravel.com) + [Inertia](https://inertiajs.com) + Vue 3 skeleton
with a strict, non-negotiable quality gate wired in from the first commit. No auth, no UI
kit, nothing to delete. Just the toolchain, configured and enforced.

## Why This Starter Kit?

- **PHPStan at `level: max`**, no baseline, no `ignoreErrors`.
- **100% type coverage** and **100% line coverage**, enforced for PHP (Pest) and the
  frontend (Vitest). Every runtime file ships with the test that covers it.
- **Rector** and a **hardened Pint ruleset** keep the PHP style and modern syntax honest.
- **ESLint 9 (flat) + Prettier** for the frontend, with `vue-tsc` type checking.
- **Real-browser tests** via `pest-plugin-browser` and headless Chromium, run with no
  `--retry`.
- **Better Laravel defaults** through [Essentials](https://github.com/nunomaduro/essentials):
  strict models, automatic eager loading, immutable dates, safe console, and more.
- **Split CI**: `lint`, `static analysis` and `tests` are three separate red checks.
- **Agent rules** in `.ai/rules/` so humans and AI agents inherit the conventions.

## Getting Started

> Requires **PHP 8.5+**, **Node 22+**, and a code coverage driver
> ([Xdebug](https://xdebug.org/docs/install) or
> [PCOV](https://github.com/krakjoe/pcov)) for the `composer test:unit` gate.

### Initial Setup

```bash
composer setup
```

This installs dependencies, creates `.env`, generates the app key, migrates, and builds the
frontend.

Start the dev processes (server, queue, logs, Vite):

```bash
composer dev
```

### Optional: Browser Testing Setup

The browser suite needs Chromium:

```bash
npx playwright install chromium
```

### Verify Installation

```bash
composer test
```

You should see 100% type coverage, 100% line coverage, and every check passing.

## Available Tooling

### Development

- `composer dev` starts the Laravel server, queue worker, log monitor and Vite dev server
  together.

### Code Quality

- `composer lint` runs Rector, Pint and the frontend formatter, fixing in place.
- `composer test:lint` is the read-only check: Pint `--test`, Rector `--dry-run`, Prettier
  `--check` and ESLint.

### Testing

- `composer test:types` runs PHPStan at `level: max` and `vue-tsc`.
- `composer test:type-coverage` enforces 100% type coverage with Pest.
- `composer test:unit` runs the Pest suite under a 100% line-coverage gate, then Vitest.
- `composer test:browser` runs the headless-Chromium suite.
- `composer test` runs the full gate in order.

### Maintenance

- `composer update:requirements` bumps Composer and npm dependencies to their latest
  versions.

## License

Released under the [MIT license](https://opensource.org/licenses/MIT).
