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
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('invitor');
            $table->morphs('invitee');
            $table->string('token');
            $table->datetime('expires_at');
            $table->datetime('accepted_at')->nullable();
            $table->timestamps();
            $table->unique(['invitee_id', 'invitee_type', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
