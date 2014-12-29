<?php
require("db.php");
require("_class/_class_user.php");
$user = new user;
$user->logout();

redirecina("_login.php");

?>