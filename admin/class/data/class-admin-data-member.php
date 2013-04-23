<?php 

/*
  File        : class/data/class-admin-data-member.php
  Description : Member Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_member extends dbhelper
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
  
  // get data by id
  function dataGetData($p_id)
  {
    $p_id = parent::escape($p_id);
    
    $sql .= 'SELECT fknametitleid,  ';
    $sql .= '   surname,  ';
    $sql .= '   givenname,  ';
    $sql .= '   nric,  ';
    $sql .= '   dateofbirth,  ';
    $sql .= '   gender,  ';
    $sql .= '   unitcode,  ';
    $sql .= '   address1,  ';
    $sql .= '   address2,  ';
    $sql .= '   address3,  ';
    $sql .= '   address4,  ';
    $sql .= '   postcode,  ';
    $sql .= '   fkcountrystateid,  ';
    $sql .= '   phone,  ';
    $sql .= '   extension,  ';
    $sql .= '   fax,  ';
    $sql .= '   mobile,  ';
    $sql .= '   email1,  ';
    $sql .= '   email2,  ';
    $sql .= '   isagreedtoobitcontrib  ';
    $sql .= 'FROM members ';
    $sql .= 'WHERE id = ' . $p_id . ' '; 
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // user manager - get list
  function dataGetList($p_limitstart, $p_recperpage)
  {
    $p_limitstart = parent::escape($p_limitstart);
    $p_recperpage = parent::escape($p_recperpage);
    
    $sql .= 'SELECT id, ';
    $sql .= '   surname, ';
    $sql .= '   givenname, ';
    $sql .= '   agentcode, ';
    $sql .= '   DATE_FORMAT(datecreated, \'%d %b %Y %H:%i\'), ';
    $sql .= '   isactive ';
    $sql .= 'FROM members ';
    $sql .= 'ORDER BY surname, givenname ';
    $sql .= 'LIMIT  ' . $p_limitstart . ', ' . $p_recperpage . ' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // user manager - get total
  function dataGetTotal()
  {
    $sql  = 'SELECT COUNT(id) ';
    $sql .= 'FROM members ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // functional methods (CRUD)
  // -------------------------
  
  
  
}

?>