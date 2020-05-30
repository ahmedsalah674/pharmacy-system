<?php

namespace App\Http\Controllers\RateController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SystemRate;
use App\UserRateActive;
class RateController extends Controller
{
    public function index()
    {
        if(\Auth::user()->role==0)
        {
            $rates=SystemRate::orderBy('created_at', 'desc')->paginate(10);
            return view('systemRates.index',compact('rates'));
        }
        else
        return redirect()->route('home');
    }
    public function store(Request $request)
    {
        SystemRate::create([
            'rate'=>$request->rate,
            'feedback'=>$request->feedback,
        ]);
        $rate=UserRateActive::where('customer_id',\Auth::user()->id)->first();
        $rate->rate_active=0;
        $rate->update();
        return redirect()->route('home')->with('message','Thank you');
    }
}
