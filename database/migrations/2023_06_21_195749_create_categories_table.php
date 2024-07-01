<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Category::create([
            'title' => 'Civil Lawyer',
           
        ]);

        Category::create([
           
            'title' => 'Criminal Lawyer',
         
        ]);

        Category::create([
         
            'title' => 'Family Lawyer',
           
        ]);

        Category::create([
         
            'title' => 'Labor Lawyer',
           
        ]);

        Category::create([
           
            'title' => 'Taxation Lawyer',
           
        ]);

        Category::create([
          
            'title' => 'Immigration Lawyer',
           
        ]);

        Category::create([
           
            'title' => 'Accidental Lawyer',
          
        ]);

        Category::create([
          
            'title' => 'Divorce Lawyer',
           
        ]);

        Category::create([
          
            'title' => 'Business layer',
           
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
