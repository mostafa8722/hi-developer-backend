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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("title")->nullable();
            $table->text("body")->nullable();
            $table->text("abstract")->nullable();
            $table->string("images")->nullable();
            $table->string("tags")->nullable();
            $table->string("slug")->nullable();
            $table->enum("status",["published","rejected","draft","unpublished"])->default("unpublished");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
