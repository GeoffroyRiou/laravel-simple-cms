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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('model_path');
            $table->string('title');
            $table->string('slug');
            $table->string('illustration')->nullable();
            $table->string('url_path')->nullable();
            $table->boolean('published')->default(0);
            $table->json('page_blocks')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('contents')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('contents')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
