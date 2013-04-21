<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'editsettings';
$is_error = false;


// instantiate
$settings = new settings();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_merchant_name = sanitizeNoTags(trim($_REQUEST['fmerchantname']));
$p_merchant_email = sanitizeNoTags(trim($_REQUEST['fmerchantemail']));
$p_tax_govt = sanitizeFloat(trim($_REQUEST['ftaxgovt']));
$p_tax_service = sanitizeFloat(trim($_REQUEST['ftaxservice']));


// set default


// validate access
// ***************
if ($p_action != $action)
{
  $response = 'Error: Invalid access to system.';
  $is_error = true;
}


// validate parameters
// *******************
if ($is_error == false)
{
  if ((!($p_merchant_name)) || (!($p_merchant_email)) || ($p_tax_govt == '') || ($p_tax_service == ''))
  {
    $response = 'Error: Missing parameter.';
    $is_error = true;
  }
}


// update process
// **************
if ($is_error == false)
{  
  $result_edit = $settings->update($p_merchant_name, $p_merchant_email, $p_tax_govt, $p_tax_service);
  
  if ($result_edit == '1')
  {
    $response = 'true';
  
  } else {
    $response = 'Error: Unable to update record. Please contact the system administrator. ';
        
  }
}



// return response
// ***************
echo $response;

?>