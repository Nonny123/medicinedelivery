@include('admin/header')
<script>
$(function()
{
    $('#dash').removeClass('active');
    $('#medicine').addClass('active');
});
</script>
<section id="content">
<section class="vbox">
  <section class="scrollable padder">
  <div class="m-b-md">
                <h3 class="m-b-none" style="margin-bottom: 10px;">Medicine</h3>
                <div class="row" style="
                    text-align: right;
                    padding-right: 20px;
                ">
                  <a class="btn btn-s-md btn-success btn-rounded" href="add-med"><i class="fa fa-fw fa-plus"></i> Add Medicine</a>
                  <a class="btn btn-s-md btn-info btn-rounded" href="#" id="upload-med"><i class="fa fa-fw fa-plus"></i> Upload Medicine</a>
                </div>

  </div>
  {{ $medicines->links() }}
<div class="col-lg-3 col-md-3 pull-right" style="text-align: center;padding: 10px;"><input class="form-control input-md" type="text" name="medine_search" id="medicine_search" placeholder="Search medicine by name" onkeyup="filter_medine(this.value,'ASC')"></div>
  <section class="panel panel-default">
   
   <table class="table table-striped m-b-none dataTable" id="myTable">
	<thead>
	  <tr>
	    <th>No.</th>
	    <th>Item Name</th>
	    <th>Item Code</th>
	    <th>Expiry Date</th>
	    <th>Batch No.</th>
	    <th>MFG</th>
	    <th>Nature</th>
	    <th>MRP</th>
	    <th id="sort">Composition</th>
	    <th>Actions</th>
	  </tr>
	</thead>
	<tbody id="medicine_content">
	<?php 
	if(count($medicines)>0)
	{
	$pageNumber= Input::get('page');	
	for($i=0;$i<count($medicines);$i++)
	{?>
	   <tr>
	   <td><?php echo(isset($pageNumber)?$i+1+((Input::get('page')-1)*30):$i+1)?></td>
	   <td><?php echo $medicines[$i]['name']?></td>
	   <td><?php echo $medicines[$i]['item_code']?></td>
	   <td><?php echo $medicines[$i]['exp']?></td>
	   <td><?php echo $medicines[$i]['batch_no']?></td>
	   <td><?php echo $medicines[$i]['mfg']?></td>
	   <td><?php echo $medicines[$i]['group']?></td>
	   <td><?php echo round($medicines[$i]['mrp'],2);?></td>
	   <td><textarea style="width: 300px; height: 80px;"><?php echo $medicines[$i]['composition']?></textarea></td>
	   <td><a class="btn btn-s-md btn-info" target="_blank" href="medicine-edit/<?php echo $medicines[$i]['id']; ?>" >Edit</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-s-md btn-danger"href="medicine-delete/<?php echo $medicines[$i]['id']; ?>">Delete</a></td>
	   </tr>
	   <?php } } else {?>
	   <tr><td colspan="7">No Medicines Found.</td></tr>
	   <?php }?>
	
	
	</tbody>
	
   </table>
   
 </section>
</section>
</section>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Medicine List</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-success hide">
            <strong>Success!</strong> Medicine successfully updated.
          </div>
          <div class="alert alert-danger hide">

        </div>
        <form class="" enctype="multipart/form-data" id="frmUpload">
                <div class="form-group">
                {{ Form::token() }}
                <p>Upload .xls .xlsx file with following headers to update the medicine list. <b>(item_code ,item_name ,batch_no ,quantity ,cost_price ,purchase_price ,rack ,composition ,manufactured_by ,marketed_by ,group ,tax ,expiry ,MRP ,discount)</b></b></p>
                        <input class="form-control" type="file" name="file" id="file" />
                </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="file_upload">Submit</button>
      </div>
    </div>

  </div>
</div>

  <script>
    $(document).ready(function(e){

$('#upload-med').click(function(e){
    $('#myModal').modal('show');
});

$("#file_upload").click(function(e){
    if($('#file').val() == ""){
        return false;
    }

     var fd = new FormData();
     var file_data = $('#file').prop('files')[0];
     var _token = $('#frmUpload input[name="_token"]').val();
     fd.append("file", file_data);
     console.log(fd);
     fd.append("_token", _token);
    $.ajax({
        url:'../medicine/upload',
        type:'POST',
        data:fd,
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        statusCode:{
            400:function(data){
            console.log(data);
                $('.alert-danger').html(data.responseJSON.msg).removeClass('hide');
            },
            403:function(data){
                $('.alert-danger').html(data.responseJSON.msg).removeClass('hide');
            }
        },
        success:function(data){
            $('.alert-success').removeClass('hide');
            $('.alert-danger').addClass('hide');
            setTimeout(function(){ window.location.reload()},1000);
        }
    })

})
    document.getElementById('searchTop').style.display = 'none';
    });

    function filter_medine(medicine,order)
    {
        $.ajax({
            url: '../medicine/medicine-list-from-name',
            data: 'name='+medicine+'&ord='+order,
            type: 'GET',
            datatype: 'JSON',
            beforeSend: function () {

            },
            success: function (data) {
                links = data.link;
                data = data.medicines;
                var table_con="";
                var i=1;
                if(data.length>0)
                {
                    $.each(data, function ($key, $med) {
                         table_con+="<tr><td>"+i+"</td><td>"+$med.name+"</td><td>"+$med.item_code+"</td><td>"+$med.exp+"</td><td>"+$med.batch_no+"</td><td>"+$med.mfg+"</td><td>"+$med.group+"</td><td>"+$med.mrp.toFixed(2)+"</td><td style='width:300px'>"+$med.composition+"</td><td><a class='btn btn-s-md btn-info' target='_blank' href='medicine-edit/"+$med.id+"' >Edit</a>&nbsp;<a class='btn btn-s-md btn-danger' href='medicine-delete/"+$med.id+"'>Delete</a></td></tr>";
                         i++;
                    });
                }else{
                    table_con+="<tr><td colspan='8'><h4>No medicines found!!</h4></td></tr>";
                }

                $('#medicine_content').html(table_con);
//                if(table_con != ""){
//                  $("#myTable").DataTable({
//                     "paging": false,
//                     "searching": false,
//                     "columnDefs": [
//                         { "orderable": false, "targets": [0,1,2,3,4,5,6,7,9] }
//                       ]
//                     });
//                }

            }
        });


    }

  </script>
@include('admin/footer')
