---
paths:
  - 'resources/js/**'
---

# JS

## Every exported function and component behaviour gets its own isolated test

Coverage is measured per exported function or per observable component behaviour (rendered
output, emitted event, user interaction), not per file. `Component.test.ts` sitting next to
`Component.vue` only guarantees the component is not forgotten; it does not guarantee every
behaviour is covered. Do not skip a behaviour's test just because nothing currently
exercises it. Same rule as `tests.md`'s "every public method gets its own isolated test",
applied to JS.

## `it()`, no `describe()`, one behaviour per test

Vitest tests use `it('does X', ...)`, never `test(...)`, and no `describe()` wrapper: the
file path already gives the grouping context. Do not combine "renders the value" and "emits
on click" into one test. Component tests live co-located next to the component
(`Component.vue` + `Component.test.ts` in the same folder), not under a separate `tests/`
tree, matching the starter-kit scaffold (`Welcome.vue` / `Welcome.test.ts`).

## Mock only collaborators that already have their own test

Once a child component, composable or lib function has its own dedicated test, `vi.mock()`
it in callers' tests instead of re-proving its behaviour, and note the sibling test file in
a comment at the `vi.mock()` call. Leaf-level pure functions with no collaborators are
exercised end to end, not mocked. Standing in for something that simply does not work under
jsdom (e.g. `@inertiajs/vue3`'s `<Head>`) is a separate, environment-driven reason; the
`vitest.setup.ts` mock exists for that, and its `<Head>` stub renders its slot so a page's
`<link>` tags still count toward coverage. Do not conflate the two reasons in a comment.

## DOM cleanup is global

`vitest.setup.ts` registers `afterEach(cleanup)` once (via `test.setupFiles`). Individual
test files do not repeat it. `@testing-library/vue` only auto-registers cleanup when a real
global `afterEach` exists, which is not the case here since test utilities are imported
explicitly rather than via Vitest globals.
