<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QuizzesQuestions extends Pivot
{
    public $timestamps = false;

    protected $table='quizzes_questions';
}
