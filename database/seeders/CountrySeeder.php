<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::query()->upsert([
            ['name' => 'Argentina', 'iso_code' => 'AR'],
            ['name' => 'Bolivia', 'iso_code' => 'BO'],
            ['name' => 'Brasil', 'iso_code' => 'BR'],
            ['name' => 'Chile', 'iso_code' => 'CL'],
            ['name' => 'Colombia', 'iso_code' => 'CO'],
            ['name' => 'Costa Rica', 'iso_code' => 'CR'],
            ['name' => 'Cuba', 'iso_code' => 'CU'],
            ['name' => 'Ecuador', 'iso_code' => 'EC'],
            ['name' => 'El Salvador', 'iso_code' => 'SV'],
            ['name' => 'Guatemala', 'iso_code' => 'GT'],
            ['name' => 'Honduras', 'iso_code' => 'HN'],
            ['name' => 'México', 'iso_code' => 'MX'],
            ['name' => 'Nicaragua', 'iso_code' => 'NI'],
            ['name' => 'Panamá', 'iso_code' => 'PA'],
            ['name' => 'Paraguay', 'iso_code' => 'PY'],
            ['name' => 'Perú', 'iso_code' => 'PE'],
            ['name' => 'República Dominicana', 'iso_code' => 'DO'],
            ['name' => 'Uruguay', 'iso_code' => 'UY'],
            ['name' => 'Venezuela', 'iso_code' => 'VE'],
        ], ['iso_code'], ['name']);
    }
}
