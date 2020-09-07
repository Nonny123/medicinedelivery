@include('admin/header')
           <div style="padding:20px">
              <div class="row">
                <div class="col-sm-6">
		  <div class="panel b-a" style="height:270px;" >
                        <div class="row m-n" >
                          <div class="col-md-6 b-b b-r" >
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                <i class="fa fa-user text-white"></i>
                              </span>
                              <span class="clear">
                                <a href="{{url()}}/admin/load-customers" class="auto">
                                <span id="cust" class="h3 block m-t-xs text-danger"></span>
                                <small class="text-muted text-u-c">Customers</small>
                              </span>
                            </a>
                          </div>
                          <div class="col-md-6 b-b">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                <i class="fa fa-user-md text-white"></i>
                              </span>
                              <span class="clear">
                                <a href="{{url()}}/admin/load-medicalprof" class="auto">
                                <span id='prof' class="h3 block m-t-xs text-success"></span>
                                <small  class="text-muted text-u-c">Total Medical Professionals</small>
                              </span>
                            </a>
                          </div>
                          <div class="col-md-6 b-b b-r">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                <i class="fa fa-truck text-white"></i>
                              </span>
                              <span class="clear">
                                <a href="{{url()}}/load-prescription-paid" class="auto">
                                <span id='tobe' class="h3 block m-t-xs text-info">25 <span class="text-sm">m</span></span>
                                <small class="text-muted text-u-c">To be shipped</small>
                              </span>
                            </a>
                          </div>
                          <div class="col-md-6 b-b">
                            <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                <i class="fa fa-truck text-white"></i>
                              </span>
                              <span class="clear">
                                <a href="{{url()}}/load-prescription-shipped" class="auto">
                                <span id='shipped'class="h3 block m-t-xs text-primary">9:30</span>
                                <small class="text-muted text-u-c">Shipped</small>
                              </span>
                            </a>
                          </div>
                          
                        </div>
                        
                      </div>
                      
                    </div>
                    
                         <div class="col-sm-6">
	                
	                 <div class="panel b-a scrollable padder"  style='max-height:270px;'>
	                  <div class="row m-n">
          	           <div id="todaysP">
          	           
       			   </div>         	
        	     	  </div>
        	     	</div>
        	     	
                  </div>
                  
                  
             </div>
             <section class="panel panel-default">
                <header class="panel-heading font-bold">Sale statistics</header>
                <footer class="panel-footer bg-white">
                  <div class="row text-center no-gutter">
                    <div class="col-xs-3 b-r b-light">
                      <p  class="h3 font-bold m-t"><span id='pres'></span></p>
                      <p class="text-muted">Verified Prescriptions</p>
                    </div>
                    <div class="col-xs-3 b-r b-light">
                      <p class="h3 font-bold m-t"><span id='rev'></span></p>
                      <p class="text-muted">Total Revenue</p>
                    </div>
                    <div class="col-xs-3 b-r b-light">
                      <p  class="h3 font-bold m-t"><span id='med'></span></p>
                      <p class="text-muted">Items/Medicines</p>
                    </div>
                    <div class="col-xs-3">
                      <p  class="h3 font-bold m-t"><span id='user'></span></p>
                      <p class="text-muted">Users(Including Admin)</p>
                    </div>
                  </div>
                </footer>
              </section>
              
              <section class="panel panel-default" style="width:50%">
                <header class="panel-heading font-bold">This Month's statistics</header>
                <footer class="panel-footer bg-white">
                  <div class="row text-center no-gutter">
                    <div class="col-xs-3 b-r b-light" style="width:50%">
                      <p  class="h3 font-bold m-t"><span id='monthpres'></span></p>
                      <p class="text-muted">Verified Prescriptions</p>
                    </div>
                    <div class="col-xs-3  b-light" style="width:50%">
                      <p class="h3 font-bold m-t"><span id='monthrev'></span></p>
                      <p class="text-muted">Revenue</p>
                    </div>
                  </div>
                </footer>
              </section>
              
              
             <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
                       	<script>
                        	var not = '<?php echo URL::to('admin/today-pres-dash'); ?>';
				$(document).ready(function(e){
				document.getElementById('searchTop').style.display = 'none';
				$.ajax({
							   type: "GET",
							   url : not,
							   dataType: 'json',
							   success: function (data) {
									$('#todaysP').html(data.notif);
									//$('#todaysCount').html(data.todaysCount);
									}
					});
				var det = '<?php echo URL::to('admin/dash-ord'); ?>';
				$.ajax({
							   type: "GET",
							   url : det,
							   dataType: 'json',
							   success: function (data) {
									$('#cust').html(data.cust);
									$('#prof').html(data.prof);
									$('#tobe').html(data.tobe);
									$('#shipped').html(data.shipped);
									}
					});
				var detail = '<?php echo URL::to('admin/dash-detail'); ?>';
				$.ajax({
				
				
							   type: "GET",
							   url : detail,
							   dataType: 'json',
							   success: function (data) {
							   	
									$('#med').html(data.med);
									$('#user').html(data.user);
									$('#pres').html(data.pres);
									$('#monthpres').html(data.mp);
									$('#rev').html((data.rev));
									$('#monthrev').html(data.mr);
									}
					});
				});
	     		</script>
@include('admin/footer')
    
