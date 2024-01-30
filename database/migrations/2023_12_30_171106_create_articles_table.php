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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("title");
            $table->text("abstract");
            $table->string("slug")->nullable();
            $table->text("body");
            $table->text("images")->nullable();
            $table->string("tags")->nullable();
            $table->integer("viewCount")->default(0);
            $table->integer("likeCount")->default(0);
            $table->integer("commentCount")->default(0);
            $table->enum("status",["published","rejected","draft","unpublished"])->default("unpublished");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
