<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $countries = [
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
        ];

        DB::table('country')->upsert($countries, ['iso_code'], ['name']);

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('state')->constrained('country')->restrictOnDelete();
        });

        DB::table('users')
            ->whereNotNull('country')
            ->orderBy('id')
            ->eachById(function (object $user): void {
                $countryId = DB::table('country')->where('name', $user->country)->value('id');

                if ($countryId !== null) {
                    DB::table('users')->where('id', $user->id)->update(['country_id' => $countryId]);
                }
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country')->nullable()->after('state');
        });

        DB::table('users')
            ->whereNotNull('country_id')
            ->orderBy('id')
            ->eachById(function (object $user): void {
                $countryName = DB::table('country')->where('id', $user->country_id)->value('name');

                DB::table('users')->where('id', $user->id)->update(['country' => $countryName]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('country_id');
        });
    }
};
