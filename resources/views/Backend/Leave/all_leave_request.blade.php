@extends('Backend.admin_master')
@section('main-content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
            <h3 class="box-title">Team List</h3>
               <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                </div>
            <div class="box-body">
            <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>Name</th>
                <th>Request Type</th>
                <th>Cause</th>
                <th>Submitted At</th>
                <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_request_by_id as $single_request)
                <tr>
                <td>{{$single_request->name}}</td>
                <td>{{$single_request->purpose}}</td>
                <td>{{$single_request->cause}}</td>
                <td>{{$single_request->created_at}}</td>
                <td>
                    <a class="team-view"  data-toggle="modal" data-target="#modal-team-view" ><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                     @if($single_request->leaveapproval =="yes" || $single_request->lateearlyapprove =="yes")
                      <a   class="btn btn-success btn-sm"  data-target="#edit-team">Approved</a>
                      @else
                      <a class="btn btn-warning btn-sm">Pending</a>
                    @endif
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
</section>
@endsection