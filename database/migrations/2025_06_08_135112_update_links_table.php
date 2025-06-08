<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->json('classification')->nullable();
        });

        Schema::table('link_settings', function (Blueprint $table) {
            $table->json('classification')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            //
        });
    }
};
