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
    public function show($id)
    {
        if(\Auth::user()->role==1)
            return redirect()->route('home')->with('error',"This profile does Not belong to you");
      $delivery= Delivery::find($id);
      if(!$delivery)
         return redirect()->route('home')->with('error',"Delivery not found");
      
          return view('delivery.show',compact('delivery'));
    }
    public function edit($id)
    { 
      if(\Auth::user()->role != 0 )
        return redircet()->route('home')->with('error','You can not access this page');   
      $delivery = Delivery::find($id);
      if(!$delivery)
        abort(404);
      else
        return view('delivery.edit',compact('delivery'));
    }

    public function update(Request $request)
    {
      if($request->image)
      {
         $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'salary'=>['required', 'numeric', 'integer','min:1000'],
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
        $delivery=Delivery::find($request->id);
        $request = $request->except('__token');
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/delivery/'), $imageName);
        $delivery->update($request);
        $delivery->image=$imageName;        
        $delivery->update();
    }
    else {
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'salary'=>['required', 'numeric', 'min:1000'],
      ]);
     $delivery=delivery::find($request->id);
     $request = $request->except('__token');
     $delivery->update($request);
    }
    
     return redirect()->route('delivery.show',$delivery->id)->with('message','Delivery data has been updated successfully');
    }
}
