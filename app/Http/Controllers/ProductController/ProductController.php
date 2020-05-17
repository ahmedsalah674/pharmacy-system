<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;

class ProductController extends Controller
{
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
        return redirect()->route('home')->with('message','Product has been added');
    }
    public function show($id)
    {
      $product = Item::find($id);
      if(!$product)
        abort(404);
      else
        return view('products.show',compact('product'));
    }
}
