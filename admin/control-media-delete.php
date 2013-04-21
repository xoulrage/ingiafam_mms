<?php 

// include files
include('includes/inc-common.php');


// settings
$response = '';
$action = 'deletemedia';
$is_error = false;


// instantiate
$common = new common();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_folder = sanitizeNoTags(trim($_REQUEST['folder']));
$p_file = sanitizeNoTags(trim($_REQUEST['file']));


// set default


// validate access
// ***************
if ($p_action != $action)
{
  $is_error = true;
}


// validate parameters
// *******************
if ($is_error == false)
{
  if (!($p_folder))
  {
    $is_error = true;
  }
}


// delete file process
// *******************
if ($is_error == false)
{
  // get folder
  switch($p_folder)
  {
    case 'news':
      $folder = DIRPATH . NEWSIMAGEPATH;
      $folder_thumbnail = DIRPATH . NEWSTHUMBIMAGEPATH;
      break;
  }
  
  // delete thumbnail (if applicable)
  if ($folder_thumbnail)
  {
    unlink($folder_thumbnail . $p_file);  
  }

  // delete file
  if ($folder)
  {
    unlink($folder . $p_file);  
  }

  $response = 'true';
}

// return response
// ***************
echo $response;

?>