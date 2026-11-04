<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;

class ExploreMapTest extends TestCase
{
    public function test_explore_route_renders_the_interactive_map_interface(): void
    {
        $this->get(route('explore'))
            ->assertSeeText('Mascotas y alertas cerca de ti.')
            ->assertSeeText('Notificaciones')
            ->assertSee('explore-google-map', false)
            ->assertSee('explore-current-location', false);
    }
}
