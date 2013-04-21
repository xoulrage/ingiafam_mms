<?php 

/*
  File        : class/class-admin-settings.php
  Description : Settings Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-admin-data-settings.php');

class settings extends data_settings
{
   
  // constructor
  function __construct()
  {
    // do nothing
  }
  
  // common methods
  // --------------

  
  // data extraction methods
  // -----------------------  

  // get list
  function getList()
  {
    $result = false;

    // connect to database    
    parent::connect();
      
    // get results
    $result = parent::dataGetList();
      
    // disconnect from database
    parent:: disconnect();  
    
    return $result;
  }  
  
  
  // functional methods
  // ------------------    

  // update record
  function update($p_merchant_name, $p_merchant_email, $p_tax_govt, $p_tax_service)
  {
    $result_update = false;
        
    // format
    $p_merchant_name = sanitizeNoTags($p_merchant_name);
    $p_merchant_email = sanitizeEmail(sanitizeNoTags($p_merchant_email));
    $p_tax_govt = sanitizeFloat($p_tax_govt);
    $p_tax_service = sanitizeFloat($p_tax_service);
    
    // set
    $p_tax_govt = number_format(($p_tax_govt/100), 2);
    $p_tax_service = number_format(($p_tax_service/100), 2);

    // set
    $arr_vars = array(
      'MERCHANT_NAME' => $p_merchant_name,
      'MERCHANT_EMAIL' => $p_merchant_email,
      'TAX_GOVT' => $p_tax_govt,
      'TAX_SERVICE' => $p_tax_service
    );
          
    // connect to database    
    parent::connect();
    
    while(list($key,$value) = each($arr_vars))
    {
      if ($value != '')
      {
        // update
        $result = parent::dataUpdate($key, $value);        
      }
    
      $key = '';
      $value = '';
    }
        
    // disconnect from database
    parent:: disconnect();
        
    $result_update = '1';
    
    return $result_update;  
  }  
    
   
}

?>