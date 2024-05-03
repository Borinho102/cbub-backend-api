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
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('phone_alt')->nullable();
            $table->string('email')->unique();
            $table->longText('about')->nullable();
            $table->integer('number_of_shops');
            $table->integer('max_shops')->nullable();
            $table->string('fiscal_id')->nullable();
            $table->string('rccm')->nullable();

            // Category
            $table->foreignId('category_id')
                ->constrained('business_categories');

            // Country & City foreign key
            $table->foreignId('country_id')->default(1)
                ->constrained('world_countries');

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
