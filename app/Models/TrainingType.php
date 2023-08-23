<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'price'
    ];

    public function training(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }
}
