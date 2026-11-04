<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('alias')->nullable()->unique()->after('name');
            $table->string('phone', 32)->nullable()->after('email');
            $table->text('identity_number')->nullable()->after('phone');
            $table->string('instagram_handle')->nullable()->after('identity_number');
            $table->string('profile_photo_path')->nullable()->after('instagram_handle');
            $table->string('address')->nullable()->after('profile_photo_path');
            $table->string('address_line_2')->nullable()->after('address');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('postal_code', 32)->nullable()->after('country');
            $table->date('birth_date')->nullable()->after('postal_code');
            $table->text('bio')->nullable()->after('birth_date');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropUnique(['alias']);
            $table->dropColumn([
                'alias',
                'phone',
                'identity_number',
                'instagram_handle',
                'profile_photo_path',
                'address',
                'address_line_2',
                'city',
                'state',
                'country',
                'postal_code',
                'birth_date',
                'bio',
                'deleted_at',
            ]);
        });
    }
};
