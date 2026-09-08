import { render, screen } from '@testing-library/vue';
import { expect, it } from 'vitest';
import Welcome from './Welcome.vue';

it('renders the getting-started heading', () => {
    render(Welcome);

    expect(screen.getByRole('heading', { name: /get started/i })).toBeTruthy();
});
