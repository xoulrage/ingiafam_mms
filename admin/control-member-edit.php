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
$arrayList['fisagreedtoobitcontrib'][$p_isagreedtoobitcontrib] = false;
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
$arrayList['fmemberid'][$p_member_id] = true;

// set default
//echo '<pre>'; print_r($arrayList); echo '</pre>';

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
  $result_edit = $member->updateMemberData($arrayList);
  
  if ($result_edit == '1'){
    $response = 'true';
  } 
  else if ($result_edit == "DupAgentCode"){    
    $response = 'Error: Duplicate Agent Code. ';    
  }
  else if ($result_edit == "DupMemberCode"){    
    $response = 'Error: Duplicate Member Code. ';    
  }
  else
  {
    $response = 'Error: Unable to update record. Please contact the system administrator. ';
  }
}




// return response
// ***************
echo $response;

?>