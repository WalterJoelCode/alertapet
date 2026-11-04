<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = now();

        Role::query()->upsert([
            ['name' => 'General', 'slug' => Role::General, 'description' => 'Miembro general de la comunidad.', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Moderador', 'slug' => 'moderator', 'description' => 'Revisa contenido y apoya a la comunidad.', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Administrador', 'slug' => 'administrator', 'description' => 'Administra la configuración del sistema.', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ], ['slug'], ['name', 'description', 'updated_at']);
    }
}
