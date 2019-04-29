@extends('Backend.admin_master')
@section('main-content')
<section class="content">
 <div class="box box-info">
     @php
      if(Auth::check()){
         $user = Auth::user();
         $user_role = $user->role;
         //dd($find_single_advancesettle);
       }
       else{
           return redirect('login');
       }
       
     @endphp
                 <div class="box-header with-border">
                 <h3 class="box-title">Advance SettleMent</h3>
                     <div class="box-tools pull-right">
                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                     <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                 </div>
                 </div>
                 {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'cashdetailform'])!!}
                       
                 <div class="box-body">
                        <div class="box-header with-border">
                         <div class="form-group proname">
                            <div class="col-sm-12">
                               <input type="hidden" class="form-control" id="userid" name="user_id" value="">
                           </div>
                        </div>
                    </div>
                    <div class="list" data-index_no="0">
                        <div class="itemWrapper">
                            <table class="table table-bordered moreTable">
                                <tr>
                                    <th width="15%">Date</th>
                                    <th width="15%">Sender</th>
                                    <th width="20%">Project Name</th>
                                    <th width="15%">Cash Voucher Type</th>
                                    <th width="20%">Description</th>
                                    <th width="15%">Amount</th>
                                </tr>
                                @php $total = 0; @endphp
                                 @foreach($find_single_advancesettle as $single_bill)
                                <tr class="item_tr single_list">
                                <td><input type="text" class="form-control" readonly value="{{$single_bill->date}}"></td>
                                <td><input type="text" class="form-control" readonly value="{{$single_bill->name}}"></td>
                                    <td><input type="text" class="form-control" readonly value="{{$single_bill->project_name}}"><br></td>
                                    <td><input type="text" class="form-control" readonly value="{{$single_bill->type}}" ><br></td>
                                    <td><textarea type="text" class="form-control" readonly>{{$single_bill->description}}</textarea><br></td>
                                    <td><input type="number" class="form-control" readonly value="{{$single_bill->advance_expense}}"><br></td>
                                </tr>
                                <?php $total += $single_bill->advance_expense ?>
                                @endforeach
                                <tr><td></td><td></td><td></td><td></td><td></td><td><input type="text" class="form-control amount" readonly value="Total :- {{$total}} TK"><br></td></tr>
        
                            </table>
                        </div>
                    </div>
                     
                 </div>
                 <div class="box-footer">
                @if($user_role==8)
                <button type="button" class="btn btn-success"  data-role="{{$user_role}}"  data-unqid="{{$first_item->unq_id}}">QR</button>
                @else
                 <button type="button" class="btn btn-info approveexpense"  data-role="{{$user_role}}" data-notifiable="{{$first_item->notifiable_id}}" data-unqid="{{$first_item->anotherunq_id}}">Approve</button>
                 <button type="button" data-unqid="{{$first_item->anotherunq_id}}" class="btn btn-warning reviewexpense">Review</button>
                 @endif
            </div>
             {!!Form::close()!!}
             </div>
         </section>
<script>
$(document).on('click','.approveexpense',function(){
    var unqid=$(this).data('unqid');
    var notifiable = $(this).data('notifiable');
    var role = $(this).data('role');
    $.get('/cash/approveexpense/'+unqid+'/'+notifiable+'/'+role,function(data){
    toastr.options = {
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 3000
            };
        toastr.success('Expense Request was approved successfully');
        window.location.href = '/admin-dashboard'; 
        console.log(data);
   })
 });
$(document).on('click','.reviewexpense',function(e){
    e.preventDefault;
    var unq_id = $(this).data('unqid');
    $.get('/cash/sendexpenseforreview/'+unq_id,function(data){
        toastr.options = {
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 3000
            };
        toastr.success('You have sent it successfully for reviewing');
        window.location.href = '/admin-dashboard'; 

    })
})
</script>
@endsection