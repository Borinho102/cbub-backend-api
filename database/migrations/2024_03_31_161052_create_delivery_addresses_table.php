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
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('full_name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('state')->nullable();
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->boolean('use_as_default')->default(true);
            $table->foreignId('city_id')->nullable()->constrained('world_cities');
            $table->foreignId('country_id')->nullable()->constrained('world_countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_addresses');
    }
};
