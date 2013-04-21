<?php 

/*
  File        : includes/inc-session.php
  Description : Session management file
  Ver         : 1.0
  Created by  : RYC
*/

header('P3P: CP="CAO PSA OUR"');

session_start();

// destroy all sessions if the last activity is more than 900 seconds
/*
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
  session_destroy();   // destroy session data in storage
  session_unset();     // unset $_SESSION variable for the runtime
}
*/

  
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

// Generate shopping id if not found
if (trim($_SESSION['SHOPPINGID']) == '')
{
  $_SESSION['SHOPPINGID'] = str_replace('.', '', uniqid(rand(), true));
}

?>