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
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id');
            $table->string('title_en');
            $table->text('description');
            $table->tinyInteger('status');
            $table->decimal('aed_price');
            $table->decimal('usd_price');
            $table->tinyInteger('type');
            $table->string('size');
            $table->tinyInteger('rooms');
            $table->date('handover');
            $table->timestamps();

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estates');
    }
};
