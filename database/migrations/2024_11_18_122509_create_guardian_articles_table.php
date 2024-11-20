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
        Schema::create('guardian_articles', function (Blueprint $table) {
            $table->id();
            $table->index("keyword");
            $table->string("origin_id");
            $table->string("type");
            $table->string("section_name");
            $table->string("title");
            $table->string("web_url");
            $table->string("api_url");
            $table->string("is_hosted");
            $table->string("pillar_name");
            $table->dateTimeTz("publication_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardian_articles');
    }
};
