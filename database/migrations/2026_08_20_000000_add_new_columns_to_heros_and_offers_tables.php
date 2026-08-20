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
        Schema::table('heros', function (Blueprint $table) {
            $table->string('ar')->nullable();
            $table->string('en')->nullable();
            $table->string('ref')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('num')->nullable();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heros', function (Blueprint $table) {
            $table->dropColumn(['ar', 'en', 'ref', 'order', 'is_active']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['num', 'icon']);
        });
    }
};
