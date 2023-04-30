<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_question_id');
            $table->unsignedBigInteger('answer_id');
            $table->integer('duration');
            //This field is added because question correct status can be changed in Answer model
            $table->boolean('is_correct');
            $table->foreign('quiz_question_id')->references('id')->on('quizzes_questions');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
