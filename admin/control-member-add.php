<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unknown Error: Please contact the system administrator.';
$action = 'addmember';
$is_error = false;


// instantiate
$member = new member();


// fetch parameters
$p_action = sanitizeNoTags(trim($_REQUEST['action']));
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
$p_dob = sanitizeNoTags(trim($_REQUEST['fdob']));
$p_gender = sanitizeNoTags(trim($_REQUEST['fgender']));
$p_unitcode = sanitizeNoTags(trim($_REQUEST['funitcode']));
$p_address1 = sanitizeNoTags(trim($_REQUEST['faddress1']));
$p_address2 = sanitizeNoTags(trim($_REQUEST['faddress2']));
$p_address3 = sanitizeNoTags(trim($_REQUEST['faddress3']));
$p_address4 = sanitizeNoTags(trim($_REQUEST['faddress4']));
$p_postcode = sanitizeInt(trim($_REQUEST['fpostcode']));
$p_countrystateid = sanitizeInt(trim($_REQUEST['fcountrystateid']));
$p_isagreedtoobitcontrib = sanitizeInt(trim($_REQUEST['fisagreedtoobitcontrib']));
$p_membercode = sanitizeNoTags(trim($_REQUEST['fmembercode']));
$p_agentcode = sanitizeNoTags(trim($_REQUEST['fagentcode']));
$p_fkagencyid = sanitizeInt(trim($_REQUEST['ffkagencyid']));
$p_fkrankid = sanitizeInt(trim($_REQUEST['ffkrankid']));
$p_fkregionid = sanitizeInt(trim($_REQUEST['ffkregionid']));
$p_fkmemberstatusid = sanitizeInt(trim($_REQUEST['ffkmemberstatusid']));
$p_fkmembertypeid = sanitizeInt(trim($_REQUEST['ffkmembertypeid']));
$p_fkmembertypestatusid = sanitizeInt(trim($_REQUEST['ffkmembertypestatusid']));
$p_dateenrolled = sanitizeNoTags(trim($_REQUEST['fdateenrolled']));
$p_dateapproved = sanitizeNoTags(trim($_REQUEST['fdateapproved']));
$p_datenextrenewal = sanitizeNoTags(trim($_REQUEST['fdatenextrenewal']));
$p_dateconverted = sanitizeNoTags(trim($_REQUEST['fdateconverted']));
$p_dateterminated = sanitizeNoTags(trim($_REQUEST['fdateterminated']));
$p_notes = sanitizeNoTags(trim($_REQUEST['fnotes']));
$p_password = sanitizeNoTags(trim($_REQUEST['password']));

$p_dob = formatDateToMySQLDate($p_dob);
$p_dateenrolled = formatDateToMySQLDate($p_dateenrolled);
$p_dateapproved = formatDateToMySQLDate($p_dateapproved);
$p_datenextrenewal = formatDateToMySQLDate($p_datenextrenewal);
$p_dateconverted = formatDateToMySQLDate($p_dateconverted);
$p_dateterminated = formatDateToMySQLDate($p_dateterminated);

$arrayList['ftitle'][$p_title] = true;
$arrayList['fsurname'][$p_surname] = true;
$arrayList['fgivenname'][$p_givenname] = true;
$arrayList['fnric'][$p_fnric] = true;
$arrayList['fdob'][$p_dob] = true;
$arrayList['fgender'][$p_gender] = true;
$arrayList['funitcode'][$p_unitcode] = true;
$arrayList['faddress1'][$p_address1] = true;
$arrayList['faddress2'][$p_address2] = true;
$arrayList['faddress3'][$p_address3] = true;
$arrayList['faddress4'][$p_address4] = true;
$arrayList['fpostcode'][$p_postcode] = true;
$arrayList['fcountrystateid'][$p_countrystateid] = true;
$arrayList['fphone'][$p_phone] = true;
$arrayList['fextension'][$p_extension] = true;
$arrayList['ffax'][$p_fax] = true;
$arrayList['fmobile'][$p_mobile] = true;
$arrayList['femail1'][$p_email1] = true;
$arrayList['femail2'][$p_email2] = true;
$arrayList['fisagreedtoobitcontrib'][$p_isagreedtoobitcontrib] = true;
$arrayList['fmembercode'][$p_membercode] = true;
$arrayList['fagentcode'][$p_agentcode] = true;
$arrayList['fagencyid'][$p_fkagencyid] = true;
$arrayList['frankid'][$p_fkrankid] = true;
$arrayList['fregionid'][$p_fkregionid] = true;
$arrayList['fmemberstatusid'][$p_fkmemberstatusid] = true;
$arrayList['fmembertypeid'][$p_fkmembertypeid] = true;
$arrayList['fmembertypestatusid'][$p_fkmembertypestatusid] = true;
$arrayList['fdateenrolled'][$p_dateenrolled] = false;
$arrayList['fdateapproved'][$p_dateapproved] = false;
$arrayList['fdatenextrenewal'][$p_datenextrenewal] = false;
$arrayList['fdateconverted'][$p_dateconverted] = false;
$arrayList['fdateterminated'][$p_dateterminated] = false;
$arrayList['fnotes'][$p_notes] = false;


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
    foreach ($val as $childkey => $boolean) {
      if (!$is_error)
      {
        // CHECK IF CHILDKEY IS A MANDATORY FIELD
        if ($boolean)
          // CHECK IF CHILDKEY CONTAINS VALUE ELSE ERROR
          $is_error = (strlen($childkey) != 0) ? false : true;
      }
    }
  }
  
  if ($is_error)
    $response = 'Error: Missing parameter.';
}


// update process
// **************
if ($is_error == false)
{  
  $result = $member->add($arrayList, $p_password);
  
  if ($result == 'DUPLICATE')
  {
    // error - duplicate membername
    $response = 'There is an existing account with the same agent code or member code in the system. Please verify.';
    
  } elseif ((is_numeric($result)) && ($result > 0)) {
    
    $response = 'true';
    
  } else {
    $response = 'Error: Unable to add new record. Please contact the system administrator. ';
        
  }
  
}



// return response
// ***************
echo $response;

?>