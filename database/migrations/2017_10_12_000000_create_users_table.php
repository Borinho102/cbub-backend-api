<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('language')->default('en');
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->ipAddress('ip_address')->nullable();

            // Currency
            $table->foreignId('currency_id')->default(1)
                ->constrained('currencies');

            // Country & City foreign key
            $table->foreignId('country_id')->default(1)
                ->constrained('world_countries');
            $table->foreignId('city_id')->nullable()
                ->constrained('world_cities');

            // Ban users
            $table->timestamp('banned_at')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
