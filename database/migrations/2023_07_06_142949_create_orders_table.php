<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('lawyer_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('amount')->nullable();
            $table->date('booking_date')->nullable();
            $table->string('lawyer_status')->nullable();
            $table->string('customer_status')->nullable();
            $table->string('lawyer_location')->nullable();
            $table->string('customer_location')->nullable();
            $table->string('payment_slip')->nullable();
            $table->string('transaction_id')->nullable();

            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('detail')->nullable();
            $table->string('rejection_reason')->nullable();




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
