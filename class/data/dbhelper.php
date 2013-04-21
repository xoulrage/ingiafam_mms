<?php 

/*
  File        : class/data/dbhelper.php
  Description : Database Wrapper Class using MYSQLi 
  Ver         : 1.0
  Created by  : RYC
*/

class dbhelper
{

/*
  // production
	private $host    = 'localhost';
	private $db_name = 'ingiafam_mms';
	private $db_user = 'ingiafam_user02';
	private $db_pwd  = 'RA7t88PP2mvz';
*/

  // development
	private $host    = 'localhost';
	private $db_name = 'ingiafam_mms';
	private $db_user = 'ingiafam';
	private $db_pwd  = 'password';	


  protected $objlink;
  protected $stmt;

  protected $paramtypestring;
  protected $paramlist = array();

  // constructor
  function __construct() 
  {
    // do nothing
  }

  // General
  // ----------------------------------------------------------------

  // connect to db
  function connect()
  {
    $this->objlink = mysqli_connect($this->host, $this->db_user, $this->db_pwd, $this->db_name);
    
    if (!$this->objlink) {
      die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    
    return true;
  }

  // set character set (UTF8)
  function setUTF8()
  {
    return mysqli_set_charset($this->objlink, 'utf8');
  }

  // disconnect from db
  function disconnect()
  {
    mysqli_kill($this->objlink, mysqli_thread_id($this->objlink));
    mysqli_close($this->objlink);
  }
  

  // standard query
  // - to be used mainly for SELECT
  // ----------------------------------------------------------------

  // escape sql string
  function escape($p_var)
  {
    return mysqli_real_escape_string($this->objlink, $p_var);
  }

  // run query
  function query($p_query)
  {
    return mysqli_query($this->objlink, $p_query, MYSQLI_STORE_RESULT);
  }

  // get last inserted id
  function getInsertedID()
  {
    return mysqli_insert_id($this->objlink);
  }

  // fetch all rows from result set
  function fetchAllRows($p_result)
  {
    $results = array();
      
    if ($p_result instanceof mysqli_result)
    {
      while($row = $p_result->fetch_array())
      {
        $results[] = $row;        
      }
    }
    
    return $results;
  }

  // clear memory associated to a result fetched
  function clear($p_result)
  {
    if ($p_result instanceof mysqli_result)
    {  
      return mysqli_free_result($p_result);
    } else {
      return false;
    }
  }


  // prepared statements / parameterized query
  // - to be used mainly for INSERT, UPDATE and DELETE
  // - note: prepared statements cannot handle single quotes in query
  // ----------------------------------------------------------------
  
  // create a prepared statement 
  function stmtPrepare($p_query)
  {
    $this->stmt = mysqli_stmt_init($this->objlink);

    mysqli_stmt_prepare($this->stmt, filter_var($p_query, FILTER_SANITIZE_STRING));

    if ($this->stmt->error == false)
    {
      return true;
    } else {
      return $this->stmt->error;
    }
  }
  
  
  // set parameter type list
  // param type:
  // i - integer 
  // d - double
  // s - string
  // b - blob    
  function stmtSetParamTypeString($p_paramtypestring)
  {
    if ($p_paramtypestring != '')
    {
      $this->paramtypestring = $p_paramtypestring;
      
      return true;
    }
    
    return false;
  }
  
  // set parameter data
  function stmtSetParamData($p_paramdata)
  {
    if (is_array($p_paramdata))
    {
      foreach($p_paramdata as $key => $val)
      {
        $this->paramlist[$key] = $val;
      }    
      
      return true;
    }
    
    return false;
  }
  
  // bind parameters to prepared statement
  function stmtBindParam()
  {
    $args = array();
    
    $args[] = $this->paramtypestring;
    
    foreach ($this->paramlist as $key => $val) {
      $args[] = &$this->paramlist[$key];
    }
    
    call_user_func_array(array($this->stmt, 'bind_param'), $args);
    
    return true;
  } 

  // execute the prepared statement
  function stmtExecute()
  {
    mysqli_stmt_execute($this->stmt);
      
    if (!mysqli_stmt_error($this->stmt))
    {
      return true;
    } else {
      die(mysqli_stmt_error($this->stmt));
    }
  
    return false;
  }

  // get last inserted id
  function stmtGetInsertedID()
  {
    return mysqli_stmt_insert_id($this->stmt);
  }

  // fetch all rows from result set
  function stmtFetchAllRows()
  {
    $results = array();

    while (mysqli_stmt_fetch($this->stmt)) {
      $x = array();
      foreach ($row as $key => $val) 
      {
        $x[$key] = $val;
      }
      $results[] = $x;
    }
    
    return $results;
  }

  // get number of rows affected by last executed statement (for INSERT, UPDATE and DELETE only)
  function stmtGetTotalAffectedRows()
  {
    return mysqli_stmt_affected_rows($this->stmt);
  }
  
  // reset the prepared statement to the state after it is prepared
  function stmtReset()
  {
    // clear string
    $this->paramtypestring = '';
  
    // clear array
    unset($this->paramlist);
    $paramlist = array();
  
    return mysqli_stmt_reset($this->stmt);
  }
  
  // close the prepared statement
  function stmtClose()
  {
    return mysqli_stmt_close($this->stmt);
  }

}

?>