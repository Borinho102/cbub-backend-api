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
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('product');
            $table->decimal('discount_percentage', 4, 2);
            $table->decimal('old_price', 10, 2);
            $table->decimal('new_price', 10, 2);
            $table->boolean('is_active')->default(1);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->morphs('user'); // user who discounted the price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discounts');
    }
};
