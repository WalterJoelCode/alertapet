<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SocialAuthenticationTest extends TestCase
{
    public function test_login_and_registration_pages_offer_social_authentication(): void
    {
        $this->get(route('login'))
            ->assertSee('Continuar con')
            ->assertSee('data-theme-toggle', false)
            ->assertSee(route('social.redirect', 'google'), false)
            ->assertSee(route('social.redirect', 'facebook'), false)
            ->assertSee(route('social.redirect', 'microsoft'), false);

        $this->get(route('register'))
            ->assertSee('Registrarme con')
            ->assertSee(route('social.redirect', 'google'), false);
    }

    public function test_unconfigured_social_provider_returns_to_login_with_an_explanation(): void
    {
        config()->set('services.google.client_id', null);
        config()->set('services.google.client_secret', null);

        $this->get(route('social.redirect', 'google'))
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors('social');
    }

    public function test_authenticated_user_sees_the_personal_home_sections(): void
    {
        $user = new User(['name' => 'María']);
        $user->id = 1;

        $this->actingAs($user)->get(route('inicio'))
            ->assertSeeText('Mi perfil')
            ->assertSeeText('Mis mascotas')
            ->assertSeeText('Mis reportes de adopción')
            ->assertSeeText('Mascotas vistas')
            ->assertSeeText('Mis mascotas perdidas')
            ->assertSeeText('Configuración')
            ->assertSeeText('Cerrar sesión');
    }
}
