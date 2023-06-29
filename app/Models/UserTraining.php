<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class UserTraining extends Model
{
    protected $table='users_trainings';

    protected $fillable=['training_id','user_id','active','expire_at'];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class,'order_user_training');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

}
