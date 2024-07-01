<?php

use App\Models\Location;
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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->timestamps();
        });

        Location::create([
          
            'city' => 'Lahore',
           
        ]);

        Location::create([
          
            'city' => 'Karachi',
           
        ]);

        Location::create([
          
            'city' => 'Islamabad',
           
        ]);

        Location::create([
          
            'city' => 'Faisalabad',
           
        ]);

        Location::create([
          
            'city' => 'Multan',
           
        ]);

        Location::create([
          
            'city' => 'Rahim Yar Khan',
           
        ]);

        Location::create([
          
            'city' => 'Peshawar',
           
        ]);

        Location::create([
          
            'city' => 'Queta',
           
        ]);

        Location::create([
          
            'city' => 'Khunjerab Pass',
           
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
