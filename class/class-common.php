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

    function getRegion(){
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

    function showDateOfBirth($day = null, $month = null, $year = null) {

        $day = (is_null($day) ? 0 : $day);
        $month = (is_null($month) ? 0 : $month);
        $year = (is_null($year) ? 0 : $year);

        //Day
        $age = '<select name="ddldobDay" id="ddldobDay">';
        $age .= '<option>--Select--</option>';
        for ($i = 1; $i <= 31; $i++) {
            if ($day == $i)
                $sel = ' selected="selected"';
            else
                $sel = '';
            $age .= '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
        }
        $age .= '</select> ';

        //Month
        $age .= '<select name="ddldobMonth" id="ddldobMonth">';
        $age .= '<option>--Select--</option>';
        for ($i = 1; $i <= 12; $i++) {
            $name = date('F', mktime(0, 0, 0, $i));
            if ($i < 10)
                $i = '0' . $i;
            if ($month == $i)
                $sel = ' selected="selected"';
            else
                $sel = '';
            $age .= '<option value="' . $i . '"' . $sel . '>' . $name . '</option>';
        }
        $age .= '</select> ';

        //Year
        $age .= '<select name="ddldobYear" id="ddldobYear">';
        $age .= '<option>--Select--</option>';
        for ($i = date("o"); $i >= date("o") - 100; $i--) {
            if ($year == $i)
                $sel = ' selected="selected"';
            else
                $sel = '';
            $age .= '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
        }
        $age .= '</select>';

        return $age;
    }
  
}

?>