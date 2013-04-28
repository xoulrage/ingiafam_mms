<?php

// include files
include('includes/inc-common.php');

function GetResponse(){
    if (!isset($_SESSION['MEMBERID']))
        return 'Please log in';

    $member = new member();

    // fetch parameters
    $p_member_id = sanitizeNoTags(trim($_SESSION['MEMBERID']));
    $p_pwd = sanitizeNoTags(trim($_REQUEST['password']));
    $p_newpwd  = sanitizeNoTags(trim($_REQUEST['newpassword']));

    if (($p_member_id) && ($p_pwd) && ($p_newpwd)){
        $result = $member->updatePwd($p_member_id, $p_pwd, $p_newpwd);

        if ($result == 1)
            return 'true';
        else
            return 'Invalid Password.';
    }else
        return 'Missing Parameters';
}

$response = GetResponse();
echo ($response);