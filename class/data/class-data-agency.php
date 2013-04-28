<?php 

/*
  File        : class/data/class-data-agency.php
  Description : Agency Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_agency extends dbhelper
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
  function dataAgency(){
      $sql = 'SELECT id, CONCAT(agencycode, \' \', name) ';
      $sql .= 'FROM agency ';
      $sql .= 'WHERE isactive = 1 ';
      $sql .= 'ORDER BY id ';

      $result_mysqli = parent::query($sql);
      $result = parent::fetchAllRows($result_mysqli);
      parent::clear($result_mysqli);

      return $result;
  }
  
  // functional methods (CRUD)
  // -------------------------

 
}
    
?>