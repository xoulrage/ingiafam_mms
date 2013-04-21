<?php

/*
  File        : includes/inc-checkaccess-admin.php
  Description : Check for user type for access to admin-only modules
  Ver         : 1.0
  Created by  : RYC
*/

if (!(($_SESSION['USERTYPE'] == 1) || ($_SESSION['USERTYPE'] == 2)))
{
  $url_redirect =  ABSPATH . BACKOFFICEPATH . 'page-unauthorized.php'; 
  header("Location: $url_redirect");      
  exit;
}

?>