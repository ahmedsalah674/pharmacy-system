<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable =[
        'item_id','quantity_imports','quantity_sells','lastWeek_quantity_imports','lastWeek_quantity_sells',
    ];
    public function item()
    {
        return $this->belongsTo('App\Item','item_id');
    }
}
