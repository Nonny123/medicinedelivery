@include('admin/header')
<script>
$(function()
{
    $('#dash').removeClass('active');
    $('#users').addClass('active');
});
</script>
<section id="content">
<section class="vbox">
  <section class="scrollable padder">
  <div class="m-b-md">
                <h3 class="m-b-none">Customers</h3>
  </div>
  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>Email</th>
	    <th>Phone</th>
	    <th>First Name</th>
	    <th>Last Name</th>
	    <th>Address</th>
	    <th>Pincode</th>

	    <th></th>
	  </tr>
	</thead>
	<tbody>
	<?php 
	if(count($customers)>0)
	{
	$pageNumber= Input::get('page');
	$i = 0;
	foreach($customers as $customer)
	{?>
	   <tr>
	   <td><?php echo(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)?></td>
	   <td><?php echo $customer->mail; ?></td>
	   <td><?php echo $customer->phone; ?></td>
	   <td><?php echo $customer->first_name; ?></td>
	   <td><?php echo $customer->last_name; ?></td>
	   <td><?php echo $customer->address; ?></td>
	   <td><?php echo $customer->pincode; ?></td>
	   <td>
	   <a href="customer-delete/<?php echo $customer->id;  ?>" class="btn btn-s-md btn-danger btn-rounded" >Delete</a>&nbsp;&nbsp;&nbsp;
	   <?php  if($customer->user()->user_status == UserStatus::PENDING()){ ?>
	   <a href="user-change-status/<?php echo $customer->id; ?>" class="btn btn-s-md btn-danger btn-rounded" >Publish</a>
	   <?php }?>
	   </td>
	   </tr>
	   <?php } } else {?>
	   <tr><td colspan="7">No Customers Found.</td></tr>
	   <?php }?>

	{{ $customers->links() }}
	</tbody>
	</table>
 </section>
</div>
 <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
  <script>
				$(document).ready(function(e){
				document.getElementById('searchTop').style.display = 'none';
				});
  </script>
@include('admin/footer')
