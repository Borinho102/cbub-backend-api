<?php

use App\Enums\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id')->unique();
            $table->nullableMorphs('customer');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->enum('status', OrderStatus::getValues())->default(OrderStatus::Pending);
            $table->text('description')->nullable();
            $table->json('data')->nullable();
            $table->foreignId('delivery_address_id')
                ->constrained('delivery_addresses');
            $table->foreignId('business_id')->constrained('businesses');
            $table->foreignId('shop_id')->constrained('shops');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
