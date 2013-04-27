<?php 

// include files
include('includes/inc-common.php');

// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'editmember';
$is_error = false;

// instantiate
$member = new member();

//$log = new Logging();
//$log->lwrite($key .' / '. $val);
//$log->lclose();

// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
$p_member_id = sanitizeInt(trim($_REQUEST['rid']));
$p_surname = sanitizeNoTags(trim($_REQUEST['fsurname']));
$p_givenname = sanitizeNoTags(trim($_REQUEST['fgivenname']));
$p_title = sanitizeNoTags(trim($_REQUEST['ftitle']));
$p_fnric = sanitizeInt(trim($_REQUEST['fnric']));
$p_phone = sanitizeInt(trim($_REQUEST['fphone']));
$p_fax = sanitizeInt(trim($_REQUEST['ffax']));
$p_mobile = sanitizeInt(trim($_REQUEST['fmobile']));
$p_extension = sanitizeInt(trim($_REQUEST['fextension']));
$p_email1 = sanitizeNoTags(trim($_REQUEST['femail1']));
$p_email2 = sanitizeNoTags(trim($_REQUEST['femail2']));
$p_dobday = sanitizeInt(trim($_REQUEST['fdobday']));
$p_dobmonth = sanitizeInt(trim($_REQUEST['fdobmonth']));
$p_dobyear = sanitizeInt(trim($_REQUEST['fdobyear']));
$p_gender = sanitizeNoTags(trim($_REQUEST['fgender']));
$p_unitcode = sanitizeNoTags(trim($_REQUEST['funitcode']));
$p_address1 = sanitizeNoTags(trim($_REQUEST['faddress1']));
$p_address2 = sanitizeNoTags(trim($_REQUEST['faddress2']));
$p_address3 = sanitizeNoTags(trim($_REQUEST['faddress3']));
$p_address4 = sanitizeNoTags(trim($_REQUEST['faddress4']));
$p_postcode = sanitizeInt(trim($_REQUEST['fpostcode']));
$p_countrystateid = sanitizeInt(trim($_REQUEST['fcountrystateid']));
$p_isagreedtoobitcontrib = sanitizeNoTags(trim($_REQUEST['fisagreedtoobitcontrib']));

$p_dob = ($p_dobmonth . '/' . $p_dobday . '/' . $p_dobyear);
$p_dob = strtotime($p_dob);
$p_dob = date("Y-m-d H:i:s", $p_dob);
        
$arrayList['ftitle'] = $p_title;
$arrayList['fsurname'] = $p_surname;
$arrayList['fgivenname'] = $p_givenname;
$arrayList['fnric'] = $p_fnric;
$arrayList['fdob'] = $p_dob;
$arrayList['fgender'] = $p_gender;
$arrayList['funitcode'] = $p_unitcode;
$arrayList['faddress1'] = $p_address1;
$arrayList['faddress2'] = $p_address2;
$arrayList['faddress3'] = $p_address3;
$arrayList['faddress4'] = $p_address4;
$arrayList['fpostcode'] = $p_postcode;
$arrayList['fcountrystateid'] = $p_countrystateid;
$arrayList['fphone'] = $p_phone;
$arrayList['fextension'] = $p_extension;
$arrayList['ffax'] = $p_fax;
$arrayList['fmobile'] = $p_mobile;
$arrayList['femail1'] = $p_email1;
$arrayList['femail2'] = $p_email2;
$arrayList['fisagreedtoobitcontrib'] = $p_isagreedtoobitcontrib;
$arrayList['fmemberid'] = $p_member_id;

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
  foreach ($arrayList as $key => $val) {
    if (!$is_error)
      $is_error = ($val) ? false : true;
  }
  
  if ($is_error)
    $response = 'Error: Missing parameter.';
}


// update process
// **************
if ($is_error == false)
{
  $result_edit = $member->updateMemberData($arrayList);
  
  if ($result_edit == '1'){
    $response = 'true';
  } else {    
    $response = 'Error: Unable to update record. Please contact the system administrator. ';    
  }
}




// return response
// ***************
echo $response;

?>