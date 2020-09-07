<html>
<head>
</head>
<body>
<style>

.autocomplete-suggestion{
  padding:7px !important;
  background-color:#f5f5f5;
  border-style: solid;
  border-width:1px;
  border-color:#ddd;
}
</style>

<link rel="stylesheet" href="<?php echo url(); ?>/assets/adminFiles/css/bootstrap-spinner.css" type="text/css" />

<section id="content">
          <section class="vbox bg-white">
            <header class="header b-b b-light hidden-print">
            </header>
            <section class="scrollable wrapper">
              <div class="row">
                
                <div class="col-xs-6">
                  <div>
                  <img width='20%' style='float:left' src=" <?php echo SYSTEM_IMAGE_URL.Setting::param('site', 'logo')['value']; ?>" /></br></br></br>
                  <div>
                  <h4> <?php echo Setting::param('site', 'app_name')['value']; ?> Inc.</h4>
                  <p><a href="<?php echo Setting::param('site', 'website')['value']; ?>"> <?php echo Setting::param('site', 'website')['value']; ?></a></p>
                  <p> <?php echo Setting::param('site', 'app_name')['value']; ?> <br>
                    <?php $text = Setting::param('site','address')['value'];
                                                $text_array = explode(" ", $text);
                                                $chunks = array_chunk($text_array, 3);
                                                foreach ($chunks as $chunk) {
                                                    $line = implode(" ", $chunk);
                                                    echo $line;
                                                    echo "<br>";
                                                }

                                                ?>
                                                {{ Setting::param('site','mail')['value'] }}
                  </p>
                </div>

              </div>          
              <div class="well m-t">
                <div class="row">
                  <div class="col-xs-6" >
                    <strong >TO:</strong>
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
              <p class="m-t m-b">Order date: <strong><?php echo date('Y-m-d',$orderDate) ?></strong><br>
                  Order status: <span class="label bg-success">Shipped</span><br>
                  Order ID: <strong>#<?php echo $id?></strong>
              </p>
              <div class=""></div>
              <table class="table">
                <thead>
                  <tr>
                    <th >SL</th>
                    <th>DESCRIPTION</th>
                    <th >QTY</th>
                    <th >UNIT PRICE</th>
                    <th >TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php echo $tbody?>
                  
	
                </tbody>
              </table>              
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>

</body>


</html>
