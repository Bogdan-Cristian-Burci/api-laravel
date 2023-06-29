<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    protected $fillable = [
        'training_category_id',
        'training_type_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TrainingCategory::class,'training_category_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(TrainingType::class,'training_type_id');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'users_trainings');
    }

}
