@extends('Backend.admin_master')
@section('main-content')
<section class="content">
        <div class="row">
            <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                <h3 class="box-title">Payable Transport Bill list</h3>
                   <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                    </div>
                <div class="box-body">
                <table id="example3" class="table table-bordered table-striped ajaxprependteam">
                    <thead>
                        <tr>
                        <th>Submited date</th>
                        <th>Project Name</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($payableBilllist as $payable)
                            <tr>
                                <td>{{$payable->created_at}}</td>
                                <td>
                                {{$payable->project_name == null ? 'Genaral' : $payable->project_name}}
                                </td>
                                <td>{{$payable->total}} Tk</td>
                                <td>{{$payable->status}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$payable->unq_id}}" class="showbill"><span class="glyphicon glyphicon-eye-open btn btn-info btn-sm"></span></a>
                                    
                                    <a data-toggle="modal" data-target="#billModal" data-unqid ="{{$payable->unq_id}}" class="showbill"><span class="btn btn-success btn-sm">QR</span></a>
                                  
                                </td>
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
        <div class="modal fade" id="billModal" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Bill Details</h4>
                    </div>
                    <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20%">Date</th>
                                        <th width="15%">From</th>
                                        <th width="15%">To</th>
                                        <th width="15%">Mode</th>
                                        <th width="20%">Purpose</th>
                                        <th width="15%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="billinfo">
        
                                </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
    </section>
    <script>
$(document).on('click','.showbill',function(){
var unq_id = $(this).data('unqid');

$.get('getallbillinfoByid/'+unq_id,function(data){
$('.billinfo').empty();
$.each(data,function(index, billInfo){
    
    $('.billinfo').append(`<tr class="item_tr single_list">
                    <td><input type="text" class="form-control"  value="`+billInfo.date+`" readonly></td>
                    <td><input type="text" class="form-control from" value="`+billInfo.from+`" readonly><br></td>
                    <td><input type="text" class="form-control"  value="`+billInfo.to+`" readonly><br></td>
                    <td><input type="text" class="form-control"  value="`+billInfo.mode+`" readonly><br></td>
                    <td><input type="text" class="form-control" value="`+billInfo.purpose+`" readonly><br></td>
                    <td><input type="number" class="form-control" value="`+billInfo.amount+`" readonly><br></td>
                </tr>`)
})
//$('.modal-body').replaceWith('blabla');
console.log(data);
    })
})
</script>
@endsection