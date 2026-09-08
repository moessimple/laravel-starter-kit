# Laravel Starter Kit (Inertia & Vue)

[![tests](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/tests.yml)
[![lint](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/lint.yml)
[![static analysis](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml/badge.svg)](https://github.com/moessimple/laravel-starter-kit/actions/workflows/static.yml)

A blank [Laravel](https://laravel.com) + [Inertia](https://inertiajs.com) + Vue 3 skeleton
with a strict, non-negotiable quality gate wired in from the first commit. No auth, no UI
kit, nothing to delete. Just the toolchain, configured and enforced.

## Why This Starter Kit?

- **PHPStan at `level: max`**, no baseline, no `ignoreErrors`.
- **100% line coverage**, enforced for PHP (Pest) and the frontend (Vitest, on every
  coverage metric). **100% type coverage** on top, via Pest's type-coverage plugin. Every
  runtime file ships with the test that covers it.
- **[`roave/security-advisories`](https://github.com/Roave/SecurityAdvisories)** refuses to
  install dependencies with known vulnerabilities.
- **Rector** and a **hardened Pint ruleset** keep the PHP style and modern syntax honest.
- **`vp lint` + `vp fmt`** (vite-plus) for the frontend, with `vue-tsc` type checking.
- **Real-browser tests** via `pest-plugin-browser` and headless Chromium, run with no
  `--retry`.
- **Better Laravel defaults** through [Essentials](https://github.com/nunomaduro/essentials):
  strict models, automatic eager loading, immutable dates, safe console, and more.
- **Split CI**: `lint`, `static analysis` and `tests` are three separate red checks.
- **Agent rules** in `.ai/rules/` so humans and AI agents inherit the conventions.

## Getting Started

Requires **PHP 8.5+**, **Node 24+**, and a code coverage driver like [Xdebug](https://xdebug.org/docs/install).

### Install

```bash
git clone https://github.com/moessimple/laravel-starter-kit.git
cd laravel-starter-kit
composer setup
```

`composer setup` installs the Composer and npm dependencies, creates `.env`, generates the
app key, runs the migrations, builds the frontend, and installs the headless Chromium the
browser suite needs.

### Dev Servers

```bash
composer dev
```

Starts the Laravel server, queue worker, log monitor and Vite dev server together.

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

- `composer lint` runs Rector, Pint and the vite-plus formatter and linter, fixing in place.
- `composer test:lint` is the read-only check: Pint `--test`, Rector `--dry-run`, and the
  frontend formatter and linter in check mode.

### Testing

- `composer test:types` runs PHPStan at `level: max` and `vue-tsc`.
- `composer test:type-coverage` enforces 100% type coverage with Pest.
- `composer test:unit` runs the Pest suite under a 100% line-coverage gate, then Vitest.
- `composer test:browser` runs the headless-Chromium suite.
- `composer test` runs the full gate in order.

### Maintenance

- `composer update:dependencies` bumps Composer and npm dependencies to their latest
  versions.

## License

Released under the [MIT License](LICENSE).
