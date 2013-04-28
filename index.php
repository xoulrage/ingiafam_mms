<?php 

// include files
include_once('includes/inc-session.php');
include_once('includes/inc-constant.php');


// redirect to main
if (isset($_SESSION['MEMBERID'])) {
  header("Location: " . ABSPATH . "main.php");
} else {
  header("Location: " . ABSPATH . "login.php");
} 

?>