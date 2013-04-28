<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hong
 * Date: 4/27/13
 * Time: 1:25 PM
 * To change this template use File | Settings | File Templates.
 */

// include files
include('includes/inc-common.php');

// settings
$response = '';
$is_error = false;

$member = new member();

$p_agentCode = sanitizeNoTags(trim($_REQUEST['agentCode']));
$p_nric = sanitizeNoTags(trim($_REQUEST['nric']));

if (($p_agentCode) && ($p_nric)){
    if (strlen($p_agentCode) == 7){
        if (substr($p_agentCode, -2, 1) == '-'){
            $p_agentCode = substr($p_agentCode, 0, 5);
        }
    }

    $result = $member->getDataByAgentCodeAndNRIC($p_agentCode, $p_nric);

    if (count($result) > 0){
        foreach($result as $row)
        {
            $r_member_id = $row[0];
            $r_agent_code = $row[2];
            $r_first_login = $row[3];
            $r_is_active = $row[6];
        }

        if ($r_first_login == 0)
            $response = 'Member is already active';
        elseif ($r_is_active == 0)
            $response = 'Member is locked';

        if ($response == ''){ //Login Successful
            $_SESSION['MEMBERID']   = $r_member_id;
            $_SESSION['FIRSTLOGIN'] = true;
            $response = 'true';
        }
    }else{
        $response = 'Member Not Found';
    }

    //echo $result;
    if ($response == '')
        $response = 'Unable to login. Unknown error.';
    echo $response;
}