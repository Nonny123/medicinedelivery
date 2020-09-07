@include('admin/header')
<style>
    .autocomplete-suggestion {
        padding: 7px !important;
        background-color: #f5f5f5;
        border-style: solid;
        border-width: 1px;
        border-color: #ddd;
    }
</style>
<link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/bootstrap-spinner.css" type="text/css"/>
<section id="content">
<section class="vbox">
<section class="scrollable padder">
<div class="m-b-md">
<h3 class="m-b-none">Update Prescription</h3></br>
<div class="row">
<div class="col-sm-6 portlet ui-sortable">
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
<div class="col-sm-6 portlet ui-sortable">
    <form action="{{url()}}/admin/update-invoice" method="POST">
        <section class="panel panel-default portlet-item" style="height:700px;width:600px">
            <header class="panel-heading" style="height:55px">
                <?php if ($status == 1) {
                    ?>
                    <button style="float:right" id="add_field_button" class="btn btn-sm btn-default"><i
                            class="fa fa-plus-square" style="padding-right:5px"></i>Add Medicine
                    </button>
                <?php } ?>
                <input type="text" id="shipping" name="shipping" class="form-control auto-input" style="width:400px"
                       placeholder="Enter Shipping Cost For This Order" value=<?php echo $shipping; ?>>
            </header>
            <div class="list-group bg-white" style="display: block;width: 100%; height: 625px;">
                <section class="vbox">
                    <section class="scrollable padder">
                        <div class="m-b-md">
                            <div class="input_fields_wrap">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <h5>Medicine Name</h5>
                                        <input type="text" id="autocomplete1" name="autocomplete1"
                                               class="form-control auto-input" name="mytext[]"
                                               placeholder="Type Medicine name"
                                               value=<?php if (!empty($items[0])) {
                                                   echo(isset($items[0]['item_name']) ? "'" . $items[0]['item_name'] . "'" : '');
                                               } else {
                                                   echo '';
                                               }
                                               ?>
                                            >
                                        <input id="itemS" name="itemS" type="hidden" value=<?php
                                            if (!empty($items[0])) {
                                                echo(count($items));
                                            } else {
                                                echo '1';
                                            }
                                        ?>>
                                        <input name="invoice_id" type="hidden" value=<?php echo $invoice_id; ?>>
                                        <input name="pres_id" type="hidden" value=<?php echo $pres_id; ?>>
                                        <input id="todelete" name="todelete" type="hidden">
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Qty</h5>
                                        <input type="number" min="1" value=<?php
                                            if (!empty($items[0])) {
                                                echo(isset($items[0]['qty']) ? $items[0]['qty'] : '1');
                                            } else {
                                                echo '1';
                                            }
                                        ?> id="qty1" name="qty1" onChange="calculate(this.id)" autocomplete="off"
                                               class="form-control" placeholder="Qty.">
                                    </div>
                                    <div class="col-lg-2">
                                        <h5>Total Price</h5>
                                        <input type="text" id="price1" class="form-control" placeholder="Total"
                                               value=<?php
                                            if (!empty($items[0])) {
                                                echo($items[0]['unit_price'] * $items[0]['qty']);
                                            } else {
                                                echo '0';
                                            }
                                        ?>>
                                        <input id="item_code1" name="item_code1" type="hidden" value=<?php
                                            if (!empty($items[0])) {
                                                echo $items[0]['item_code'];
                                            } else {
                                                echo '';
                                            }
                                        ?>>
                                        <input type="hidden" id="pricee1" name="pricee1" class="form-control"
                                               placeholder="Total"
                                               value=<?php echo(isset($items[0]['unit_price']) ? $items[0]['unit_price'] : ''); ?>>
                                    </div>
                                    <div class='col-lg-2   >
						    <h5>Discount</h5>
						    <input type=' text
                                    ' id='discount1' class='form-control' placeholder='Discount'
                                    value=<?php echo $discount; ?> disabled >
                                </div>
                            </div>
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
                        //var itemS= document.getElementById('itemAr').value;
                        //  var itemP=JSON.parse(itemS);
                        var itemS = <?php if(!empty($items[0]))
					                        echo json_encode( $items );
					                       else
					                         echo '0';
					                        ?>;

                        var itemSize = parseInt(itemS);
                        var todelete = [];
                        var dis = <?php echo $discount; ?>;
                        while (y < itemS.length) {

                            y++;
                            x++;
                            var unitP = itemS[y - 1]['unit_price'];
                            var total = itemS[y - 1]['qty'] * unitP;
                            $(wrapper).append("<div class='row' style='padding-top:10px'><div class='col-lg-3'><input type='text' id='autocomplete" + y + "'" + "name='autocomplete" + y + "'" + "class='form-control auto-input' style='width:200px' name='mytext[]' placeholder='Type Medicine name'value=" + "'" + itemS[y - 1]['item_name'] + "'" + "></div><div class='col-lg-3' style='width:100px;margin-left:80px'><input type='number' min='1' value=" + itemS[y - 1]['qty'] + " onChange='myFunction(this.id)'  autocomplete='off' id='qty" + y + "'" + "name='qty" + y + "'" + " class='form-control'  placeholder='Qty.'></div><div class='col-lg-3'  style='width:120px;margin-left:-8px' ><input type='text' id='price" + y + "'" + "class='form-control'placeholder='Total' value=" + total + " > <input type='hidden' id='pricee" + y + "'" + "name='pricee" + y + "'" + " value=" + unitP + " class='form-control'  placeholder='Total' ><input id='item_code" + y + "'" + "name='item_code" + y + "'" + " type='hidden' value='" + itemS[y - 1]['item_code'] + "'" + " ></div><div class='col-lg-3'  style='width:120px;margin-left:-8px' ><input type='text' id='discount" + y + "'" + "class='form-control'placeholder='Discount' value='" + dis + "' disabled ></div><div class='col-lg-3 remove_field' id='" + y + "'" + " style='margin-top:10px;margin-left:-8px;width:20px;' ><i class='fa fa-minus-circle'></i></div></div>"); //add input box
                        }


                        $(add_button).click(function (e) {
                            e.preventDefault();
                            if (x < max_fields) {
                                x++;
                                itemSize++;
                                $(wrapper).append("<div class='row' style='padding-top:10px'><div class='col-lg-3'><input type='text' name='autocomplete" + x + "'" + "id='autocomplete" + x + "'" + "class='form-control auto-input' style='width:200px'  placeholder='Type Medicine name' value=''></div><div class='col-lg-3' style='width:100px;margin-left:80px'><input type='number' min='1' value='1' onChange='myFunction(this.id)'  autocomplete='off' name='qty" + x + "'" + "id='qty" + x + "'" + " class='form-control'  placeholder='Qty.'></div><div class='col-lg-3'  style='width:120px;margin-left:-8px' ><input type='text' id='price" + x + "'" + "class='form-control'placeholder='Total' > <input type='hidden' name='pricee" + x + "'" + " id='pricee" + x + "'" + "  class='form-control'  placeholder='Total' ></div><div class='col-lg-3'  style='width:120px;margin-left:-8px' ><input type='text' id='discount" + x + "'" + "class='form-control'placeholder='Discount' value='' disabled></div><div id='" + x + "'" + "class='col-lg-3 remove_field'  style='margin-top:10px;margin-left:-8px;width:20px;' ><i class='fa fa-minus-circle'><input id='item_code" + x + "'" + "name='item_code" + x + "'" + " type='hidden' value='0' ></i></div></div>"); //add input box
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
                                $("#price" + id).val(suggestion.mrp);
                                $("#autocomplete" + id).val(suggestion.value);
                                $("#pricee" + id).val(suggestion.mrp);
                                $("#price" + id).val(suggestion.mrp);
                                $("#item_code" + id).val(suggestion.data);
                                $("#discount" + id).val(((suggestion.discount == 0) ? discount : suggestion.discount));
                                $("#itemS").val(id);
                            }
                        });
                    });

                    function calculate(id, val) {
                        var id2 = id.match(/\d+/)[0];

                        $("#price" + id2).val(document.getElementById("qty" + id2).value * document.getElementById("pricee" + id2).value);
                    }
                </script>
            </div>
            <?php if ($status == 1) {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <button style="float:right" id="add_field_button" class="btn btn-s-md btn-success">Verify
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
