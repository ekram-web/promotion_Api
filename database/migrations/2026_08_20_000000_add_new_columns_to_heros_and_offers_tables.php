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
            if (!Schema::hasColumn('heros', 'ar')) {
                $table->string('ar')->nullable();
            }
            if (!Schema::hasColumn('heros', 'en')) {
                $table->string('en')->nullable();
            }
            if (!Schema::hasColumn('heros', 'ref')) {
                $table->string('ref')->nullable();
            }
            if (!Schema::hasColumn('heros', 'order')) {
                $table->integer('order')->default(0);
            }
            if (!Schema::hasColumn('heros', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        Schema::table('offers', function (Blueprint $table) {
            if (!Schema::hasColumn('offers', 'num')) {
                $table->string('num')->nullable();
            }
            if (!Schema::hasColumn('offers', 'icon')) {
                $table->string('icon')->nullable();
            }
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
