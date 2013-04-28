<?php
// include files
include('includes/inc-common.php');

function GetResponse(){
    $member = new member();

    // fetch parameters
    $p_agentCode = sanitizeNoTags(trim($_REQUEST['agentCode']));
    $p_password  = sanitizeNoTags(trim($_REQUEST['password']));

    if (($p_agentCode) && ($p_password))
    {
        $result = $member->getDataByUsername($p_agentCode);

        if (count($result) > 0)
        {
            foreach($result as $row)
            {
                $r_memberId     = $row[0];
                $r_agentCode    = trim($row[2]);
                $r_pwd          = trim($row[4]);
                $r_salt      = trim($row[5]);
                $r_isFirstLogin = $row[13];
                $r_isActive     = $row[16];
            }

            if ($r_memberId == 0)
                return 'Member not found.';

            if($r_isActive == 0)
                return 'Member is locked.';

            if($r_isFirstLogin == 1)
                return 'Member is not activated';

            // get hash pwd
            $hash_pwd = $member->generateHash($p_password, $r_salt);

            if ($hash_pwd == $r_pwd) //Login Successful
            {
                $_SESSION['MEMBERID'] = $r_memberId;
                $_SESSION['FIRSTLOGIN'] = false;
                //TODO: Update last login date

                return 'true';
            }else
                return 'Incorrect username and password combination. Please try again.';
        }else
            return 'Member not found.';
    }else{
        return 'Missing parameters.';
    }
}

$response = GetResponse();
echo $response;
