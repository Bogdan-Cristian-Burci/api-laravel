<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTraining extends Model
{
    protected $table='users_trainings';

    protected $fillable=['training_id','user_id','active','expire_at'];
}
