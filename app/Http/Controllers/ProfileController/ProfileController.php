<?php

namespace App\Http\Controllers\ProfileController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class ProfileController extends Controller
{
    public function show($id)
    {
      $user= User::find($id);
     
      if(!$user)
         return redirect()->route('home')->with('error',"This Profile Not Found"); 
      elseif( $id != \Auth::user()->id)
         return redirect()->route('profile.show',\Auth::user()->id);

          return view('profile.show',compact('user'));
    }
}
