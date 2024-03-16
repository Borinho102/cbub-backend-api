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
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('initials')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_alt')->nullable();
            $table->string('email')->unique();
            $table->longText('about')->nullable();

            // Category
            $table->foreignId('category_id')
                ->constrained('business_categories');

            // Country & City foreign key
            $table->foreignId('country_id')->default(1)
                ->constrained('world_countries');
            $table->foreignId('city_id')->nullable()
                ->constrained('world_cities');

            // Currency
            $table->foreignId('currency_id')->default(1)
                ->constrained('currencies');

            // goe-location
            $table->point('location')->nullable();
            // Add a Polygon spatial data field named area
            $table->polygon('area')->nullable();

            // social links
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
