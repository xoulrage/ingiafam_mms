<?php

include_once('dbhelper.php');

class data_common extends dbhelper  {

  function dataSalutationTitle()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM name_title ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataCountryState()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM country_state ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY sort; ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
}
?>
