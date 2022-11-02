<?php

use Domain\Organisation\Models\Organisation;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    Organisation::factory()->create();
});

it('shows the application', function () {
    $this->get(route('application.thanks'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page->component('Recruitment/Applications/Thanks')
        );
});
