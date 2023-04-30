<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    /**
     * Default number of questions set for every quiz, can be changed if it is sent through request when creating a quiz
     * @var int
     */
    public static int $TOTAL_NUMBER_OF_QUESTIONS = 15;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id','name','number_of_questions'
    ];

    /**
     * Retrieve the chapter that question belongs to
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class,'quizzes_questions');
    }

    /**
     * Get all responses
     * @return HasMany
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Responses::class,'quiz_question_id','id');
    }

}
