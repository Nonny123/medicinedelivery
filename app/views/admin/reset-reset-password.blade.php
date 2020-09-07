<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reset</title>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.js"></script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>

</head>

<body>
<div class="container">


 <h1>Reset Password</h1>
<?php 
 if(Session::has('passwordError')){?>
<div style="color: green"><h3><?php echo Session::get('passwordError');?> </h3></div>
<?php }?>
<strong id="div-notify" style="color: red"></strong>
<form method="POST" action="/admin/admin-change-password" accept-charset="UTF-8" id="formCheckPassword">

{{Form::token()}}

<div class="form-group">
<label for="email">Email:</label>
<input type="hidden" name="mdofemail" value="<?php echo $md ?>" />
<input class="form-control" name="email" type="email" required>
</div>
<div class="form-group">
<label for="email">New Password:</label>
<input class="form-control" name="password" id="password" type="password" required>
</div>

<div class="form-group">
<label for="email">Confirm Password:</label>
<input class="form-control" name="cpassword" id="cpassword" type="password" required>
</div>

<button class="btn btn-primary" name="submit" value="Login" type="submit">Submit</button>

</form>

<script>
$("#formCheckPassword").validate({
           rules: {
               password: { 
                 required: true,
                    minlength: 4,
                    maxlength: 10

               } , 

                   cpassword: { 
                    equalTo: "#password",
                     minlength: 4,
                     maxlength: 10
               }


           },
     messages:{
         password: { 
                 required:"the password is required"

               }
     }

});
</script>

</div>
</body>
</html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script type="text/javascript">
