@extends('Backend.admin_master')
@section('main-content')
<section class="content">
 <div class="box box-info">
     @php
      if(Auth::check()){
         $user = Auth::user();
         $user_role = $user->role;
        
       }
       else{
           return redirect('login');
       }
       
     @endphp
                 <div class="box-header with-border">
                 <h3 class="box-title">Conveyance Detail Bill</h3>
                     <div class="box-tools pull-right">
                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                     <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                 </div>
                 </div>
                 {!!Form::open(['method' => 'POST','class' => 'form-horizontal', 'id'=>'conveyancedetailform'])!!}
                       
                 <div class="box-body">
                        <div class="box-header with-border">
                         <div class="form-group proname">
                            <div class="col-sm-12">
                                @if($first_item->project_name==null)
                                   <span>Genaral</span>
                                   @else
                                <input type="text" class="form-control" id="projectname" name="project_name" value="{{$first_item->project_name}}">
                               <input type="hidden" class="form-control" id="userid" name="user_id" value="">
                               @endif
        
                            </div>
                        </div>
                    </div>
                    <div class="list" data-index_no="0">
                        <div class="itemWrapper">
                            <table class="table table-bordered moreTable">
                                <tr>
                                    <th width="15%">Date</th>
                                    <th width="15%">From</th>
                                    <th width="15%">To</th>
                                    <th width="15%">Mode</th>
                                    <th width="15%">Purpose</th>
                                    <th width="15%">Amount</th>
                                </tr>
                                @php $total = 0; @endphp
                                 @foreach($find_single_bill as $single_bill)
                                <tr class="item_tr single_list">
                                <td><input type="text" class="form-control mydatepicker date" readonly value="{{$single_bill->date}}"></td>
                                    <td><input type="text" class="form-control from" readonly value="{{$single_bill->from}}"><br></td>
                                    <td><input type="text" class="form-control to" readonly value="{{$single_bill->to}}" ><br></td>
                                    <td><input type="text" class="form-control mode" readonly value="{{$single_bill->mode}}"><br></td>
                                    <td><input type="text" class="form-control purpose" readonly value="{{$single_bill->purpose}}"><br></td>
                                    <td><input type="number" class="form-control amount" readonly value="{{$single_bill->amount}}"><br></td>
                                </tr>
                                <?php $total += $single_bill->amount ?>
                                @endforeach
                                <tr><td></td><td></td><td></td><td></td><td></td><td><input type="text" class="form-control amount" readonly value="Total :- {{$total}} TK"><br></td></tr>
        
                            </table>
                        </div>
                    </div>
                     
                 </div>
                 <div class="box-footer">
                     @if($user_role==8)
                     <button type="button" class="btn btn-success"  data-role="{{$user_role}}" data-notifiable="{{$first_item->notifiable_id}}" data-unqid="{{$first_item->unq_id}}">QR</button>
                      @else
                     <button type="button" class="btn btn-info approveconveyance"  data-role="{{$user_role}}" data-notifiable="{{$first_item->notifiable_id}}" data-unqid="{{$first_item->unq_id}}">Approve</button>
                     <button type="button" data-unqid="{{$first_item->unq_id}}" class="btn btn-warning review">Review</button>
                     @endif
                 </div>
             {!!Form::close()!!}
             </div>
         </section>
<script>
$(document).on('click','.approveconveyance',function(){
    var unqid=$(this).data('unqid');
    var notifiable = $(this).data('notifiable');
    var role = $(this).data('role');
    $.get('/transport/approveconveyancebymng/'+unqid+'/'+notifiable+'/'+role,function(data){
    toastr.options = {
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 3000
            };
        toastr.success('Bill was approved successfully');
        window.location.href = '/admin-dashboard'; 
        console.log(data);
   })
 });
$(document).on('click','.review',function(e){
    e.preventDefault;
    var unq_id = $(this).data('unqid');
    $.ajax({
        url: "{!! route('transsend.review') !!}",
        type: "get", 
        data: {  
            unq_id: unq_id
        },
        success: function(daa) {
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
        }
       
    });
})
</script>
@endsection