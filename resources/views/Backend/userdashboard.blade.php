@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="box box-default">
         <div class="box-header with-border">
           <h3 class="box-title">User Dashboard</h3>
              <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
           </div>
         </div>
         {{-- @php
         if(Auth::check()){
        $user = Auth::user();
        $user_name = $user->name;
      }
      else{
          return redirect('login');
      } --}}
            
        {{-- @endphp --}}
        
         <div class="box-body">
           <div class="row"> 
               <div class="welcome-card">
                  {{-- <h4>Welcome {{$user_name}}</h4> --}}
               </div>
           </div>
         </div>
        
       </div>
     </section>
@endsection
