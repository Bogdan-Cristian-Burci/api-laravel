<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'multiplier'
    ];

    public function training(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }


}
