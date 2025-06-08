<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('link_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('link_id');
            $table->tinyInteger('priority')->default(0);
            $table->enum('operand', ['OR', 'AND'])->default('AND');
            $table->string('url');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_settings');
    }
};
