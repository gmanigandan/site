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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('username')->unique()->nullable();  // Corrected this to a string
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable(); // For Address Line 1
            $table->string('status')->nullable();
            $table->rememberToken();
            $table->timestamps();
        
            $table->index(['username', 'email', 'status', 'created_at']);
        });
 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     
    }
};
