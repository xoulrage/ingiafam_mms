<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'edituser';
$is_error = false;


// instantiate
$user = new user();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_user_id = sanitizeNoTags(trim($_REQUEST['rid']));
$p_usertype = sanitizeInt(trim($_REQUEST['fusertype']));
$p_username = sanitizeNoTags(trim($_REQUEST['fusername']));
$p_pwd = sanitizeNoTags(trim($_REQUEST['fpwd']));
$p_fname = sanitizeNoTags(trim($_REQUEST['ffname']));
$p_lname = sanitizeNoTags(trim($_REQUEST['flname']));
$p_email = sanitizeNoTags(trim($_REQUEST['femail']));
$p_module_ids = sanitizeNoTags(trim($_REQUEST['fmoduleids']));
$p_module_checked = sanitizeNoTags(trim($_REQUEST['fmodulechecked']));
$p_publish = sanitizeInt(trim($_REQUEST['fpublish']));


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
  if ((!($p_usertype)) || ($p_username == '') || ($p_fname == '') || ($p_lname == '') || ($p_email == ''))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{
  // update user data
  $result_edit = $user->updateUserData($p_user_id, $p_usertype, $p_username, $p_fname, $p_lname, $p_email, $p_publish);
  
  if ($result_edit == '1')
  {
    // update access rights
    $result_edit_access = $user->updateAccessRights($p_user_id, $p_module_checked);
    
    if ($result_edit_access == '1')
    {
      $response = 'true';
      
    } else {
      
      $response = 'Error: Unable to update access rights record. Please contact the system administrator. ';
      
    }

  } else {
    
    if ($result_edit == 'DUPLICATE')
    {

      $response = 'There is an existing account with the same username in the system. Please re-select again.';   
      
    } else {

      $response = 'Error: Unable to update record. Please contact the system administrator. ';         
      
    }
    
  }

}


// return response
// ***************
echo $response;

?>