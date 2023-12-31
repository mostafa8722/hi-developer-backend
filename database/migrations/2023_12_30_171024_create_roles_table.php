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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("en_title")->unique();
            $table->string("body")->nullable();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("en_title")->unique();
            $table->string("section")->unique();
            $table->string("body")->nullable();
            $table->timestamps();
        });
        Schema::create('permission_role', function (Blueprint $table) {

            $table->foreignId("role_id")->references("id")->on("permissions")->onDelete("cascade");

            $table->foreignId("permission_id")->references("id")->on("roles")->onDelete("cascade");
            $table->primary(['role_id','permission_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {

            $table->foreignId("role_id")->references("id")->on("permissions")->onDelete("cascade");
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");

            $table->primary(['role_id','user_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }

};
