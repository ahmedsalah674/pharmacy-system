<?php

namespace App\Http\Controllers\OrderController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Order;
use App\Delivery;
use App\ItemOrder;

class OrderController extends Controller
{
    public function create()
  {
    $products = Item::where('quantity','>','0')->get();
    $address = Order::select('address')->where('user_id',\Auth::user()->id)->first();
    $deliveries = Delivery::all();
    return view('orders.create',compact('products','address','deliveries'));
  }


  public function store(Request $request)
  {
      if(\Auth::user()->role==0 && !$request->delivery_id)
      {
        return redirect()->back()->with('error','choose delivery');
      }
        $this->validate($request,[
        'address' => 'required|max:500',
        ]);
        if($request->id)
        {
            $ids=$request->id;
            $quantities = $request->quantity;
            foreach ($ids as $index => $value) 
            {
                $item= Item::find($value);
                if($quantities[$index] > $item->quantity )
                return redirect()->back()->with('message',"Sorry but we haven't this quantity of ".$item->name );
            }
            $user_id = \Auth::user()->id;
            $total_price = 0; 
            $prices = $request->price;
            $discounts = $request->discount;
            foreach ($prices as $index => $price)
            {
                $total_price = $total_price + ( ($price * $quantities[$index]) - ($discounts[$index]/100 *$quantities[$index] * $price));
            }
            $order = Order::create([
            'user_id' => $user_id,
            'delivery_id' => $request->delivery_id,
            'total_price' => $total_price,
            'address' => $request->address
            ]);
            foreach ($request->id as $key => $value) 
            {
                ItemOrder::create([
                    'item_id' => $value,
                    'order_id' => $order->id,
                    'quantity' => $quantities[$key],
                ]);
            }
            foreach ($ids as $index => $value)
            {
                $item= Item::find($value);
                $item->quantity=$item->quantity-$quantities[$index];
                $item->update();
            }
            
            return redirect()->route('home');
        }
    else 
        return redirect()->back()->with("error","you must choose any item to create order");

  }

}
