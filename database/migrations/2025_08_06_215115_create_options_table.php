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
        Schema::create('options', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
                // Links to id on questions table, deletes options if question is deleted
            $table->string('option_text'); // The answer choice
            $table->boolean('is_correct')->default(false); // Marks if this is the correct answer
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
