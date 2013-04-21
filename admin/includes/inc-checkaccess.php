<?php

/*
  File        : includes/inc-checkaccess.php
  Description : Check for access rights session to module
  Ver         : 1.0
  Created by  : RYC
*/

if ($_SESSION['USERTYPE'] != 1)
{
  if (MODULEID != '')
  {
    if ($_SESSION['MODULE_' . MODULEID] != 1)
    {
      $url_redirect =  ABSPATH . BACKOFFICEPATH . 'page-unauthorized.php'; 
      header("Location: $url_redirect");      
      exit;
    }
  }
}

?>