<?php

// include files
include_once('includes/inc-constant.php');
include_once('includes/inc-session.php');


$_SESSION = array();
session_unset();
session_destroy();

$url_redirect =  ABSPATH . BACKOFFICEPATH . "login.php";

header("Location: $url_redirect");

?>