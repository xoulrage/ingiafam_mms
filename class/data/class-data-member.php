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



       $sql = 'SELECT m.id, ';
       $sql .= 'm.membercode, ';                //1
       $sql .= 'm.agentcode, ';                 //2
       $sql .= 'm.unitcode, ';
       $sql .= 'm.pwd, ';
       $sql .= 'm.saltpwd, ';
       $sql .= 'm.fknametitleid, ';
       $sql .= 'm.surname, ';                   //7
       $sql .= 'm.givenname, ';                 //8
       $sql .= 'm.nric, ';                      //9
       $sql .= 'm.dateofbirth, ';      //10  $sql .= 'DATE_FORMAT(m.dateofbirth, \'%d %b %Y\'), ';
       $sql .= 'm.gender, ';                    //11
       $sql .= 'm.fkagencyid, ';
       $sql .= 'CONCAT(a.agencycode, \' \', a.name) AS \'Agency\', ';  //13
       $sql .= 'm.fkrankid, ';
       $sql .= 'ra.name AS \'Rank\', ';         //15
       $sql .= 'm.fkregionid, ';
       $sql .= 'r.name AS \'Region\', ';        //17
       $sql .= 'm.address1, ';                  //18
       $sql .= 'm.address2, ';                  //19
       $sql .= 'm.address3, ';                  //20
       $sql .= 'm.address4, ';                  //21
       $sql .= 'm.postcode, ';                  //22
       $sql .= 'm.fkcountrystateid, ';
       $sql .= 'cs.name AS \'State\', ';        //24
       $sql .= 'm.phone, ';                     //25
       $sql .= 'm.extension, ';                 //26
       $sql .= 'm.fax, ';                       //27
       $sql .= 'm.mobile, ';                    //28
       $sql .= 'm.email1, ';                    //29
       $sql .= 'm.email2, ';                    //30
       $sql .= 'm.fkmemberstatusid, ';
       $sql .= 'm.fkmembertypeid, ';
       $sql .= 'mt.name AS \'Member Type\', ';  //33
       $sql .= 'm.fkmembertypestatusid, ';
       $sql .= 'm.isagreedtoobitcontrib, ';
       $sql .= 'DATE_FORMAT(m.dateenrolled, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.dateapproved, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.datenextrenewal, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.dateconverted, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.dateterminated, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.datelastuserlogin, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.datelastuseredit, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.datelastadminedit, \'%d %b %Y %H:%i\'), ';
       $sql .= 'm.notes, ';
       $sql .= 'm.isfirstlogin, ';
       $sql .= 'DATE_FORMAT(m.datefirstlogin, \'%d %b %Y %H:%i\'), ';
       $sql .= 'DATE_FORMAT(m.datecreated, \'%d %b %Y %H:%i\'), ';
       $sql .= 'm.isactive ';
       $sql .= 'FROM members m ';
       $sql .= 'LEFT JOIN agency a ON a.id = m.fkagencyid ';
       $sql .= 'LEFT JOIN country_state cs ON cs.id = m.fkcountrystateid ';
       $sql .= 'LEFT JOIN member_type mt ON mt.id = m.fkmembertypeid ';
       $sql .= 'LEFT JOIN region r ON r.id = m.fkregionid ';
       $sql .= 'LEFT JOIN rank ra ON ra.id = m.fkrankid ';
       $sql .= 'WHERE m.id = ' . $p_id . ' ';

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

    function dataUpdateMemberData($p_agentCode, $p_nric, $p_surname, $p_givenname, $p_dateofbirth, $p_gender, $p_fkregionid, $p_fkagencyid,
                                  $p_address1, $p_address2, $p_address3, $p_address4, $p_fkcountrystateid, $p_postcode, $p_phone, $p_extension,
                                  $p_fax, $p_mobile, $p_email, $p_email2, $p_id){

        $result_update = '0';

        $sql  = 'UPDATE members SET ';
        $sql .= 'agentcode = ? , ';
        $sql .= 'nric = ?, ';
        $sql .= 'surname = ?, ';
        $sql .= 'givenname = ?, ';
        $sql .= 'dateofbirth = ?, ';
        $sql .= 'gender = ?, ';
        $sql .= 'fkregionid = ?, ';
        $sql .= 'fkagencyid = ?, ';
        $sql .= 'address1 = ?, ';
        $sql .= 'address2 = ?, ';
        $sql .= 'address3 = ?, ';
        $sql .= 'address4 = ?, ';
        $sql .= 'fkcountrystateid = ?, ';
        $sql .= 'postcode = ?, ';
        $sql .= 'phone = ?, ';
        $sql .= 'extension = ?, ';
        $sql .= 'fax = ?, ';
        $sql .= 'mobile = ?, ';
        $sql .= 'email1 = ?, ';
        $sql .= 'email2 = ? ';
        $sql .= 'WHERE id = ? ';

        $paramtype = 'ssssssiissssisssssssi';

        $paramdata = array(
            'agentcode' => $p_agentCode,
            'nric'=> $p_nric,
            'surname' => $p_surname,
            'givenname' => $p_givenname,
            'dateofbirth' => $p_dateofbirth,
            'gender' => $p_gender,
            'fkregionid' => $p_fkregionid,
            'fkagencyid' => $p_fkagencyid,
            'address1' => $p_address1,
            'address2' => $p_address2,
            'address3' => $p_address3,
            'address4' => $p_address4,
            'fkcountrystateid' => $p_fkcountrystateid,
            'postcode' => $p_postcode,
            'phone' => $p_phone,
            'extension' => $p_extension,
            'fax' => $p_fax,
            'mobile' => $p_mobile,
            'email1' => $p_email,
            'email2' => $p_email2,
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
}
    
?>