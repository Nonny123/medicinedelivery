@include('admin/header')

<style>

.autocomplete-suggestion{
  padding:7px !important;
  background-color:#f5f5f5;
  border-style: solid;
  border-width:1px;
  border-color:#ddd;
}
</style>

<link rel="stylesheet" href="{{url()}}/assets/adminFiles/css/bootstrap-spinner.css" type="text/css" />

<section id="content">
          <section class="vbox bg-white">
            <header class="header b-b b-light hidden-print">
              <button href="#" class="btn btn-sm btn-info pull-right" onclick="window.print();">Print</button>
              <p>Invoice</p>
            </header>
            <section class="scrollable wrapper">
              <div class="row">
                <div class="col-xs-6">
                   <div class="col-lg-12"><a href="{{ Setting::param('site','website')['value'] }}"> <img width='30%' style='float:left' src="{{SYSTEM_IMAGE_URL.Setting::param('site','logo')['value'] }}" ></div>
                  <div class="col-lg-12"><p><?php $text = Setting::param('site','address')['value'];
                                                 $text_array = explode(" ", $text);
                                                 $chunks = array_chunk($text_array, 3);
                                                 foreach ($chunks as $chunk) {
                                                     $line = implode(" ", $chunk);
                                                     echo $line;
                                                     echo "<br>";
                                                 }

                                                 ?>
                                                 {{ Setting::param('site','mail')['value'] }}
                  </p></div>
                </div>
                <div class="col-xs-6 text-right">
                  <p class="h4"><?php echo $id?></p>
                  <h5><?php echo $date?></h5>           
                </div>
              </div>          
              <div class="well m-t">
                <div class="row">
                  <div class="col-xs-6">
                    <strong>TO:</strong>
                    <h4><?php echo $details['fname']." ".$details['lname']?></h4>
                    <p>
                      <?php echo $details['addr']?><br>
                      <?php echo $details['pin']?><br>
                      Phone: <?php echo $details['ph']?><br>
                      Email: <?php echo $details['mail']?><br>
                    </p>
                  </div>
                </div>
              </div>
              <p class="m-t m-b">Order date: <strong><?php echo date('Y-m-d',strtotime($orderDate)) ?></strong><br>
                  Order status: <span class="label bg-success"><?php echo $status; ?></span><br>
                  Order ID: <strong>#<?php echo $id?></strong>
              </p>
              <div class="line"></div>
              <table class="table">
                <thead>
                  <tr>
                    <th width="60">SL</th>
                    <th>DESCRIPTION</th>
                    <th class='text-right' width="60">QTY</th>
                    <th class='text-right' width="140">UNIT PRICE</th>
                    <th class='text-right' width="140">SUB TOTAL</th>
                    <th class='text-right' width="140">UNIT DISCOUNT</th>
                    <th class='text-right'width="140">DISCOUNT</th>
                    <th class='text-right' width="90">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  
                  
                  
	
                </tbody>
              </table>              
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
        
@include('admin/footer')


    <script>
        $(document).ready(function(e){
                document.getElementById('searchTop').style.display = 'none';
                itemList='{{url()}}/admin/load-invoice-items/'+<?php echo $invID?>;
                // <?php echo $invID ?>
                console.log(itemList);
                $.ajax({
                type: "GET",
                url : itemList,
                dataType: 'json',
                success: function (data) {
                $('.table tbody').html(data.tbody);
                }
            });
        });
    </script>
