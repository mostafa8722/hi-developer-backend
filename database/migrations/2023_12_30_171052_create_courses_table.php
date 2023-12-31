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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->default(0)->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("title");
            $table->text("abstract");
            $table->text("body");
            $table->string("slug")->nullable();
            $table->enum("type",["free","vip","cash"]);
            $table->text("images")->nullable();
            $table->string("tags")->nullable();
            $table->integer("price")->default(0);
            $table->integer("viewCount")->default(0);
            $table->integer("commentCount")->default(0);
            $table->string("time")->default("00:00:00");
            $table->enum("status",["published","rejected","draft","unpublished"])->default("unpublished");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
