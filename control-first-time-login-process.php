<?php

// include files
include('includes/inc-common.php');

function GetResponse()
{
    if (!isset($_SESSION['MEMBERID']))
        return 'Please log in';

    if ($_SESSION['FIRSTLOGIN'] == false)
        return 'Member has already been activated.';

    $member = new member();

    // fetch parameters
    $p_password = sanitizeNoTags(trim($_REQUEST['password']));
    $p_id = sanitizeNoTags(trim($_SESSION['MEMBERID']));

    if ($p_password){
        $result = $member->updateFirstLogin($p_id, $p_password);

        if ($result == 1) {
            $_SESSION['FIRSTLOGIN'] = false;
            return 'true';
        }

        return 'Unable to set password. Unknown error.';
    }

}

$response = GetResponse();
echo $response;











