<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('quizzes', function (Blueprint $table) {
        $table->id();
        $table->string('title');            // Title of the quiz
        $table->text('description')->nullable(); // Description (optional)
        // Add any extra fields you want here, for example:
        // $table->boolean('is_active')->default(true);
        // $table->integer('time_limit')->nullable(); // minutes, optional

        $table->timestamps(); // created_at and updated_at columns
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
