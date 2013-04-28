<?php 

/*
  File        : class/data/class-admin-data-member.php
  Description : Member Data Access Class 
  Ver         : 1.0
  Created by  : RYC
*/

include_once('dbhelper.php');

class data_member extends dbhelper
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
  
  // get data by id
  function dataGetData($p_id)
  {
    $p_id = parent::escape($p_id);
    
    $sql .= 'SELECT fknametitleid,  ';
    $sql .= '   surname,  ';
    $sql .= '   givenname,  ';
    $sql .= '   nric,  ';
    $sql .= '   dateofbirth,  ';
    $sql .= '   gender,  ';
    $sql .= '   unitcode,  ';
    $sql .= '   address1,  ';
    $sql .= '   address2,  ';
    $sql .= '   address3,  ';
    $sql .= '   address4,  ';
    $sql .= '   postcode,  ';
    $sql .= '   fkcountrystateid,  ';
    $sql .= '   phone,  ';
    $sql .= '   extension,  ';
    $sql .= '   fax,  ';
    $sql .= '   mobile,  ';
    $sql .= '   email1,  ';
    $sql .= '   email2,  ';
    $sql .= '   isagreedtoobitcontrib,  ';
    $sql .= '   fkrankid,  ';
    $sql .= '   membercode,  ';
    $sql .= '   agentcode,  ';
    $sql .= '   fkagencyid,  ';
    $sql .= '   fkregionid,  ';
    $sql .= '   fkmemberstatusid,  ';
    $sql .= '   fkmembertypeid,  ';
    $sql .= '   fkmembertypestatusid,  ';
    $sql .= '   dateenrolled,  ';
    $sql .= '   dateapproved,  ';
    $sql .= '   datenextrenewal,  ';
    $sql .= '   dateconverted,  ';
    $sql .= '   dateterminated,  ';
    $sql .= '   datelastadminedit,  ';
    $sql .= '   notes  ';
    $sql .= 'FROM members ';
    $sql .= 'WHERE id = ' . $p_id . ' '; 
    
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
    
    $sql .= 'SELECT id, ';
    $sql .= '   surname, ';
    $sql .= '   givenname, ';
    $sql .= '   agentcode, ';
    $sql .= '   DATE_FORMAT(datecreated, \'%d %b %Y %H:%i\'), ';
    $sql .= '   isactive ';
    $sql .= 'FROM members ';
    $sql .= 'ORDER BY surname, givenname ';
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
    $sql .= 'FROM members ';
    
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
    $sql .= 'FROM members ';
    $sql .= 'WHERE id = ' . $p_id . ' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;  
  }
  
  function dataAgency()
  {
    $sql = 'SELECT id, agencycode ';
    $sql .= 'FROM agency ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY agencycode ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataRank()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM rank ';
    $sql .= 'WHERE isative = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataRegion()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM region ';
    $sql .= 'WHERE isative = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataMemberStatus()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM member_status ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataMemberType()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM member_type ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataMemberTypeStatus()
  {
    $sql = 'SELECT id, name ';
    $sql .= 'FROM member_type_status ';
    $sql .= 'WHERE isactive = 1 ';
    $sql .= 'ORDER BY sort ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result; 
  }
  
  function dataCheckAgentCodeDuplicate($p_newagentcode)
  {
    $sql  = 'SELECT 1 ';
    $sql .= 'FROM members ';
    $sql .= 'WHERE agentcode = \'' . $p_newagentcode . '\' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;
  }
  
  function dataCheckMemberCodeDuplicate($newmembercode)
  {
    $sql  = 'SELECT 1 ';
    $sql .= 'FROM members ';
    $sql .= 'WHERE membercode = \'' . $newmembercode . '\' ';
    
    $result_mysqli = parent::query($sql);
    $result = parent::fetchAllRows($result_mysqli);
    parent::clear($result_mysqli);      

    return $result;   
  }
  
  // functional methods (CRUD)
  // -------------------------
  // user manager - add new user
  function dataAdd($paramdata, $p_salt, $p_hashpwd)
  {
    $result_id = false;
    
    $sql  = 'INSERT INTO members ';
    $sql .= '(fknametitleid, surname, givenname, nric, dateofbirth, gender, unitcode, ';
    $sql .= 'address1, address2, address3, address4, postcode, fkcountrystateid, phone, ';
    $sql .= 'extension, fax, mobile, email1, email2, isagreedtoobitcontrib, membercode, ';
    $sql .= 'agentcode, fkagencyid, fkrankid, fkregionid, fkmemberstatusid, fkmembertypeid, fkmembertypestatusid, ';
    $sql .= 'dateenrolled, dateapproved, datenextrenewal, dateconverted, dateterminated, notes, pwd, ';
    $sql .= 'saltpwd, isfirstlogin, isactive) ';
    $sql .= 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ';

    $paramtype = 'ississsssssiisssssssssiiiiiissssssssii';
    
    $paramdata2 = array(
      'userpwd' => $p_hashpwd,
      'saltpwd' => $p_salt,
      'isfirstlogin' => true,
      'isactive' => true
    );
    
    $paramdata = array_merge($paramdata, $paramdata2);
    
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
  
  function dataUpdateMemberData($paramdata)
  {
    $result_update = false;   
    
    $sql  = 'UPDATE members SET ';
    $sql .= ' fknametitleid = ?, ';
    $sql .= ' surname = ?, ';
    $sql .= ' givenname = ?, ';
    $sql .= ' nric = ?, ';
    $sql .= ' dateofbirth = ?, ';
    $sql .= ' gender = ?, ';
    $sql .= ' unitcode = ?, ';
    $sql .= ' address1 = ?, ';
    $sql .= ' address2 = ?, ';
    $sql .= ' address3 = ?, ';
    $sql .= ' address4 = ?, ';
    $sql .= ' postcode = ?, ';
    $sql .= ' fkcountrystateid = ?, ';
    $sql .= ' phone = ?, ';
    $sql .= ' extension = ?, ';
    $sql .= ' fax = ?, ';
    $sql .= ' mobile = ?, ';
    $sql .= ' email1 = ?, ';
    $sql .= ' email2 = ?, ';
    $sql .= ' isagreedtoobitcontrib = ?, ';    
    $sql .= ' membercode = ?, ';
    $sql .= ' agentcode = ?, ';
    $sql .= ' fkagencyid = ?, ';
    $sql .= ' fkrankid = ?, ';
    $sql .= ' fkregionid = ?, ';
    $sql .= ' fkmemberstatusid = ?, ';
    $sql .= ' fkmembertypeid = ?, ';
    $sql .= ' fkmembertypestatusid = ?, ';
    $sql .= ' dateenrolled = ?, ';
    $sql .= ' dateapproved = ?, ';
    $sql .= ' datenextrenewal = ?, ';
    $sql .= ' dateconverted = ?, ';
    $sql .= ' dateterminated = ?, ';
    $sql .= ' datelastadminedit = CURRENT_TIMESTAMP, ';
    $sql .= ' notes = ? ';
    $sql .= 'WHERE id = ? '; 

    $paramtype = 'ississssssssissssssissiiiiiissssssi';
    
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
    
    $sql  = 'UPDATE members SET ';
    $sql .= ' pwd = ?, ';
    $sql .= ' saltpwd = ? ';
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
  
  // user manager - update publish status (account status)
  function dataUpdatePublishStatus($p_id, $p_update_status)
  {
    $result_update = false;
    
    $sql  = 'UPDATE members SET ';
    
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
  
  // user manager - delete user
  function dataDelete($p_id)
  {
    $result_update = false;
    
    $sql  = 'UPDATE members SET ';
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
}

?>