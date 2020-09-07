<?php
    $message = "To Reset click the following link" . "<br>";
    $message .= URL . "/admin/admin-reset-password/" . md5($email) . "<br>";
    echo $message;
