<?php 

/*
  File        : class/data/class-data-common.php
  Description : Common Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_common extends dbhelper
{
  
  // constructor
  function __construct()
  {
    // do nothing
  }
  
  // get country list
  function dataGetCountryList()
  {
    $sql  = 'SELECT printablename ';
    $sql .= 'FROM country ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY name ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  // settings - get merchant name and email address
  function dataGetMerchantEmail()
  {
    $sql  = 'SELECT item, ';
    $sql .= 'value ';
    $sql .= 'FROM settings ';
    $sql .= 'WHERE item IN (\'MERCHANT_NAME\', \'MERCHANT_EMAIL\') ';
    $sql .= 'AND isactive = 1 ';

    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  // settins - get specified settings
  function dataGetSettings($p_settings_name='')
  {
    if ($p_settings_name)
    {
      $arr_settings_name = explode(',', $p_settings_name);
    
      while(list($key,$value) = each($arr_settings_name))
      {
        $settings .= '\'' . trim($value) . '\',';
      }
    
      if ($settings)
      {
        $settings = rtrim($settings, ',');
      }      
    }
    
    $sql  = 'SELECT item, ';
    $sql .= 'value ';
    $sql .= 'FROM settings ';
    
    if ($settings)
    {
      $sql .= 'WHERE item IN (' . $settings . ') ';
      $sql .= 'AND isactive = 1 ';
      
    } else {
      $sql .= 'WHERE isactive = 1 ';
      
    }

    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
}

?>