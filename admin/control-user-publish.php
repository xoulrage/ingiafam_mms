<?php 

// include files
include('includes/inc-common.php');


// settings
$action = 'updatepublish';


// instantiate
$user = new user();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_user_id = sanitizeNoTags(trim($_REQUEST['rid']));
$p_page = sanitizeNoTags(trim($_REQUEST['pg']));


// set default


// process update publish state
// ****************************
if ($p_action == $action)
{
  $result = $user->updatePublishStatus($p_user_id);
}


// redirect
// ********
$url_redirect = 'user.php?pg=' . $p_page;
header("location: $url_redirect");

?>