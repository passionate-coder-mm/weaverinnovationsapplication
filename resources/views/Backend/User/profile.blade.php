@extends('Backend.admin_master')
@section('main-content')
<section class="content-header">
        <h1>
          User Profile
        </h1>
      </section>
      <section class="content">
          <div class="row">
              <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                  <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{url('/'.$slug->image)}}" alt="User profile picture" width="128" height="128">
      
                     <h3 class="profile-username text-center">{{$slug->name}}</h3>
                    <p class="text-muted text-center">Designation:{{$slug->designation}}</p>
                    <p class="text-muted text-center">Employee Id :{{$slug->office_id}}</p>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
      
                <!-- About Me Box -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">About Me</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
      
                    <p class="text-muted">
                      B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>
      
                    <hr>
      
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
      
                    <p class="text-muted">Malibu, California</p>
      
                    <hr>
                    <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                     <p>
                      <span class="label label-danger">UI Design</span>
                      <span class="label label-success">Coding</span>
                      <span class="label label-info">Javascript</span>
                      <span class="label label-warning">PHP</span>
                      <span class="label label-primary">Node.js</span>
                    </p>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <!-- Post -->
                      <div class="post">
                        <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="{{url('/'.$slug->image)}}" alt="user image">
                              <span class="username">
                                <a href="#">{{$slug->name}}</a>
                                <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                              </span>
                         
                        </div>
                        <!-- /.user-block -->
                        <p>
                          Lorem ipsum represents a long-held tradition for designers,
                          typographers and the like. Some people hate it and argue for
                          its demise, but others ignore the hate as they create awesome
                          tools to help create filler text for everyone from bacon lovers
                          to Charlie Sheen fans.
                        </p>
                        
                      </div>
                    
                  </div>
                 
                </div>
               
              </div>
             
            </div>
          </section>
@endsection