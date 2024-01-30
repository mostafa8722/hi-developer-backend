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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string("type",10)->nullable();;
            $table->string("title");
            $table->string("slug")->nullable();
            $table->text("abstract")->nullable();;
            $table->text("body")->nullable();;
            $table->text("videoUrl")->nullable();
            $table->string("tags")->nullable();
            $table->boolean("free")->default(false);
            $table->string("time",15)->default("00:00:00");
            $table->string("time_published",15)->default("00:00:00");
            $table->integer("number")->nullable();;
            $table->integer("viewCount")->default(0);
            $table->integer("commentCount")->default(0);
            $table->integer("likeCount")->default(0);
            $table->integer("downloadCount")->default(0);
            $table->enum("status",["published","rejected","draft","unpublished"])->default("unpublished");
            $table->timestamps();
        });



    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
