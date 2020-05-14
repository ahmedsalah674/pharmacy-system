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
    public function edit()
    {
      $user = User::find(\Auth::user()->id);
      if(!$user)
        abort(404);
      else
        return view('profile.edit',compact('user'));
    }

    public function update(Request $request)
    { 
      if($request->email!=\Auth::user()->email)
         $this->validate($request,['email' => ['required', 'string', 'email', 'max:255', 'unique:users'],]);
      if($request->image)
      {
         $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
        $user=user::find(\Auth::user()->id);
        $request = $request->except('__token');
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/users'), $imageName);
        $user->update($request);
        $user->image=$imageName;        
        $user->update();
    }
    else {
      if($request->email!=\Auth::user()->email)
         $this->validate($request,['email' => ['required', 'string', 'email', 'max:255', 'unique:users'],]);
      $this->validate($request,[
        'name' => ['required', 'string', 'max:255'],
      ]);
     $user=user::find(\Auth::user()->id);
     $request = $request->except('__token');
     $user->update($request);
    }
     return redirect()->route('profile.show',\Auth::user()->id)->with('message','your profile Updated Successfully');
    }
}
