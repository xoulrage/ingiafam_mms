<?php 

/*
  File        : includes/inc-formatting.php
  Description : File containing common functions used for data formatting / sanitizing
  Ver         : 1.0
  Created by  : RYC
*/

// trim array values (used mainly to trim $_GET / $_POST)
// eg. to trim $_POST: array_filter($_POST, 'trimArray');
function trimArray(&$p_var)
{
  $p_var = trim($p_var);
}

// input sanitize : strip all tags
function sanitizeNoTags($p_var)
{
  return strip_tags($p_var);
}

// input sanitize : strip all tags and convert both double and single quotes to HTML entities
function sanitizeNoTagsHtml($p_var)
{
  return htmlentities(strip_tags($p_var), ENT_QUOTES, 'UTF-8');  
}

// input sanitize : integers
// - strips all except digit, plus and minus sign
function sanitizeInt($p_var)
{
  return filter_var($p_var, FILTER_SANITIZE_NUMBER_INT);
}


// input sanitize : float
// - strips all except digit, decimal, plus and minus sign
function sanitizeFloat($p_var)
{
  return filter_var($p_var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

// output sanitize : convert special characters to HTML entities
function sanitizeHtml($p_var)
{
  return htmlspecialchars($p_var);
}


// input sanitize : email
// - strips all except alphabets, digits and !#$%&'*+-/=?^_`{|}~@.[]
function sanitizeEmail($p_var)
{
  return filter_var($p_var, FILTER_SANITIZE_EMAIL);
}


// format : add slashes (for sql statements)
function addSlashesFormat($p_var)
{
  if (get_magic_quotes_gpc()) 
  {
    return $p_var;
  } else {
    return addslashes($p_var);
  }
}


// format : remove slashes (output from db)
function removeSlashesFormat($p_var)
{
  $p_var = str_replace("\'", "'", $p_var);
  $p_var = str_replace('\"', '"', $p_var);    
    
  return $p_var;
}

?>