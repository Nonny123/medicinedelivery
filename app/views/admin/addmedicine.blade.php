@include('admin/header')
 <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
  <script>
				$(document).ready(function(e){
				document.getElementById('searchTop').style.display = 'none';
				});
  </script>
<section id="content">
<section class="vbox">
  <section class="scrollable padder">
    <div class="m-b-md">
                <h3 class="m-b-none">Add/Edit Medicine</h3>
  </div>
  
        <section class="panel panel-default">
        <?php $message = Session::get('message',null); ?>
        @if(!is_null($message))
            <p class="alert alert-danger">{{ $message }}</p>
        @endif
 		<header class="panel-heading font-bold">Update Medicine Database</header>
		<strong id="div-notify" style="color: red"></strong>
		<form method="POST" class="panel-body" action="{{url()}}/admin/new-med" accept-charset="UTF-8">

		{{Form::token()}}

		<div class="form-group">
		<label for="email">Item Code:</label>
		<input class="form-control"  name="item_code" type="text" value=<?php echo(isset($details['item_code']) ?"'".$details['item_code']."'":'""');?> required>
		</div>
		<input  name="id" type="hidden" value=<?php echo(isset($details['id']) ?"'".$details['id']."'":'""');?> >
		<div class="form-group">
		<label for="email">Item Name:</label>
		<input class="form-control"   name="item_name" type="text" value=<?php echo(isset($details['item_name']) ?"'".$details['item_name']."'":'""');?> required>
		</div>
		<div class="form-group">
		<label for="email">Batch No.:</label>
		<input class="form-control"   name="batch_no" type="text" value=<?php echo(isset($details['batch_no']) ?  "'".$details['batch_no']."'":'""');?> >
		</div>
		<div class="form-group">
		<label for="email">Cost Price:</label>
		<input class="form-control"  name="cost_price" type="text" value=<?php echo(isset($details['cost_price']) ?  "'".$details['cost_price']."'":'""');?> >
		<input class="form-control"  type="hidden" name="quantity"  value=<?php echo(isset($details['quantity']) ?  "'".$details['quantity']."'":'""');?> >
		</div>
		<div class="form-group">
		<label for="email">Purchase Price:</label>
		<input class="form-control"  name="purchase_price" type="text" value=<?php echo(isset($details['purchase_price']) ?  "'".$details['purchase_price']."'":'""');?> >
		</div>
		<div class="form-group">
		<label for="email">Rack:</label>
		<input class="form-control"  name="rack_number" type="text" value=<?php echo(isset($details['rack_number']) ?  "'".$details['rack_number']."'":'""');?> >
		</div>
		<div class="form-group">
		<label for="email">MRP:</label>
		<input class="form-control"  name="selling_price" type="text" value=<?php echo(isset($details['selling_price']) ?  "'".$details['selling_price']."'":'""');?> required>
		</div>
		<div class="form-group">
		<label for="email">Expiry Date:</label>
		<input class="form-control"  id="expiry" name="expiry" type="text" value=<?php echo(isset($details['expiry']) ?  "'".$details['expiry']."'":'""');?> required>
		</div>
		<div class="form-group">
		<label for="email">Tax:</label>
		<input class="form-control"  name="tax" type="text" value=<?php echo(isset($details['tax']) ?  "'".$details['tax']."'":'""');?> required>
		</div>
		<div class="form-group">
		<label for="email">Composition:</label>
		<input class="form-control"  name="composition" type="text" value=<?php echo(isset($details['composition'])?"'".$details['composition']."'":'""');?> >
		</div>
        <div class="form-group">
        <label for="email">Manufacturer:</label>
        <input class="form-control"  name="manufacturer" type="text" value=<?php echo(isset($details['manufacturer'])?"'".$details['manufacturer']."'":'""');?> >
        </div>
        <div class="form-group">
        <label for="email">Nature of drug:</label>
        <input class="form-control"  name="group" type="text" value=<?php echo(isset($details['group'])?"'".$details['group']."'":'""');?> >
        </div>
		<div class="form-group">
		<label for="email">Discount:</label>
		<input class="form-control"  name="discount" type="text" value=<?php echo(isset($details['discount'])?"'".$details['discount']."'":'"0"');?> >
		</div>
		<div class="form-group">
		<button class="btn btn-default btn-lg" name="submit" value="Add" type="submit">Add</button>
	    </div>
	</form>
 </section>
</section>
</section>

@include('admin/footer')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function(e){
    $( "#expiry" ).datepicker({ minDate: 0});

});
</script>