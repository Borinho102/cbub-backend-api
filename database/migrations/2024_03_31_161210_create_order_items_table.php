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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_id')
                ->constrained('orders');
            $table->morphs('item');
            $table->foreignId('business_id')->nullable()
                ->constrained('businesses');
            $table->foreignId('shop_id')->nullable()
                ->constrained('shops');
            $table->integer('quantity');
            $table->decimal('unit_amount');
            $table->decimal('total_amount');
            $table->string('currency');
            $table->text('description')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
