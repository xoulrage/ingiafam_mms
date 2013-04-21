<?php

// include files
include('includes/inc-common.php');


// settings
$response = '';
$action = 'getfilelist';
$is_error = false;


// instantiate
$common = new common();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_folder = sanitizeNoTags(trim($_REQUEST['folder']));
$p_selected_file = sanitizeNoTags(trim($_REQUEST['file']));


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


// get file list options
// *********************
if ($is_error == false)
{
  // get folder
  switch($p_folder)
  {
    case 'news':
      $folder = DIRPATH . NEWSIMAGEPATH;
      break;      
  }

  // get list
  $response = $common->getFilesOptions($folder, $p_selected_file);
}


// return response
// ***************
echo $response;

?>