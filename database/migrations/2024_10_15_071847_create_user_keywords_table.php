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
        Schema::create('user_keywords', function (Blueprint $table) {
            $table->id(); // Primary key for user_keywords
            $table->unsignedBigInteger('userId'); // Must match the type of the 'id' in users table
            $table->unsignedBigInteger('keywordId'); // Must match the type of the 'id' in keywords table
            $table->timestamps(); // Timestamps

            // Add foreign key constraints
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('keywordId')->references('id')->on('keywords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_keywords');
    }
};
