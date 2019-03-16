@extends('layouts.app')

@section('content')
@if(Auth::user()->role == 1)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">AdminDashboard</div>

                <div class="card-body">
                 
                        <div class="alert alert-success" role="alert">
                           
                        </div>
                    

                    You are logged in - {{Auth::user()->name}}!
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
