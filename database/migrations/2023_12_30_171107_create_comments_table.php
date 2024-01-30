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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('parent_id')->default(0)->references('id')->on('comments')->onDelete('cascade');
            $table->foreignId('course_id')->default(0)->references('id')->on('courses')->onDelete('cascade');
            $table->foreignId('episode_id')->default(0)->references('id')->on('episodes')->onDelete('cascade');
            $table->foreignId('article_id')->default(0)->references('id')->on('articles')->onDelete('cascade');

            $table->text("comment");
            $table->enum("status",["unseen","unapproved","approved"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
