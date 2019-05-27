 <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
          @php
        if(Auth::check()){
         $user = Auth::user();
         $user_role = $user->role;
       }
       else{
           return redirect('login');
       }
             
         @endphp 
        @if($user_role == 1 || $user_role == 2 || $user_role == 3 )
        <li class="treeview active menu-open">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Initial Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('user_options.index')}}"><i class="fa fa-user"></i> User Options</a></li>
            <li><a href="{{route('role_options.index')}}"><i class="fa fa-circle-o"></i> Role Options</a></li>
            <li><a href="{{route('department_options.index')}}"><i class="fa fa-circle-o"></i> Department Options</a></li>
            <li><a href="{{route('designation_options.index')}}"><i class="fa fa-circle-o"></i> Desigantion Options</a></li>
            <li><a href="{{route('team_options.index')}}"><i class="fa fa-circle-o"></i> Team Options</a></li>
            <li><a href="{{route('holyday-option.index')}}"><i class="fa fa-circle-o"></i>Holyday Option</a></li>
            <li><a href="{{url('user/loginhistory')}}"><i class="fa fa-circle-o"></i> Login History</a></li>
          </ul>
        </li>
        @endif 
      </ul>
       <ul class="sidebar-menu" data-widget="tree">
          {{-- @if($user_role == 1 || $user_role == 2 ) --}}
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Attendance Options</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right"></span>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{route('attendance.index')}}"><i class="fa fa-circle-o"></i> Attendance Info</a></li>
              <li><a href="{{url('attendances/attendancefilter')}}"><i class="fa fa-circle-o"></i>Attendance Filter</a></li>
              @if($user_role != 5)
              <li><a href="{{url('attendances/datewisecompleteattendance')}}"><i class="fa fa-circle-o"></i>Attendance Summary</a></li>
              @endif
           </ul>
          </li>
          {{-- @endif --}}
        </ul>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Leave Request Options</span>
                <span class="pull-right-container">
                  <span class="label label-primary pull-right"></span>
                </span>
              </a>
              <ul class="treeview-menu">
              <li><a href="{{route('leave_options.index')}}"><i class="fa fa-circle-o"></i>Request Form</a></li>
             </ul>
            </li>
           </ul>
           <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>VAS</span>
                <span class="pull-right-container">
                  <span class="label label-primary pull-right"></span>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('transport-voucher.index')}}"><i class="fa fa-circle-o"></i>Transport/Conveyance</a></li>
                {{-- <li><a href="{{route('transport-voucher.index')}}"><i class="fa fa-circle-o"></i>Approval List</a></li> --}}
                <li><a href="{{route('cash-voucher.index')}}"><i class="fa fa-circle-o"></i>Cash Payment</a></li>
                <li><a href="{{route('transaction.scane')}}"><i class="fa fa-circle-o"></i>Transaction</a></li>
                <li><a href="{{route('transaction.helper')}}"><i class="fa fa-circle-o"></i>Transaction Helper</a></li>

              </ul>
            </li>
           </ul>
    </section>
  </aside>