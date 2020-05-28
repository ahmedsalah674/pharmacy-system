<?php

namespace App\Http\Controllers\DeliveryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delivery;
class DeliveryController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role==0)
        {
            $deliveries= Delivery::all();
            return view('delivery.all',compact('deliveries'));
        }
        else return redirect()->route('home');
    }
}
