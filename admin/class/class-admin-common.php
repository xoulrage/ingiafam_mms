<?php 

/*
  File        : class/class-admin-common.php
  Description : Common Type Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-admin-data-common.php');

class common extends data_common
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
  
  // get country list for options
  function getSalutationTitle()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataSalutationTitle();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  // get country list for options
  function getCountryState()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataCountryState();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function showDateControl($dayCtrlID, $monthCtrlID, $yearCtrlID, $day = null, $month = null, $year = null) {

    $day = (is_null($day) ? 0 : $day);
    $month = (is_null($month) ? 0 : $month);
    $year = (is_null($year) ? 0 : $year);

    //Day 
    $date = '<select name="'. $dayCtrlID .'" id="'. $dayCtrlID .'">';
    $date .= '<option value="0">Select Day</option>';
    for ($i = 1; $i <= 31; $i++) {
      if ($day == $i)
        $sel = ' selected="selected"';
      else
        $sel = '';
      $date .= '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
    }
    $date .= '</select> ';

    //Month 
    $date .= '<select name="'. $monthCtrlID .'" id="'. $monthCtrlID .'">';
    $date .= '<option value="0">Select Month</option>';
    for ($i = 1; $i <= 12; $i++) {
      $name = date('F', mktime(0, 0, 0, $i));
      if ($i < 10)
        $i = '0' . $i;
      if ($month == $i)
        $sel = ' selected="selected"';
      else
        $sel = '';
      $date .= '<option value="' . $i . '"' . $sel . '>' . $name . '</option>';
    }
    $date .= '</select> ';

    //Year 
    $date .= '<select name="'. $yearCtrlID .'" id="'. $yearCtrlID .'">';
    $date .= '<option value="0">Select Year</option>';
    for ($i = date("o"); $i >= date("o") - 100; $i--) {
      if ($year == $i)
        $sel = ' selected="selected"';
      else
        $sel = '';
      $date .= '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
    }
    $date .= '</select><br/>';

    return $date;
  }
}

?>