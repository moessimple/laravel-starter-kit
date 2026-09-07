<?php

declare(strict_types=1);

it('renders the welcome page', function (): void {
    $this->get(route('home'))->assertOk();
});
