<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'editprofile';
$is_error = false;


// instantiate
$user = new user();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_user_id = sanitizeNoTags(trim($_SESSION['USERID']));
$p_fname  = sanitizeNoTags(trim($_REQUEST['ffname']));
$p_lname  = sanitizeNoTags(trim($_REQUEST['flname']));
$p_email  = sanitizeNoTags(trim($_REQUEST['femail']));


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
  if ((!($p_user_id)) || (!($p_fname)) || (!($p_lname)) || (!($p_email)))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{
  $result_update = $user->updateData($p_user_id, $p_fname, $p_lname, $p_email);
  
  $response = 'true';
}

// return response
// ***************
echo $response;

?>