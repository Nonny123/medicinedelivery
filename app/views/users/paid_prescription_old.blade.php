@include('...header')
/<script>
    $(function () {
        $("#accordion").accordion();
    });
</script>

<div class="contact-container">
<div class="prescription-inner container">
<div class="col-sm-8">
    <h1 class="prescription-h1">Payment made. Awaiting shipping</h1>
</div>
<div class="col-sm-4">
    <div class="right-inner-addon">
        <button type="button" class="btn btn-primary logout-btn ripple" data-color="#4BE7EC"
                onclick="goto_detail_page();">SEARCH
        </button>
        <input type="text" id="tags" class="form-control search_medicine" placeholder="Search medicines here"/>
    </div>
</div>
<div class="clear"></div>
<div class="prescription-cont">
<div class="col-sm-9">
<div class="prescription-left">


<!--   <div class="col-sm-6 search-medicine">
       <div class="col-sm-5">
           <label>Sort By Medicines</label>
       </div>
       <div class="col-sm-7">
           <div class="right-inner-search">
               <button type="button" class="btn btn-primary logout-btn ripple" data-color="#4BE7EC"><i class="icon-search2"></i></button>
               <input type="search" class="form-control" placeholder="All Medicines" />
           </div>
       </div>
       <div class="clear"></div>
   </div>-->

<div class="clear"></div>
<div class="table-responsive">
    <table class="table prescription-table">
        <tr>
            <td>
                <table class="tab-pres-head">
                    <thead>
                    <th>Date Added</th>
                    <th>Medicines</th>
                    <th>Units</th>
                    <th>Price</th>
                    </thead>
                </table>
            </td>
        </tr>
    </table>
</div>
<div class="table-responsive">
    <table class="table prescription-table">
        <tr>
            <td>
                <div class="presc-cont1">
                    <div id="accordion">
                        <?php

                        $email = Session::get('user_id');
                        $totalprice = 0;
                        $discount = 0;
                        $date = new DateTime();

                        if (count($prescriptions) > 0)
                        {
                            $invoice_number = array();
                            for ($i = 0; $i < count($prescriptions); $i++) {

                                if ($prescriptions[$i]->invoice_number == null) {
                                    $real_invoice = "dummy_invoice" . $i;
                                } else {
                                    $real_invoice = $prescriptions[$i]->invoice_number;
                                }
                                array_push($invoice_number, $real_invoice);
                            }
                            $uniq_invoice = array_unique($invoice_number);  //getting unique invoice number
                            foreach ($uniq_invoice as $key => $value) {
                                $puchase_invoice = $prescriptions[$key]->invoice_number;
                                if ($prescriptions[$key]->status == 'pending') {
                                    //$collapse = 'ui-state-disabled';
                                    $collapse = '';
                                } else {
                                    $collapse = '';
                                }

                                ?>
                                <h3 class="{{ $collapse; }}">
                                    <table class="tab-presc2">
                                        <tbody>
                                        <tr class="prescription-content">
                                            <td>
                                                <img class=""
                                                     src="{{ URL::asset('/public/images/prescription/'.$email.'/'.$prescriptions[$key]->path) }}"
                                                     height="60" width="60"><span
                                                    class="date-added"><?php echo $date->format('Y-m-d') ?> </span>
                                            </td>
                                            <td colspan="2" class="txt-green">
                                                {{'Paid'}}
                                            </td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </h3>
                                <div>
                                    <table class="tab-presc2">
                                        <tbody>
                                        <?php
                                        $totalprice=0;
                                        $discount=0;
                                        for ($k = $key; $k < count($prescriptions); $k++) {
                                            if ($prescriptions[$k]->invoice_number == $uniq_invoice[$key]) {

                                                if ($prescriptions[$k]->discount == null) {
                                                    $line_discount = 0;
                                                } else {
                                                    $line_discount = $prescriptions[$k]->discount;
                                                }
                                                $totalprice += round($prescriptions[$k]->unit_price * $prescriptions[$k]->qty, 2);

                                                $discount += $line_discount * $prescriptions[$k]->qty * $prescriptions[$k]->unit_price / 100;




                                                ?>

                                                <tr class="prescription-content">
                                                    <td></td>
                                                    <td style="text-align: left">{{ $prescriptions[$k]->item_name }}</td>
                                                    <td>{{ $prescriptions[$k]->qty }}</td>
                                                    <td>{{ round($prescriptions[$k]->unit_price *
                                                        $prescriptions[$k]->qty,2) }}
                                                    </td>
                                                </tr>



                                            <?php

                                            } else {
                                                break;
                                            }
                                        }

                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2">
                                                <table class="tbl-inside">
                                                    <tr>
                                                        <td class="sub-total">Sub total:</td>
                                                        <td><span class="num-strike"></span> {{ $totalprice }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td class="sub-total">Shipping cost</td>
                                                        <td> {{ $prescriptions[$key]->shipping }}</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="sub-total">Discount</td>
                                                        <td> {{ round($discount,2) }}</td>

                                                    </tr>


                                                    <tr>
                                                        <td></td>
                                                        <td>Net Payable: <span class="sub-total">{{ round($totalprice-$discount,2)+$prescriptions[$key]->shipping }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php if ($prescriptions[$key]->status != 'shipped') {?>
                                        <tr class="prescription-tab">
                                            <td>&nbsp;</td>
                                            <td colspan="2"><a
                                                    href="{{ URL::to('medicine/downloading/'.$prescriptions[$key]->path) }}">
                                                    <i class="icon-download"></i> </a> Download Prescription
                                            </td>
                                            <td>
                                                <?php if ($prescriptions[$key]->status == 'active') {?>
                                                <button type="button" class="btn btn-primary buynow-btn ripple"
                                                        invoice="<?php if ($puchase_invoice != null) {
                                                            echo $puchase_invoice;
                                                        } ?>" data-color="#A3C4E5" onclick="purchase(this)">BUY NOW
                                                </button>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                               <?php
                            }
                        }else{
                        ?>
                    </div>
                    <h4 style="padding: 10px; text-align: center">No search results found for this category</h4>
                    <?php
                    }
                    ?>
                </div>
</div>
</td>
</tr>
</table>
</div>
</div>
</div>
<!-- col 9 -->
<div class="col-sm-3">
    <div class="prescription-right">
        <div class="col-sm-12">
            <h2 style="text-align: center">Upload Prescription</h2>

            <div class="upload-pres ">
                <p>You can use either JPG or PNG images. We will identify the medicines and process your order at the earliest.</p>
                @if ( Session::has('flash_message') )
                <div class="alert {{ Session::get('flash_type') }}">
                    <h5 style="text-align: center">{{ Session::get('flash_message') }}</h5>
                </div>
                @endif
                <div class="col-sm-12 file-upload">

                    <i class="icon-browse-upload"></i>

                    <p>Upload your prescription here</p>
                    {{ Form::open(array('url'=>'medicine/store-prescription/1','files'=>true,'id'=>'upload_form')) }}
                    <input id="input-20" type="file" name="file"
                           class="prescription-upload custom-file-input cart_file_input" required="required">

                </div>
                <button type="submit" class="btn btn-primary save-btn ripple" data-color="#40E0BC" id="upload">UPLOAD
                </button>
                {{ Form::close() }}

                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- col 3 -->
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<!-- prescription-cont -->
</div>
<footer>
    <div class="container innerBtm">
        @include('...footer')
        <script type="text/javascript">
//            $(document).on({
//                ajaxStart: function () {
//                    $('.search_medicine').addClass('search_medicine_my_cart my_cart_search');
//                },
//                ajaxStop: function () {
//                    $('.search_medicine').removeClass('search_medicine_my_cart my_cart_search');
//                }
//
//            });

            $(document).ready(function () {
                $('.ui-accordion-content').css('display', 'none');
            });


            var current_item_code;
            $(".search_medicine").autocomplete({
                search: function(event, ui) {
                    $('.search_medicine').addClass('search_medicine_my_cart my_cart_search' );
                },
                open: function(event, ui) {
                    $('.search_medicine').removeClass('search_medicine_my_cart my_cart_search' );
                },
                source: '{{ URL::to('medicine/load-medicine-web/1' )}}',
                minLength : 0,
                select : function (event, ui) {
                    item_code = ui.item.item_code;
                    current_item_code = item_code;

                }
            })
            ;
            function goto_detail_page() {
                $(".search_medicine").val("");
                var serched_medicine = $(".search_medicine").val();
                window.location = "{{URL::to('medicine-detail/')}}/" + current_item_code;

            }
            function purchase(obj) {
                var invoice = $(obj).attr('invoice');
                window.location = "{{URL::to('medicine/make-payment/')}}/" + invoice;

            }
            function change_list() {
                //alert($('.category').val());
                var category = $('.category').val();

                window.location = "{{URL::to('my-prescription')}}/" + category;
            }
        </script>