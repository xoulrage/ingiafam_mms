<?php 

// include files
include('includes/inc-common.php');


// settings
$action = 'updatepublish';


// instantiate
$member = new member();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_member_id = sanitizeNoTags(trim($_REQUEST['rid']));
$p_page = sanitizeNoTags(trim($_REQUEST['pg']));


// set default


// process update publish state
// ****************************
if ($p_action == $action)
{
  $result = $member->updatePublishStatus($p_member_id);
}


// redirect
// ********
$url_redirect = 'member.php?pg=' . $p_page;
header("location: $url_redirect");

?>