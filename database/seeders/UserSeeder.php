<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::withTrashed()->firstOrNew([
            'email' => 'walter.castil@alertapet.test',
        ]);

        $user->fill([
            'role_id' => Role::general()->id,
            'name' => 'Walter Castil',
            'alias' => 'walter.castil',
            'recovery_email' => 'walter.recuperacion@alertapet.test',
            'password' => Hash::make('password'),
            'city' => 'Managua',
            'country_id' => Country::query()->where('iso_code', 'NI')->valueOrFail('id'),
            'bio' => 'Miembro de la comunidad AlertaPet.',
            'is_verified' => true,
            'is_worker_organization' => false,
            'terms_accepted' => true,
            'terms_accepted_at' => now(),
        ]);

        $user->save();

        if ($user->trashed()) {
            $user->restore();
        }
    }
}
