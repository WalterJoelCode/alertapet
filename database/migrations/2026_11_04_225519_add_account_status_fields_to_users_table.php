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
            $table->boolean('is_verified')->default(false)->after('email_verified_at');
            $table->boolean('is_worker_organization')->default(false)->after('is_verified');
            $table->string('recovery_email')->nullable()->unique()->after('email');
            $table->boolean('terms_accepted')->default(false)->after('recovery_email');
            $table->timestamp('terms_accepted_at')->nullable()->after('terms_accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['recovery_email']);
            $table->dropColumn([
                'is_verified',
                'is_worker_organization',
                'recovery_email',
                'terms_accepted',
                'terms_accepted_at',
            ]);
        });
    }
};
