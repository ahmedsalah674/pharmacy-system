<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name','price','expiration_date','quantity','image','discount',
      ];
  
      public function getImageAttribute($value)
      {
        return asset('images/item/'.$value);
      }
}
