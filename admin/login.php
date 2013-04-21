<?php 

// include files
include_once('includes/inc-common.php');


// settings


// instantiate


// fetch parameters


// set default


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  <title><?php echo CLIENTNAME; ?> - Back Office</title>

  <meta name="title" content="">
  <meta name="description" content="">
  
  <meta name="author" content=""> 
  <meta name="copyright" content=""> 
  <meta http-equiv="pragma" content="no-cache"> 
  
  <!--
  <link rel="shortcut icon" href="<?php echo WEBSITEPATH; ?>wp-content/themes/INGiafam-Custom/images/favicon.ico">  
  -->
  
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/global.css" />  
  <link rel="stylesheet" type="text/css" href="css/text.css" />
  <link rel="stylesheet" type="text/css" href="css/layout-login.css" />
    
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function () {

  // functions
  // function - disable inputs
  function disableInput()
  {
    $("#f_username").attr('disabled', 'disabled');
    $("#f_userpwd").attr('disabled', 'disabled');
    $("#btn_login").attr('disabled', 'disabled');
  }

  // function - enable inputs
  function enableInput()
  {
    $("#f_username").removeAttr('disabled');
    $("#f_userpwd").removeAttr('disabled');
    $("#btn_login").removeAttr('disabled');
  }

  // event - click login button
  $("#btn_login").click(function(){

    // initialize
    var fusername = jQuery.trim($("#f_username").val());
    var fuserpwd = jQuery.trim($("#f_userpwd").val());

    // disable inputs
    disableInput();
  
    // clear error message field
    $("#msg").html('<img src="images/loading.gif" /> Logging in. Please wait...');
  
    // validation
    if ((fusername == '') || (fuserpwd == ''))
    {
      // validation failed - missing required fields
      $("#msg").html('<span class="text_error">Please ensure all fields are completed.</span>');
    
      // enable inputs
      enableInput();
    
    } else {
    
      // validation successful
      $.ajax({
        type: "POST",
        url:  "control-login-process.php",
        data: ({ 
          username : fusername,
          userpwd: fuserpwd
        }),        
        cache: false,
        success: function(data){
        
          data = jQuery.trim(data);

          if (data == 'true') {

            // set loading msg
            $("#msg").html('<img src="images/loading.gif" /> Login successful... Redirecting...</div>');

            window.location.href= 'main.php';
          
          } else {
            
            // show message
            $("#msg").html('<span class="text_error">' + data + '</span>');

            // enable inputs
            enableInput();

          }
              
        }
      });
    
    }
  
  });

  });
  </script>
  
</head>
<body>

  <div id="login_wrapper">
    <div id="box">
      <div id="top_holder">
        <span class="text_title_login">BACK OFFICE ADMINISTRATION</span>
      </div>
      <div id="form">
        
        <table width="80%">
          <tr>
            <td width="20%"><b>Username:</b></td>
            <td align="right"><input type="text" id="f_username" size="40" maxlength="20"></td>
          </tr>
          <tr>
            <td><b>Password:</b></td>
            <td align="right"><input type="password" id="f_userpwd" size="40" maxlength="20"></td>
          </tr>
        </table>
      </div>
      <div id="bottom_holder">
        <div id="msg"></div>
        <div id="button_holder">
          <input type="button" class="button_blue" id="btn_login" value="Log In">
        </div>
      </div>
    </div>
  </div>

</body>
</html>