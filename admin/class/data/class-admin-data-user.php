<?php 

/*
  File        : class/data/class-admin-data-user.php
  Description : User Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_user extends dbhelper
{
  
  // constructor
  function __construct()
  {
    // do nothing
  }

  // common methods
  // --------------
  
  
  
  // data extraction methods
  // -----------------------  

    // get user data by username
  function dataGetDataByUsername($p_username)
  {
    $p_username = parent::escape($p_username);
    
    $sql  = 'SELECT id, ';
    $sql .= 'fkusertypeid,';
    $sql .= 'userpwd, ';
    $sql .= 'saltpwd, ';
    $sql .= 'firstname, ';
    $sql .= 'lastname, ';
    $sql .= 'email, ';
    $sql .= 'DATE_FORMAT(datelastlogin, \'%d %b %Y %H:%i\'), ';
    $sql .= 'isactive  ';
    $sql .= 'FROM user ';
    $sql .= 'WHERE username = \'' . $p_username . '\' ';
    $sql .= 'AND isdeleted = 0 ';   
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;   
  }
  
  // get data by id
  function dataGetData($p_id)
  {
    $p_id = parent::escape($p_id);
    
    $sql  = 'SELECT fkusertypeid,';
    $sql .= 'username, ';
    $sql .= 'userpwd, ';
    $sql .= 'saltpwd, ';
    $sql .= 'firstname, ';
    $sql .= 'lastname, ';
    $sql .= 'email, ';
    $sql .= 'DATE_FORMAT(datelastlogin, \'%d %b %Y %H:%i\'), ';
    $sql .= 'isactive  ';
    $sql .= 'FROM user ';
    $sql .= 'WHERE id = ' . $p_id . ' ';
    $sql .= 'AND isdeleted = 0 ';  
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // get access rights
  function dataGetAccessRights($p_id)
  {
    $p_id = parent::escape($p_id);
    
    $sql  = 'SELECT moduleids ';
    $sql .= 'FROM user_access ';
    $sql .= 'WHERE fkuserid = ' . $p_id . ' ';
    $sql .= 'AND isactive = 1 ';  
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // get all access rights
  function dataGetAllAccessRights()
  {
    
    $sql  = 'SELECT moduleid, ';
    $sql .= 'name ';
    $sql .= 'FROM user_module ';
    $sql .= 'WHERE isactive = 1 '; 
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }

  // user manager - get list
  function dataGetList($p_limitstart, $p_recperpage)
  {
    $p_limitstart = parent::escape($p_limitstart);
    $p_recperpage = parent::escape($p_recperpage);
    
    $sql  = 'SELECT a.id, ';
    $sql .= 'a.fkusertypeid, ';
    $sql .= '(SELECT b.title FROM user_type b WHERE b.id = a.fkusertypeid) AS usertype, ';
    $sql .= 'a.username, ';
    $sql .= 'a.firstname, ';
    $sql .= 'a.lastname, ';
    $sql .= 'DATE_FORMAT(a.datelastlogin, \'%a %d %b %Y\') AS lastlogindate, ';                      
    $sql .= 'a.isactive ';    
    $sql .= 'FROM user a ';
    $sql .= 'WHERE a.fkusertypeid <> 1 ';
    $sql .= 'AND a.isdeleted = 0 ';    
    $sql .= 'ORDER BY a.username ';
    $sql .= 'LIMIT  ' . $p_limitstart . ', ' . $p_recperpage . ' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // user manager - get total
  function dataGetTotal()
  {
    $sql  = 'SELECT COUNT(id) ';
    $sql .= 'FROM user ';
    $sql .= 'WHERE isdeleted = 0 ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  // user manager - get publish status (account status)
  function dataGetPublishStatus($p_id)
  {
    $p_id = parent::escape($p_id);
    
    $sql  = 'SELECT isactive ';
    $sql .= 'FROM user ';
    $sql .= 'WHERE id = ' . $p_id . ' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }  
  
  
  // functional methods
  // ------------------
  
  // update login date
  function dataUpdateLoginDate($p_id)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user ';
    $sql .= 'SET datelastlogin = NOW() ';
    $sql .= 'WHERE id = ? ';

    $paramtype = 'i';
    
    $paramdata = array(
      'userid' => $p_id 
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
    
  // update info
  function dataUpdateData($p_id, $p_fname, $p_lname, $p_email)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user SET ';
    $sql .= 'firstname = ?, ';
    $sql .= 'lastname = ?, ';
    $sql .= 'email = ? ';
    $sql .= 'WHERE id = ? ';

    $paramtype = 'sssi';
    
    $paramdata = array(
      'firstname' => $p_fname,
      'lastname'=> $p_lname,
      'email' => $p_email,
      'userid' => $p_id 
    );    

    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
  
  // update pwd
  function dataUpdatePwd($p_id, $p_newhashpwd, $p_newsalt)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user SET ';
    $sql .= 'userpwd = ?, ';
    $sql .= 'saltpwd = ? ';
    $sql .= 'WHERE id = ? ';

    $paramtype = 'ssi';
    
    $paramdata = array(
      'newhashpwd' => $p_newhashpwd,
      'newsalt'=> $p_newsalt,
      'userid' => $p_id 
    );    

    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
  
  // user manager - add new user
  function dataAdd($p_username, $p_salt, $p_hashpwd, $p_fname, $p_lname, $p_email, $p_usertype, $p_publish)
  {
    $result_id = false;
    
    $sql  = 'INSERT INTO user ';
    $sql .= '(fkusertypeid, username, userpwd, saltpwd, firstname, lastname, email, isactive) VALUES ';
    $sql .= '(?, ?, ?, ?, ?, ?, ?, ?) ';

    $paramtype = 'issssssi';
    
    $paramdata = array(
      'fkusertypeid' => $p_usertype,
      'username' => $p_username,
      'userpwd' => $p_hashpwd,
      'saltpwd' => $p_salt,
      'firstname' => $p_fname,
      'lastname' => $p_lname,
      'email' => $p_email,
      'isactive' => $p_publish
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
   
    parent::stmtExecute();
    $result_id = parent::stmtGetInsertedID();
    parent::stmtReset();
    parent::stmtClose();    

    return $result_id;    
  }
  
  // user manager - edit user data
  function dataUpdateUserData($p_id, $p_usertype, $p_username, $p_firstname, $p_lastname, $p_email, $p_publish)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user SET ';
    $sql .= 'username = ?, ';
    $sql .= 'fkusertypeid = ?, ';
    $sql .= 'firstname = ?, ';
    $sql .= 'lastname = ?, ';
    $sql .= 'email = ?, ';
    $sql .= 'isactive = ? ';
    $sql .= 'WHERE id = ? ';

    $paramtype = 'sisssii';
    
    $paramdata = array(
      'username' => $p_username,
      'fkusertypeid' => $p_usertype,
      'firstname' => $p_firstname,
      'lastname'=> $p_lastname,
      'email' => $p_email,
      'isactive' => $p_publish,
      'userid' => $p_id 
    );    

    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    $result_update = '1';

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
  
  // user manager - delete user
  function dataDelete($p_id)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user SET ';
    $sql .= 'isactive = 0, ';
    $sql .= 'isdeleted = 1 ';
    $sql .= 'WHERE id = ? ';

    $paramtype = 'i';
    
    $paramdata = array(
      'userid' => $p_id 
    );    

    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }

  // user manager - update publish status (account status)
  function dataUpdatePublishStatus($p_id, $p_update_status)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user SET ';
    
    if ($p_update_status == 1)
    {
      $sql .= 'isactive = 1 ';
    } else {
      $sql .= 'isactive = 0 ';
    }

    $sql .= 'WHERE id = ? ';

    $paramtype = 'i';
    
    $paramdata = array(
      'id' => $p_id 
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }    

  // user manager (access rights) - add new access rights
  function dataAddAccessRights($p_id, $p_module_ids)
  {
    $result_id = false;
    
    $sql  = 'INSERT INTO user_access ';
    $sql .= '(fkuserid, moduleids) VALUES ';
    $sql .= '(?, ?) ';

    $paramtype = 'is';
    
    $paramdata = array(
      'fkuserid' => $p_id,
      'moduleids' => $p_module_ids
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
   
    parent::stmtExecute();
    $result_id = parent::stmtGetInsertedID();
    parent::stmtReset();
    parent::stmtClose();    

    return $result_id;    
  }
  
  // user manager (access rights) - update acccess rights
  function dataUpdateAccessRights($p_id, $p_module_ids)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user_access SET ';
    $sql .= 'moduleids = ? ';
    $sql .= 'WHERE fkuserid = ? ';

    $paramtype = 'si';
    
    $paramdata = array(
      'moduleids' => $p_module_ids,
      'fkuserid' => $p_id
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    $result_update = '1';

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }  
  
  // user manager (access rights) - clear all access rights
  function dataClearAccessRights($p_id)
  {
    $result_update = false;
    
    $sql  = 'UPDATE user_access SET ';
    $sql .= 'isactive = 0 ';
    $sql .= 'WHERE fkuserid = ? ';

    $paramtype = 'i';
    
    $paramdata = array(
      'fkuserid' => $p_id
    );
    
    parent::stmtPrepare($sql);    

    parent::stmtSetParamTypeString($paramtype);
    parent::stmtSetParamData($paramdata);
    parent::stmtBindParam();
    
    parent::stmtExecute();
    $result = parent::stmtGetTotalAffectedRows();
    
    if ($result > 0)
    {
      $result_update = '1';
    }

    parent::stmtReset();    
    parent::stmtClose(); 
    
    return $result_update;  
  }
  
}

?>