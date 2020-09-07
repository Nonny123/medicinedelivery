@include('...header')

        <div class="row acc-cont">
            <div class="col-md-4 prof-left">
                <div class="profile-top">
                    <h1>My Profile</h1>
                </div>
                <div class="col-md-12 prof-pic">
                    <div class="placeholder ">
                        <div class="prof-img-bg show-image">

                            <img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="200x200" src="{{ URL::asset('/public/images/prescription/'.Auth::user()->email.'/profile_pic') }}" data-holder-rendered="true">

                       {{ Form::open(array('url'=>'user/store-profile-pic','files'=>true,'id'=>'upload_form')) }}

                       {{ Form::token() }}

                        <input id="input-20" type="file" name="file"  class="prescription-upload update"  >
                        <span style="display: none;">   <input type="submit" id="upload">  </span>
                       {{ Form::close() }}


                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="profile-btm">

                    <?php
                    if(Auth::user()->user_type_id==UserType::CUSTOMER())
                    {
                        $name=Auth::user()->customer;
                        $full_name=$name->first_name." ".$name->last_name;
                        $phone=$name->phone;
                    }
                    elseif(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL())
                    {
                        $name=DB::table('ed_professional')->where('prof_mail', Auth::user()->email)->select('prof_first_name','prof_last_name','prof_phone')->first() ;
                        $full_name=$name->prof_first_name." ".$name->prof_last_name;
                        $phone=$name->prof_phone;
                    }

                    ?>
                        <h2>{{ $full_name }}</h2>
                        <div class="border-prof"><span></span></div>
                        <p class="ph-no">{{ $phone }}</p>
                        <p class="email">{{Auth::user()->email}}</p>
                       <a href="{{ URL::to('logout') }}"> <button type="button" class="btn btn-primary btn-lg logout-btn ripple" data-color="#4BE7EC">LOGOUT</button></a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                    <a href="{{ URL::to('my-cart') }}" class="btn btn-default ripple" data-color="#F9FBFC" role="button">
                        <span class="box-icon">
                            <i class="fa fa-order"></i>
                        </span>
                        <div class="box-info">
                            <p class="size-h2">My Cart</p>
                        </div>
                    </a>
                    <a href="{{URL::to('my-prescription')}}" class="btn btn-default ripple" data-color="#F9FBFC" role="button">
                        <span class="box-icon">
                            <i class="fa fa-prescription"></i>
                        </span>
                        <div class="box-info">
                            <p class="size-h2">My Prescriptions</p>
                        </div>
                    </a>
                    <a href="{{ URL::to('my-order') }}" class="btn btn-default ripple" data-color="#F9FBFC" role="button">
                        <span class="box-icon">
                            <i class="fa fa-medicine"></i>
                        </span>
                        <div class="box-info">
                            <p class="size-h2">My Orders</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-12 addPersonal">
                <h3 id="result_text" style="background-color: #DFF0D8; padding: 10px; text-align: center; border-radius: 5px; display: none"></h3>
               <h2>Add Personal Details <span> <a href="#myModal_change_password"  data-toggle="modal">Click Here </a> To Change Password</span></h2>


                    <div class="clear"></div>
                    <div class="div-hr"></div>
                    <form class="form-horizontal addPersonalDetails" role="form">
                        <div class="col-md-6">
                            <input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="Address">Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="first_name" value="@if(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL()){{$user_data->prof_first_name;}}@else{{$user_data->first_name;}}@endif">
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="District">Last Name</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="last_name" type="text"  value="@if(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL()){{$user_data->prof_last_name;}}@else{{$user_data->last_name;}}@endif">
                                </div>
                            </div>

                            <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="Address">Address</label>
                                <div class="col-sm-9">
                                <textarea class="form-control address_area" id="address" style="padding: 10px 20px;">@if(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL()){{$user_data->prof_address}}@else{{$user_data->address}}@endif</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">



                            <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="District">phone</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="phone" type="text" placeholder="" value="@if(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL()){{$user_data->prof_phone;}}@else{{$user_data->phone;}} @endif">
                                </div>
                            </div>
                          <!--  <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="State">State</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" placeholder="">
                                </div>
                            </div>-->
                            <div class="form-group form-group-sm">
                                <label class="col-sm-3 control-label" for="Pincode">Pincode</label>
                                <div class="col-sm-9 pcode">
                                <input class="form-control" type="text" id="pincode" placeholder="" value="@if(Auth::user()->user_type_id==UserType::MEDICAL_PROFESSIONAL()){{$user_data->prof_pincode;}}@else{{$user_data->pincode;}}@endif">
                                   <!-- <input class="col-sm-2" type="text" placeholder="">
                                    <input class="col-sm-2" type="text" placeholder="">
                                    <input class="col-sm-2" type="text" placeholder="">
                                    <input class="col-sm-2" type="text" placeholder="">
                                    <input class="col-sm-2" type="text" placeholder="">
                                    <input class="col-sm-2" type="text" placeholder="">-->
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary save-btn ripple" data-color="#40E0BC">SAVE CHANGES</button>
                            <div class="changePwd"><a href="#">Click here</a> to Change Password</div>
                            <div class="clear"></div>
                        </div>



                        <div class="clear"></div>

                    </form>
<!--                            <div class="form-group">-->
<!--                                <label class="labels control-label" style="float:left;">Pincode</label>-->
<!--                                <div class="txtPincode">-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                    <input type="number" class="pincode" />-->
<!--                                </div>-->
                </div>
            </div>
            <div class="clear"></div>
        </div>



<div class="modal fade" id="resultModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <h3 id="result_content"></h3>
        </div>
    </div>
</div>
<footer>
<div class="container innerBtm">
@include('...footer')
<script type="text/javascript">

$('.save-btn').click(function(){

        var first_name=$('#first_name').val();
        var last_name=$('#last_name').val();
        var address=$('#address').val();
        var pincode=$('#pincode').val();
        var phone=$('#phone').val();
        var _token=$('#_token').val();

        $is_empty = false;
        $('.addPersonalDetails input').each(function(e){
            if($(this).val() == ""){
                $is_empty = true;
            }
        });

        if($is_empty){
            $("#result_text").html("Please enter all fields").css({'color':'red','display':'block'});return false;
            }
                $.ajax({
                  type: "POST",
                  url: '{{ URL::to('user/update-details-user/1' )}}',
                  data: "first_name="+first_name+"&address="+address+"&pincode="+pincode+"&phone="+phone+"&last_name="+last_name+"&_token="+_token,
                  datatype: 'json',
                  complete:function(data){

                  },
                  success: function (data) {

                    if(data[0].result.status=="success")
                    {
                        $("#result_text").html('Profile Updated Successfully');
                        $("#result_text").css({'color':'green','display':'block'});
                        $("#result_text").delay(5000).fadeOut("slow");
                        location.reload();
                    }
                    else
                    {
                        $(".change_pass_msg").html('Profile Updation Failed');
                        $("#result_text").css({'color':'red','display':'block'});
                        $(".change_pass_msg").delay(5000).fadeOut("slow");
                    }

                  }
                });
})


$("#input-20").change(function() {
        if($('#input-20').val().length!=0)
        {
        $('#upload').click();
        }
     });


 </script>
