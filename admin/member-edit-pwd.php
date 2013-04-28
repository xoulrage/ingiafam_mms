<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_available = false;
$check_all = false;


// instantiate
$common = new common();
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
      $r_membername = $row[1] . ' ' . $row[2];
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

    // function - check for blank spaces in string
    function hasBlankSpaces(string) {
      return /\s/g.test(string);
    }

    <?php if ($is_available == true) { ?>

    // initialize
    // **********

    // **********    

    // event - click on save button
    $('#btn_save').click(function(){
      
      // set vars
      var f_pwd = jQuery.trim($("#f_pwd").val());
      var f_confirmpwd = jQuery.trim($("#f_confirmpwd").val());
      
      var objContent = $("#content_left");

      var iserror = false;

      // initiate block ui
      block(objContent, $("#blockloading"));
      
      // clear error message
      $("#msg").html('');
       
      // validation - check required fields
      if ((f_pwd == '') || (f_confirmpwd == ''))
      {
        iserror = true;
        
        $("#msg").html('Please ensure that all required fields are completed.');
        unblock(objContent);
        
      } 
      
      // validation - check minimum length of password
      if (iserror != true)
      {
        if ((f_pwd.length < 6) || (f_confirmpwd.length < 6)) 
        {
          iserror = true;
        
          $("#msg").html('Please ensure that the passwords are of a minimum of 6 characters in length.');
          unblock(objContent);
        }
      }
      
      // validation - check for blank spaces in passwords
      if (iserror != true)
      {
        if ((hasBlankSpaces(f_pwd)) || (hasBlankSpaces(f_confirmpwd)))
        {
          iserror = true;
        
          $("#msg").html('Please ensure that the passwords have no blank spaces within.');
          unblock(objContent);
        } 
      }      
      
      // validation - check password confirmation
      if (iserror != true)
      {
        if (f_pwd != f_confirmpwd) 
        {
          iserror = true;
        
          $("#msg").html('The passwords do not match. Please re-confirm again.');
          unblock(objContent);    
        }
      }
      
      if (iserror != true) {      
      
        // validation successful
        $.ajax({
          type: "POST",
          url:  "control-member-edit-pwd.php",
          data: ({
            action : 'editmemberpwd', 
            rid : '<?php echo $p_member_id; ?>',               
            fpwd: f_pwd
          }),        
          cache: false,
          success: function(data){
        
            data = jQuery.trim(data);

            if (data == 'true') {

              // initiate block ui
              block(objContent, $("#blocksuccess"));

              // delay redirect by 1 second
              setTimeout(function() {
                window.location.href= 'member.php?pg=<?php $p_page; ?>';
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
      
      window.location.href = 'member.php?pg=<?php echo $p_page; ?>';
      return false;
      
    });  
    
  });
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">MEMBERS - EDIT PASSWORD</span>
      </div>
      
      <div id="content">

<?php if ($is_available == true) { ?>

        Please complete the information below:
        <br /><br /><br />

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="25%"><b>Member Name: </b></td>
            <td><?php echo $r_membername; ?></td>
          </tr>
          <tr>
            <td valign="top"><b>Password: <span class="text_red">*</span></b></td>
            <td valign="top"><input type="password" id="f_pwd" size="50" maxlength="20"></td>
          </tr>
          <tr>
            <td valign="top"><b>Please Re-Enter The Password: <span class="text_red">*</span></b></td>
            <td valign="top"><input type="password" id="f_confirmpwd" size="50" maxlength="20"></td>
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