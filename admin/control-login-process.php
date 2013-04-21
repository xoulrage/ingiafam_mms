<?php 

// include files
include('includes/inc-common.php');


// settings
$response = 'Unable to login. Unknown error.';
$is_error = false;


// instantiate
$user = new user();


// fetch parameters
$p_username = sanitizeNoTags(trim($_REQUEST['username']));
$p_userpwd  = sanitizeNoTags(trim($_REQUEST['userpwd']));


// set default


// login process
// *************

if (($p_username) && ($p_userpwd))
{
  // get data by username
  $result = $user->getDataByUsername($p_username);
  
  if (count($result) > 0)
  {
    foreach($result as $row)
    {
      $r_user_id      = $row[0];
      $r_user_type_id = $row[1];
      $r_pwd          = trim($row[2]);
      $r_salt         = trim($row[3]);
      $r_firstname    = trim($row[4]);
      $r_lastname     = trim($row[5]);
      $r_email        = trim($row[6]);
      $r_lastlogin    = trim($row[7]);
      $r_active       = $row[8];
    }
    
    if ($r_user_id > 0)
    {

      if ($r_active == 1)
      {

        // get hash pwd
        $hash_pwd = $user->generateHash($p_userpwd, $r_salt);
        
        // password match process
        if ($hash_pwd == $r_pwd)
        {
          
          // login successful
          // - set sessions
          $_SESSION['AUTHLOGIN'] = '';
          $_SESSION['USERID']    = $r_user_id;
          $_SESSION['USERTYPE']  = $r_user_type_id;             
          $_SESSION['USERNAME']  = $p_username;
          $_SESSION['FNAME']     = $r_firstname;
          $_SESSION['LNAME']     = $r_lastname;
          $_SESSION['EMAIL']     = $r_email;
          $_SESSION['LASTLOGIN'] = $r_lastlogin;

          // get access rights
          $arr_access_rights = $user->getAccessRights($r_user_id, $r_user_type_id);
          
          // set access rights
          if (is_array($arr_access_rights))
          {
            foreach ($arr_access_rights as $value)
            {
              $_SESSION['MODULE_' . $value] = 1;
            }
          }

          // update login date
          $result_update = $user->updateLoginDate($r_user_id);
          
          // successful login response
          $response = 'true';
          
        } else {
          
          // error - incorrect password
          $response = 'Incorrect username and password combination. Please try again.';
          $is_error = true;
          
        }
      
      } else {
      
        // error - account suspended
        $response = 'Account is locked.';
        $is_error = true;
      
      }      
      
    } else {
      
      // error - account not found
      $response = 'Account not found.';
      $is_error = true;
      
    }
        
  } else {
    
    // error - account not found
    $response = 'Account not found.';
    $is_error = true;
    
  }
  
} else {
  
  // error - missing parameters
  $response = 'Error: Missing parameters';
  $is_error = true;
  
}


// return response
// ***************
echo $response;

?>