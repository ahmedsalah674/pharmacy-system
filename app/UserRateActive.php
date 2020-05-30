<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRateActive extends Model
{
    protected $fillable = ['customer_id', 'rate_active'];
    protected $table='user_rate_active';
}
