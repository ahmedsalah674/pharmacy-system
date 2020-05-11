<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'name','salaray','number_of_deliveries',
      ];
      protected $table = 'delivery';
}
