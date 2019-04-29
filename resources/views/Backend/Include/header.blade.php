<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/admin-dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="{{url('images/img1.png')}}" width="150" height="50"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
           
              <div id="app"> 
                    <notifications  v-bind:allnotifications="allnotifications"></notifications>
              </div>
          
          </ul>
        <ul class="nav navbar-nav">
         @php
         use Carbon\Carbon;
         use App\Billnotification;
          if(Auth::check()){
         $user = Auth::user();
         $user_name = $user->name;
         $user_role = $user->role;
         $user_img =  $user->image; 
         $user_id =  $user->id; 
         $user_uniq= $user->slug;
       }
       else{
           return redirect('login');
       }
       $data = [];
       $data['manager_message_count'] = Billnotification::where('notifiable_id','=',$user_id)->where('read_at','=','no')->get();
       $data['manager_message'] = DB::select(DB::raw("SELECT users.name,users.image,conveyance_vouchers.project_name,conveyance_vouchers.unq_id,conveyance_vouchers.review,conveyance_vouchers.created_at,SUM(conveyance_vouchers.amount) AS total
                                      FROM conveyance_vouchers
                                      LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                      WHERE conveyance_vouchers.notifiable_id = $user_id AND conveyance_vouchers.read_at ='no'
                                      GROUP BY(conveyance_vouchers.unq_id)"));
       $data['manager_messageforcash'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,cashvouchers.unq_id,cashvouchers.review,cashvouchers.created_at,SUM(cashvouchers.amount) AS total
                                      FROM cashvouchers
                                      LEFT JOIN users ON cashvouchers.user_id = users.id
                                      LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                      WHERE cashvouchers.notifiable_id = $user_id AND cashvouchers.read_at ='no'
                                      GROUP BY(cashvouchers.unq_id)"));
      $data['manager_messageforcashespense'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,expenseadvances.unq_id,expenseadvances.anotherunq_id,expenseadvances.review,expenseadvances.created_at,SUM(expenseadvances.advance_expense) AS total
                                      FROM expenseadvances
                                      LEFT JOIN users ON expenseadvances.user_id = users.id
                                      LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                      WHERE expenseadvances.notifiable_id = $user_id AND expenseadvances.read_at ='no'
                                      GROUP BY(expenseadvances.anotherunq_id)"));

       $data['ceo_message_count'] = Billnotification::where('notifiable_id','=',$user_id)->where('read_at','=','ceono')->get();
       $data['ceo_message'] = DB::select(DB::raw("SELECT users.name,users.image,conveyance_vouchers.project_name,conveyance_vouchers.review,conveyance_vouchers.unq_id,conveyance_vouchers.created_at,SUM(conveyance_vouchers.amount) AS total
                                      FROM conveyance_vouchers
                                      LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                      WHERE conveyance_vouchers.notifiable_id = $user_id AND conveyance_vouchers.read_at ='no'
                                      GROUP BY(conveyance_vouchers.unq_id)"));
      $data['ceo_messageforcash'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,cashvouchers.unq_id,cashvouchers.review,cashvouchers.created_at,SUM(cashvouchers.amount) AS total
                                      FROM cashvouchers
                                      LEFT JOIN users ON cashvouchers.user_id = users.id
                                      LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                      WHERE cashvouchers.notifiable_id = $user_id AND cashvouchers.read_at ='no'
                                      GROUP BY(cashvouchers.unq_id)"));
      $data['ceo_messageforcashespense'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,expenseadvances.unq_id,expenseadvances.anotherunq_id,expenseadvances.review,expenseadvances.created_at,SUM(expenseadvances.advance_expense) AS total
                                      FROM expenseadvances
                                      LEFT JOIN users ON expenseadvances.user_id = users.id
                                      LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                      WHERE expenseadvances.notifiable_id = $user_id AND expenseadvances.read_at ='no'
                                      GROUP BY(expenseadvances.unq_id)"));
        $data['cfo_message_count'] = Billnotification::where('notifiable_id','=',$user_id)->where('read_at','=','cfono')->get();
       $data['cfo_message'] = DB::select(DB::raw("SELECT users.name,users.image,conveyance_vouchers.project_name,conveyance_vouchers.review,conveyance_vouchers.unq_id,conveyance_vouchers.created_at,SUM(conveyance_vouchers.amount) AS total
                                      FROM conveyance_vouchers
                                      LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                      WHERE conveyance_vouchers.notifiable_id = $user_id AND conveyance_vouchers.read_at ='no'
                                      GROUP BY(conveyance_vouchers.unq_id)"));
        $data['cfo_messageforcash'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,cashvouchers.unq_id,cashvouchers.review,cashvouchers.created_at,SUM(cashvouchers.amount) AS total
                                      FROM cashvouchers
                                      LEFT JOIN users ON cashvouchers.user_id = users.id
                                      LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                      WHERE cashvouchers.notifiable_id = $user_id AND cashvouchers.read_at ='no'
                                      GROUP BY(cashvouchers.unq_id)"));
        $data['cfo_messageforcashespense'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,expenseadvances.unq_id,expenseadvances.anotherunq_id,expenseadvances.review,expenseadvances.created_at,SUM(expenseadvances.advance_expense) AS total
                                      FROM expenseadvances
                                      LEFT JOIN users ON expenseadvances.user_id = users.id
                                      LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                      WHERE expenseadvances.notifiable_id = $user_id AND expenseadvances.read_at ='no'
                                      GROUP BY(expenseadvances.unq_id)"));
          $data['acc_message_count'] = Billnotification::where('notifiable_id','=',0)->where('read_at','=','no')->get();
          $data['acc_message'] = DB::select(DB::raw("SELECT users.name,users.image,conveyance_vouchers.project_name,conveyance_vouchers.review,conveyance_vouchers.unq_id,conveyance_vouchers.created_at,SUM(conveyance_vouchers.amount) AS total
                                      FROM conveyance_vouchers
                                      LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                      WHERE conveyance_vouchers.notifiable_id = 0 AND conveyance_vouchers.read_at ='no'
                                      GROUP BY(conveyance_vouchers.unq_id)"));
          $data['acc_messageforcash'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,cashvouchers.unq_id,cashvouchers.review,cashvouchers.created_at,SUM(cashvouchers.amount) AS total
                                      FROM cashvouchers
                                      LEFT JOIN users ON cashvouchers.user_id = users.id
                                      LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                      WHERE cashvouchers.notifiable_id = 0 AND cashvouchers.read_at ='no'
                                      GROUP BY(cashvouchers.unq_id)"));
          $data['acc_messageforcashespense'] = DB::select(DB::raw("SELECT users.name,users.image,projectnames.project_name,expenseadvances.unq_id,expenseadvances.anotherunq_id,expenseadvances.review,expenseadvances.created_at,SUM(expenseadvances.advance_expense) AS total
                                      FROM expenseadvances
                                      LEFT JOIN users ON expenseadvances.user_id = users.id
                                      LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                      WHERE expenseadvances.notifiable_id = 0 AND expenseadvances.read_at ='no'
                                      GROUP BY(expenseadvances.unq_id)"));

       @endphp    
        
         @if($user_role == 3)
         <li class="dropdown messages-menu">
         <a href="#" class="dropdown-toggle notificationcount" data-userrole="{{$user_role}}" data-userid="{{$user_id}}" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success messagecount">{{count($data['manager_message_count'])}}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have {{count($data['manager_message_count'])}} messages</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                @foreach($data['manager_message'] as $message)
                <li>
                 
                <a href="{{url('transport/singlemessage/'.$message->unq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$message->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $message->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($message->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$message->project_name}}</p>
                  <p>Total: {{$message->total}} TK</p>
                  <p>Voucher Type: Transport</p>
                  <p>
                    Status:
                  @if($message->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($message->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                @foreach( $data['manager_messageforcash'] as $cashmessage)
                <li>
                <a href="{{url('cash/singlemessage/'.$cashmessage->unq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashmessage->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashmessage->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashmessage->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashmessage->project_name}}</p>
                  <p>Total: {{$cashmessage->total}} TK</p>
                  <p>Voucher Type: Cash</p>
                  <p>
                    Status:
                  @if($cashmessage->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashmessage->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                @foreach($data['manager_messageforcashespense'] as $cashexpense)
                <li>
                <a href="{{url('cash/singlemessageforexpense/'.$cashexpense->anotherunq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashexpense->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashexpense->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashexpense->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashexpense->project_name}}</p>
                  <p>Total: {{$cashexpense->total}} TK</p>
                  <p>Voucher Type: Advance Settle</p>
                  <p>
                    Status:
                  @if($cashexpense->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashexpense->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                <!-- end message -->
              </ul>
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li>
        @elseif($user_role == 6)
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle notificationcount" data-userrole="{{$user_role}}" data-userid="{{$user_id}}" data-toggle="dropdown">
             <i class="fa fa-envelope-o"></i>
             <span class="label label-success messagecount">{{count($data['ceo_message_count'])}}</span>
           </a>
           <ul class="dropdown-menu">
             <li class="header">You have {{count($data['ceo_message_count'])}} messages</li>
             <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                 @foreach($data['ceo_message'] as $ceo)
                 <li><!-- start message -->
                 <a href="{{url('transport/singlemessage/'.$ceo->unq_id)}}">
                     <div class="pull-left">
                       <img src="{{url('/'.$ceo->image)}}" class="img-circle" alt="User Image">
                     </div>
                     <h4>
                      {{ $ceo->name}}
                       <small><i class="fa fa-clock-o"></i> <?php
                          $date = Carbon::parse($ceo->created_at);
                           $dat_pro =  $date->diffForHumans(Carbon::now());
                          echo $dat_pro;
                        ?></small>
                     </h4>
                     <p>Project Name:- {{$ceo->project_name}} TK</p>
                     <p>Total:- {{$ceo->total}} TK</p>
                     <p>
                       Status:
                     @if($ceo->review=='yes')
                     <span class="reviewing">Reviewing</span>
                     @elseif($ceo->review=='reviwed')
                     <span class="reviewed">Reviewed</span>
                     @endif
                     </p>
                   </a>
                 </li>
                 @endforeach
                 @foreach( $data['ceo_messageforcash'] as $cashmessage)
                <li>
                <a href="{{url('cash/singlemessage/'.$cashmessage->unq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashmessage->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashmessage->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashmessage->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashmessage->project_name}}</p>
                  <p>Total: {{$cashmessage->total}} TK</p>
                  <p>Voucher Type: Cash</p>
                  <p>
                    Status:
                  @if($cashmessage->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashmessage->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                @foreach($data['ceo_messageforcashespense'] as $cashexpense)
                <li>
                <a href="{{url('cash/singlemessageforexpense/'.$cashexpense->anotherunq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashexpense->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashexpense->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashexpense->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashexpense->project_name}}</p>
                  <p>Total: {{$cashexpense->total}} TK</p>
                  <p>Voucher Type: Advance Settle</p>
                  <p>
                    Status:
                  @if($cashexpense->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashexpense->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                 <!-- end message -->
               </ul>
             </li>
             <li class="footer"><a href="#">See All Messages</a></li>
           </ul>
         </li>
         @elseif($user_role == 7)
         <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle notificationcount" data-userrole="{{$user_role}}" data-userid="{{$user_id}}" data-toggle="dropdown">
             <i class="fa fa-envelope-o"></i>
             <span class="label label-success messagecount">{{count($data['cfo_message_count'])}}</span>
           </a>
           <ul class="dropdown-menu">
             <li class="header">You have {{count($data['cfo_message_count'])}} messages</li>
             <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                 @foreach($data['cfo_message'] as $cfo)
                 <li><!-- start message -->
                 <a href="{{url('transport/singlemessage/'.$cfo->unq_id)}}">
                     <div class="pull-left">
                       <img src="{{url('/'.$cfo->image)}}" class="img-circle" alt="User Image">
                     </div>
                     <h4>
                      {{ $cfo->name}}
                       <small><i class="fa fa-clock-o"></i> <?php
                          $date = Carbon::parse($cfo->created_at);
                           $dat_pro =  $date->diffForHumans(Carbon::now());
                          echo $dat_pro;
                        ?></small>
                     </h4>
                     <p>Project Name:- {{$cfo->project_name}} TK</p>
                     <p>Total:- {{$cfo->total}} TK</p>
                     <p>
                       Status:
                     @if($cfo->review=='yes')
                     <span class="reviewing">Reviewing</span>
                     @elseif($cfo->review=='reviwed')
                     <span class="reviewed">Reviewed</span>
                     @endif
                     </p>
                   </a>
                 </li>
                 @endforeach
                 @foreach( $data['cfo_messageforcash'] as $cashmessage)
                <li>
                <a href="{{url('cash/singlemessage/'.$cashmessage->unq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashmessage->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashmessage->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashmessage->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashmessage->project_name}}</p>
                  <p>Total: {{$cashmessage->total}} TK</p>
                  <p>Voucher Type: Cash</p>
                  <p>
                    Status:
                  @if($cashmessage->review =='yes')
                   <small class="reviewing">Reviewing</small>
                  @elseif($cashmessage->review=='reviwed')
                    <small class="reviewed">Reviewed</small>
                   @else
                    <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                @foreach($data['cfo_messageforcashespense'] as $cashexpense)
                <li>
                <a href="{{url('cash/singlemessageforexpense/'.$cashexpense->anotherunq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashexpense->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashexpense->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashexpense->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashexpense->project_name}}</p>
                  <p>Total: {{$cashexpense->total}} TK</p>
                  <p>Voucher Type: Advance Settle</p>
                  <p>
                    Status:
                  @if($cashexpense->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashexpense->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                 <!-- end message -->
               </ul>
             </li>
             <li class="footer"><a href="#">See All Messages</a></li>
           </ul>
         </li>
         @elseif($user_role == 8)
         <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle notificationcount" data-userrole="{{$user_role}}" data-userid="{{$user_id}}" data-toggle="dropdown">
             <i class="fa fa-envelope-o"></i>
             <span class="label label-success messagecount">{{count($data['acc_message_count'])}}</span>
           </a>
           <ul class="dropdown-menu">
             <li class="header">You have {{count($data['acc_message_count'])}} messages</li>
             <li>
               <!-- inner menu: contains the actual data -->
               <ul class="menu">
                 @foreach($data['acc_message'] as $acc)
                 <li><!-- start message -->
                 <a href="{{url('transport/singlemessage/'.$acc->unq_id)}}">
                     <div class="pull-left">
                       <img src="{{url('/'.$acc->image)}}" class="img-circle" alt="User Image">
                     </div>
                     <h4>
                      {{ $acc->name}}
                       <small><i class="fa fa-clock-o"></i> <?php
                          $date = Carbon::parse($acc->created_at);
                           $dat_pro =  $date->diffForHumans(Carbon::now());
                          echo $dat_pro;
                        ?></small>
                     </h4>
                     <p>Project Name:- {{$acc->project_name}} TK</p>
                     <p>Total:- {{$acc->total}} TK</p>
                     <p>
                       Status:
                     @if($acc->review=='yes')
                     <span class="reviewing">Reviewing</span>
                     @elseif($acc->review=='reviwed')
                     <span class="reviewed">Reviewed</span>
                     @endif
                     </p>
                   </a>
                 </li>
                 @endforeach
                 @foreach( $data['acc_messageforcash'] as $cashmessage)
                <li>
                <a href="{{url('cash/singlemessage/'.$cashmessage->unq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashmessage->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashmessage->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashmessage->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashmessage->project_name}}</p>
                  <p>Total: {{$cashmessage->total}} TK</p>
                  <p>Voucher Type: Cash</p>
                  <p>
                    Status:
                  @if($cashmessage->review =='yes')
                   <small class="reviewing">Reviewing</small>
                  @elseif($cashmessage->review=='reviwed')
                    <small class="reviewed">Reviewed</small>
                   @else
                    <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                @foreach($data['acc_messageforcashespense'] as $cashexpense)
                <li>
                <a href="{{url('cash/singlemessageforexpense/'.$cashexpense->anotherunq_id)}}">
                    <div class="pull-left">
                      <img src="{{url('/'.$cashexpense->image)}}" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                     {{ $cashexpense->name}}
                      <small><i class="fa fa-clock-o"></i> <?php
                         $date = Carbon::parse($cashexpense->created_at);
                          $dat_pro =  $date->diffForHumans(Carbon::now());
                         echo $dat_pro;
                       ?></small>
                    </h4>
                    <p>Project Name: {{$cashexpense->project_name}}</p>
                  <p>Total: {{$cashexpense->total}} TK</p>
                  <p>Voucher Type: Advance Settle</p>
                  <p>
                    Status:
                  @if($cashexpense->review =='yes')
                  <small class="reviewing">Reviewing</small>
                  @elseif($cashexpense->review=='reviwed')
                   <small class="reviewed">Reviewed</small>
                   @else
                   <small class="reviewed">Pending</small>
                   @endif
                  </p>
                  </a>
                </li>
                @endforeach
                 <!-- end message -->
               </ul>
             </li>
             <li class="footer"><a href="#">See All Messages</a></li>
           </ul>
         </li>
        @endif
        
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{url('/'.$user_img)}}" class="user-image" alt="User Image">
              <span class="hidden-xs"> {{$user_name}}</span>
            </a>
            <ul class="dropdown-menu">
             
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('/'.$user_img)}}" class="img-circle" alt="User Image">

                <p style="text-align:center">
                  {{$user_name}}
                 
                </p>
              </li>
              
              <li class="user-footer">
                <div class="pull-left">
                <a href="{{url('userprofile/'.$user_uniq)}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                        <a class="dropdown-item btn btn-default btn-flat" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                     </a>

                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    
    <script>
      $(document).on('click','.notificationcount',function(){
        $('.messagecount').text('0');
        var userid = $(this).data('userid');
        var userrole = $(this).data('userrole');
        $.get('/transport/makemessagezero/'+userid+'/'+userrole,function(data){
          
          console.log(data);
        })
        //alert(userrole);
      })
      </script>
  </header>
