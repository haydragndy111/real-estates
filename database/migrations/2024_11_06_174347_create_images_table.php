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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('real_estate_id');
            $table->string('url');
            $table->tinyInteger('sort_order');
            $table->boolean('main_image');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('real_estate_id')
                ->references('id')
                ->on('real_estates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
