<?php

use App\Models\PromoCode;
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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('code')->unique();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('discount_type', collect((new PromoCode)::DISCOUNT_TYPES)->keys()->all())
                ->default('percentage');
            $table->float('discount_value')
                ->comment('Percentage value if discount type is percentage and discount amount if discount type is fixed_price');
            $table->integer('minimum_spend')->nullable();
            $table->integer('maximum_spend')->nullable();
            $table->integer('max_usage')->nullable()
                ->comment('Number of times the promo code can be use.');
            $table->integer('max_usage_per_user')->nullable()
                ->comment('Number of times the promo code can be use by a specific user.');
            $table->boolean('free_delivery')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('shop_id')->nullable()
                ->constrained('shops');
            $table->foreignId('business_id')->nullable()
                ->constrained('businesses');
            $table->string('tags')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
};
