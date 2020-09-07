@include('...header')

        <div class="jumbotron">
            <div class="jumb-layer"></div>
            <input type="hidden" name="msg" id="msg" value="<?php if(isset($_GET['msg'])) echo $_GET['msg'];?>">
            <div class="container">
                    <h1>Buy medicines online. It’s easy as its name.</h1>
                    <p >Buying medicines was never this easy. Stay at the comfort of your home and get medicines delivered

to your door- step. And it’s double the gain when our discounted rates offer you the benefit of extra

savings! </p><br>
                <div class="search-box container">
                 <span class="med_search_loader" style="display: none;"><img src="assets/images/loader1.gif" /></span>
                    <h3>Search Medicine</h3>
                    <div class="row-search">

                        <div class="input-group back_ground_loader">

                          <input type="text" id="tags" class="form-control search_medicine" placeholder="Eg: Paracetamol 650">

                        <span class="input-group-btn">
                            <button class="btn btn-default ripple" type="button" data-color="#39F2F9" onclick="goto_detail_page();">
                                <img src="assets/images/search-icon.png" />

                            </button>
                        </span>

                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="alert" id="new_med_status" style="margin: 0 auto;display: none; width: 896px; font-size: 18px">
                    </div>
                </div>
            </div>

        </div>
    <!-- jumbotron -->

        <div class="upload-section">
                @if ( Session::has('flash_message') )
                    <div class="alert {{ Session::get('flash_type') }}" style="margin: 0 auto; width: 800px">
                        <h5 style="text-align: center; font-size: 22px">{{ Session::get('flash_message') }}</h5>
                    </div>
                @endif
                <div class="container">
                    <div class="upload-img"></div>

                         {{ Form::open(array('url'=>'medicine/store-prescription/1','files'=>true,'id'=>'upload_form')) }}
                         <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input id="input-20" type="file" name="file"  class="prescription-upload" >
                        <span style="display: none;">   <input type="submit" id="upload">  </span>
                       {{ Form::close() }}

                    <h3>Click Here To Upload Your Prescription</h3>
                </div>
        </div>


    <!-- upload section -->
    <div class="app-section">
        <div class="container">
            <h3>Now you can try with our Mobile App</h3>
            <p>{{ Setting::param('site','app_name')['value'] }} Mobile app is at your fingertips to facilitate smarter buying of medicines. The App

is available both for iOS and Android platforms.</p>
            <div class="app-container">
                <div class="app-store-img">
                    <a href="#">
                        <img src="assets/images/google_play.png" alt="{{ Setting::param('site','app_name')['value'] }} Google Play" />
                    </a>
                </div>
                <div class="app-store-img">
                    <a href="#">
                        <img src="assets/images/app_store.png" alt="{{ Setting::param('site','app_name')['value'] }} App Store" />
                    </a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
@include('...footer')

<div id="resultModal" class="modal fade " role="dialog">
   <div class="modal-dialog" style="width: 600px !important;">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title" id="res-title"></h4>
       </div>
       <div class="modal-body" style="font-size: 18px; text-align: center" id="res-content">  </div>

     </div>

   </div>
 </div>
<script type="text/javascript">

$(document).ready(function () {
        var msg = $('#msg').val();
        if (msg == "success") {
            $('#res-title').css('color','green');
            $('#res-title').html('Success');
            $('#res-content').html('Your account is activated successfully. You can login now.');
            $('#resultModal').modal({
            });
        }else if(msg == "failed"){
            $('#res-title').css('color','red');
            $('#res-title').html('Failed');
            $('#res-content').html('Something went wroing. Please try again later.');
            $('#resultModal').modal({
            });
        }
    });

var current_item_code="";

$(".search_medicine").autocomplete({
    search: function(event, ui) {
        $('.med_search_loader').css('display','block' );
    },
    open: function(event, ui) {
        $('.med_search_loader').css('display','none' );
    },
    source: '{{ URL::to('medicine/load-medicine-web/1' )}}',
    minLength: 0,
    select: function (event, ui) {
            item_code = ui.item.item_code;
            current_item_code=item_code;
     },
        response: function( event, ui ) {
         $('.med_search_loader').css('display','none' );
        }
})

function goto_detail_page()
     {
     var name=$(".search_medicine").val();
     if(current_item_code=="")
     {
        $.ajax({
        url: 'medicine/add-new-medicine',
        data: 'name='+name,
        type: 'POST',
        datatype: 'JSON',
        success: function (data) {
                if(data.status)
                {
                    $('#new_med_status').show();
                    $('#new_med_status').addClass('alert-success');
                    $('#new_med_status').html('This medicine is not available for now. Please check availability later.');
                    $("#new_med_status").delay(5000).fadeOut("slow");
                }else
                {
                    $('#new_med_status').show();
                    $('#new_med_status').addClass('alert-danger');
                    $('#new_med_status').html('Something went wrong. Please try again later.');
                    $("#new_med_status").delay(5000).fadeOut("slow");
                }
            }
        });
     }
     else{
        window.location="medicine-detail/"+current_item_code;
     }
     }

     $("#input-20").change(function() {
        if($('#input-20').val().length!=0)
        {
        $.ajax({
                url: 'user/check-session',
                type: 'GET',
                datatype: 'JSON',
                success: function (data) {
                        if(data==1)
                        {
                            $('#upload').click();
                        }else{
                            $('#loginModal').click();
                        }
                    }
                });

        }
     });

</script>
