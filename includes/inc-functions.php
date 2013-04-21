<?php 

/*
  File        : includes/inc-functions.php
  Description : File containing common functions
  Ver         : 1.0
  Created by  : RYC
*/

// create dropdown options for select field
function createOptions($p_list, $p_selected)
{
  $result_options = '';
    
  if (is_array($p_list) == true)
  {
    while(list($key, $value) = each($p_list)) 
    {
      if ($value == $p_selected)
      {
        $result_options .= '<option value="' . $value . '" selected>' . $key . '</option>'."\n";
      } else {
        $result_options .= '<option value="' . $value . '">' . $key . '</option>'."\n";
      }
    }
  }
  
  return $result_options;
}

// create pagination
function createPagination($p_total_rec, $p_rec_perpage, $p_current_page, $p_page_url, $p_param='')
{
  if ((is_numeric($p_total_rec) == true) && (is_numeric($p_rec_perpage) == true) && (is_numeric($p_current_page) == true))
  {
    // get total pages
    if (($p_total_rec % $p_rec_perpage) > 0)
    {
      $total_pages = (($p_total_rec - ($p_total_rec % $p_rec_perpage)) / $p_rec_perpage) + 1;
    }
    else
    {
      $total_pages = $p_total_rec / $p_rec_perpage;
    }
      
    // output pagination
    // -----------------
    echo '<!-- START - Pagination -->', "\n";
    echo '<div id="pagination">', "\n";      
    echo '<div id="pagination_number">', "\n";
      
    if ($total_pages == 1)
    {
      echo '<a href="#" class="on" onClick="return false;">1</a>', "\n";
    }
    else
    {
      for ($ictr=1; $ictr<=$total_pages; $ictr++)
      {
        if ($ictr == $p_current_page)
        {
          echo '<a href="#" class="on" onClick="return false;">' . $ictr . '</a>';
        } 
        else
        {
          $url_page = $p_page_url . '?pg=' . $ictr;
            
          if ($p_param != '')
          {
            $url_page = $url_page . '&' . $p_param;
          }
            
          echo '<a href="' . $url_page . '">' . $ictr . '</a>';
            
          $url_page == '';
        }
      }
    }     

    echo '</div>', "\n";      
    echo '</div>', "\n";
    echo '<div class="reset"></div>', "\n";
    echo '<!-- END - Pagination -->', "\n";
    // -----------------
            
  }
 
}

// get limit start (for sql query to determine start of record based to search for - used for pagination purposes)
function getLimitStart($p_page, $p_recperpage)
{
  if ($p_page == 1)
  {
    $p_limitstart = 0;
  } else {
    $p_limitstart = ((($p_page - 1) * $p_recperpage) - 1) + 1; 
  }
    
  return $p_limitstart;
}

// convert datepicker date (dd-mm-yyyy) to db date (yyyy-mm-dd)
function convertToDBDate($p_date)
{
  $result_date;
    
  if ($p_date != '')
  {
    // get date components
    $arr_date   = explode('-', $p_date);
    $date_day   = trim($arr_date[0]);
    $date_month = trim($arr_date[1]);      
    $date_year  = trim($arr_date[2]);

    // check if date is valid
    if ((is_numeric($date_day) == true) && (is_numeric($date_month) == true) && (is_numeric($date_year) == true))
    {
      if (checkdate($date_month, $date_day, $date_year) == true)
      {
        $result_date = $date_year . '-' . $date_month . '-' . $date_day;
      } else {
        $result_date = '';      
      }      
    } 
          
  }
    
  return $result_date;
}

// convert db date (yyyy-mm-dd) to datepicker date (dd-mm-yyyy)
function convertFromDBDate($p_date)
{
  $result_date;
    
  if ($p_date != '')
  {
    // get date components
    $arr_date   = explode('-', $p_date);
    $date_day   = trim($arr_date[2]);
    $date_month = trim($arr_date[1]);      
    $date_year  = trim($arr_date[0]);

    // check if date is valid
    if ((is_numeric($date_day) == true) && (is_numeric($date_month) == true) && (is_numeric($date_year) == true))
    {
      if (checkdate($date_month, $date_day, $date_year) == true)
      {
        $result_date = $date_day . '-' . $date_month . '-' . $date_year;
      } else {
        $result_date = '';      
      }      
    } 
          
  }
    
  return $result_date;
}


?>