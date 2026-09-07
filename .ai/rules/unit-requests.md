---
paths:
  - 'tests/Unit/Requests/**'
---

# Unit Requests

## Asserting a FormRequest's `rules()` array directly is legitimate here

`expect((new XRequest)->rules())->toEqual([...])` against the literal rule array is a
sanctioned convention, not an implementation-detail smell. It is the baseline coverage every
FormRequest test carries: the declared rule set is the contract worth pinning. (Rationale:
Jason McCreary, "Test Validation in Laravel with a Form Request assertion".)

Add `createFormRequest()` boundary assertions (see `tests.md`) on top only when the rule
array alone cannot secure a specific edge: a regex/format rule, conditional or cross-field
rules, a custom Rule object, or `authorize()` / `prepareForValidation()` logic. A plain
`required|string|max` request needs only the array check.
