<?php 

/*
  File        : class/class-admin-member.php
  Description : Member Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-admin-data-member.php');

class member extends data_member
{
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
  // get user by ID
  function getData($p_id)
  {
    $result = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetData($p_id);
      
      // disconnect from database
      parent:: disconnect();    
    }
    
    return $result;
  }

  // user manager - get list
  function getList($p_page, $p_recperpage)
  {
    $result = false;
    
    // format
    $p_page = sanitizeInt($p_page);
    $p_recperpage = sanitizeInt($p_recperpage);
    
    if (($p_page) && ($p_recperpage))
    {
      // get limit start
      $limitstart = getLimitStart($p_page, $p_recperpage);
      
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetList($limitstart, $p_recperpage);
      
      // disconnect from database
      parent:: disconnect();  
    }
    
    return $result;
  }
  
  // user manager - get total users
  function getTotal()
  {
    $result_total = 0;
    
    // connect to database    
    parent::connect();
      
    // get results
    $result = parent::dataGetTotal();
      
    // disconnect from database
    parent:: disconnect();  
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_total = $row[0];
      }
    }
    
    return $result_total;
  }
  
  // user manager - get publish status
  function getPublishStatus($p_id)
  {
    $result_status = '';

    // format
    $p_id = sanitizeInt($p_id);

    if ($p_id) 
    {
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetPublishStatus($p_id);
      
      // disconnect from database
      parent:: disconnect();  
      
      if (count($result) > 0)
      {
        foreach($result as $row)
        {
          $result_status = $row[0];
        }
      }

    }

    return $result_status;    
  }
  
  function getAgency()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataAgency();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function getRank()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataRank();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function getRegion()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataRegion();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function getMemberStatus()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataMemberStatus();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function getMemberType()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataMemberType();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  function getMemberTypeStatus()
  {
    $result_arr = array();
    
    // connect to db
    parent::connect();
       
    $result = parent::dataMemberTypeStatus();
      
    // disconnect from db
    parent::disconnect();
    
    if (count($result) > 0)
    {
      foreach($result as $row)
      {
        $result_arr[$row[0]] = $row[1];
      }
    }
    
    return $result_arr;
  }
  
  // functional methods (CRUD)
  // -------------------------
  function add($arrayList, $p_password)
  {
    foreach ($arrayList as $key => $val) {
      foreach ($val as $childkey => $boolean) {
        if (!$isValidated)
        {
          // CHECK IF CHILDKEY IS A MANDATORY FIELD
          if ($boolean)
            // CHECK IF CHILDKEY CONTAINS VALUE ELSE ERROR
            $isValidated = (strlen($childkey) == 0) ? false : true;
        }
        
        // CREATE NEW 2D ARRAY FOR SQL PARAM
        $arrayList2d[$key] = $childkey;
      }
    }
    
    if ($isValidated)
    {
      // check for duplicate agent and member code
      $newagentcode = $this->getArrayValue('fagentcode', $arrayList);
      $newmembercode = $this->getArrayValue('fmembercode', $arrayList);

      if ($isValidated)
      {
        parent::connect();
        $resultDuplicate = parent::dataCheckAgentCodeDuplicate($newagentcode);            
        parent:: disconnect();

        if (count($resultDuplicate))
        {
          $isValidated = false;
        }
      }        

      if ($isValidated)
      {
        parent::connect();
        $resultDuplicate = parent::dataCheckMemberCodeDuplicate($newmembercode);            
        parent:: disconnect();

        if (count($resultDuplicate))
        {
          $isValidated = false;
        }
      }
    
      if ($isValidated)
      {
        // format
        $p_pwd  = strtolower($p_password);      
      
        // generate new salt
        $salt = $this->generateSalt();
        
        // generate new hash pwd
        $hash_pwd = $this->generateHash($p_pwd, $salt);      
      
        // connect to database    
        parent::connect();
        
        // add new user
        $result_update = parent::dataAdd($arrayList2d, $salt, $hash_pwd);
                 
        // disconnect from database
        parent:: disconnect();   
      }
      else {
        $result_update = 'DUPLICATE';
      }
      
      return $result_update;
    }
  }
  
  function updateMemberData($arrayList) 
  {
    $result_update = false;
    $isValidated = false;
    $duplicateErrorMsg = "";
    
    // format
    $p_id = $this->getArrayValue('fmemberid', $arrayList);
    
    foreach ($arrayList as $key => $val) {
      foreach ($val as $childkey => $boolean) {
        if (!$isValidated)
        {
          // CHECK IF CHILDKEY IS A MANDATORY FIELD
          if ($boolean)
            // CHECK IF CHILDKEY CONTAINS VALUE ELSE ERROR
            $isValidated = (strlen($childkey) == 0) ? false : true;
        }
        
        // CREATE NEW 2D ARRAY FOR SQL PARAM
        $arrayList2d[$key] = $childkey;
      }
    }
    
    if ($isValidated)
    {
      // check for existing member
      $result = $this->getData($p_id);
      
      if (count($result) == 1)
      {
        // check for duplicate agent and member code
        $newagentcode = $this->getArrayValue('fagentcode', $arrayList);
        $newmembercode = $this->getArrayValue('fmembercode', $arrayList);
        $originalmembercode = $result[0][21];
        $originalagentcode = $result[0][22];

        if ($isValidated)
        {
          if ($newagentcode != $originalagentcode)
          {
            parent::connect();
            $resultDuplicate = parent::dataCheckAgentCodeDuplicate($newagentcode);            
            parent:: disconnect();
            
            if (count($resultDuplicate))
            {
              $duplicateErrorMsg = "DupAgentCode";
              $isValidated = false;
            }
          }
        }        
        
        if ($isValidated)
        {
          if ($newmembercode !== $originalmembercode)
          {
            parent::connect();
            $resultDuplicate = parent::dataCheckMemberCodeDuplicate($newmembercode);            
            parent:: disconnect();
            
            if (count($resultDuplicate))
            {
              $duplicateErrorMsg = "DupMemberCode";
              $isValidated = false;
            }
          }
        }
        
        if ($isValidated)
        {
          // connect to database    
          parent::connect();

          // get update result
          $result = parent::dataUpdateMemberData($arrayList2d);

          // disconnect from database
          parent:: disconnect();

          if ($result == '1')
          {
            $result_update = '1';
          }         
        }
        else {
          $result_update = $duplicateErrorMsg;
        }
      }
      else {
          $result_update = 'Error';
        }
    }
    else {
      $result_update = 'Error';
    }
    
    return $result_update;
  }
  
  function updateMemberPwd($p_id, $p_newpwd)
  {
    $common = new common();
    $result_update = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if (($p_id) && ($p_newpwd))
    {
      // - generate new salt
      $newsalt = $this->generateSalt();
      
      $newhashpwd = $this->generateHash($p_newpwd, $newsalt);
      
      // connect to database    
      parent::connect();
      
      // get update results
      $result = parent::dataUpdatePwd($p_id, $newhashpwd, $newsalt);
      
      // disconnect from database
      parent:: disconnect();

      if ($result == '1')
      {
        $result_update = '1';
      }      
      
    }
    
    return $result_update;
  }
  
  // user manager - update publish status (account status)
  function updatePublishStatus($p_id)
  {
    $result_update = false;
    $current_status = '';
    $update_status = '';
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if ($p_id)
    {
      $current_status = $this->getPublishStatus($p_id);
      
      if ($current_status == 0)
      {
        $update_status = 1;
      } else {
        $update_status = 0;      
      }
      
      // connect to db
      parent::connect();
      
      $result = parent::dataUpdatePublishStatus($p_id, $update_status);
      
      // disconnect from db
      parent::disconnect();

      if ($result == '1')
      {
        $result_update = '1';
      }
      
    }  
    
    return $result_update;
  }
  
  // user manager - delete user
  function delete($p_id)
  {
    $result_delete = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();      
      
      // delete record
      $result = parent::dataDelete($p_id);      
            
      // disconnect from database
      parent:: disconnect();
      
      if ($result == '1')
      {
        $result_delete = '1';
      } 
    }
    
    return $result_delete;
  }
  
  function getArrayValue($arraykey, $arrayList)
  {
    foreach ($arrayList as $key => $val) {
      if ($arraykey == $key)
      {
        foreach ($val as $childkey => $boolean) {
          return $childkey;
        }
      }
    }
    
    return 0;
  }
}

?>