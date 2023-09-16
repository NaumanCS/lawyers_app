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
        Schema::create('create_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_name')->nullable();
            $table->string('created_by')->nullable();
            $table->string('meeting_with')->nullable();
            $table->string('meeting_link')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_meetings');
    }
};
