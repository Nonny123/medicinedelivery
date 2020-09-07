@include('admin/header')
<script>
$(function()
{
    $('#dash').removeClass('active');
    $('#presc').addClass('active');
});
</script>

<section id="content">
<section class="vbox">
  <section class="scrollable padder">
  <div class="row">
  <div class="col-lg-9"><h3 class="m-b-none">Unverified Prescriptions</h3></div>
  <div class="col-lg-3" style="padding-top: 7px;"><input class="form-control" type="text" name="pres_search" id="pres_search" placeholder="Search prescription by email" onkeyup="filter_pres(this.value,'unverified')" ></div>

  </div>

  <?php
          // TODO : Update the invoice number in the view

  echo ($pres->links());
  ?>

  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>From</th>
	    <th>Date</th>
	    <th>Prescription Status</th>
	    <th>Actions</th>
	  </tr>
	</thead>
	<tbody id="pres_content">
<?php
	if(count($pres)>0)
	{
	$pageNumber= Input::get('page');
	for($i=0;$i<count($pres);$i++)
	{
	if ($pres[$i]->in_status =='pending') {
        $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
    } else {
       $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
    }
	?>
	   <tr >
	   <td>{{(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)}}</td>
	   <td>{{$pres[$i]->email}}</td>
	   <td>{{date('d-M-Y',strtotime($pres[$i]->created_date))}}</td>
	   <td><?php echo "Pending Verification";?></td>
	   <td><a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/pres-edit/{{$pres[$i]->pres_id}}/1' >Details</a>&nbsp;&nbsp;&nbsp;
	   <a class='btn btn-s-md btn-danger btn-rounded' data-href='{{url()}}/admin/pres-delete/{{$pres[$i]->pres_id}}/{{ PrescriptionStatus::UNVERIFIED() }}' onclick="confirm_deletion(this);">Delete</a></td>
	   </tr>
	   <?php } } else {?>
	   <tr><td colspan="7">No Prescriptions Found.</td></tr>
	   <?php }?>


	</tbody>
	</tbody>
	</table>
 </section>
 </section></section></section>
<script>
 function filter_pres(email,status)
     {
         $.ajax({
             url: '../admin/load-pres-email',
             data: 'email='+email+'&status='+status,
             type: 'GET',
             datatype: 'JSON',
             beforeSend: function () {

             },
             success: function (data) {
                 var table_con="";
                 var i=1;
                 if(data.length>0)
                 {
                     $.each(data, function ($key, $med) {
                          table_con+="<tr><td>"+i+"</td><td>"+$med.email+"</td><td>"+$med.created_date+"</td><td>Pending Verification</td>" +
                           "<td><a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/pres-edit/"+$med.pres_id+"/1' >Details</a>&nbsp;&nbsp;&nbsp;" +
                            "<a class='btn btn-s-md btn-danger btn-rounded'  data-href='{{url()}}/admin/pres-delete/"+$med.pres_id+"/pending' onclick='confirm_deletion(this)'>Delete</a></td>" +
                             "</tr>";
                          i++;
                     });
                 }else{
                     table_con+="<tr><td colspan='8'><h4>No prescriptions found!!</h4></td></tr>";
                 }
                 $('#pres_content').html(table_con);
             }
         });
     }

     function confirm_deletion(element){
     console.log(element);
        var conf = confirm("Do you really want to delete this order ?");
        if(conf){
            $.ajax({
                url:$(element).data('href'),
                type:'POST',
                dataType:'JSON',
                statusCode:{
                    401:function(data){
                        alert('Please log in to continue...')
                        window.location.href = "/";
                    },
                    500:function(data){

                    }

                },
                success:function(data){
                      window.location.reload();
                }
            })
        }
     }
</script>
@include('admin/footer')
