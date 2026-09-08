<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

it('renders the welcome page with the shared app name', function (): void {
    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->component('Welcome')
            ->where('name', config('app.name'))
            ->where('auth.user', null)
        );
});
