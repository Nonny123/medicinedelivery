@include('...header')
<?php
if(count($med_info)>0)
{
 ?>

<div class="contact-container">

        <div class="details-page-inner container">
          <div class="alert alert-success med_detailes_alert" style="display: none;" role="alert"> </div>
          <div class="alert alert-danger w_med_detailes_alert" style="display: none;" role="alert"></div>
            <div class="detail-page-header">
                <div class="col-sm-8">
                    <div class="border-btm">
                        <div class="col-sm-7 nopadding">
                           <input type="hidden" id="hidden_medicine_id" value="{{{ $med_info[0]->id }}}">
                           <input type="hidden" id="hidden_medicine" value="{{{ $med_info[0]->item_name }}}">
                           <input type="hidden" id="hidden_selling_price" value="{{{ $med_info[0]->selling_price }}}">
                           <input type="hidden" id="hidden_item_code" value="{{{ $med_info[0]->item_code }}}">
                           <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">

                            <h4 class="buynow-title">{{{ $med_info[0]->item_name }}} </h4>
                        </div>
                        <div class="col-sm-5 nopadding txt-align-right">
                            <span class="buy-now-txt-blue">Price/Tablet : {{ Setting::currencyFormat($med_info[0]->selling_price) }}</span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="right-inner-addon">
                        <button type="button"  class="btn btn-primary logout-btn ripple" data-color="#4BE7EC" onclick="goto_detail_page();">SEARCH</button>
                        <input type="text" id="tags" class="form-control search_medicine"  placeholder="Search another medicine" />

                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="prescription-cont">
                <div class="col-sm-9">
                    <div class="detail-left">
                        <div class="border-btm2">
                            <div class="col-sm-6 nopadding"><h2 class="title-buy-details">Information</h2></div>

                            <div class="col-sm-6 nopadding txt-align-right btn-save-order">
                              Quantity: <input type="number" value="1" min="1" id="med_quantity" placeholder="Enter Quantity">
                                <button type="button" class="btn btn-primary save-btn ripple add_to_cart" data-color="#40E0BC">Add to cart</button>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="col-sm-11 nopadding">
                        <?php if($med_info[0]->marketed_by!="Not available" || $med_info[0]->manufacturer!="Not available"){?>
                            <div class="info-content">
                                <h2>Marketed By</h2>
                                <p id="mfg"><?php  if($med_info[0]->marketed_by!="Not available") echo $med_info[0]->marketed_by; elseif($med_info[0]->manufacturer!="Not available") echo $med_info[0]->manufacturer; ?></p>
                            </div>
                            <?php }?>
                            <div class="info-content">
                                <h2>Composition</h2>
                                <table>
                                <?php
                                $composition=(explode(",",$med_info[0]->composition))
                                 ?>
                                 @if(count($composition)>0)
                                    @for($i=0;$i<count($composition);$i++)
                                    <tr>
                                        <td>{{{ $composition[$i] }}}</td>
                                        <td></td>
                                    </tr>
                                   <!-- <tr>
                                        <td>Chlorpheniramine maleate</td>
                                        <td>42 mg</td>
                                    </tr>
                                    <tr>
                                        <td>Pseudoephedrine hydrochloride</td>
                                        <td>02 mg</td>
                                    </tr>-->
                                    @endfor
                                  @endif
                                </table>

                            </div>
                            <div class="info-content">
                                <h2>Drug Type</h2>
                                <p id="drug">{{$med_info[0]->group}}</p>
                            </div>
                        </div>
                        <div class="col-sm-1">
&nbsp;
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <!-- col 9 -->
                <div class="col-sm-3">
                    <div class="prescription-right">
                        <div class="col-sm-12">
                            <h2>Alternatives</h2>
                            <div class="alter-list">

                             <span class="med_search_loader"><img src=" {{URL::to('assets/images/loader1.gif')}}" /></span>

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
    <?php } ?>
        <div class="container innerBtm">


@include('...footer')

<script type="text/javascript">
//$(document).on({
//   ajaxStart: function() { $('.search_medicine').addClass('search_medicine_my_cart my_cart_search' );    },
//   ajaxStop: function() { $('.search_medicine').removeClass('search_medicine_my_cart my_cart_search' ); }
//});
var current_item_code;
$(".search_medicine").autocomplete({
    search: function(event, ui) {
        $('.search_medicine').addClass('search_medicine_my_cart my_cart_search' );
    },
    open: function(event, ui) {
        $('.search_medicine').removeClass('search_medicine_my_cart my_cart_search' );
    },
    source: '{{ URL::to('medicine/load-medicine-web/1' )}}',
    minLength: 0,
    select: function (event, ui) {
            item_code = ui.item.item_code;
           current_item_code=item_code;

     }
})
  function goto_detail_page()
     {
     $(".search_medicine").val("");
     var serched_medicine=$(".search_medicine").val();
      window.location="{{URL::to('medicine-detail/')}}/"+current_item_code;

     }
window.onload = function() {
  fetch_alternatives();
};

function fetch_alternatives()
{
var hidden_medicine=$('#hidden_medicine').val();
var hidden_medicine_id=$('#hidden_medicine_id').val();
var alternative="";
var count=1;

                $.ajax({
                  type: "GET",
                  url: '{{ URL::to('medicine/load-sub-medicine' )}}',
                  data: "n="+hidden_medicine+"&id="+hidden_medicine_id,
                  datatype: 'json',
                  complete:function(data){

                  },
                  success: function (data) {
                    if(data[0].result.status=="failure" || data[0].result.msg.length == 0)
                    {
                    alternative="<p style='text-align: center; padding-top: 15px; font-size: 16px'>No alternate medicines available</p>";
                    $('.alter-list').html(alternative);
                    }
                    alternative+="<ol>";
                    for(i=0;i<(data[0].result.msg.length);i++)
                    {
                    var st="";
                    if(parseFloat(data[0].result.price) >= parseFloat(data[0].result.msg[i].selling_price))
                    {
                        var st="style='color:green'";
                    }else if(parseFloat(data[0].result.price) < parseFloat(data[0].result.msg[i].selling_price)){
                        var st="style='color:red'";
                    }
                    count=+1;
                    alternative+=" <li>";
                    alternative+='<a href="{{URL::to('medicine-detail/')}}/'+ data[0].result.msg[i].item_code +'"><p><span> '+(i+1)+' .</span>'+data[0].result.msg[i].item_name+'</p></a>';
                    alternative+="<p "+ st +">MRP "+data[0].result.msg[i].mrp+"</p>";
                    alternative+="</li>";
                    }

                    alternative+="</ol>";
                    $('.alter-list').html(alternative);
                  }
                });
}

$('.add_to_cart').click(function(){

var hidden_medicine=$('#hidden_medicine').val();
var med_quantity=$('#med_quantity').val();
var hidden_item_code=$('#hidden_item_code').val();
var hidden_selling_price=$('#hidden_selling_price').val();
var _token=$('#_token').val();
var id=$('#hidden_medicine_id').val();
    if(med_quantity.length>0 && med_quantity >0 )
    {
          $.ajax({
                  type: "GET",
                  url: '{{ URL::to('medicine/add-cart/0' )}}',
                  data: "id="+id+"&medicine="+hidden_medicine+"&med_quantity="+med_quantity+"&hidden_item_code="+hidden_item_code+"&hidden_selling_price="+hidden_selling_price+"&_token="+_token,
                  datatype: 'json',
                  complete:function(data){

                  },
                  success: function (data) {
                   if(data==0)
                   {
                     $('#loginModal').click();
                   }
                   if(data=="updated")
                   {
                    $('.med_detailes_alert').css('display', 'block' );
                    $(".med_detailes_alert").html("Your cart has been successfully updated.");
                    $(".med_detailes_alert").delay(5000).fadeOut("slow");


                   // alert("your order is updated");
                   }
                   if(data=="inserted")
                   {
                   $('.med_detailes_alert').css('display', 'block' );
                   $(".med_detailes_alert").html("Your cart has been successfully updated.");
                   $(".med_detailes_alert").delay(5000).fadeOut("slow");
                    window.location="{{URL::to('my-cart/')}}";
                   }

                  }
                });


    }
    else
    {
    $('.w_med_detailes_alert').css('display', 'block' );
    $(".w_med_detailes_alert").html("Please Fill quantity field");
    $(".w_med_detailes_alert").delay(3000).fadeOut("slow");
    }

 });

</script>
