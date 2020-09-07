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
    <div class="col-lg-9">  <h3 class="m-b-none">All Prescriptions</h3>
</div>
    <div class="col-lg-3" style="padding-top: 7px">  <input type="text" class="form-control" name="pres_search" id="pres_search" placeholder="Search prescription by email" onkeyup="filter_pres(this.value,'all')" >
</div>
    </div>
    <!-- Status -->
      <input type="hidden" value="{{ ShippingStatus::SHIPPED() }}" id="shipping_status" />
      <input type="hidden" value="{{ InvoiceStatus::PAID() }}" id="invoice_status" />
      <input type="hidden" value="{{ PrescriptionStatus::VERIFIED() }}" id="prescription_status" />


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
	    <th>Prescription Status</th>
        <th>Payment Status</th>
	    <th>Shipping Status</th>
	    	    <th>Invoice</th>

	    <th width="390px">Actions</th>
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
    if($pres[$i]->status==PrescriptionStatus::UNVERIFIED())
    {
        $edit=1;
    }else
    {
        $edit=0;
    }
	?>
	   <tr>
	   <td>{{(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)}}</td>
	   <td>{{$pres[$i]->email}}</td>
	   <td>{{date('d-M-Y',strtotime($pres[$i]->created_date))}}</td>
	   <td><strong>{{ PrescriptionStatus::statusName($pres[$i]->status)}}</strong></td>
	   <td ><strong>{{ InvoiceStatus::statusName($pres[$i]->in_status)}}</strong></td>
	   <td><strong>{{ ShippingStatus::statusName($pres[$i]->shipping_status)}}</strong></td>
	   <td><a class='text-info' href='{{url()}}/admin/load-invoice/{{$pres[$i]->id}}'>{{ $pres[$i]->invoice;}}</a></td>

	   <td><a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/pres-edit/{{$pres[$i]->pres_id}}/{{$edit}}' >Details</a>&nbsp;&nbsp;&nbsp;
	   <?php if($pres[$i]->status==PrescriptionStatus::UNVERIFIED()){?><a class='btn btn-s-md btn-danger btn-rounded' data-href='{{url()}}/admin/pres-delete/{{$pres[$i]->pres_id}}/all' onclick="confirm_deletion(this);">Delete</a>&nbsp;&nbsp;&nbsp;<?php }?>
	   @if($pres[$i]->status=='paid')<a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/ship-order/{{$pres[$i]->pres_id}}'  onclick="return confirm('Do you really want to make this order as shipped?');">Ship Order</a>@endif
	   </td>
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
                url: '../admin/load-all-pres-email',
                data: 'email='+email+'&status='+status,
                type: 'GET',
                datatype: 'JSON',
                beforeSend: function () {

                },
                success: function (data) {
                    var table_con="";
                    var i=1;
                    $delete = $inv = "";
                    $edit=0;
                    $ship = "";
                    if(data.length>0)
                    {
                        $.each(data, function ($key, $med) {
                        $inv = "";
                        if ($med.status =='pending') {
                            $paid = "<i class='fa fa-times'  style='color:#DF0101'></i>";
                        } else {
                           $paid = "<i class='fa fa-check'  style='color:#01DF01'></i>";
                        }
                        // For UnVerified Prescription
                        if($med.pstatus != $('#prescription_status').val())
                        {
                            $pstat= "Pending Verification";
                            $edit=1;
                            $ship = "";
                            $delete="<a class='btn btn-s-md btn-danger btn-rounded' href='{{url()}}/admin/pres-delete/"+$med.pres_id+"/all' onclick=\"return confirm('Do you really want to delete this order?');\">Delete</a>&nbsp;&nbsp;&nbsp;"
                        }
                        else if($med.pstatus == $('#prescription_status').val() && $med.status_id !=$('#invoice_status').val() ) { // If Prescription is saved And Payment is not made
                            $pstat= "Verified";
                            $edit=0;
                            $delete="";
                            $inv="<a class='text-info' href='{{url()}}/admin/load-invoice/"+$med.pres_id+"'>" +($med.invoice)+"</a>";
                            $ship = "";
                        }
                        else if($med.pstatus == $('#prescription_status').val() && $med.status_id ==$('#invoice_status').val()) {
                            $pstat= $med.pstatus;
                            $edit=0;
                            $delete="";
                            $ship = "";
                            $inv="<a class='text-info' href='{{url()}}/admin/load-invoice/"+$med.pres_id+"'>" +($med.invoice)+"</a>";
                            if($med.status_id==$('#invoice_status').val() && $med.s_status != $('#shipping_status').val()){
                            $ship="<a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/ship-order/"+$med.pres_id+"'  onclick=\"return confirm('Do you really want to make this order as shipped?');\">Ship Order</a>";
                            }
                        }
                         table_con+="<tr><td>"+i+"</td><td>"+$med.email+"</td><td>"+$med.created_date+"</td><td>"+$med.pres_status+"</i></td>" +
                          "<td>"+$med.invoice_status+"</td>"+
                          "<td>"+$med.ship_status+"</td>"+
                          "<td>"+$inv+"</td><td><a class='btn btn-s-md btn-info btn-rounded' href='{{url()}}/admin/pres-edit/"+$med.pres_id+"/"+$edit+"' >Details</a>&nbsp;&nbsp;&nbsp;" +$delete+$ship+
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
