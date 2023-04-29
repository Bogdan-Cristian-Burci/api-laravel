<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name','description'
    ];

    /**
     * Retrieve the chapter that question belongs to
     * @return BelongsTo
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * get all possible answers for the question
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function quiz(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class,'quizzes_questions');
    }
}
