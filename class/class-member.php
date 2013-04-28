<?php 

/*
  File        : class/class-member.php
  Description : Member Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-data-member.php');

class member extends data_member
{
  var $login_hash_key;
  var $arr_modules;

    // constructor
    function __construct()
    {
      define('SALT_LENGTH', 9);
      define('HASH_ALGORITHM', 'SHA512');
      define('LOGIN_HASH', 'cb88e31fc1d1fd78850ab46bd60bcb4304277900919030f1ad0a069d7087d9c2c16bdf45f31b26daf7df5639d803c0846eeee861c8cfc263943aa072effb2934');

      $this->login_hash_key = LOGIN_HASH;
    }

    // common methods
    // --------------
    // generate salt
    function generateSalt()
    {
        $var_salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);

        return $var_salt;
    }

    // generate hash
    function generateHash($var_text, $var_salt = null)
    {
        $var_hash = hash(HASH_ALGORITHM, $var_salt . $var_text);

        return $var_hash;
    }
  
    // data extraction methods
    // -----------------------
    // get user data by user name
    function getDataByAgentCodeAndNRIC($p_agentcode, $p_nric)
    {
        $result = false;

        if (($p_agentcode) && ($p_nric))
        {
            // format
            $p_agentcode = strtolower(addSlashesFormat($p_agentcode));
            $p_nric = strtolower(addSlashesFormat($p_nric));

            // connect to database
            parent::connect();

            // get results
            $result = parent::dataGetDataByAgentCodeAndNRIC($p_agentcode, $p_nric);

            // disconnect from database
            parent:: disconnect();
        }

        return $result;
    }

    function getData($p_id){
        $result = false;

        $p_id = sanitizeInt($p_id);

        if ($p_id){
            parent::connect();
            $result = parent::dataGetData($p_id);
            parent::disconnect();
        }

        return  $result;
    }

    function getDataByUsername($p_agentcode){
        $result = false;

         if ($p_agentcode){
             // format
             $p_agentcode = strtolower(addSlashesFormat($p_agentcode));
             parent::connect();
             $result = parent::dataGetDataByUsername($p_agentcode);
             parent:: disconnect();
         }

        return $result;
    }

    // functional methods (CRUD)
    // -------------------------
    function updateFirstLogin($p_id, $p_pwd){
        $result = false;

        if (($p_id) && ($p_pwd)){
            // format
            $p_id = sanitizeInt($p_id);
            $p_pwd  = strtolower($p_pwd);

            // generate new salt
            $salt = $this->generateSalt();

            // generate new hash pwd
            $hash_pwd = $this->generateHash($p_pwd, $salt);

            parent::connect();
            $result = parent::dataUpdateFirstLogin($p_id, $hash_pwd, $salt);
            parent:: disconnect();
        }

        return $result;
    }


    function updatePwd($p_id, $p_pwd, $p_newpwd){
        $result_update = 'invalid_pwd';

        // format
        $p_id = sanitizeInt($p_id);

        if (($p_id) && ($p_pwd) && ($p_newpwd)){
            // get user info
            $result_data = $this->getData($p_id);

            if (count($result_data) > 0)
            {
                foreach($result_data as $row_data)
                {
                    $rd_hashpwd = $row_data[4];
                    $rd_salt = $row_data[5];
                }

                $hashpwd = $this->generateHash($p_pwd, $rd_salt);

                if ($hashpwd == $rd_hashpwd)
                {
                    $newsalt = $this->generateSalt();
                    $newhashpwd = $this->generateHash($p_newpwd, $newsalt);

                    if (($newsalt) && ($newhashpwd))
                    {
                        parent::connect();
                        $result = parent::dataUpdatePwd($p_id, $newhashpwd, $newsalt);
                        parent::disconnect();

                        if ($result == '1')
                            $result_update = '1';
                    }
                }
            }
        }
        return $result_update;
    }

    function updateMemberData($p_agentCode, $p_nric, $p_surname, $p_givenname, $p_dateofbirth, $p_gender, $p_fkregionid, $p_fkagencyid,
                              $p_address1, $p_address2, $p_address3, $p_address4, $p_fkcountrystateid, $p_postcode, $p_phone, $p_extension,
                              $p_fax, $p_mobile, $p_email, $p_email2, $p_id){
        $isDuplicateAgentCode = false;
        $p_id = sanitizeInt($p_id);

        if(($p_agentCode) && ($p_nric) && ($p_surname) && ($p_givenname) && ($p_dateofbirth) && ($p_gender) && ($p_fkregionid) && ($p_fkagencyid) &&
         ($p_fkcountrystateid) && ($p_postcode) && ($p_phone) && ($p_mobile) && ($p_email) && ($p_email2) && ($p_id)){

            $p_nric = addSlashesFormat($p_nric);
            $p_surname = addSlashesFormat($p_surname);
            $p_givenname = addSlashesFormat($p_givenname);
            $p_address1 = addSlashesFormat($p_address1);
            $p_address2 = addSlashesFormat($p_address2);
            $p_address3 = addSlashesFormat($p_address3);
            $p_address4 = addSlashesFormat($p_address4);
            $p_postcode = addSlashesFormat($p_postcode);
            $p_phone = addSlashesFormat($p_phone);
            $p_extension = addSlashesFormat($p_extension);
            $p_fax = addSlashesFormat($p_fax);
            $p_mobile = addSlashesFormat($p_mobile);
            $p_email = addSlashesFormat($p_email);
            $p_email2 = addSlashesFormat($p_email2);

            $result_data = $this->getDataByUsername($p_agentCode);

            if (count($result_data) > 0)
            {
                foreach($result_data as $row_data)
                {
                    $r_id = $row_data[0];
                    if ($r_id != $p_id)
                        $isDuplicateAgentCode = true;
                        break;
                }
            }

            if ($isDuplicateAgentCode)
                return 'The Agent Code already existed!';

            parent::connect();
            $result = parent::dataUpdateMemberData($p_agentCode, $p_nric, $p_surname, $p_givenname, $p_dateofbirth, $p_gender, $p_fkregionid, $p_fkagencyid,
                $p_address1, $p_address2, $p_address3, $p_address4, $p_fkcountrystateid, $p_postcode, $p_phone, $p_extension,
                $p_fax, $p_mobile, $p_email, $p_email2, $p_id);
            parent::disconnect();

            if ($result == '1')
                return '1';
            elseif ($result == '0')
                return 'No Changes Made';
        }else
            return 'Missing Parameters.';

        return 'Unknown Error.';
    }

}


    
?>