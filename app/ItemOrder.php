<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model
{
    protected $fillable = [
        'item_id','order_id','quantity',
      ];
      protected $table = 'items_orders';
    
      public function item()
      {
        return $this->belongsTo('App\Item');
      } 
      public function order()
      {
        return $this->belongsTo('App\Order');
      } 
}
