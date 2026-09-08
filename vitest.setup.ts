import { cleanup } from '@testing-library/vue';
import { afterEach, vi } from 'vitest';

// @inertiajs/vue3's <Head> and <Link> reach for the Inertia app context that only
// a real Inertia page visit sets up. Component tests render a page in isolation,
// so stand them in with inert equivalents.
vi.mock('@inertiajs/vue3', () => ({
    Head: {
        name: 'Head',
        props: { title: { type: String, default: '' } },
        template: '<slot />',
    },
    Link: {
        name: 'Link',
        props: { href: { type: String, default: '' } },
        template: '<a :href="href"><slot /></a>',
    },
}));

afterEach(() => {
    cleanup();
});
