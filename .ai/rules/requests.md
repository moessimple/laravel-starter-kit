---
paths:
  - 'app/Http/Requests/**'
---

# Requests

## Expose a semantic getter, not raw `input()`

Every FormRequest declares a domain-named getter (e.g. `title()`, `body()`) that wraps
`$this->string('field')->toString()` (or the matching typed accessor), rather than callers
reading `$request->input()`, dynamic properties, or a raw `validated()` array. Add one getter
per validated field.

## Build rules with the fluent `Rule` builder

Prefer `Rule::string()->max(...)`, `Rule::string()->email()`, etc. over plain rule strings
like `'string'`, `'max:255'`. Match this style for new fields.
