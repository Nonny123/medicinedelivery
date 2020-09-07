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
                <h3 class="m-b-none">Medical Professionals</h3>
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
	if(count($mprof)>0)
	{
	$pageNumber= Input::get('page');
		$i=0;
	foreach($mprof as $prof)
	{
	?>
	   <tr>
	   <td><?php echo(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)?></td>
	   <td><?php echo $prof->prof_mail; ?></td>
	   <td><?php echo $prof->prof_phone; ?></td>
	   <td><?php echo $prof->prof_first_name; ?></td>
	   <td><?php echo $prof->prof_last_name; ?></td>
	   <td><?php echo $prof->prof_address; ?></td>
	   <td><?php echo $prof->prof_pincode; ?></td>
	   <td><a href="mprof-delete/<?php echo $prof->id; ?>" class="btn btn-s-md btn-danger btn-rounded"  >Delete</a>&nbsp;&nbsp;&nbsp;
	   <?php  if($prof->user()->user_status ==UserStatus::PENDING()){ ?>
       	   <a href="prof-change-status/<?php echo $prof->id; ?>" class="btn btn-s-md btn-danger btn-rounded" >Publish</a>
       	   <?php }?>
	   </td>
	   </tr>
	   <?php } } else {?>
	   <tr><td colspan="7">No Medical Professionals Found.</td></tr>
	   <?php }?>

	{{ $mprof->links() }}
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
