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
@if($user_role == 1)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">AdminDashboard</div>

                <div class="card-body">
                 
                        <div class="alert alert-success" role="alert">
                           
                        </div>
                    

                    You are logged in - {{$user_name}}!
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
