@extends('adminlte::page')
@php( $username = \Auth::user()->name)
@php( $userrole = \Auth::user()->role)
@if($userrole==0)
@php($userrole='Parmacist')
@elseif($userrole==1)
@php ($userrole='Customer')
@endif
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fas fa-home text-info"></i> Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Welcome at PMS system {{$userrole}} : <b>{{$username}}</b>  
            </div>
        </div>
    </div>
</div>

@endsection
