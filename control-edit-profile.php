<?php

// include files
include('includes/inc-common.php');

function GetResponse(){
    if (!isset($_SESSION['MEMBERID']))
        return 'Please log in';

    $member = new member();

    // fetch parameters
    $p_id             = sanitizeNoTags(trim($_SESSION['MEMBERID']));
    $p_agentcode      = sanitizeNoTags(trim($_REQUEST['agentcode']));
    $p_surname        = sanitizeNoTags(trim($_REQUEST['surname']));
    $p_givenname      = sanitizeNoTags(trim($_REQUEST['givenname']));
    $p_nric           = sanitizeNoTags(trim($_REQUEST['nric']));
    $p_dateofbirth    = sanitizeNoTags(trim($_REQUEST['dateofbirth']));
    $p_gender         = sanitizeNoTags(trim($_REQUEST['gender']));
    $p_Agency         = sanitizeNoTags(trim($_REQUEST['Agency']));
    $p_Region         = sanitizeNoTags(trim($_REQUEST['Region']));
    $p_address1       = sanitizeNoTags(trim($_REQUEST['address1']));
    $p_address2       = sanitizeNoTags(trim($_REQUEST['address2']));
    $p_address3       = sanitizeNoTags(trim($_REQUEST['address3']));
    $p_address4       = sanitizeNoTags(trim($_REQUEST['address4']));
    $p_postcode       = sanitizeNoTags(trim($_REQUEST['postcode']));
    $p_State          = sanitizeNoTags(trim($_REQUEST['State']));
    $p_phone          = sanitizeNoTags(trim($_REQUEST['phone']));
    $p_extension      = sanitizeNoTags(trim($_REQUEST['extension']));
    $p_fax            = sanitizeNoTags(trim($_REQUEST['fax']));
    $p_mobile         = sanitizeNoTags(trim($_REQUEST['mobile']));
    $p_email1         = sanitizeNoTags(trim($_REQUEST['email1']));
    $p_email2         = sanitizeNoTags(trim($_REQUEST['email2']));


    if(($p_agentcode) && ($p_nric) && ($p_surname) && ($p_givenname) && ($p_dateofbirth) && ($p_gender) && ($p_Region) && ($p_Agency)
        && ($p_State) && ($p_postcode) && ($p_phone) && ($p_mobile) && ($p_email1) && ($p_email2) && ($p_id)){

        $p_dateofbirth = strtotime($p_dateofbirth);
        $p_dateofbirth = date("Y-m-d H:i:s", $p_dateofbirth);

        $result = $member->updateMemberData($p_agentcode, $p_nric, $p_surname, $p_givenname, $p_dateofbirth, $p_gender, $p_Region, $p_Agency,
                                            $p_address1, $p_address2, $p_address3, $p_address4, $p_State, $p_postcode, $p_phone, $p_extension,
                                            $p_fax, $p_mobile, $p_email1, $p_email2, $p_id);

        if ($result == '1')
            return 'true';
        else
            return $result;
    }else{
        return 'Missing parameters.';
    }
}

$response = GetResponse();
echo ($response);