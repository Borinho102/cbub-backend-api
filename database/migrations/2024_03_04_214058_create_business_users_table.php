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
        Schema::create('business_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('language')->default('en');

            $table->foreignId('business_id')->nullable()
                ->constrained('businesses');

            $table->ipAddress('ip_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->rememberToken();

            // Currency
            $table->foreignId('currency_id')->default(1)
                ->constrained('currencies');

            // Country & City foreign key
            $table->foreignId('country_id')->default(1)
                ->constrained('world_countries');
            $table->foreignId('city_id')->nullable()
                ->constrained('world_cities');

            // two_auth & tokens
            $table->boolean('two_factor_auth')->default(false);
            $table->string('two_factor_token')->nullable();
            $table->datetime('two_factor_expiry')->nullable();

            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            // ban admin user
            $table->timestamp('banned_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_users');
    }
};
