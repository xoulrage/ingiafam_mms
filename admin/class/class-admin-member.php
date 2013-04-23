<?php 

/*
  File        : class/class-admin-member.php
  Description : Member Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-admin-data-member.php');

class member extends data_member
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
  // get user by ID
  function getData($p_id)
  {
    $result = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetData($p_id);
      
      // disconnect from database
      parent:: disconnect();    
    }
    
    return $result;
  }

  // user manager - get list
  function getList($p_page, $p_recperpage)
  {
    $result = false;
    
    // format
    $p_page = sanitizeInt($p_page);
    $p_recperpage = sanitizeInt($p_recperpage);
    
    if (($p_page) && ($p_recperpage))
    {
      // get limit start
      $limitstart = getLimitStart($p_page, $p_recperpage);
      
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetList($limitstart, $p_recperpage);
      
      // disconnect from database
      parent:: disconnect();  
    }
    
    return $result;
  }
  
  // user manager - get total users
  function getTotal()
  {
    $result_total = 0;
    
    // connect to database    
    parent::connect();
      
    // get results
    $result = parent::dataGetTotal();
      
    // disconnect from database
    parent:: disconnect();  
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_total = $row[0];
      }
    }
    
    return $result_total;
  }
  
  // functional methods (CRUD)
  // -------------------------
  

}

?>