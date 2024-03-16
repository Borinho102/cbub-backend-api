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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->string('sku')->nullable()->unique();
            $table->string('slug')->unique();
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_available')->default(true);
            $table->foreignId('category_id')->constrained('product_categories');
            $table->foreignId('business_id')->constrained('businesses');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
