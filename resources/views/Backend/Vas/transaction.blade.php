@extends('Backend.admin_master')
@section('main-content')
<section class="content">
        <div class="box box-info">
            <div class="row">
                <div class="col-sm-8">
                        <video id="preview"></video>
                </div>
                <div class="col-sm-4 billinfo" style="padding-top:10px;display:none">
                  <h3>Bill Info will go here</h3>
                  <li>Username: <span class="uname"></span></li>
                  <li>Project Name : <span class="pname"></span></li>
                  <li>Type : <span class="ttype"></span></li>
                  <li class="hideadvance" style="display: none">Total Advance : <span class="tadvance"></span></li>
                  <li>Total Expense : <span class="tamount"></span></li>
                  <li>Todays cash : <span class="dailycash"></span></li><br>
                  <div class="ancorapp"></div>
                </div>
            </div>
                
        </div>
<script>
    let scanner = new Instascan.Scanner(
        {
            video: document.getElementById('preview')
        }
    );
    scanner.addListener('scan', function(content) {
        // alert('Do you want to open this page?: ' + content);
        $('.ancorapp').empty();
    $.ajax({
        url: "{!! route('transaction.qrcodeinfo') !!}",
        type: "get", 
        data: { 
            content: content, 
            
        },
        success: function(data) {
            if(data[0].success =='yes'){
                $('.billinfo').css('display','block');
                $('.billinfo .uname').text(data[0].name)
                $('.billinfo .pname').text(data[0].project_name)
                $('.billinfo .ttype').text(data[0].type)
                if(data[0].type=='advanceexpense'){
                 $('.hideadvance').css('display','block');
                 $('.billinfo .tadvance').text(data[0].advance_amount)

                }
                $('.billinfo .tamount').text(data[0].total)
                $('.billinfo .dailycash').text(data[1].cash_amount)

            toastr.options = {
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "fadeIn": 300,
                        "fadeOut": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 3000
                      };
                toastr.warning('The bill was paid before');
        }else{
                $('.billinfo').css('display','block');
                $('.billinfo .uname').text(data[0].name)
                $('.billinfo .pname').text(data[0].project_name)
                $('.billinfo .ttype').text(data[0].type)
                if(data[0].type=='advanceexpense'){
                 $('.hideadvance').css('display','block');
                 $('.billinfo .tadvance').text(data[0].advance_amount)

                }else{
                    $('.hideadvance').css('display','none');
 
                }
                $('.billinfo .tamount').text(data[0].total)
                $('.billinfo .dailycash').text(data[1].cash_amount)

                if(data[0].type =='advanceexpense'){
                    $('.ancorapp').append(`<a data-cash="`+data[1].cash_amount+`" data-expense="`+data[0].total+`" data-type="`+data[0].type+`"  data-unqid="`+data[0].anotherunq_id+`" class="completeaction" style="cursor: pointer;padding:4px 19px;border-radius: 3px;background:#3a71b5;;color:#fff;font-weight: bold;">Pay</a>
                    `);
                }else if(data[0].type=='Advance' || data[0].type=='Expense' ||data[0].type=='transport'){
                    $('.ancorapp').append(`<a data-cash="`+data[1].cash_amount+`" data-expense="`+data[0].total+`" data-type="`+data[0].type+`"  data-unqid="`+data[0].unq_id+`" class="completeaction" style="cursor: pointer;padding:4px 19px;border-radius: 3px;background:#3a71b5;;color:#fff;font-weight: bold;">Pay</a>
            `);

                }else{
                    console.log('something else');
                }

        }
        
            console.log(data);
        },
        error: function(xhr) {
        }
    });
    
        window.open(content, "_blank");
    });
    Instascan.Camera.getCameras().then(cameras => 
    {
        if(cameras.length > 0){
            scanner.start(cameras[0]);
        } else {
            console.error("Please enable Camera!");
        }
    });
    $(document).on('click','.completeaction',function(data){
        var unqid = $(this).data('unqid');
        var type = $(this).data('type');
        var expense = $(this).data('expense');
        var cash = $(this).data('cash');
        if(parseInt(cash) > parseInt(expense)){
        $.ajax({
        url: "{!! route('billpay.complete') !!}",
        type: "get", 
        data: { 
            unqid: unqid, 
            type: type,
            expense: expense,
            
        },
        success: function(data) {
            toastr.options = {
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "fadeIn": 300,
                        "fadeOut": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 3000
                      };
                toastr.success('Bill was paid successfully');
                $('.billinfo').css('display','none');
        }
        });
    

        }
    })
</script>
</section>
@endsection

