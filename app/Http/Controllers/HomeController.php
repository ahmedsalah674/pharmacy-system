<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemRate;
use App\UserRateActive;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(\Auth::user()->role==0)
            { 
                $rates=intval(SystemRate::pluck('rate')->avg()*10);
                return view('home',compact('rates'));
            }
        elseif(\Auth::user()->role==1)
        {
            $active=UserRateActive::where('customer_id',\Auth::user()->id)->first()->rate_active;
            return view('home',compact('active'));
        }
        return view('home');
    }
}
