<?php include('page-header.php'); ?>

<script type="text/javascript">
  $(document).ready(function () {
      function PerformFirstTimeLogin(){
          var msg = $('#err_msg1');
          var agentCode = jQuery.trim($('#f_agentcode1').val());
          var nric = jQuery.trim($('#f_nric1').val()) + jQuery.trim($('#f_nric2').val()) + jQuery.trim($('#f_nric3').val());

          msg.html('<img src="images/loading-small.gif" /> Logging in. Please wait...');

          if (agentCode == '' || nric == ''){
              msg.html('<span class="text_red">Please ensure that all required fields are completed.</span>');
              return;
          }

          $.ajax({
              type: "POST",
              url:  "control-login-process-first.php",
              data: ({
                  agentCode : agentCode,
                  nric: nric
              }),
              cache: false,
              success: function(data){
                  data = jQuery.trim(data);

                  if (data == 'true')   {
                      msg.html('<img src="images/loading-small.gif" /> Member Found... Redirecting...');
                      window.location.href = 'first-time-login.php';
                  }
                  else
                      msg.html('<span class="text_red">' + data + '</span>');
              }
          });
      }

      function PerformLogin(){
          var msg = $("#err_msg");
          var agentCode = jQuery.trim($('#f_agentcode').val());
          var password  =  jQuery.trim($('#f_pwd').val());

          msg.html('<img src="images/loading-small.gif" /> Logging in. Please wait...');

          if (agentCode == '' || password == '')   {
              msg.html('<span class="text_red">Please ensure that all required fields are completed.</span>');
              return;
          }

          $.ajax({
              type: "POST",
              url:  "control-login-process.php",
              data: ({
                  agentCode : agentCode,
                  password: password
              }),
              cache: false,
              success: function(data){
                  data = jQuery.trim(data);

                  if (data == 'true')   {
                      msg.html('<img src="images/loading-small.gif" /> Login Successful... Redirecting...');
                      window.location.href = 'main.php';
                  }
                  else
                      msg.html('<span class="text_red">' + data + '</span>');
              }
          });
      }


      // event - click on register button
      $('#btn_register').click(function(){
          window.location.href = 'http://www.ingiafam.org.my/join-page/';
          return false;
      });

      $('#btn_submit').click(function(){
          PerformFirstTimeLogin();
      });

      $('#btn_login').click(function(){
          PerformLogin();
      });

  });
</script>

<div id="left">
  <div id="content_title">
    <span class="content_title">Member Login</span>
  </div>
  <div id="form">
    <div>Are you a returning active member? If yes, please key in your Agent Code and Password.</div>
    <br />
    <div id="err_msg"></div>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="30%">Agent Code:</td>
        <td><input type="text" id="f_agentcode" size="25" maxlength="7"></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" id="f_pwd" size="25" maxlength="12"></td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="button" id="btn_login" value="Login" class="button_blue">
        </td>
      </tr>
    </table>
  </div>
</div>

<div id="right">
  <div id="content_title">
    <span class="content_title">First-Time Login</span>
  </div>
  <div id="form">
    <div>Logging in for the first time? Please key in your Agent Code and new NRIC number.</div>
    <br />
    <div id="err_msg1"></div>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="30%">Agent Code:</td>
        <td><input type="text" id="f_agentcode1" size="25" maxlength="7"></td>
      </tr>
      <tr>
        <td>NRIC (New):</td>
        <td><input type="text" id="f_nric1" size="7" maxlength="6">-<input type="text" id="f_nric2" size="3" maxlength="2">-<input type="text" id="f_nric3" size="5" maxlength="4"></td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="button" id="btn_submit" value="Submit" class="button_blue">
        </td>
      </tr>
    </table>
  </div>
</div>
<div class="reset"></div>

<div id="full">
  <div id="content_title">
    <span class="content_title">Not a member yet?</span>
  </div>
  <div id="content">
    Register today as a member and enjoy members-only news &amp; updates, online registration of courses / seminars, purchase of premium items and many more. Click on the link below to register.
    <br /><br />
    <input type="button" id="btn_register" value="Click to Register" class="button_blue">
  </div>
</div>
<div class="reset"></div>

<?php include('page-footer.php'); ?>

            
