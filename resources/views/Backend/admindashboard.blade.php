@extends('Backend.admin_master')
@section('main-content')
@if(Auth::user()->role == 1 || Auth::user()->role == 2)
<section class="content">
    <div class="box box-default">
         <div class="box-header with-border">
           <h3 class="box-title">Admin Dashboard</h3>
              <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
           </div>
         </div>
        
         <div class="box-body">
           <div class="row"> 
               <div class="welcome-card">
                  <h4>Welcome {{Auth::user()->name}}</h4>
               </div>
           </div>
         </div>
        
       </div>
     </section>
@endif
@endsection
