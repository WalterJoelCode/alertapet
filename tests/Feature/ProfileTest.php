<?php

namespace Tests\Feature;

use App\Livewire\ProfileEditor;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_assigns_the_general_role(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Ana López',
            'email' => 'ana@example.test',
            'recovery_email' => 'ana.recuperacion@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms_accepted' => true,
        ])->assertRedirectToRoute('inicio');

        $user = User::query()->where('email', 'ana@example.test')->firstOrFail();

        $this->assertSame(Role::General, $user->role->slug);
        $this->assertTrue($user->terms_accepted);
        $this->assertSame('ana.recuperacion@example.test', $user->recovery_email);
    }

    public function test_profile_requires_authentication(): void
    {
        $this->get(route('profile'))->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_can_update_personal_profile_details(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(ProfileEditor::class)
            ->set('name', 'Ana López')
            ->set('email', 'ana@example.test')
            ->set('recoveryEmail', 'ana.recuperacion@example.test')
            ->set('alias', 'ana_con_mascotas')
            ->set('phone', '+505 8888 0000')
            ->set('city', 'Managua')
            ->set('countryId', Country::query()->where('iso_code', 'NI')->valueOrFail('id'))
            ->set('identityNumber', '001-000000-0000A')
            ->set('termsAccepted', true)
            ->call('save')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertSame('Ana López', $user->name);
        $this->assertSame('ana_con_mascotas', $user->alias);
        $this->assertSame('Managua', $user->city);
        $this->assertSame('Nicaragua', $user->country->name);
        $this->assertSame('001-000000-0000A', $user->identity_number);
        $this->assertTrue($user->terms_accepted);
    }

    public function test_profile_requires_a_unique_alias_and_email(): void
    {
        $existingUser = User::factory()->create([
            'alias' => 'cuenta_existente',
            'email' => 'existente@example.test',
        ]);
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test(ProfileEditor::class)
            ->set('name', 'Ana López')
            ->set('alias', $existingUser->alias)
            ->set('email', $existingUser->email)
            ->set('termsAccepted', true)
            ->call('save')
            ->assertHasErrors([
                'alias' => 'unique',
                'email' => 'unique',
            ]);

        $user->refresh();

        $this->assertNotSame($existingUser->alias, $user->alias);
        $this->assertNotSame($existingUser->email, $user->email);
    }
}
