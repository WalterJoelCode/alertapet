<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationFlowTest extends TestCase
{
    public function test_home_renders_the_explore_and_report_call_to_action(): void
    {
        $this->get(route('home'))
            ->assertSeeText('Explorar y reportar')
            ->assertSee(route('explore'), false);
    }
}
