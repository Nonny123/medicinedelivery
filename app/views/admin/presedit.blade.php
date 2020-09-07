@include('admin/header')
<style>
    .autocomplete-suggestion {
        padding: 7px !important;
        background-color: #f5f5f5;
        border-style: solid;
        border-width: 1px;
        border-color: #ddd;
    }
    .input_fields_wrap .row{
    margin-bottom: 10px;
    }

    .input_fields_wrap .form-control{
        padding: 3px 3px;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/bootstrap-spinner.css" type="text/css"/>
<section id="content">
<section class="vbox">
<section class="scrollable padder">
<div class="m-b-md">
<h3 class="m-b-none">Update Prescription</h3></br>

@if($errors->any())
    <div class="alert alert-danger">
      <strong>Oops ! {{ $errors->first() }}</strong>
    </div>
@endif
<div class="row">
<div class="col-sm-4 portlet ui-sortable">
    <section class="panel panel-default portlet-item">
        <header class="panel-heading">
            Prescription
            <i id='rotatePres' class="fa fa-refresh btn btn-default"
               style="float:right;border-radius:26px; display: none"></i>
        </header>
        <div style="padding:15px">
            <img id='presImgId' src="{{url()}}/public/images/prescription/<?php echo $email . '/' . $path; ?>"
                 style="display: block;width: 70%; height:50%;margin-left:100px"/>
        </div>
    </section>
</div>
<div class="col-sm-8 portlet ui-sortable">
    <form action="{{url()}}/admin/update-invoice" id="formAdd" method="POST">
            {{ Form::token() }}

        <section class="panel panel-default portlet-item" >
            <header class="panel-heading" >
                <?php if ($status == 1) {
                    ?>
                    <button style="float:right" id="add_field_button" class="btn btn-sm btn-default"><i
                            class="fa fa-plus-square" style="padding-right:5px"></i>Add Medicine
                    </button>
                <?php } ?>
                Shipping Cost : <input type="text" id="shipping" name="shipping" class="form-control auto-input" style="width:400px"
                       placeholder="Enter Shipping Cost For This Order" value=<?php echo $shipping; ?>>
            </header>
            <div class="list-group bg-white" style="display: block;width: 100%; height: 625px;">
                <section class="vbox">
                    <section class="scrollable padder">
                        <div class="m-b-md">
                            <div class="input_fields_wrap">
                                <?php
                                $i = 1;
                                if(!empty($items)){

                                foreach($items as $item){ ?>
                                <div class="row col-lg-12">
                                    <div class="col-lg-3">
                                        @if($i == 1)<h5>Medicine Name</h5> @endif
                                        <input type="text" id="autocomplete{{ $i }}" name="autocomplete{{ $i }}"
                                               class="form-control auto-input" name="mytext[]"
                                               placeholder="Type Medicine name"
                                               value=<?php if (!empty($item)) {
                                                   echo(isset($item['item_name']) ? "'" . $item['item_name'] . "'" : '');
                                               } else {
                                                   echo '';
                                               }
                                               ?>
                                            >
                                        @if($i == 1)
                                        <input id="itemS" name="itemS" type="hidden" value=<?php
                                            if (!empty($item)) {
                                                echo(count($items));
                                            } else {
                                                echo '1';
                                            }
                                        ?>>
                                        <input name="invoice_id" type="hidden" value=<?php echo $invoice_id; ?>>
                                        <input name="pres_id" type="hidden" value=<?php echo $pres_id; ?>>
                                        <input id="todelete" name="todelete" type="hidden">
                                        @endif
                                    </div>
                                    <div class="col-lg-1">
                                        @if($i == 1)<h5>Qty</h5>@endif
                                        <input type="number" min="1" value=<?php
                                            $quantity = 1;
                                            if (!empty($item))
                                                $quantity = (isset($item['quantity']) ? $item['quantity'] : '1');

                                            echo $quantity;
                                        ?> id="qty{{ $i }}" name="qty{{ $i }}" onChange="calculate(this.id)" autocomplete="off"
                                               class="form-control" placeholder="Qty.">
                                    </div>

                                     <div class="col-lg-1">
                                        @if($i == 1)<h5>Mrp</h5>@endif
                                        <input type="text" id="pricee{{ $i }}" name="pricee{{ $i }}" onChange="calculate(this.id)" class="form-control"
                                                                                       placeholder="Mrp"
                                                                                       value=<?php echo(isset($item['unit_price']) ? $item['unit_price'] : ''); ?>>
                                    </div>
                                    <div class="col-lg-1">
                                        @if($i == 1)<h5>S Total</h5>@endif
                                        <input type="text" id="price{{ $i }}" name="sub_total{{ $i }}" class="form-control" placeholder="Sub Total"
                                               value=<?php
                                            if (!empty($item)) {
                                                echo($item['unit_price'] * $quantity );
                                            } else {
                                                echo '0';
                                            }
                                        ?>>
                                        <input id="item_code{{ $i }}" name="item_code{{ $i }}" type="hidden" value=<?php
                                            if (!empty($item)) {
                                                echo $item['item_id'];
                                            } else {
                                                echo '';
                                            }
                                        ?>>

                                    </div>
                                    <div class='col-lg-1'>
						                @if($i == 1)<h5>Disc</h5>@endif
                                        <input type='text' id='discount1{{ $i }}' name="unit_discount{{ $i }}" class='form-control' placeholder='Discount'
                                        value=<?php echo empty($item['unit_disc']) ? $discount : $item['unit_disc']; ?> readonly>
                                    </div>
                                    <div class='col-lg-2'>
						                @if($i == 1)<h5>Total Disc</h5>@endif
						                <input type='text' id='discount{{ $i }}' readonly  onChange="calculate(this.id)" name='discount{{ $i }}' class='form-control' placeholder='Discount'
                                        value=<?php
                                        if(empty($item['discount'])){
                                            echo $total_discount = $discount * $quantity;
                                            $is_system_discount = true;
                                        }else{
                                            echo  $item['discount'];
                                            $is_system_discount = false;
                                        }
                                        ?>  />
                                    </div>

                                    <div class='col-lg-2'>
						                @if($i == 1)<h5>Total</h5>@endif
						                <input type='text' id='total_price{{ $i }}' name='total_price{{ $i }}' class='form-control' placeholder=''
                                        value=<?php echo(isset($item['total_price']) ? $item['total_price'] - (($is_system_discount) ? $total_discount : 0)  : 0); ?>  >
                                    </div>
                            </div>
                            <?php
                                $i++;
                            } }else{ ?>

                                                            <div class="row col-lg-12">
                                                                <div class="col-lg-3">
                                                                    <h5>Medicine Name</h5>
                                                                    <input type="text" id="autocomplete1" name="autocomplete1"
                                                                           class="form-control auto-input" name="mytext[]"
                                                                           placeholder="Type Medicine name"
                                                                           value="" />

                                                                    <input id="itemS" name="itemS" type="hidden" value="1" />
                                                                    <input name="invoice_id" type="hidden" value=<?php echo $invoice_id; ?> />
                                                                    <input name="pres_id" type="hidden" value=<?php echo $pres_id; ?>>
                                                                    <input id="todelete" name="todelete" type="hidden">
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <h5>Qty</h5>
                                                                    <input type="number" min="1" value="1" id="qty1" name="qty1" onChange="calculate(this.id)" autocomplete="off"
                                                                           class="form-control" placeholder="Qty.">
                                                                </div>

                                                                 <div class="col-lg-1">
                                                         <h5>Mrp</h5>
                                                                    <input type="text" id="pricee1" name="pricee1" class="form-control"
                                                                                                                   placeholder="Mrp"onChange="calculate(this.id)"
                                                                                                                   value="" />
                                                                </div>
                                                                <div class="col-lg-1">
                                                                   <h5>S Total</h5>
                                                                    <input type="text" id="price1" name="sub_total1" class="form-control"  placeholder="Sub Total"
                                                                           value="" />
                                                                    <input id="item_code1" name="item_code1" type="hidden" value="" />

                                                                </div>
                                                                <div class='col-lg-1'>
                            						                <h5>Disc</h5>
                                                                    <input type='text' id='discount11' name="unit_discount1" class='form-control'  placeholder='Discount' onChange="calculate(this.id)"
                                                                    value="" readonly>
                                                                </div>
                                                                <div class='col-lg-2'>
                            						             <h5>Total Disc</h5>
                            						                <input type='text' id='discount1' name='discount1' class='form-control' placeholder='Discount' onChange="calculate(this.id)"
                                                                    value="" />
                                                                </div>

                                                                <div class='col-lg-2'>
                            						                <h5>Total</h5>
                            						                <input type='text' id='total_price1' name='total_price1' class='form-control' placeholder=''
                                                                    value="" />
                                                                </div>
                                                        </div>

                            <?php }  ?>
                        </div>
                    </section>
                </section>
                <script>
                    var discount = <?php echo $discount; ?>;
                    $(document).ready(function () {
                        var angle = 0;
                        var max_fields = 100;
                        var wrapper = $(".input_fields_wrap");
                        var add_button = $("#add_field_button");
                        var x = 1;
                        var y = 1;
                        var itemSize = $('#itemS').val();
					    var todelete =[];


                        $(add_button).click(function (e) {
                            e.preventDefault();
                            var x = itemSize;
                            if (x < max_fields) {
                                x++;
                                itemSize++;
                                // Input text
                                $html = "<div class='row col-lg-12' >" +
                                 "<div class='col-lg-3'><input type='text' name='autocomplete" + x + "'" + "id='autocomplete" + x + "'" + "class='form-control auto-input' placeholder='Type Medicine name' value=''></div>" +
                                 "<div class='col-lg-1'><input type='number' min='1' value='1' onChange='calculate(this.id)'  autocomplete='off' name='qty" + x + "'" + "id='qty" + x + "'" + " class='form-control'  placeholder='Qty.'></div>" +
                                 "<div class='col-lg-1'><input type='text' name='pricee" + x + "'" + " id='pricee" + x + "'" + "  class='form-control'  onChange='calculate(this.id)'  placeholder='Total' ></div>" +
                                 "<div class='col-lg-1'><input type='text' id='price" + x + "'" +" name='sub_total" + x + "'" +" class='form-control'placeholder='Sub Total' > </div>" +
                                 "<div class='col-lg-1'><input type='text' id='discount1" + x + "'" + " name='unit_discount" + x + "'" +"class='form-control' readonly placeholder='Discount'  onChange='calculate(this.id)'  value='' ></div>" +
                                 "<div class='col-lg-2'><input type='text' id='discount" + x + "'" + " name='discount" + x + "'" +"class='form-control' readonly placeholder='Discount'  onChange='calculate(this.id)'  value='' ></div>" +
                                 "<div class='col-lg-2'><input type='text' id='total_price" + x + "'" + " name='total_price" + x + "'" +"class='form-control' placeholder='Total Price' value='' /></div>" +
                                 "<div id='" + x + "'" + "class='col-lg-1 remove_field'  style='margin-top:10px;margin-left:-8px;width:20px;' ><i class='fa fa-minus-circle'><input id='item_code" + x + "'" + "name='item_code" + x + "'" + " type='hidden' value='0' ></i></div>" +
                                 "</div>";
                                $(wrapper).append($html); //add input box
                            }
                        });
                        $('#rotatePres').on('click', function () {
                            angle += 90;
                            $("#presImgId").rotate(angle);
                        });
                        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                            position = parseInt(this.id);
                            todelete.push(
                                document.getElementById('item_code' + position).value
                            );
                            document.getElementById('todelete').value = todelete;
                            console.log(document.getElementById('todelete').value);
                            e.preventDefault();
                            $(this).parent('div').remove();
                            x--;
                            itemSize--;

                            for (var i = parseInt(this.id); i <= itemSize; i++) {
                                console.log(i);
                                document.getElementById(i + 1).setAttribute('id', i);
                                document.getElementById('autocomplete' + (i + 1)).setAttribute('name', 'autocomplete' + i);
                                document.getElementById('price' + (i + 1)).setAttribute('name', 'price' + i);
                                document.getElementById('item_code' + (i + 1)).setAttribute('name', 'item_code' + i);
                                document.getElementById('qty' + (i + 1)).setAttribute('name', 'qty' + i);
                                document.getElementById('pricee' + (i + 1)).setAttribute('name', 'pricee' + i);

                                document.getElementById('autocomplete' + (i + 1)).setAttribute('id', 'autocomplete' + i);
                                document.getElementById('price' + (i + 1)).setAttribute('id', 'price' + i);
                                document.getElementById('item_code' + (i + 1)).setAttribute('id', 'item_code' + i);
                                document.getElementById('qty' + (i + 1)).setAttribute('id', 'qty' + i);
                                document.getElementById('pricee' + (i + 1)).setAttribute('id', 'pricee' + i);

                            }

                            $("#itemS").val(itemSize);

                        })

                    });
                    $(document).on('focus', '.auto-input', function (e) {
                        var id = this.id.match(/\d+/)[0];
                        $(this).autocomplete({
                            serviceUrl: '{{url()}}/admin/load-medicine-web',
                            onSelect: function (suggestion) {
                                console.log(suggestion);
                                var disc = parseFloat((suggestion.discount == 0) ? discount : suggestion.discount);
                                $("#price" + id).val(suggestion.mrp);
                                $("#autocomplete" + id).val(suggestion.value);
                                $("#pricee" + id).val(suggestion.mrp);
                                $("#price" + id).val(suggestion.mrp);
                                $("#item_code" + id).val(suggestion.id);
                                $("#total_price" + id).val(parseFloat(suggestion.mrp) - disc);
                                $("#discount" + id).val(disc);
                                $("#discount1" + id).val(disc);
                                $("#itemS").val(id);
                            }
                        });
                    });
                    // TODO
                    function calculate(id, val) {
                        var id2 = id.match(/\d+/)[0];
                        var sub_total =   parseFloat(document.getElementById("qty" + id2).value )* parseFloat(document.getElementById("pricee" + id2).value)
                        var discount =    parseFloat(document.getElementById("discount1" + id2).value)* parseFloat(document.getElementById("qty" + id2).value)
                        var total_price = sub_total - discount
                        $("#price" + id2).val(sub_total);
                        $("#discount" + id2).val(discount);
                        $("#total_price" + id2).val(total_price);
                    }
                </script>
            </div>
            <?php if ($status == 1) {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" style="float:right" id="add_field_button" onclick="add_item()" class="btn btn-s-md btn-success">Verify
                        </button>
                    </div>
                </div>
            <?php } ?>
        </section>
    </form>
</div>
</div>
</div>
</section>
</section>
</section>
<script src="{{url()}}/assets/adminFiles/js/jquery.autocomplete.js"></script>
<script src="{{url()}}/assets/adminFiles/js/jquery.spinner.js"></script>
@include('admin/footer')
<script type="text/javascript">

function add_item(){
        var shipping = $('#shipping').val();
        var item = $("#item_code1").val();

        if(item == ""){
            alert('Please add an item to the cart');
            return false;
        }
        conf = true;
        if(shipping == 0){
            var conf = confirm('You have not updated the shipping price ! Do you want to proceed with out updating it')
        }

        if(conf){
            $('#formAdd').submit();
        }else{
        return false;
        }
}
</script>

}

</script>


