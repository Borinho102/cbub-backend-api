<?php

use App\Enums\ProductType;
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
            $table->string('barcode')->nullable()->unique();
            $table->string('slug')->unique();
            $table->string('weight')->nullable();
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->unsigned();
            $table->integer('min_purchase_quantity')->default(1);
            $table->string('video_link')->nullable();
            $table->string('video_provider')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('refundable')->default(true);
            $table->boolean('free_shipping')->default(false);
            $table->foreignId('category_id')->constrained('product_categories');
            $table->foreignId('business_id')->constrained('businesses');
            $table->foreignId('shop_id')->constrained('shops');
            $table->foreignId('parent_id')->nullable()->constrained('products');
            $table->enum('type', ProductType::getValues())->default(ProductType::Physical);
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
