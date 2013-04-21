<?php 

/*
  File        : class/class-common.php
  Description : Common Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-data-common.php');

class common extends data_common
{
 
  // constructor
  function __construct()
  {
    // do nothing    
  }
  
  // get country list for options
  function getCountryList()
  {
    $result_arr = '';
    
    // connect to db
    parent::connect();
       
    $result = parent::dataGetCountryList();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $name = trim($row[0]);
        
        $result_arr[$name] = $name;
        
        $name = '';
      }
    }
    
    return $result_arr;
  }
  
  // settings - get merchant name and email address
  function getMerchantEmail()
  {
    $result = '';
    
    // connect to db
    parent::connect();
       
    $result = parent::dataGetMerchantEmail();
      
    // disconnect from db
    parent::disconnect();
    
    return $result;
  }
  
  // settings - get specified settings
  function getSettings($p_settings_name='')
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataGetSettings($p_settings_name);
      
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
  
}

?>