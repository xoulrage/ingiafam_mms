<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$is_available = false;


// instantiate
$common = new common();
$settings = new settings();


// fetch parameters


// set default


// get settings details
// ********************
$result = $settings->getList();
  
if (count($result) > 0)
{
  $is_available = true;

  $arr_vars = array(
    'MERCHANT_NAME' => 'merchantname',
    'MERCHANT_EMAIL' => 'merchantemail',
    'TAX_GOVT' => 'taxgovt',
    'TAX_SERVICE' => 'taxservice'
  );

  $arr_vars_type = array(
    'MERCHANT_NAME' => 's',
    'MERCHANT_EMAIL' => 's',
    'TAX_GOVT' => 'p',
    'TAX_SERVICE' => 'p'
  );
  
  foreach($result as $row)
  {
    $r_item = trim($row[0]);
    $r_value = trim($row[1]);

    if ($arr_vars[$r_item])
    {
      if ($arr_vars_type[$r_item] == 'p')
      {
        ${$arr_vars[$r_item]} = number_format(($r_value * 100), 2);
                
      } else {
        ${$arr_vars[$r_item]} = $r_value;
        
      }
      
    }

    // clear
    $r_item = '';
    $r_value = '';    
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

    // function - allow only numbers to be keyed in
    function allowNumbersOnly(event)
    {
      if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
      } else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
            event.preventDefault();
          }
        } else {
          if (event.keyCode < 96 || event.keyCode > 105) {
            event.preventDefault();
          }
        }
      }
    }    

    // function - allow only decimal numbers to be keyed in
    function allowDecimalNumbersOnly(event)
    {
      if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 110 || event.keyCode == 190) {
      } else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
            event.preventDefault();
          }
        } else {
          if (event.keyCode < 96 || event.keyCode > 105) {
            event.preventDefault();
          }
        }
      }
    }  

    // function - email validation
    function validateEmail(p_email) 
    {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if( !emailReg.test( p_email ) ) {
        return false;
      } else {
        return true;
      }
    } 

    <?php if ($is_available == true) { ?>

    // event - allow only decimal numbers to be keyed in for govt tax
    $("#f_taxgovt").keydown(function(event) {
    
      allowDecimalNumbersOnly(event);
    
    });

    // event - allow only decimal numbers to be keyed in for service tax
    $("#f_taxservice").keydown(function(event) {
    
      allowDecimalNumbersOnly(event);
    
    });

    // event - click on save button
    $('#btn_save').click(function(){
      
      // set vars
      var f_merchantname = jQuery.trim($("#f_merchantname").val());
      var f_merchantemail = jQuery.trim($("#f_merchantemail").val());
      var f_taxgovt = jQuery.trim($("#f_taxgovt").val());
      var f_taxservice = jQuery.trim($("#f_taxservice").val());
      
      var objContent = $("#content_left");
      
      // initiate block ui
      block(objContent, $("#blockloading"));
      
      // clear error message
      $("#msg").html('');
      
      // validation
      if ((f_merchantname == '') || (f_merchantemail == '') || (f_taxgovt == '') || (f_taxservice == ''))
      {
        $("#msg").html('Please ensure that all required fields are completed.');
        unblock(objContent);
        
      } else {
      
        if (!(validateEmail(f_merchantemail)))
        {
          $("#msg").html('Please enter valid email address for the email fields.');
          unblock(objContent);
          
        } else {
      
          // validation successful
          $.ajax({
            type: "POST",
            url:  "control-settings-edit.php",
            data: ({
              action : 'editsettings', 
              fmerchantname : f_merchantname,
              fmerchantemail : f_merchantemail,
              ftaxgovt : f_taxgovt,
              ftaxservice : f_taxservice
            }),        
            cache: false,
            success: function(data){
        
              data = jQuery.trim(data);

              if (data == 'true') {

                // initiate block ui
                block(objContent, $("#blocksuccess"));

                // delay redirect by 1 second
                setTimeout(function() {
                  window.location.href= 'settings.php';
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
        
      }
      
    });

    <?php } ?>

    // event - click on cance button
    $('#btn_cancel').click(function(){
      
      // initiate block ui
      block($("#content_left"), $("#blockcancel"));
      
      window.location.href = 'settings.php';
      return false;
      
    });  
    
  });
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">GENERAL SETTINGS - EDIT</span>
      </div>
      
      <div id="content">

<?php if ($is_available == true) { ?>

        Please complete the information below:
        <br /><br /><br />

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_general">
          <tr>
            <td width="30%"><b>Merchant Name: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_merchantname" size="80" maxlength="500" value="<?php echo $merchantname; ?>"></td>
          </tr>
          <tr>
            <td><b>Merchant Email: <span class="text_red">*</span></b></td>
            <td><input type="text" id="f_merchantemail" size="80" maxlength="500" value="<?php echo $merchantemail; ?>"></td>
          </tr>
          <tr>
            <td><b>Government Tax: <span class="text_red">*</span> </b></td>
            <td><input type="text" id="f_taxgovt" size="6" maxlength="5" value="<?php echo $taxgovt; ?>">%</td>
          </tr>
          <tr>
            <td><b>Service Tax: <span class="text_red">*</span> </b></td>
            <td><input type="text" id="f_taxservice" size="6" maxlength="5" value="<?php echo $taxservice; ?>">%</td>
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
       
      </div>

<?php } ?> 
      
    </div>          

<?php include('page-footer.php'); ?>