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
                <h3 class="m-b-none">Shipped Prescriptions</h3>
  </div>
  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>From</th>
	    <th>Date</th>
	    <th>Paid</th>
	    <th>Shipped</th>
	    <th id="sortByStatus" class="th-sortable" data-toggle="class">Status <span class="th-sort">
                            <i class="fa fa-sort-down text"></i>
                            <i class="fa fa-sort-up text-active"></i>
                            <i class="fa fa-sort"></i>
                          </span></th>
	    <th></th>
	    <th>Invoice</th>
	  </tr>
	</thead>
	<tbody>




	</tbody>
	<span id='paginate'></span>
	</table>

  	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>


	<script>
	var status='ASC';
	$(document).ready(function(e){
		 document.getElementById("searchField").placeholder = "Search by Email..";
		 loadData(0,"");
		 $(document).on('click','.pagination li a',function(e){
		 	e.preventDefault();
		 	var details = $(this).attr('href');
			var email = $('#searchField').val();
			$.ajax({
		           type: "GET",
		           url : details,
		           dataType: 'json',
		           data : {details:details,email:email},
		           success: function (data) {
					$('.table tbody').html(data.tbody);
					$('#paginate').html(data.paginate);
					}
		       });
		 });
	});
	$("#sortByStatus").click(function(){
	    status=='ASC'?status='DESC':status='ASC';
	    loadData(1,status);
	    
	});
	function loadData($type,$value)
	{
			var details = '<?php echo URL::to('/admin/load-prescription-shipped'); ?>';
			if($type==0)
 				var email = $value;
 			else if($type==1)
 			 	var status = $value;
			//var status = $('#searchField').val();
			$.ajax({
		           type: "GET",
		           url : details,
		           dataType: 'json',
		           data : {details:details,email:email,status:status},
		           success: function (data) {
					$('.table tbody').html(data.tbody);
					$('#paginate').html(data.paginate);
					}
		       });
	}
		$("#searchField").bind("change paste keyup", function() {
		  	loadData(0,$(this).val());
		});
	function updatePaidStatus($id){
		var details = 'admin/update-invoice-status/'+$id;
		$.ajax({
		           type: "GET",
		           url : details,
		           success:function(){
		            window.location.reload();
		           }
		});
	}
	</script>
      </tbody>
    </table>
 </section>
</div>
@include('admin/footer')
