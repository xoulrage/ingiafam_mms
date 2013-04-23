<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_available = false;
$check_all = false;


// instantiate
//$common = new common();
$member = new member();

// fetch parameters
$p_member_id = sanitizeInt(trim($_REQUEST['rid']));
$p_page = sanitizeInt(trim($_REQUEST['pg']));


// set default
if (!($p_page))
{
  $p_page = 1;
}

// get room details
// ****************
if ($p_member_id)
{
  $result = $member->getData($p_member_id);
  
  if (count($result) > 0)
  {
    $is_available = true;
    
    foreach($result as $row)
    {
      $r_nametitleid = $row[0];
      $r_surname = $row[1];
      $r_givenname = $row[2];
      $r_nric = $row[3];
      $r_dateofbirth = $row[4];
      $r_gender = $row[5];
      $r_unitcode = $row[6];
      $r_address1 = $row[7];
      $r_address2 = $row[8];
      $r_address3 = $row[9];
      $r_address4 = $row[10];
      $r_postcode = $row[11];
      $r_countrystateid = $row[12];
      $r_phone = $row[13];
      $r_extension = $row[14];
      $r_fax = $row[15];
      $r_mobile = $row[16];
      $r_email1 = $row[17];
      $r_email2 = $row[18];
      $r_isagreedtoobitcontrib = $row[19];
      
      // format
      $r_surname = removeSlashesFormat($r_surname);
      $r_givenname = removeSlashesFormat($r_givenname);
    }
  }
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
            rid : '<?php echo $p_member_id; ?>',               
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
        <span class="text_title_content">MEMBER - EDIT</span>
      </div>
      
      <div id="content">

<?php if ($is_available == true) { ?>

        Please complete the information below:
        <br /><br /><br />

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="25%"><b>Title: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_nametitleid" size="50" maxlength="20" value="<?php echo $r_nametitleid; ?>"></td>
          </tr>
          <tr>
            <td width="25%"><b>Surname: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_surname" size="50" maxlength="20" value="<?php echo $r_surname; ?>"></td>
          </tr>
          <tr>
            <td><b>Given name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_givenname" size="80" maxlength="250" value="<?php echo $r_givenname; ?>"></td>
          </tr>          
          <tr>
            <td><b>NRIC: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_nric" size="80" maxlength="250" value="<?php echo $r_nric; ?>"></td>
          </tr>
          <tr>
            <td><b>Date of Birth: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_dateofbirth" size="80" maxlength="250" value="<?php echo $r_dateofbirth; ?>"></td>
          </tr>
          <tr>
            <td><b>Gender: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_gender" size="80" maxlength="250" value="<?php echo $r_gender; ?>"></td>
          </tr>
          <tr>
            <td><b>Unit Code: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_unitcode" size="80" maxlength="250" value="<?php echo $r_unitcode; ?>"></td>
          </tr>
          <tr>
            <td width="25%"><b>Address 1: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_address1" size="50" maxlength="20" value="<?php echo $r_address1; ?>"></td>
          </tr>
          <tr>
            <td><b>Address 2: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_address2" size="80" maxlength="250" value="<?php echo $r_address2; ?>"></td>
          </tr>          
          <tr>
            <td><b>Address 3: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_address3" size="80" maxlength="250" value="<?php echo $r_address3; ?>"></td>
          </tr>
          <tr>
            <td><b>Address 4: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_address4" size="80" maxlength="250" value="<?php echo $r_address4; ?>"></td>
          </tr>
          <tr>
            <td><b>Post Code: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_postcode" size="80" maxlength="250" value="<?php echo $r_postcode; ?>"></td>
          </tr>
          <tr>
            <td><b>Country State ID: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_countrystateid" size="80" maxlength="250" value="<?php echo $r_countrystateid; ?>"></td>
          </tr>
          <tr>
            <td width="25%"><b>Phone: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_phone" size="50" maxlength="20" value="<?php echo $r_phone; ?>"></td>
          </tr>
          <tr>
            <td><b>Extension: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_extension" size="80" maxlength="250" value="<?php echo $r_extension; ?>"></td>
          </tr>          
          <tr>
            <td><b>Fax: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_fax" size="80" maxlength="250" value="<?php echo $r_fax; ?>"></td>
          </tr>
          <tr>
            <td><b>Mobile: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_mobile" size="80" maxlength="250" value="<?php echo $r_mobile; ?>"></td>
          </tr>
          <tr>
            <td><b>Primary Email: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_email1" size="80" maxlength="250" value="<?php echo $r_email1; ?>"></td>
          </tr>
          <tr>
            <td><b>Alternate Email: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_email2" size="80" maxlength="250" value="<?php echo $r_email2; ?>"></td>
          </tr>
          <tr>
            <td width="25%"><b>isagreedtoobitcontrib: <span class="text_red">*</span></b></td>
            <td>
              <input type="checkbox" id="f_module_1" name="f_module_1" <?php echo $r_isagreedtoobitcontrib == 0 ? '' : 'checked="checked"' ?>>
            </td>
          </tr>
          <tr>
            <td><b>Change Password: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_password" size="80" maxlength="250" value="<?php echo $r_password; ?>"></td>
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