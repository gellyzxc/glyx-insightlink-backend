<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('link_route_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('link_setting_id');
            $table->foreignUuid('route_setting_id');
            $table->json('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_route_settings');
    }
};
