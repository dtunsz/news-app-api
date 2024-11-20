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
        Schema::create('newsapi_articles', function (Blueprint $table) {
            $table->id();
            $table->index("keyword");
            $table->string("author");
            $table->string("title");
            $table->string("description");
            $table->string("web_url");
            $table->string("image_url");
            $table->text("content");
            $table->dateTimeTz("publication_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsapi_articles');
    }
};
