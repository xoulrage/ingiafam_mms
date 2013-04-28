<?php 

/*
  File        : class/class-agency.php
  Description : Agency Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-data-agency.php');

class agency extends data_agency
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
  function GetAgency(){
      $result_arr = array();

      parent::connect();
      $result = parent::dataAgency();
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
  
  // functional methods (CRUD)
  // -------------------------

 
}
    
?>