<?php 

/*
  File        : class/data/class-admin-data-settings.php
  Description : Settings Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_settings extends dbhelper
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
  function dataGetList()
  {
    
    $sql  = 'SELECT item, ';
    $sql .= 'value ';
    $sql .= 'FROM settings ';
    $sql .= 'WHERE isactive = 1 ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }  
  
  
  // functional methods
  // ------------------    

  // update record
  function dataUpdate($p_item, $p_value)
  {
    $result_update = false;
    
    $sql  = 'UPDATE settings SET ';
    $sql .= 'value = ? ';
    $sql .= 'WHERE item = ? ';
    
    $paramtype = 'ss';
    
    $paramdata = array(
      'value' => $p_value,
      'item' => $p_item
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    $result_update = '1';

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
  
    
  
}

?>