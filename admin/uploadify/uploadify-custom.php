<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

/* Customized by RYC */

// include files
include('../includes/inc-constant.php');
include('../class/class-admin-image.php');

// capture parameters
$p_type = trim($_REQUEST['type']);

// define a destination
switch($p_type) {
  
  case 'news':
    $targetPath = DIRPATH . NEWSIMAGEPATH;
    $create_thumb = true;
    $targetPathThumb = DIRPATH . NEWSTHUMBIMAGEPATH;
    $thumbSize = 80;
    $fileTypes = array('jpg','jpeg','gif','png');
    break;
}  

// set token
$verifyToken = md5('unique_salt' . $_POST['timestamp']);

// process
if ($targetPath) {
  if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
  
    $tempFile = $_FILES['Filedata']['tmp_name'];
    
    $targetFileName = $_FILES['Filedata']['name'];
    
    $targetFile = rtrim($targetPath,'/') . '/' . $targetFileName;
  
    // validate the file type
    $fileParts = pathinfo($_FILES['Filedata']['name']);
  
    if (in_array($fileParts['extension'],$fileTypes)) {
      move_uploaded_file($tempFile,$targetFile);
      
      // create thumbnails
      if ($create_thumb == true)
      {
        $sourceFile = $targetFile;
        
        $image = new image();
        $image->setImage($sourceFile);
        $image->createThumb($thumbSize);
        $image->saveImage($targetPathThumb, $targetFileName, 100);
      }
      
      echo '1';
    } else {
      echo 'Invalid file type.';
    }
    
  }
}

?>