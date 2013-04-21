<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'editpwd';
$is_error = false;


// instantiate
$user = new user();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_user_id = sanitizeNoTags(trim($_SESSION['USERID']));
$p_pwd = sanitizeNoTags(trim($_REQUEST['fpwd']));
$p_newpwd  = sanitizeNoTags(trim($_REQUEST['fnewpwd']));


// set default


// validate access
// ***************
if ($p_action != $action)
{
  $response = 'Error: Invalid access to system.';
  $is_error = true;
}


// validate parameters
// *******************
if ($is_error == false)
{
  if ((!($p_user_id)) || (!($p_pwd)) || (!($p_newpwd)))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{
  $result_update = $user->updatePwd($p_user_id, $p_pwd, $p_newpwd);
  
  if ($result_update == '1')
  {
    $response = 'true';    
  } else {
    $response = 'invalid_pwd';
  }
}



// return response
// ***************
echo $response;

?>