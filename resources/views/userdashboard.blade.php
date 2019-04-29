@extends('layouts.app')

@section('content')
@php
 if(Auth::check()){
         $user = Auth::user();
         $user_role = $user->role;
         $user_name = $user->name;
       }
       else{
           return redirect('login');
       }
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">UserDashboard</div>

                <div class="card-body">
                   You are logged in - {{$user_name}}!!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
