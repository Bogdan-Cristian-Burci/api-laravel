<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('quizzes_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes_questions');
    }
};
