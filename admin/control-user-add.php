<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'adduser';
$is_error = false;


// instantiate
$user = new user();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_usertype = sanitizeInt(trim($_REQUEST['fusertype']));
$p_username = sanitizeNoTags(trim($_REQUEST['fusername']));
$p_pwd = sanitizeNoTags(trim($_REQUEST['fpwd']));
$p_fname = sanitizeNoTags(trim($_REQUEST['ffname']));
$p_lname = sanitizeNoTags(trim($_REQUEST['flname']));
$p_email = sanitizeNoTags(trim($_REQUEST['femail']));
$p_module_ids = sanitizeNoTags(trim($_REQUEST['fmoduleids']));
$p_module_checked = sanitizeNoTags(trim($_REQUEST['fmodulechecked']));


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
  if ((!($p_usertype)) || ($p_username == '') || ($p_pwd == '') || ($p_fname == '') || ($p_lname == '') || ($p_email == ''))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{  
  $result = $user->add($p_username, $p_pwd, $p_fname, $p_lname, $p_email, $p_usertype, 1);
  
  if ($result == 'DUPLICATE')
  {
    // error - duplicate username
    $response = 'There is an existing account with the same username in the system. Please re-select again.';
    
  } elseif ((is_numeric($result)) && ($result > 0)) {
    
    // add access rights
    $result_access = $user->addAccessRights($result, $p_module_checked);
   
    if ($result_access > 0)
    {
      $response = 'true';
      
    } else {
      $response = 'Error: Unable to add new record for access rights. Please contact the system administrator. ';
        
    }
    
  } else {
    $response = 'Error: Unable to add new record. Please contact the system administrator. ';
        
  }
  
}



// return response
// ***************
echo $response;

?>