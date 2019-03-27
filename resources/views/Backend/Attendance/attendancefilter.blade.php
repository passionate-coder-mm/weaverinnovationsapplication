@extends('Backend.admin_master')
@section('main-content')
<section class="content">
      <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Filter</h3>
    </div>    
    {!!Form::open(['method' => 'POST','id'=>'filter'])!!}
         <div class="box-body">
          <div class="row">
              <div class="form-group">
                  <div class="col-sm-3 customdesignfilter">
                    <select id="userserchid" class="form-control select2" style="width: 100%;" name="user_id">
                     @foreach($all_user as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                   </select> 
                  </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="from_date" class="form-control datepicker" id="datepicker" placeholder="From Date">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="to_date" class="form-control datepicker" id="datepicker1" placeholder="To Date">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
              </div>
            </div>
            <div class="box-header with-border">
              <h3 class="box-title">Datewise Filter</h3>
          </div> 
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Date</th>
                  <th scope="col">Inn Time</th>
                  <th scope="col">Out Time</th>
                </tr>
              </thead>
              <tbody class="datewiseappend">
                
               
              </tbody>
            </table>
        </div>
        {!!Form::close()!!}
      </div>
    </div>
    
</section>
 
      <script>
         $( function() {
            $("#datepicker" ).datepicker();
            $("#datepicker1" ).datepicker();
        });
        $(document).on('submit','#filter',function(e){
          e.preventDefault();
          var data = $(this).serialize();
          $.ajax({
              url:"datewiseattendance",
              method:"POST",
              data:data,
              dataType:"json",
              success:function(data)
              { 
                $('.datewiseappend').empty();
                if(data.length < 1){
                  $('.datewiseappend').append(`<tr><td</td><td>No Result Found</td><td></td><td></td></tr>`);
                }else{
                  $.each(data,function(index,filterdata){
                        $('.datewiseappend').append(` <tr >
                        <td scope="row">`+filterdata.name+`</td>
                        <td>`+filterdata.att_date+`</td>
                        <td>`+filterdata.in_time+`</td>
                        <td>`+filterdata.out_time+`</td>
                      </tr>`);
                })
                }
               
                console.log(data);
               }
          });
       });
       $(".datepicker").attr("autocomplete", "off");
      </script>
@endsection