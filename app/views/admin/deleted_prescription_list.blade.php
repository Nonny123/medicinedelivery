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
  <div class="m-b-md">
  </div>
  <div class="row">
  <div class="col-lg-9">  <h3 class="m-b-none">Deleted Prescriptions</h3>
</div>
  <div class="col-lg-3" style="padding-top: 7px">  <input type="text" class="form-control" name="pres_search" id="pres_search" placeholder="Search prescription by email" onkeyup="filter_pres(this.value,'deleted')" >
</div>
  </div>
  <?php
  echo ($pres->links());
  ?>
  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>From</th>
	    <th>Date</th>
	    <th>Status</th>
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
	   <tr>
	   <td>{{(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)}}</td>
	   <td>{{$pres[$i]->email}}</td>
	   <td>{{date('d-M-Y',strtotime($pres[$i]->created_date))}}</td>
	   <td>Deleted</td>
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
               url: '../admin/load-deleted-pres-email',
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
                            table_con+="<tr><td>"+i+"</td><td>"+$med.email+"</td><td>"+$med.created_date+"</td>" +
                             "<td>Deleted</td></tr>";
                            i++;
                       });
                   }else{
                       table_con+="<tr><td colspan='8'><h4>No prescriptions found!!</h4></td></tr>";
                   }
                   $('#pres_content').html(table_con);
               }
           });
       }
  </script>
@include('admin/footer')
