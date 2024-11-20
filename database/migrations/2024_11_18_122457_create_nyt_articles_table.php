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
        Schema::create('nyt_articles', function (Blueprint $table) {
            $table->id();
            $table->index("keyword");
            $table->string("abstract");
            $table->string("web_url");
            $table->text("lead_paragraph");
            $table->string("uri");
            $table->string("section_name");
            $table->string("subsection_name");
            $table->dateTimeTz("publication_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nyt_articles');
    }
};
