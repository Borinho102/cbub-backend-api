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
        Schema::create('promo_code_service', function (Blueprint $table) {
            $table->nullableMorphs('service');
            $table->foreignId('promo_code_id')
                ->constrained('promo_codes');
            $table->unique(['service_id', 'service_type', 'promo_code_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_code_service');
    }
};
