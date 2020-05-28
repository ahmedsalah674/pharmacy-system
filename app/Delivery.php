<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'name','salary','image',
      ];
      protected $table = 'delivery';
      public function getImageAttribute($value)
    {
      return asset('images/delivery/'.$value);
    }
}
