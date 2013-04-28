<?php
// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checkfirstlogin.php');
?>

<?php include('page-header.php'); ?>

<script type="text/javascript">
  $(document).ready(function () {

      // event - click on register button
      $('#btn_register').click(function(){

          window.location.href = 'http://www.ingiafam.org.my/join-page/';
          return false;

      });

      /**
       * @return {boolean}
       */
      function CheckAlphaNumeric(pwd){
          var regExpr = new RegExp("[a-z/_/$]{1}","i");
          if(!regExpr.test(pwd))
              return false;

          regExpr = new RegExp("[0-9]{1}","i");
          return regExpr.test(pwd);
      }

      $('#btn_submit').click(function(){
          var msg = $("#err_msg");
          var alphaNumericPattern =  "^[a-z0-9/_/$]{8,12}";
          var regExpr = new RegExp(alphaNumericPattern,"i");

          var password = jQuery.trim($('#f_pwd').val());
          var password1 =  jQuery.trim($('#f_pwdconfirm').val());

          msg.html('<img src="images/loading-small.gif" /> Changing Password. Please wait...');

          if ((password == '') || (password1 == '')) {
              msg.html('<span class="text_red">Please ensure that all required fields are completed.</span>');
              return;
          }

          if (password.length < 8 || password1.length < 8) {
              msg.html('<span class="text_red">Please ensure that the password are at least 8 characters in length.</span>');
              return;
          }

          if (password != password1) {
              msg.html('<span class="text_red">Your passwords do not match.</span>');
              return;
          }

          if (!regExpr.test(password)) {
              msg.html('<span class="text_red">Your password must contain only alphabets and numbers.</span>');
              return;
          }

          if (!CheckAlphaNumeric(password)) {
              msg.html('<span class="text_red">Your password must contain both alphabets and numbers.</span>');
              return;
          }

          //return;

          $.ajax({
              type: "POST",
              url:  "control-first-time-login-process.php",
              data: ({
                  password : password
              }),
              cache: false,
              success: function(data){
                  data = jQuery.trim(data);

                  if (data == 'true')   {
                      msg.html('<img src="images/loading-small.gif" /> Password updated successfully... Redirecting...');
                      window.location.href = 'main.php';
                  }
                  else
                      msg.html('<span class="text_red">' + data + '</span>');
              }
          });

      });

  });
</script>

<div id="full">
  <div id="content_title">
    <span class="content_title">First-Time Login</span>
  </div>
  <div id="form">
    <div>Your account set-up for the first-time login is almost complete. Please enter a password of your choice below. Note: It has to contain both alphabets and numbers and between 8 - 12 characters in length.</div>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="30%">Password:</td>
        <td><input type="password" id="f_pwd" size="25" maxlength="12"></td>
      </tr>
      <tr>
        <td>Please re-enter the password again:</td>
        <td><input type="password" id="f_pwdconfirm" size="25" maxlength="12"></td>
      </tr>
    </table>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="10%" valign="top"><input type="button" id="btn_submit" value="Submit" class="button_blue"></td>
        <td valign="middle"><div id="err_msg"></div></td>
      </tr>
    </table>
  </div>
</div>
<div class="reset"></div>

<?php include('page-footer.php'); ?>