<?php

namespace App\Http\Controllers\OrderController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Order;
use App\Delivery;
use App\ItemOrder;
use App\Report;
use App\UserRateActive;

class OrderController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
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
            if(\Auth::user()->role==0)
             return redirect()->route('order.all')->with('message',"your order added ");
            else 
            return redirect()->route('order.myOrders')->with('message',"your order added ");
        }
    else 
        return redirect()->back()->with("error","you must choose any item to create order");

  }

  
  public function show($id)
  {
    $order=Order::find($id);
    $items_order=ItemOrder::where('order_id',$id)->get();
    if(!$order )
      return abort(404);

    return view('orders.show',compact(['order','items_order']));
  }
  public function edit($id)
  {
    $order = Order::find($id);
    if($order && (\Auth::user()->role==0 || $order->user_id== \Auth::user()->id) )
   {
      $products = ItemOrder::where('order_id',$id)->get();
      $deliveries = Delivery::all();
      $items = Item::all();
      return view('orders.edit',compact(['order','products','deliveries','items']));
    }
    elseif(!$order)
     return abort(404);
    else return redirect()->route('home')->with('info',"You can only edit your orders");
  }
  
  public function update(Request $request,int $order_id)
  { $order=Order::find($order_id);
    if(\Auth::user()->role==0 && !$order->delivery_id){
      $this->validate($request,[
      'delivery_name' => 'required|max:500',
    ]);}
    if(!$order->address){
      $this->validate($request,[
      'address' => 'required|max:500',
    ]);}
    $itemsOldOrder= ItemOrder::where('order_id',$order_id)->get();
    if($order)
    {
      $ids=$request->id;
      if($ids)
      {
        $total_prices=0;
        $quantities = $request->quantity;
        $flags_index = array_fill(0,count($ids), 0);
        $flags_count = array_fill(0,count($itemsOldOrder), 0);
        foreach ($ids as $index => $value) 
        {
          for($count=0;$count < count($itemsOldOrder);$count++)
          {
            if($ids[$index] == $itemsOldOrder[$count]->item_id)
              {
                $flags_count[$count]=1;$flags_index[$index]=1; 
                if($quantities[$index] > $itemsOldOrder[$count]->quantity )
                  { 
                    $dif=$quantities[$index] - $itemsOldOrder[$count]->quantity;
                    if($itemsOldOrder[$count]->item->quantity < $dif)
                      return redirect()->back()->with('error',"Sorry but we haven't this quantity of ".$itemsOldOrder[$count]->item->name ." we have only ".$itemsOldOrder[$count]->item->quantity );
                    else
                      { 
                        $itemsOldOrder[$count]->item->quantity-=$dif;
                        $itemsOldOrder[$count]->quantity=$quantities[$index];
                        $itemsOldOrder[$count]->update();
                        $itemsOldOrder[$count]->item->update();
                      } 
                  }
                elseif($quantities[$index] < $itemsOldOrder[$count]->quantity )
                  {
                    $dif=$itemsOldOrder[$count]->quantity -$quantities[$index] ;
                    $itemsOldOrder[$count]->item->quantity+=$dif;
                    $itemsOldOrder[$count]->quantity=$quantities[$index];
                    $itemsOldOrder[$count]->update();
                    $itemsOldOrder[$count]->item->update(); 
                  }//end else if
                  
              } //end for (count)
          }//end foreach $ids
        }
        foreach($flags_count as $count=> $flag)
          if(!$flag)
          {
             $itemsOldOrder[$count]->item->quantity+=$itemsOldOrder[$count]->quantity;
             $itemsOldOrder[$count]->item->update();
             ItemOrder::destroy($itemsOldOrder[$count]->id);  
         }
        foreach($flags_index as $index =>$flag )
        { if(!$flag)
        {               
             ItemOrder::create([
              'item_id' => $ids[$index],
              'order_id' => $order_id,
              'quantity' => $quantities[$index],
            ]);
            $new_item=Item::find($ids[$index]);
            $new_item->quantity-=$quantities[$index];
            $new_item->update();
          }
          $product=item::find($ids[$index]);
          $total_prices+= ($product->price * $quantities[$index]) -(($product->price * $quantities[$index] * $product->discount/100)) ;
         }
         
      }
      else {
        foreach($itemsOldOrder as $itemOldOrder)
          {
            $del_item=itemOrder::find($itemOldOrder->id);
            $del_item->item->quantity+=$del_item->quantity;  
            $del_item->item->update();
            itemOrder::destroy($itemOldOrder->id);}  
            Order::destroy($order_id);
            return redirect()->route('home')->with("message","Order has been deleted");
      }  
      $Order=Order::find($order_id);
      if($Order){
      $Order->total_price=$total_prices;
      if($request->address)
        $Order->address=$request->address;
      if($request->delivery_name)
        $Order->delivery_id=$request->delivery_name;
      $Order->update();
      return redirect()->route('order.show',$Order)->with("message","Order has been edited");
    }
    }//end if
  else
    abort(404);    
  }
  //change all var (id) to (request->id) after create all orders page
  //we don't need to change it -mohamed-
  public function destroy($id)
  {
    $order=Order::find($id);
      if(!$order )
        return abort(404); 
    if($order->user_id == \Auth::user()->id || \Auth::user()->role == 0)
    {  
        $items_order=ItemOrder::where('order_id',$id)->get();
        foreach($items_order as $item_order)
        {
        if($order->state!="Delivered")
        {
          $item_order->item->quantity += $item_order->quantity;
          $item_order->item->update();
        }
          ItemOrder::destroy($item_order->id);
        }
        Order::destroy($id);
      return redirect()->route('order.all')->with('message','Order has been deleted');
    }
    else 
      return redirect()->route('order.all')->with('error',"you can't delete this order");
  }

  public function index()
  {
    $orders = Order::all();
    foreach($orders as $order) // just to avoid any mistake
      {
        $itemOrder = ItemOrder::where('order_id',$order->id)->get();
        if(count($itemOrder)==0 )
        {
          Order::destroy($order->id);
          $orders = Order::all(); // orders after update
        }
    }
    $temp_array=array();
    foreach($orders as $order)
      if($order->state!="Delivered")
        array_push($temp_array,$order);
    $orders=$temp_array;
    return view('orders.all',compact('orders'));
  }

  public function deliver($id)
  {
    $order = Order::find($id);
    if($order)
    {
      if(!$order->delivery_id || !$order->address)
        return redirect()->route('order.edit',$id)->with('info','the order must have address and delivery first');
      if($order->state=="In Progress")
        {
          $order->state=1;
          $order->update();
        }
      return redirect()->back()->with('message','Please Press Finsh When Order Deliver');
    }
    else
      return abort(404);
  }

  public function finish($id)
  {
    $now=\Carbon\Carbon::now();
    $order = Order::find($id);
    $items =ItemOrder::where('order_id',$order->id)->get();
    if($order->state=="On the Way")
      {
        $order->state=2;
        $order->update();
        if(count($items)>0)
        {
          foreach($items as $item)
          {
            $report=Report::where('item_id',$item->item_id)->first();
            if($report && $report->created_at->diffInDays($now) <= 7)
              {
                $report->quantity_sells+=$item->quantity;
                $report->update();
              }
              elseif($report && $report->created_at->diffInDays($now) > 7)
              {
                Report::create([
                  'item_id'=>$item->item_id,
                  'quantity_imports'=>$item->item->quantity + $item->quantity ,
                  'quantity_sells'=>$item->quantity,
                  'lastWeek_quantity_sells'=>$report->quantity_sells,
                  'lastWeek_quantity_imports'=>$report->quantity_imports,
                  ]);
                $report->delete();
              }
          }
        }
        $rate=UserRateActive::find(\Auth::user()->id);
        $rate->rate_active=1;
        $rate->update();
      }
    else
      return abort(404);
    return redirect()->back();  
  }

  public function myOrders()
  {
    if(\Auth::user()->role==1)
    {
      $orders = Order::where('user_id',\Auth::user()->id)->get();
      $myOrders=array();
      foreach($orders as $order)
        if($order->state!="Delivered")
          array_push($myOrders,$order);
      return view('orders.myOrders',compact('myOrders'));
    }
    else
      return redirect()->route('home');
  }
  public function history()
  {
    if(\Auth::user()->role==1)
      $orders = Order::where('user_id',\Auth::user()->id)->get();
    else  
      $orders = Order::all();
    $orders_history=array();
    foreach($orders as $order)
      if($order->state=="Delivered")
        array_push($orders_history,$order);
    return view('orders.history',compact('orders_history'));
  }
  public function report()
  {
    $now=\Carbon\Carbon::now();
    $reports=Report::all();
    $temp=array();
    foreach($reports as $report)
      {
        if($report->created_at->diffInDays($now) <= 7)
              array_push($temp,$report);
      } 
     $reports=$temp;
    return view('orders.report',compact('reports'));
  }

}
