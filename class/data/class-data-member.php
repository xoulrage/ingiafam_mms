<?php 

/*
  File        : class/data/class-data-member.php
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

  
  // functional methods (CRUD)
  // -------------------------
   function dataGetDataByAgentCodeAndNRIC($p_agentcode, $p_nric){
       $p_agentcode = parent::escape($p_agentcode);
       $p_nric = parent::escape($p_nric);

       $sql  = 'SELECT 	id, ';
       $sql .= 'nric, ';
       $sql .= 'agentcode, ';
       $sql .= 'isfirstlogin, ';
       $sql .= 'datefirstlogin, ';
       $sql .= 'datecreated, ';
       $sql .= 'isactive ';
       $sql .= 'FROM members ';
       $sql .= 'WHERE agentcode LIKE \'' . $p_agentcode . '%\' ';
       $sql .= 'AND nric = \'' . $p_nric . '\' ';

       $result_mysqli = parent::query($sql);
       $result = parent::fetchAllRows($result_mysqli);
       parent::clear($result_mysqli);


       return $result;
       //return $sql;
   }

   function dataGetData($p_id){
       $p_id = parent::escape($p_id);

       $sql = 'SELECT id, '; //
       $sql .= 'membercode, '; //
       $sql .= 'agentcode, '; //
       $sql .= 'unitcode, ';
       $sql .= 'pwd, '; //
       $sql .= 'saltpwd, ';
       $sql .= 'fknametitleid, ';
       $sql .= 'surname, '; //
       $sql .= 'givenname, '; //
       $sql .= 'nric, '; //
       $sql .= 'dateofbirth, '; //
       $sql .= 'gender, '; //
       $sql .= 'fkagencyid, '; //
       $sql .= 'fkrankid, ';
       $sql .= 'fkregionid, '; //
       $sql .= 'address1, '; //
       $sql .= 'address2, '; //
       $sql .= 'address3, '; //
       $sql .= 'address4, '; //
       $sql .= 'postcode, '; //
       $sql .= 'fkcountrystateid, '; //
       $sql .= 'phone, '; //
       $sql .= 'extension, '; //
       $sql .= 'fax, '; //
       $sql .= 'mobile, '; //
       $sql .= 'email1, '; //
       $sql .= 'email2, '; //
       $sql .= 'fkmemberstatusid, ';
       $sql .= 'fkmembertypeid, ';
       $sql .= 'fkmembertypestatusid, ';
       $sql .= 'isagreedtoobitcontrib, ';
       $sql .= 'DATE_FORMAT(dateenrolled, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(dateapproved, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(datenextrenewal, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(dateconverted, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(dateterminated, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(datelastuserlogin, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(datelastuseredit, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(datelastadminedit, \'%d %b %Y %H:%i\'), ';
       $sql .= 'notes, ';
       $sql .= 'isfirstlogin, ';
       $sql .= 'DATE_FORMAT(datefirstlogin, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(datecreated, \'%d %b %Y %H:%i\'), ';
       $sql .= 'isactive ';
       $sql .= 'FROM members ';
       $sql .= 'WHERE id = ' . $p_id . ' ';

       $result_mysqli = parent::query($sql);
       $result = parent::fetchAllRows($result_mysqli);
       parent::clear($result_mysqli);

       return $result;
   }

   function dataGetDataByUsername($p_agentcode)
   {
        $p_agentcode = parent::escape($p_agentcode);

        $sql  = 'SELECT id, ';
        $sql .= 'membercode, ';
        $sql .= 'agentcode, ';
        $sql .= 'unitcode, ';
        $sql .= 'pwd, ';
        $sql .= 'saltpwd, ';
        $sql .= 'fknametitleid, ';
        $sql .= 'surname, ';
        $sql .= 'givenname, ';
        $sql .= 'DATE_FORMAT(dateterminated, \'%d %b %Y %H:%i\'), ';
        $sql .= 'DATE_FORMAT(datelastuserlogin, \'%d %b %Y %H:%i\'), ';
        $sql .= 'DATE_FORMAT(datelastuseredit, \'%d %b %Y %H:%i\'), ';
        $sql .= 'DATE_FORMAT(datelastadminedit, \'%d %b %Y %H:%i\'), ';
        $sql .= 'isfirstlogin, ';
        $sql .= 'DATE_FORMAT(datefirstlogin, \'%d %b %Y %H:%i\'), ';
        $sql .= 'DATE_FORMAT(datecreated, \'%d %b %Y %H:%i\'), ';
        $sql .= 'isactive ';
        $sql .= 'FROM members ';
        $sql .= 'WHERE agentcode = \'' . $p_agentcode . '\' ';

        $result_mysqli = parent::query($sql);
        $result = parent::fetchAllRows($result_mysqli);
        parent::clear($result_mysqli);

        return $result;
   }

    // update pwd
    function dataUpdatePwd($p_id, $p_newhashpwd, $p_newsalt)
    {
        $result_update = false;

        $sql  = 'UPDATE members SET ';
        $sql .= 'pwd = ?, ';
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

    //update isfirstlogin
    function dataUpdateFirstLogin($p_id, $p_newhashpwd, $p_newsalt)
    {
        $result_update = false;

        $sql  = 'UPDATE members SET ';
        $sql .= 'isfirstlogin = 0, ';
        $sql .= 'pwd = ?, ';
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

}
    
?>