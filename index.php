<?php

session_start();

// verif user logat
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

header("location: shop.php");
exit;
?>