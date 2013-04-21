<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_available = false;
$check_all = false;


// instantiate
$common = new common();
$user = new user();


// fetch parameters
$p_user_id = sanitizeInt(trim($_REQUEST['rid']));
$p_page = sanitizeInt(trim($_REQUEST['pg']));


// set default
if (!($p_page))
{
  $p_page = 1;
}


// get room details
// ****************
if ($p_user_id)
{
  $result = $user->getData($p_user_id);
  
  if (count($result) > 0)
  {
    $is_available = true;
    
    foreach($result as $row)
    {
      $r_usertype = $row[0];
      $r_username = $row[1];
      $r_fname = sanitizeHtml(trim($row[4]));
      $r_lname = sanitizeHtml(trim($row[5]));
      $r_email = sanitizeHtml(trim($row[6]));
      $r_lastlogin = $row[7];
      $r_publish = $row[8];
      
      // format
      $r_fname = removeSlashesFormat($r_fname);
      $r_lname = removeSlashesFormat($r_lname);
      
      if (!($r_lastlogin))
      {
        $r_lastlogin = '- No login activity yet -';
      }
    }
    
    // set to check and disable all user access rights checkboxes if user is of type admin
    if ($r_usertype == 2)
    {
      $check_all = true;  
    }
    
  }
}


// get user access modules
// ***********************
if ($is_available)
{
  // - get all user access modules
  $result_module = $user->getAllAccessRights();

  if (is_array($result_module))
  {
    if (count($result_module) > 0)
    {
      foreach($result_module as $row_module)
      {
        $rm_id = $row_module[0];
        $rm_name = $row_module[1];
      
        $module_ids .= $rm_id . '|';
      
        $rm_id = '';
        $rm_name = '';
      }
    
      $module_ids = trim($module_ids, '|');
    }
    reset($result_module);
  }
  
  // - get assigned user access rights
  $arr_access_rights = $user->getAccessRights($p_user_id, $r_usertype);
}


// set select options
// ******************
$options_user_type = $common->getUserTypeOptions($r_usertype);
$options_publish = $common->getActiveLockedOptions($r_publish);


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

    // function - email validation
    function validateEmail(email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if( !emailReg.test( email ) ) {
        return false;
      } else {
        return true;
      }
    }  

    // function - check for blank spaces in string
    function hasBlankSpaces(string) {
      return /\s/g.test(string);
    }

    <?php if ($is_available == true) { ?>

    // initialize
    // **********
    <?php if ($check_all == true) { ?>
    // check all checkboxes for access modules
    $("input[id^=f_module_]").attr('checked', 'checked');
    
    // disable all checkboxes for access modules
    $("input[id^=f_module_]").attr('disabled', 'disabled');    
    <?php } ?>
    // **********    

    // event - user type select option change
    $('#f_usertype').change(function(){
      
      var selected = $(this).val();
      
      if (selected == 2)
      {
        // check all checkboxes for access modules
        $("input[id^=f_module_]").attr('checked', 'checked');
        
        // disable all checkboxes for access modules
        $("input[id^=f_module_]").attr('disabled', 'disabled');
        
      } else {
        
        // enable all checkboxes for access modules
        $("input[id^=f_module_]").removeAttr('disabled');        
        
      }
      
    });

    // event - click on save button
    $('#btn_save').click(function(){
      
      // set vars
      var f_usertype = jQuery.trim($("#f_usertype").val());
      var f_username = jQuery.trim($("#f_username").val());
      var f_fname = jQuery.trim($("#f_firstname").val());
      var f_lname = jQuery.trim($("#f_lastname").val());
      var f_email = jQuery.trim($("#f_email").val());
      var f_module_ids = '<?php echo $module_ids; ?>';
      var f_module_checked = '';
      var f_publish = jQuery.trim($("#f_publish").val());
      
      var objContent = $("#content_left");

      var iserror = false;

      // initiate block ui
      block(objContent, $("#blockloading"));
      
      // clear error message
      $("#msg").html('');
 
      // get checked fields
      $('input[id^=f_module_]').each(function () {
        if (this.checked) {
          f_module_checked += $(this).val() + '|';
        }
      });

      // remove last character
      f_module_checked = f_module_checked.substr(0, f_module_checked.length-1);

      
      // validation - check required fields
      if ((f_usertype == '') || (f_username == '') || (f_fname == '') || (f_lname == '') || (f_email == ''))
      {
        iserror = true;
        
        $("#msg").html('Please ensure that all required fields are completed.');
        unblock(objContent);
        
      } 
      
      // validation - check minimum length of username
      if (iserror != true)
      {
        if (f_username.length < 6) 
        {
          iserror = true;
        
          $("#msg").html('Please ensure that the username is of a minimum of 6 characters in length.');
          unblock(objContent);
        }
      }
      
      // validation - check for blank spaces in username
      if (iserror != true)
      {
        if (hasBlankSpaces(f_username))
        {
          iserror = true;
        
          $("#msg").html('Please ensure that the the username has no blank spaces within.');
          unblock(objContent);
        } 
      }
      
      // validation - email
      if (iserror != true)
      {
        if (validateEmail(f_email) != true) 
        {
          iserror = true;
        
          $("#msg").html('Please enter a valid email address.');
          unblock(objContent);    
        }
      } 
      
      if (iserror != true) {      
      
        // validation successful
        $.ajax({
          type: "POST",
          url:  "control-user-edit.php",
          data: ({
            action : 'edituser', 
            rid : '<?php echo $p_user_id; ?>',               
            fusertype: f_usertype,
            fusername: f_username,
            ffname: f_fname,
            flname: f_lname,
            femail: f_email,
            fmoduleids: f_module_ids,
            fmodulechecked: f_module_checked,
            fpublish : f_publish
          }),        
          cache: false,
          success: function(data){
        
            data = jQuery.trim(data);

            if (data == 'true') {

              // initiate block ui
              block(objContent, $("#blocksuccess"));

              // delay redirect by 1 second
              setTimeout(function() {
                window.location.href= 'user.php?pg=<?php $p_page; ?>';
              }, 1000);
                  
            } else {
            
              // show message
              $("#msg").html(data);

              // unblock ui
              unblock(objContent);

            }
              
          }
        });
        
      }
      
    });

    <?php } ?>

    // event - click on cancel button
    $('#btn_cancel').click(function(){
      
      // initiate block ui
      block($("#content_left"), $("#blockcancel"));
      
      window.location.href = 'user.php?pg=<?php echo $p_page; ?>';
      return false;
      
    });  
    
  });
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">USER MANAGER - EDIT</span>
      </div>
      
      <div id="content">

<?php if ($is_available == true) { ?>

        Please complete the information below:
        <br /><br /><br />

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="25%"><b>Last Logged In On: </b></td>
            <td><?php echo $r_lastlogin; ?></td>
          </tr>
          <tr>
            <td width="25%"><b>User Type: <span class="text_red">*</span></b></td>
            <td>
              <select id="f_usertype">
                <?php echo $options_user_type; ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><b>Account Status: <span class="text_red">*</span></b></td>
            <td>
              <select id="f_publish">
                <?php echo $options_publish; ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="25%"><b>Username: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_username" size="50" maxlength="20" value="<?php echo $r_username; ?>"></td>
          </tr>
          <tr>
            <td><b>First Name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_firstname" size="80" maxlength="250" value="<?php echo $r_fname; ?>"></td>
          </tr>          
          <tr>
            <td><b>Last Name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_lastname" size="80" maxlength="250" value="<?php echo $r_lname; ?>"></td>
          </tr>
          <tr>
            <td><b>Email: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_email" size="80" maxlength="200" value="<?php echo $r_email; ?>"></td>
          </tr>          
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">
              <span class="text_title_content_small">USER ACCESS SETTINGS</span>
              <hr />
            </td>
          </tr>
          <tr>
            <td colspan="2">Note: Check to allow access.</td>
          </tr>

<?php 
if ((is_array($result_module)) && (count($result_module) > 0))
{
  foreach($result_module as $row_module)
  {
    $rm_id = $row_module[0];
    $rm_name = $row_module[1];

    if ($arr_access_rights[$rm_id])
    {
      $checked = 'checked';
    }

    // output
    echo '<tr class="grey">' . "\n";
    echo '<td>' . $rm_name . '</td>' . "\n";
    echo '<td><input type="checkbox" name="f_module_' . $rm_id . '" id="f_module_' . $rm_id . '" value="' . $rm_id . '" ' . $checked . '></td>' . "\n";
    echo '</tr>' . "\n";
    
    // clear
    $rm_id = '';
    $rm_name = '';
    $checked = '';
  }
}
?>
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

<?php } ?>

<?php if ($is_available != true) { ?>

        <span class="text_red">Record not found.</span>
        <br /><br /><br />

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td>
              <input type="button" id="btn_cancel" value="CANCEL" class="button_orange">             
            </td>
          </tr>
        </table>
  
<?php } ?>

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

<?php if ($is_available == true) { ?>
      
      <div id="content">
        <span class="text_red">*</span> Required field
        
        <br /><br /><br /><br /><br />
        
      </div>

<?php } ?> 
      
    </div>          

<?php include('page-footer.php'); ?>