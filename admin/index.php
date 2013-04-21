<?php 

// include files
include_once('includes/inc-session.php');
include_once('includes/inc-constant.php');


// redirect to main
if (isset($_SESSION['USERID'])) {
  header("Location: " . ABSPATH . BACKOFFICEPATH . "main.php");
} else {
  header("Location: " . ABSPATH . BACKOFFICEPATH . "login.php");
} 

?>