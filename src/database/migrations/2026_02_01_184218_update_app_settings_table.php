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
        Schema::table('app_settings', function (Blueprint $table) {
            // Drop the columns that are no longer needed
            $table->dropColumn(['is_boolean', 'is_encrypted']);

            // Add the new columns
            $table->integer('type')->default(0)->after('section');
            $table->json('options')->nullable()->after('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            // Remove the new columns
            $table->dropColumn(['type', 'options']);

            // Add back the old columns
            $table->boolean('is_boolean')->default(false);
            $table->boolean('is_encrypted')->default(false);
        });
    }
};