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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('email')->unique();
            $table->string('username')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('avatar')->nullable();
            $table->text('body')->nullable();
            $table->string('role')->default("user");
            $table->string('api_token')->nullable();
            $table->string('verifyCode')->nullable();
            $table->string('resetPassword')->nullable();
            $table->rememberToken();
            $table->enum("status",["active","unactive"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
