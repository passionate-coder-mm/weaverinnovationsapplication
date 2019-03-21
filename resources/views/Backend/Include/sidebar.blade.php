 <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        @if(Auth::user()->role == 1 || Auth::user()->role == 2 )
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Initial Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('user_options.index')}}"><i class="fa fa-circle-o"></i> User Options</a></li>
            <li><a href="{{route('role_options.index')}}"><i class="fa fa-circle-o"></i> Role Options</a></li>
            <li><a href="{{route('department_options.index')}}"><i class="fa fa-circle-o"></i> Department Options</a></li>
            <li><a href="{{route('designation_options.index')}}"><i class="fa fa-circle-o"></i> Desigantion Options</a></li>
            <li><a href="{{route('team_options.index')}}"><i class="fa fa-circle-o"></i> Team Options</a></li>

          </ul>
        </li>
        @endif
        {{-- <li>
          <a href="">
            <i class="fa fa-th"></i> <span>User</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
            <a href="">
              <i class="fa fa-th"></i> <span>Role</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <li>
          <a href="">
            <i class="fa fa-th"></i> <span>Department</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
          <a href="">
            <i class="fa fa-th"></i> <span>Designation</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li>
            <a href="">
              <i class="fa fa-th"></i> <span>Team Creation</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <li>
            <a href="">
              <i class="fa fa-th"></i> <span>Team</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
          <li>
          <a href ="">
               <i class="fa fa-th"></i> <span>Attendance</span>
                <span class="pull-right-container">
              </span>
            </a>  
          </li>
          <li>
            <a href ="">
                  <i class="fa fa-th"></i> <span>Attendance View</span>
                  <span class="pull-right-container">
                </span>
              </a>  
          </li> --}}
      </ul>
    </section>
  </aside>