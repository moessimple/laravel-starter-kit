import { expect, it } from 'vitest';

import { cn } from './utils';

it('joins truthy class values and drops falsy ones', () => {
    expect(cn('a', false, null, undefined, 'b')).toBe('a b');
});

it('lets a later Tailwind utility win over an earlier conflicting one', () => {
    expect(cn('p-2', 'p-4')).toBe('p-4');
});
