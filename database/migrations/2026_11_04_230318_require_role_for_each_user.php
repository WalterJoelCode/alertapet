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
        if (DB::table('users')->whereNull('role_id')->exists()) {
            $generalRoleId = DB::table('roles')->where('slug', 'general')->value('id');

            if ($generalRoleId === null) {
                $generalRoleId = DB::table('roles')->insertGetId([
                    'name' => 'General',
                    'slug' => 'general',
                    'description' => 'Miembro general de la comunidad.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('users')->whereNull('role_id')->update(['role_id' => $generalRoleId]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->foreignId('role_id')->nullable(false)->change();
            $table->foreign('role_id')->references('id')->on('roles')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->foreignId('role_id')->nullable()->change();
            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });
    }
};
