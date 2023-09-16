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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('location')->nullable();
            $table->string('amount')->nullable();
            $table->string('categories_id')->nullable();
            $table->string('start_day')->nullable();
            $table->string('end_day')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('add_extra_day')->nullable();
            $table->string('extra_day')->nullable();
            $table->string('extra_day_start_time')->nullable();
            $table->string('extra_day_end_time')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('ratings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
