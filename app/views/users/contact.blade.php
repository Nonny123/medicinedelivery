@include('...header')


    <script type="text/javascript">
    $(document).on({
       ajaxStart: function() {
                    $('.mail_loader').css('display', 'inline' );
                    // $(".mail_btn").disabled =true;
                    //  document.getElementById('.mail_btn').disabled = true;
                  },
       ajaxStop: function() {
                    $('.mail_loader').css('display', 'none' );
                    $('.mail_alert').css('display', 'block' );
                    $(".mail_alert").delay(10000).fadeOut("slow");
                    //document.getElementById('.mail_btn').disabled = false;
                    //$(".mail_btn").disabled =false;
                  }
    });
		$(document).ready(function(e) {

			$('.contact-form').validate({

				 submitHandler: function(form) {
						var edname = $('#name').val();
						var edemail = $('#email').val();
						var edmsg = $('#msg').val();
						var token = $('#_token').val();


						$.ajax({
							url:'user/contact-us',
							type:'POST',
							data:{name:edname,email:edemail,msg:edmsg,submits:1,_token:token},
							success: function(alerts){

									$('.form-result3').html(alerts).fadeOut(8000);

										$('.contact-form')[0].reset();
									if(alerts==0)
										{
										$('.mail_alert').html("Failed to send your mail! Please send again ");
										}

									}
						});

					}
			});
        });
    </script>

    <div class="contact-container">
        <div class="contact-inner container">

            <div class="col-sm-3">

                <h1 class="contact-h1">Contact Us</h1>
            </div>

            <div class="col-sm-9 contact-right-section">
                <div class="contact-right-upper">
                <div class="alert alert-success mail_alert" style="display: none;" role="alert"> Your enquiry has been submitted successfully. We will get back to you shortly</div>
                    <h2 class="contact-h2">Get in touch with us</h2>
                    <p>Please feel free to reach out to us. We will be more than happy to help.</p>
                   <!--<div class="form-result3" style="position: absolute;top: 45px;left: 795px;color: #4F8A10;font-size: 14px;"></div>-->
                    <form class="form-horizontal contact-form" role="form" action="<?php echo URL; ?>/user/contact-us" method="POST" >
                         <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
                        <div class="col-sm-8">

                            <div class="col-sm-6">
                                <input class="form-control" type="text" name="name" id="name" placeholder="Your Name" required />
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email ID" required>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="form-control" type="text" name="msg" id="msg" placeholder="Enter your message here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary save-btn ripple mail_btn" data-color="#40E0BC">&nbsp;Send&nbsp;</button> <img class="mail_loader" style="display: none;" src="<?php echo URL; ?>/assets/images/loader1.gif">
                        </div>
                        <div class="col-sm-4">

                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
                <div class="connect-with">

                    <div class="col-sm-12">
                        <h2 class="contact-h2">Connect with us</h2>
                        <div class="col-sm-3 " style="text-align:center"">
                            <div class="contact-icon-bg" style="margin: 10px auto"><i class="icon-phone"></i></div>
                            <p>{{ Setting::param('site','phone')['value'] }}</p>
                            <!--<p>+91 980 989 4776</p>-->
                        </div>
                        <div class="col-sm-3 " style="text-align:center"">
                            <div class="contact-icon-bg" style="margin: 10px auto"><i class="icon-address"></i></div>
                             <p><?php $text = Setting::param('site','address')['value'];
                                                 $text_array = explode(" ", $text);
                                                 $chunks = array_chunk($text_array, 3);
                                                 foreach ($chunks as $chunk) {
                                                     $line = implode(" ", $chunk);
                                                     echo $line;
                                                     echo "<br>";
                                                 }

                                                 ?>

                  </p>
                        </div>
                        <div class="col-sm-3 " style="text-align:center"">
                            <div class="contact-icon-bg" style="margin: 10px auto"><i class="icon-mail"></i></div>
                            <p>{{ Setting::param('site','mail')['value'] }}</p>

                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<footer>
    <div class="container innerBtm">




@include('...footer')