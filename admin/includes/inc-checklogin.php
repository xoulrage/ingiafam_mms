<?php

/*
  File        : includes/inc-checklogin.php
  Description : Check for login session
  Ver         : 1.0
  Created by  : RYC
*/

if (!isset($_SESSION['USERID'])) {
  $url_redirect =  ABSPATH . BACKOFFICEPATH . 'login.php'; 
  header("Location: $url_redirect");
}    

?>