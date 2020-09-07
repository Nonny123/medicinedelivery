<?php
$client_name=Input::get('name');
$client_mail=Input::get('email');
$client_msg=Input::get('msg');


echo "Name : ".$client_name;
echo "<br>";
echo "Email : ".$client_mail;
echo "<br>";
echo "Message : ".$client_msg;


?>