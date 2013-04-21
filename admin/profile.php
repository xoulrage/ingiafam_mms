<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_user_available = false;


// instantiate
$user = new user();


// fetch parameters
$p_user_id = sanitizeNoTags(trim($_SESSION['USERID']));


// set default


// get user data
// *************
if ($p_user_id)
{
  $result = $user->getData($p_user_id);
  
  if (count($result) > 0)
  {
    $is_user_available = true; 
    
    foreach($result as $row)
    {
      $r_username = trim($row[1]);
      $r_fname = trim($row[4]);
      $r_lname = trim($row[5]);
      $r_email = trim($row[6]);
      $r_lastlogin = trim($row[7]);
    }
  }
}

// - log user out if account not found
if ($is_user_available != true)
{
  $url_redirect = ABSPATH . BACKOFFICEPATH . 'logout.php';
  header("location: $url_redirect");
}


?>

<?php include('page-header.php'); ?>

  <script type="text/javascript">
  $(document).ready(function () {
    
    // event - click on edit info button
    $('#btn_editinfo').click(function(){
      
      window.location.href = 'profile-editinfo.php';
      return false;
      
    });

    // event - click on edit password button
    $('#btn_editpwd').click(function(){
      
      window.location.href = 'profile-editpwd.php';
      return false;
      
    });
    
  });  
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">EDIT YOUR PROFILE</span>
      </div>
      
      <div id="content">
        Your login account information is as shown below:
        <br /><br /><br />
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="20%"><b>Username:</b></td>
            <td><?php echo $r_username; ?></td>
          </tr>
          <tr>
            <td><b>First Name:</b></td>
            <td><?php echo $r_fname; ?></td>
          </tr>
          <tr>
            <td><b>Last Name:</b></td>
            <td><?php echo $r_lname; ?></td>
          </tr>
          <tr>
            <td><b>Email Address:</b></td>
            <td><?php echo $r_email; ?></td>
          </tr>
          <tr>
            <td><b>Last Login On:</b></td>
            <td><?php echo trim($_SESSION['LASTLOGIN']); ?></td>
          </tr>
        </table>

      </div>
      
    </div>
    <div id="content_right">
      <div id="content_title_small">
        <span class="text_title_content_small">INSTRUCTIONS</span>
      </div>
      
      <div id="content">
        If you wish to edit your profile information, click on the button below:
        <br /><br />
        <input type="button" id="btn_editinfo" value="EDIT PROFILE" class="button_blue">

        <br /><br /><br />
        If you wish to change your password, click on the button below:
        <br /><br />
        <input type="button" id="btn_editpwd" value="CHANGE PASSWORD" class="button_blue">

      </div>
      
    </div>

<?php include('page-footer.php'); ?>