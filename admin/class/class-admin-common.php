<?php 

/*
  File        : class/class-admin-common.php
  Description : Common Type Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

class common
{
   
  // constructor
  function __construct()
  {
    // do nothing
  }

  // files folder
  function getFiles($p_folder)
  {    
    if ($p_folder)
    {
      if ($handle = opendir($p_folder)) 
      {
        while (false !== ($file = readdir($handle))) 
        { 
          if (($file != ".") && ($file != "..") && ($file != ".htaccess") && !(is_dir($p_folder . $file))) 
          {
            $result_arr_files[$file] = $file;
          }
        }
      }
      closedir($handle);
      
      if (is_array($result_arr_files))
      {
        natcasesort($result_arr_files); 
      }
    }
    
    return $result_arr_files;
  }
  
  // files folder options
  function getFilesOptions($p_folder, $p_selected)
  {
    $result_options = '';
    $arr_files[''] = '';
    
    if ($p_folder)
    {
      if ($handle = opendir($p_folder)) 
      {
        while (false !== ($file = readdir($handle))) 
        { 
          if (($file != ".") && ($file != "..") && ($file != ".htaccess") && !(is_dir($p_folder . $file))) 
          {
            $arr_files[$file] = $file;
          }
        }
      }
      closedir($handle);
 
      if (is_array($arr_files) == true)
      {
        natcasesort($arr_files);

        $result_options = createOptions($arr_files, $p_selected);
      }
    }
    
    return $result_options;
  }
    
  // publish options
  function getPublishOptions($p_selected)
  {
    $result_options = '';
    
    $arr_options = array(
      'ON-HOLD'   => '0',
      'PUBLISHED' => '1'      
    );

    $result_options = createOptions($arr_options, $p_selected);
    
    return $result_options;
  }

  // yesno options
  function getYesNoOptions($p_selected)
  {
    $result_options = '';
    
    $arr_options = array(
      'NO'   => '0',
      'YES' => '1'      
    );

    $result_options = createOptions($arr_options, $p_selected);
    
    return $result_options;
  }
  
  // user acount status options
  function getActiveLockedOptions($p_selected)
  {
    $result_options = '';
    
    $arr_options = array(
      'LOCKED' => '0',
      'ACTIVE' => '1'      
    );

    $result_options = createOptions($arr_options, $p_selected);
    
    return $result_options;
  }
  
  // user account type options
  function getUserTypeOptions($p_selected)
  {
    $result_options = '';
    
    $arr_options = array(
      'Administrator' => '2',
      'Normal User' => '3'      
    );

    $result_options = createOptions($arr_options, $p_selected);
    
    return $result_options;
  }
  
}

?>