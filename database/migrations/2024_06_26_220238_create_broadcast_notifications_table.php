<?php

use App\Enums\NotificationType;
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
        Schema::create('broadcast_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title');
            $table->json('body');
            $table->string('image')->nullable();
            $table->json('data')->nullable();
            $table->morphs('broadcaster');
            $table->enum('type', NotificationType::getValues())
                ->default(NotificationType::Default);
            $table->foreignId('business_id')->nullable()
                ->constrained('businesses');
            $table->foreignId('shop_id')->nullable()
                ->constrained('shops');
            $table->dateTime('broadcast_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_notifications');
    }
};
