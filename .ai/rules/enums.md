---
paths:
  - 'app/Enums/**'
---

# Enums

## Plain value types only

Enums in `app/Enums` must not extend, implement or use anything (no traits, no interfaces
beyond the backing type). They are domain nouns, not behaviour carriers.

## Unbacked unless the scalar value is consumed

Declare enums with no backing type. Add `: string` / `: int` only when the value is actually
used outside the enum (e.g. passed to a framework API).

## Result enums for multi-outcome operations

When a service method has more than one distinct failure mode, model the outcome as a
dedicated unbacked enum (a success case plus one per failure). The method returns the enum;
the controller maps each case to an HTTP status with `abort_if()`. Single pass/fail
operations stay `bool` and get no enum.

## Every enum still gets its own unit test

Including a value-only enum. Do not skip it as "too small to test" (see `general.md`).
