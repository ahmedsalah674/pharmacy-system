<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\ItemOrder;
use App\Report; 
class ProductController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
          'name' => 'max:255|required|',
          'price' => 'numeric|integer|max:99999|required',
          'expiration' => 'date|required|',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'quantity' => 'required|numeric|max:99999:',
          'discount' => 'max:100',
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/item/'), $imageName);
        $image = Item::create([
          'name' => $request->name,
          'price' => $request->price,
          'expiration_date' => $request->expiration,
          'quantity' => $request->quantity,
          'discount' => $request->discount,
          'image' => $imageName,
        ]);
          Report::create([
            'item_id'=>$image->id,
            'quantity_imports'=>$image->quantity,
          ]);
        return redirect()->route('home')->with('message','Product has been added');
    }
    public function show($id)
    {
      if(\Auth::user()->role==0)
      {
        $product = Item::find($id);
        if(!$product)
          abort(404);
        else
          return view('products.show',compact('product'));   
      }
      return redirect()->route('home');
    }
    public function index()
    {
      if(\Auth::user()->role == 0)
      {
        $products = Item::orderBy('created_at','desc')->paginate(10);
        return view('products.all',compact('products'));
      }
      else
        return redirect()->route('home');
    }
    
    public function edit($id)
    {
      if(\Auth::user()->role==0)
      {
        $product = Item::find($id);
        if(!$product)
          abort(404);
        else
          return view('products.edit',compact('product'));
      }
      else 
        return redirect()->route('home');
        
    }

    public function update(Request $request, $id)
    {
        $now=\Carbon\Carbon::now();
        $product = Item::find($id);
        if(!$product)
          abort(404);
          if($request->quantity > $product->quantity)
          {
            $report=Report::where('item_id',$product->id)->first() ;
            if($report->created_at->diffInDays($now) <= 7 )
              {
                $report->quantity_imports+=$request->quantity - $product->quantity;
                $report->update();
              }
            if($report->created_at->diffInDays($now) > 7 )
            {
              Report::create([
                'item_id'=>$report->item_id,
                'quantity_imports'=>$request->quantity,
                'lastWeek_quantity_imports'=>$report->quantity_imports,
                'lastWeek_quantity_sells'=>$report->quantity_sells,
                ]);
              $report->delete();
            }
          }
        $request = $request->except('__token');
        $product->update($request);
        
        return redirect()->route('product.all')->with('message','Product has been updated');
    }
    public function destroy(Request $request)
    {
      $items_orders=ItemOrder::where('item_id',$request->id)->get();
      if(count($items_orders)>0)
      {
        foreach($items_orders as $item_order)
        {
          $item_order->delete();
        }
      }
      $reports= Report::where('item_id',$request->id)->get();
      foreach($reports as $report)
        $report->delete();
      Item::destroy($request->id);
      return redirect()->back()->with(['message'=>"The Item's been deleted successfuly"]);
    }
}
