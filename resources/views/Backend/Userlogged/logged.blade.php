@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Login Activity</h3>
             <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
             </div>
          <div class="box-body">
            <table id="example3" class="table table-bordered table-striped ajaxprependrole">
              <thead>
               
               <tr>
                <th width="20%">User Name</th>
                <th width="40%">User Agent</th>
                <th width="20%">User IP</th>
                <th width="20%">Login Time</th>
              </tr>
            
              </thead>
              <tbody>
             @foreach ($logged_users as $logged_user)
              <tr>
                <td>{{$logged_user->user_name}}</td>
                <td>{{$logged_user->user_agent}}</td>
                <td>{{$logged_user->ip_address}}</td>
                <td>{{$logged_user->created_at}}</td>
             </tr>
             @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
@endsection