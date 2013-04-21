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
      
      $r_fname = sanitizeHtml($r_fname);
      $r_lname = sanitizeHtml($r_lname);
      $r_email = sanitizeHtml($r_email);
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

    // - email validation
    function validateEmail(p_email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if( !emailReg.test( p_email ) ) {
        return false;
      } else {
        return true;
      }
    } 
    
    // event - click on save button
    $('#btn_save').click(function(){
      
      // set vars
      var f_fname = jQuery.trim($("#f_fname").val());
      var f_lname = jQuery.trim($("#f_lname").val());
      var f_email = jQuery.trim($("#f_email").val());
      
      var objContent = $("#content_left");
      
      // initiate block ui
      block(objContent, $("#blockloading"));
      
      // clear error message
      $("#msg").html('');
      
      // validation
      if ((f_fname == '') || (f_lname == '') || (f_email == ''))
      {
        $("#msg").html('Please ensure that all required fields are completed.');
        unblock(objContent);
        
      } else {
        
        if (validateEmail(f_email) != true)
        {
          $("#msg").html('Please enter a valid email address.');
          unblock(objContent);

        } else {
          
          // validation successful
          $.ajax({
            type: "POST",
            url:  "control-profile-updateinfo.php",
            data: ({
              action : 'editprofile', 
              ffname : f_fname,
              flname : f_lname,
              femail : f_email
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
                $("#msg").html(data);

                // unblock ui
                unblock(objContent);

              }
              
            }
          });
          
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
        <span class="text_title_content">EDIT YOUR PROFILE</span>
      </div>
      
      <div id="content">
        
        Please complete the information below:
        <br /><br /><br />
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="25%"><b>Username:</b></td>
            <td><?php echo $r_username; ?></td>
          </tr>
          <tr>
            <td><b>First Name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_fname" size="80" maxlength="250" value="<?php echo $r_fname; ?>"></td>
          </tr>
          <tr>
            <td><b>Last Name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_lname" size="80" maxlength="250" value="<?php echo $r_lname; ?>"></td>
          </tr>
          <tr>
            <td><b>Email Address: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_email" size="80" maxlength="250" value="<?php echo $r_email; ?>"></td>
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
      </div>
      
    </div>

<?php include('page-footer.php'); ?>