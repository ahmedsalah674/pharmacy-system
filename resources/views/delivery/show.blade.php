@extends('adminlte::page')
@section('title','User profile')
@section('content_header')
  <h1><i class="fas fa-user-circle text-info"></i> Delivery Data:</h1>
@endsection
@section('content')
<table class="table " style="margin-bottom:5px">
  <tbody>
    @if($delivery->image!= asset('images/delivery/'))
    <i class="fas fa-image mr-1 text-info "></i>
    <label>Delivery Image:</label>
    <br>  
    <tr>
      <tD><a href="{{$delivery->image}}"><img src="{{$delivery->image}}" alt="User profile image " class="rounded-circle" height="120" width="200"></a></td>
    </tr>
    @endif
    <tr>
      <td >
        <i class="fas fa-signature text-info"></i>
        Delivery Name:
        <label for=""> {{ $delivery->name }}</label>
      </td>
    </tr>
    <tr>
        <td >
        <i class="fas fa-signature text-info"></i>
            Delivery salary: <label for="">{{ $delivery->salary }}EGP</label>
        </td>
    </tr>
      </tbody>
</table>
@if(\Auth::user()->role ==0)
  <div>
    <a href="{!!route('delivery.edit',$delivery->id)!!}" style="width: 30%" class="btn btn-primary btn-mg " ><i class="fas fa-edit fa-sm"></i> Edit</a>
  </div>
@endif
@endsection

