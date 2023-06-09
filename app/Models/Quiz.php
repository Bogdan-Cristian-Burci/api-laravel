<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Quiz extends Model
{
    use HasFactory;

    /**
     * Default number of questions set for every quiz, can be changed if it is sent through request when creating a quiz
     * @var int
     */
    public static int $TOTAL_NUMBER_OF_QUESTIONS = 40;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id','name','number_of_questions','training_id'
    ];

    /**
     * Retrieve the chapter that question belongs to
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get all questions for the quiz
     * @return BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class,'quizzes_questions');
    }

    /**
     * Get all saved responses for the quiz
     * @return HasManyThrough
     */
    public function responses(): HasManyThrough
    {
        return $this->hasManyThrough(
            Response::class,
            QuizQuestion::class,
            'quiz_id',
            'quiz_question_id',
            'id',
            'id');
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

}
