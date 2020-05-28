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
    public function create()
    {
        if(\Auth::user()->role==0)
            return view('delivery.create');
        else
            return redirect()->route('home');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'max:255|required|',
          'salary' => 'numeric|integer|required|min:1000',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/delivery'), $imageName);
        $image = Delivery::create([
          'name' => $request->name,
          'salary' => $request->salary,
          'image' => $imageName,
        ]);
        return redirect()->route('delivery.all')->with('message',"The Delivery has been added successfuly");
    }
}
