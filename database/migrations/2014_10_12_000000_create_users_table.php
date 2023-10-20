<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('role')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('is_document_submit')->default(0)->nullable();
            $table->string('degree')->nullable();
            $table->string('high_court')->nullable();
            $table->string('supreme_court')->nullable();
            $table->string('high_court_licence')->nullable();
            $table->string('supreme_court_licence')->nullable();
            $table->string('experience_in_years')->nullable();
            $table->string('qualification')->nullable();
            $table->string('qualification_certificate')->nullable();
            $table->string('certificates')->nullable();
            $table->string('document_status')->default('not submitted')->nullable();
            $table->string('reason')->nullable();
            $table->tinyInteger('is_blocked')->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Junaid Ur Rehman',
            'email' => 'junaid@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'lawyer'
        ]);

        User::create([
            'name' => 'Nauman Asif',
            'email' => 'nauman@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'user'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
