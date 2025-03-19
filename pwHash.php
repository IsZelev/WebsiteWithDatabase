<?php
$password = "terza_pass";  //
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>