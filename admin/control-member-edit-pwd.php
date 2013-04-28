<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'editmemberpwd';
$is_error = false;


// instantiate
$member = new member();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_member_id = sanitizeNoTags(trim($_REQUEST['rid']));
$p_newpwd  = sanitizeNoTags(trim($_REQUEST['fpwd']));


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
  if ((!($p_member_id)) || (!($p_newpwd)))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{
  $result_update = $member->updateMemberPwd($p_member_id, $p_newpwd);
  
  if ($result_update == '1')
  {
    $response = 'true';    
  } else {
    $response = 'Error: Unable to update record. Please contact the system administrator.';
  }
}



// return response
// ***************
echo $response;

?>