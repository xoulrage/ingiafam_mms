<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_user_available = false;


// instantiate


// fetch parameters


// set default


?>

<?php include('page-header.php'); ?>

  <script type="text/javascript">
  $(document).ready(function () {
    
    // function - block ui
    function block(obj, text)
    {
      obj.block({
        message: text,
        css: {
          padding: '10px',
          width: '50%',
          top: '20%',
          border: '2px #2E64FE solid',
          backgroundColor: '#fff', 
          '-webkit-border-radius': '5px', 
          '-moz-border-radius': '5px'
        }        
      });
    }
    
    // function - unblock ui
    function unblock(obj)
    {
      obj.unblock();      
    }
    
    // event - click on save button
    $('#btn_save').click(function(){

      // set vars
      var f_pwd = jQuery.trim($("#f_pwd").val());
      var f_newpwd = jQuery.trim($("#f_newpwd").val());
      var f_confirmpwd = jQuery.trim($("#f_confirmpwd").val());
      
      var objContent = $("#content_left");
      
      // initiate block ui
      block(objContent, $("#blockloading"));
      
      // clear error message
      $("#msg").html('');
      
      // validation
      if ((f_pwd == '') || (f_newpwd == '') || (f_confirmpwd == ''))
      {
        $("#msg").html('Please ensure that all required fields are completed.');
        unblock(objContent); 

      } else {
        
        if ((f_pwd.length < 6) || (f_newpwd < 6) || (f_confirmpwd < 6))
        {
          $("#msg").html('Please ensure that the password are at least 6 characters in length.');
          unblock(objContent); 
          
        } else {
          
          if (f_newpwd != f_confirmpwd)
          {
            $("#msg").html('Your new passwords do not match. Please re-confirm again.');
            unblock(objContent); 
            
          } else {
            
            // validation successful
            $.ajax({
              type: "POST",
              url:  "control-profile-updatepwd.php",
              data: ({
                action : 'editpwd', 
                fpwd : f_pwd,
                fnewpwd : f_newpwd
              }),        
              cache: false,
              success: function(data){
        
                data = jQuery.trim(data);

                if (data == 'true') {

                  // initiate block ui
                  block(objContent, $("#blocksuccess"));

                  // delay redirect by 1.5 seconds
                  setTimeout(function() {
                    window.location.href= 'profile.php';
                  }, 1500);
          
                } else {
                  
                  // show message
                  if (data == 'invalid_pwd') {
                    $("#msg").html('Your current password entered is invalid. Please try again.');
                  
                  } else {
                    $("#msg").html(data); 
                  
                  }
                  
                  // unblock ui
                  unblock(objContent);

                }
              
              }
            });
            
          }
          
        }
        
      }
      
    });

    // event - click on cance button
    $('#btn_cancel').click(function(){
      
      // initiate block ui
      block($("#content_left"), $("#blockcancel"));
      
      window.location.href = 'profile.php';
      return false;
      
    });
    
  });  
  </script>

    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">EDIT YOUR PASSWORD</span>
      </div>
      
      <div id="content">

        Please complete the information below:
        <br /><br /><br />
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="25%"><b>Your current password: <span class="text_red">*</span></b></td>
            <td><input type="password" id="f_pwd" size="50" maxlength="12"></td>
          </tr>
          <tr>
            <td><b>Your new password: <span class="text_red">*</span></b></td>
            <td><input type="password" id="f_newpwd" size="50" maxlength="12"></td>
          </tr>
          <tr>
            <td><b>Confirm your new password: <span class="text_red">*</span></b></td>
            <td><input type="password" id="f_confirmpwd" size="50" maxlength="12"></td>
          </tr>       
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input type="button" id="btn_save" value="SAVE" class="button_blue">
              &nbsp;&nbsp;
              <input type="button" id="btn_cancel" value="CANCEL" class="button_orange">             
            </td>
            <td>
              <div id="msg" class="text_error"></div>
            </td>
          </tr>
        </table>

        <div id="blockloading" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            PROCESSING... PLEASE WAIT...
          </div>
        </div>

        <div id="blocksuccess" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            CHANGES SAVED...<br />
            REDIRECTING... PLEASE WAIT...
          </div>
        </div>

        <div id="blockcancel" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            REDIRECTING... PLEASE WAIT...
          </div>
        </div>

      </div>
      
    </div>
    <div id="content_right">
      <div id="content_title_small">
        <span class="text_title_content_small">INSTRUCTIONS</span>
      </div>
      
      <div id="content">
        <span class="text_red">*</span> Required field
        <br /><br />
        Please enter your current password and confirm your new password. Your new password must be at least 6 characters in length.
      </div>
      
    </div>

<?php include('page-footer.php'); ?>