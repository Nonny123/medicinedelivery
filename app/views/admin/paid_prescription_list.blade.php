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
  <div class="col-lg-9"> <h3 class="m-b-none">Paid Prescriptions</h3></div>
  <!-- TODO Search filter not working for nay -->
  <div class="col-lg-3" style="padding-top: 7px">  <input class="form-control" type="text" name="pres_search" id="pres_search" placeholder="Search prescription by email" onkeyup="filter_pres(this.value,'paid')" >
</div>
  </div>
  <?php
  echo ($pres->links());
  ?>
  <input type="hidden" value="{{ ShippingStatus::SHIPPED() }}" id="shipping_status" />
  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>From</th>
	    <th>Date</th>
	    <th>Actions</th>
	    <th>Invoice</th>
	  </tr>
	</thead>
	<tbody id="pres_content">
<?php
	if(count($pres)>0)
	{
	$pageNumber= Input::get('page');
	for($i=0;$i<count($pres);$i++)
	{
	if ($pres[$i]->in_status == InvoiceStatus::PAID()) {
        $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
    } else {
        $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
    }
	?>
	   <tr>
	   <td>{{(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)}}</td>
	   <td>{{$pres[$i]->email}}</td>
	   <td>{{date('d-M-Y',strtotime($pres[$i]->created_date))}}</td>
	   <td>
	    @if($pres[$i]->shipping_status != ShippingStatus::SHIPPED())
	        <a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/ship-order/{{$pres[$i]->pres_id}}'  onclick="return confirm('Do you really want to make this order as shipped?');">Ship Order</a>
        @else
            Shipped
        @endif
	   {{--&nbsp;&nbsp;&nbsp;<a class='btn btn-s-md btn-danger btn-rounded' href='{{url()}}/admin/pres-delete/{{$pres[$i]->pres_id}}/paid'  onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>--}}
	   <td><a class='text-info' href='{{url()}}/admin/load-invoice/{{$pres[$i]->id}}'>{{ $pres[$i]->invoice }}</a></td>
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
                           table_con+="<tr><td>"+i+"</td><td>"+$med.email+"</td><td>"+$med.created_date+"</td>";
                           if($med.shipping_status != $('#shipping_status').val())
                            table_con+="<td><a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/ship-order/"+$med.pres_id+"'  onclick='return confirm(\"Do you really want to make this order as shipped?\");'>Ship Order</a></td>";
                            else
                            table_con+="<td>Shipped</td>";
                              table_con+="<td><a class='text-info' href='{{url()}}/admin/load-invoice/"+$med.pres_id+"'>"+$med.invoice+"</a></td></tr>";
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
