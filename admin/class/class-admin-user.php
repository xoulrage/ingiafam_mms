<?php 

/*
  File        : class/class-admin-user.php
  Description : User Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('data/class-admin-data-user.php');

class user extends data_user
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
  function getDataByUsername($p_username)
  {
    $result = false;
    
    if ($p_username)
    {
      // format
      $p_username = strtolower(addSlashesFormat($p_username));
    
      // connect to database    
      parent::connect();
      
      // get results
      $result = parent::dataGetDataByUsername($p_username);
      
      // disconnect from database
      parent:: disconnect();      
    }
    
    return $result;
  }  
  
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
  
  // get access rights
  function getAccessRights($p_id, $p_type_id)
  {
    $result = array();
    
    // format
    $p_id = sanitizeInt($p_id);
    $p_type_id = sanitizeInt($p_type_id);
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();      
      
      if (($p_type_id == 1) || ($p_type_id == 2))
      {
        // get access rights for administrators
        $result = parent::dataGetAllAccessRights();
      
        if (count($result) > 0)
        {
          foreach($result as $row)
          {
            $r_module_id = $row[0];
          
            $result[$r_module_id] = $r_module_id;
          }
        }
                
      } else {
        // get access rigths for other users
        $result = parent::dataGetAccessRights($p_id);

        if (count($result) > 0)
        {
          foreach($result as $row)
          {
            $r_module_ids = $row[0];
          }
        }
        
        if ($r_module_ids)
        {
          $arr_module_ids = explode('|', $r_module_ids);
          
          foreach ($arr_module_ids as $value)
          {
            $result[$value] = $value;
          }          
        } 
      }

      // disconnect from database
      parent:: disconnect();

    }
    
    return $result;
  }  

  // get all access rights
  function getAllAccessRights()
  {
    $result = false;
    
    // connect to database    
    parent::connect();    

    $result = parent::dataGetAllAccessRights();

    // disconnect from database
    parent:: disconnect();
    
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
  
  
  // functional methods
  // ------------------
  
  // update login date
  function updateLoginDate($p_id)
  {
    $result_update = false;
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();
      
      // get update result
      $result = parent::dataUpdateLoginDate($p_id);
      
      // disconnect from database
      parent:: disconnect();
      
      if ($result == '1')
      {
        $result_update = true;
      }   
    }
  
    return $result_update;
  }
  
  // update user info
  function updateData($p_id, $p_fname, $p_lname, $p_email)
  {
    $result_update = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if (($p_id) && ($p_fname) && ($p_lname) && ($p_email))
    {      
      // connect to database    
      parent::connect();
      
      // get update result
      $result = parent::dataUpdateData($p_id, $p_fname, $p_lname, $p_email);
      
      // disconnect from database
      parent:: disconnect();
      
      if ($result == '1')
      {
        $result_update = '1';
      }
    }
    
    return $result_update;
  }  
  
  // update user password
  function updatePwd($p_id, $p_pwd, $p_newpwd)
  {
    $result_update = 'invalid_pwd';
    $is_current_pwd_valid = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if (($p_id) && ($p_pwd) && ($p_newpwd))
    {
      // get user info
      $result_data = $this->getData($p_id);
      
      if (count($result_data) > 0)
      {
        foreach($result_data as $row_data)
        {
          $rd_hashpwd = $row_data[2];
          $rd_salt = $row_data[3];
        }
        
        $hashpwd = $this->generateHash($p_pwd, $rd_salt);
        
        if ($hashpwd == $rd_hashpwd)
        {
          // current password match
          // - generate new salt
          $newsalt = $this->generateSalt();
          
          $newhashpwd = $this->generateHash($p_newpwd, $newsalt);
          
          if (($newsalt) && ($newhashpwd))
          {
            // update new password
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
        }
      }
      
    }
    
    return $result_update;
  }

  // user manager - add new user
  function add($p_username, $p_pwd, $p_fname, $p_lname, $p_email, $p_usertype, $p_publish)
  {
    $result_user_id = '';
    $is_duplicate = false;

    // format
    $p_usertype = sanitizeInt($p_usertype);
    
    if (($p_username) && ($p_pwd) && ($p_fname) && ($p_email) && ($p_usertype != '') && ($p_publish != ''))    
    {
      // check for existing username
      $result = $this->getDataByUsername($p_username);
      
      if (count($result) > 0)
      {
        $is_duplicate = true;
        $result_user_id = 'DUPLICATE';              
      }
      
      if ($is_duplicate != true)
      {
        // format
        $p_pwd  = strtolower($p_pwd);      
      
        // generate new salt
        $salt = $this->generateSalt();
        
        // generate new hash pwd
        $hash_pwd = $this->generateHash($p_pwd, $salt);      
      
      
        // connect to database    
        parent::connect();
        
        // add new user
        $result_user_id = parent::dataAdd($p_username, $salt, $hash_pwd, $p_fname, $p_lname, $p_email, $p_usertype, $p_publish);
                 
        // disconnect from database
        parent:: disconnect();
      }
    }
    
    return $result_user_id;
  }

  // user manager - edit user
  function updateUserData($p_id, $p_usertype, $p_username, $p_firstname, $p_lastname, $p_email, $p_publish)
  {
    $result_update = false;
    $is_duplicate = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    $p_usertype = sanitizeInt($p_usertype);
    
    if (($p_id) && ($p_usertype) && ($p_username) && ($p_firstname) && ($p_lastname) && ($p_email))
    {      
      // check for existing username
      $result = $this->getDataByUsername($p_username);
      
      if (count($result))
      {
        foreach ($result as $row)
        {
          $r_id = $row[0];
        }
      }
      
      if ($r_id)
      {
        if ($r_id != $p_id)
        {
          $is_duplicate = true;
          $result_update = 'DUPLICATE';
        }
      }
      
      if ($is_duplicate != true)
      {
        // connect to database    
        parent::connect();
      
        // get update result
        $result = parent::dataUpdateUserData($p_id, $p_usertype, $p_username, $p_firstname, $p_lastname, $p_email, $p_publish);
      
        // disconnect from database
        parent:: disconnect();
      
        if ($result == '1')
        {
          $result_update = '1';
        }        
      }

    }
    
    return $result_update;
  }
  
  // user manager - update user password
  function updateUserPwd($p_id, $p_newpwd)
  {
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

      $result2 = $this->clearAccessRights($p_id);
      
      if ($result == '1')
      {
        $result_delete = '1';
      } 
    }
    
    return $result_delete;
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
  
  // user manager (access rights) - add new access rights
  function addAccessRights($p_id, $p_module_ids)
  {
    $result_id = '';
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if (($p_id) && ($p_module_ids))
    {      
      // connect to database    
      parent::connect();
      
      $result_id = parent::dataAddAccessRights($p_id, $p_module_ids);
      
      // disconnect from database
      parent:: disconnect();
    }    
    
    return $result_id;
  }
  
  // user manager (access rights) - update acccess rights
  function updateAccessRights($p_id, $p_module_ids)
  {
    $result_update = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if (($p_id) && ($p_module_ids))
    {     
      // connect to database    
      parent::connect();
      
      $result = parent::dataUpdateAccessRights($p_id, $p_module_ids);

      // disconnect from database
      parent:: disconnect();
      
      if ($result == '1')
      {
        $result_update = '1';
      }
    }    
    
    return $result_update;
  }

  // user manager (access rights) - clear all access rights
  function clearAccessRights($p_id)
  {
    $result_clear = false;
    
    // format
    $p_id = sanitizeInt($p_id);
    
    if ($p_id)
    {
      // connect to database    
      parent::connect();
      
      $result = parent::dataClearAccessRights($p_id);
      
      // disconnect from database
      parent:: disconnect();
    }    
    
    return $result;
  }
  
  
}

?>