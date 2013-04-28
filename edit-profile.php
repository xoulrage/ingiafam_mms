<?php
// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');

$member = new member();
$common = new common();
$agency = new agency();

$result_agency = $agency->GetAgency();
$result_region = $common->getRegion();
$result_countrystate = $common->getCountryState();
$result = $member->getData($_SESSION['MEMBERID']);

foreach($result as $row){
    $r_id          = $row[0];
    $r_memberCode  = removeSlashesFormat($row[1]);
    $r_agentcode   = removeSlashesFormat($row[2]);
    $r_surname     = removeSlashesFormat($row[7]);
    $r_givenname   = removeSlashesFormat($row[8]);
    $r_nric        = $row[9];
    $r_dateofbirth = $row[10];
    $r_gender      = $row[11];
    $r_Agency      = $row[12];
    $r_Rank        = $row[15];
    $r_Region      = $row[16];
    $r_address1    = removeSlashesFormat($row[18]);
    $r_address2    = removeSlashesFormat($row[19]);
    $r_address3    = removeSlashesFormat($row[20]);
    $r_address4    = removeSlashesFormat($row[21]);
    $r_postcode    = $row[22];
    $r_State       = $row[23];
    $r_phone       = removeSlashesFormat($row[25]);
    $r_extension   = removeSlashesFormat($row[26]);
    $r_fax         = removeSlashesFormat($row[27]);
    $r_mobile      = removeSlashesFormat($row[28]);
    $r_email1      = removeSlashesFormat($row[29]);
    $r_email2      = removeSlashesFormat($row[30]);
    $r_MemberType  = $row[33];
}
$p_ic1 = '';
$p_ic2 = '';
$p_ic3 = '';
$p_icLength = strlen($r_nric);

if ($r_nric != ''){
    $p_ic1 = substr($r_nric, 0, 6);
    $p_ic2 = substr($r_nric, 6, 2);
    $p_ic3 = substr($r_nric, 8, 4);
}

$dob_array = explode("-", $r_dateofbirth);
$r_dob_day = $dob_array[2];
$r_dob_month = $dob_array[1];
$r_dob_year = $dob_array[0];
?>

<?php include('page-header.php'); ?>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
      function UpdateProfile(){
          var msg = $("#err_msg");
          var sel = '--Select--';
          var plsSel = '--Please Select--';

          function ValidateForm(){
              var errList = new Array();

              if (isStringEmpty(agentcode))
                  errList.push('Agent Code is empty.');

              if (isStringEmpty(nric))
                  errList.push('NRIC (New) is empty.');
              else if(nric.length < 12)
                errList.push('Please complete your NRIC (New)');
              else if(!(isNumber(nric)))
                errList.push('NRIC (New) can contain only Numbers.')

              if (isStringEmpty(surname))
                  errList.push('Surname is empty.');

              if (isStringEmpty(givenname))
                  errList.push('Given Name is empty.');

              if (dateofbirthD == sel || dateofbirthD == sel || dateofbirthD == sel)
                  errList.push('Please complete your Date of Birth.');

              if (Region == plsSel)
                  errList.push('Please select your Region.');

              if (Agency == plsSel)
                errList.push('Please select your Agency.');

              if (isStringEmpty(address1) && isStringEmpty(address2) && isStringEmpty(address3) && isStringEmpty(address4))
                errList.push('Please enter your Address.');

              if (State == plsSel)
                errList.push('Please select your State.');

              if (isStringEmpty(postcode))
                  errList.push('Please enter your Postcode.');
              else if (!(isNumber(postcode)))
                  errList.push('Postcode can only contain Numbers.');

              if (isStringEmpty(phone))
                  errList.push('Please enter your Phone.');

              if (isStringEmpty(mobile))
                  errList.push('Please enter your Mobile.');

              if (isStringEmpty(email1))
                  errList.push('Please enter your Email (Primary).');
              else if (!(validateEmail(email1)))
                errList.push('Please enter a valid Email (Primary).');

              if (isStringEmpty(email2))
                  errList.push('Please enter your Email (Secondary).');
              else if (!(validateEmail(email2)))
                  errList.push('Please enter a valid Email (Secondary).');
              else if (email1 == email2)
                  errList.push('Please enter a different Email (Secondary).');

              return errList;
          }

          var agentcode     = jQuery.trim($('#f_agentcode').val());
          var surname       = jQuery.trim($('#f_surname').val());
          var givenname     = jQuery.trim($('#f_givenname').val());
          var nric          = jQuery.trim($('#f_nric1').val()) + jQuery.trim($('#f_nric2').val()) + jQuery.trim($('#f_nric3').val());
          var dateofbirthD  = jQuery.trim($('#ddldobDay').val());
          var dateofbirthM  = jQuery.trim($('#ddldobMonth').val());
          var dateofbirthY  = jQuery.trim($('#ddldobYear').val());
          var gender        = jQuery.trim($('#f_gender').val());
          var Agency        = jQuery.trim($('#f_agency').val());
          var Region        = jQuery.trim($('#f_region').val());
          var address1      = jQuery.trim($('#f_address1').val());
          var address2      = jQuery.trim($('#f_address2').val());
          var address3      = jQuery.trim($('#f_address3').val());
          var address4      = jQuery.trim($('#f_address4').val());
          var postcode      = jQuery.trim($('#f_postcode').val());
          var State         = jQuery.trim($('#f_state').val());
          var phone         = jQuery.trim($('#f_phone').val());
          var extension     = jQuery.trim($('#f_ext').val());
          var fax           = jQuery.trim($('#f_fax').val());
          var mobile        = jQuery.trim($('#f_mobile').val());
          var email1        = jQuery.trim($('#f_email1').val());
          var email2        = jQuery.trim($('#f_email2').val());

          msg.html('<img src="images/loading-small.gif" /> Updating Profile. Please wait...');

          var ErrorMsgList = ValidateForm();

          if (ErrorMsgList.length > 0)
          {
              var errMsg = '';
              ErrorMsgList.forEach(function(entry){
                  errMsg += "&bull; " + entry + "<br />";
              });
              msg.html('<span class="text_red">' + errMsg + '</span>');
              return;
          }

          $.ajax({
              type: "POST",
              url:  "control-edit-profile.php",
              data: ({
                  agentcode    : agentcode,
                  surname      : surname,
                  givenname    : givenname,
                  nric         : nric,
                  dateofbirth  : dateofbirthY + '-' + dateofbirthM + '-' + dateofbirthD,
                  gender       : gender,
                  Agency       : Agency,
                  Region       : Region,
                  address1     : address1,
                  address2     : address2,
                  address3     : address3,
                  address4     : address4,
                  postcode     : postcode,
                  State        : State,
                  phone        : phone,
                  extension    : extension,
                  fax          : fax,
                  mobile       : mobile,
                  email1       : email1,
                  email2       : email2
              }),
              cache: false,
              success: function(data){
                  data = jQuery.trim(data);

                  if (data == 'true')   {
                      msg.html('<img src="images/loading-small.gif" /> Profile updated successfully... Redirecting...');
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

      // event - click on cancel button
      $('#btn_cancel').click(function(){
          window.location.href = 'main.php';
          return false;
      });

      $('#btn_submit').click(function(){
          UpdateProfile();
      });


  });
</script>
<div id="full">
  <div id="content_title">
    <span class="content_title">Edit Profile</span>
  </div>
  <div id="form">
    <div>Note: Fields marked with <span class="text_red">*</span> are compulsory.</div>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="20%">Agent Code: <span class="text_red">*</span></td>
        <td><input type="text" id="f_agentcode" size="8" maxlength="7" value="<?php echo $r_agentcode ?>"></td>
      </tr>
      <tr>
        <td>NRIC (new): <span class="text_red">*</span></td>
        <td><input type="text" id="f_nric1" size="7" maxlength="6" value="<?php echo $p_ic1 ?>">-<input type="text" id="f_nric2" size="3" maxlength="2" value="<?php echo $p_ic2 ?>">-<input type="text" id="f_nric3" size="5" maxlength="4" value="<?php echo $p_ic3 ?>"></td>
      </tr>
      <tr>
        <td>Surname: <span class="text_red">*</span></td>
        <td><input type="text" id="f_surname" size="80" maxlength="200" value="<?php echo $r_surname ?>"></td>
      </tr>
      <tr>
        <td>Given Name: <span class="text_red">*</span></td>
        <td><input type="text" id="f_givenname" size="80" maxlength="200" value="<?php echo $r_givenname ?>"></td>
      </tr>
      <tr>
        <td>Date of Birth: <span class="text_red">*</span></td>
        <td>
            <?php echo $common->showDateOfBirth($r_dob_day, $r_dob_month, $r_dob_year); ?>

          <!--<select id="f_dob_day">

          </select>
          <select id="f_dob_mth">

          </select>
          <select id="f_dob_year">

          </select>-->
          (DD-MM-YYYY)
        </td>
      </tr>
      <tr>
        <td>Gender: <span class="text_red">*</span></td>
        <td>
          <select id="f_gender">
            <option value="M" <?php echo $r_gender == 'M' ? 'selected' : '' ?>>Male</option>
            <option value="F" <?php echo $r_gender == 'F' ? 'selected' : '' ?>>Female</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Region: <span class="text_red">*</span></td>
        <td>
          <select id="f_region">
              <option>--Please Select--</option>
              <?php foreach ($result_region as $key => $val) {
                  $strselected = ($r_Region === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
              <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Agency: <span class="text_red">*</span></td>
        <td>
          <select id="f_agency">
              <option>--Please Select--</option>
              <?php foreach ($result_agency as $key => $val) {
                  $strselected = ($r_Agency === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
              <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td valign="top">Address: <span class="text_red">*</span></td>
        <td valign="top">
          <input type="text" id="f_address1" size="80" maxlength="200" value="<?php echo $r_address1 ?>">
          <input type="text" id="f_address2" size="80" maxlength="200" value="<?php echo $r_address2 ?>">
          <input type="text" id="f_address3" size="80" maxlength="200" value="<?php echo $r_address3 ?>">
          <input type="text" id="f_address4" size="80" maxlength="200" value="<?php echo $r_address4 ?>">
        </td>
      </tr>
      <tr>
        <td>State: <span class="text_red">*</span></td>
        <td>
          <select id="f_state">
              <option>--Please Select--</option>
              <?php foreach ($result_countrystate as $key => $val) {
                  $strselected = ($r_State === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
              <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Postcode: <span class="text_red">*</span></td>
        <td><input type="text" id="f_postcode" size="10" maxlength="5" value="<?php echo $r_postcode ?>"></td>
      </tr>
      <tr>
        <td>Phone: <span class="text_red">*</span></td>
        <td><input type="text" id="f_phone" size="25" maxlength="20" value="<?php echo $r_phone ?>"></td>
      </tr>
      <tr>
        <td>Extension: </td>
        <td><input type="text" id="f_ext" size="25" maxlength="20" value="<?php echo $r_extension ?>"></td>
      </tr>
      <tr>
        <td>Fax: </td>
        <td><input type="text" id="f_fax" size="25" maxlength="20" value="<?php echo $r_fax ?>"></td>
      </tr>
      <tr>
        <td>Mobile: <span class="text_red">*</span></td>
        <td><input type="text" id="f_mobile" size="25" maxlength="20" value="<?php echo $r_mobile ?>"></td>
      </tr>
      <tr>
        <td>Email (Primary): <span class="text_red">*</span></td>
        <td><input type="text" id="f_email1" size="80" maxlength="200" value="<?php echo $r_email1 ?>"></td>
      </tr>
      <tr>
        <td>Email (Secondary): <span class="text_red">*</span></td>
        <td><input type="text" id="f_email2" size="80" maxlength="200" value="<?php echo $r_email2 ?>""></td>
      </tr>
    </table>
    <br />
    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td width="20%" valign="top">
          <input type="button" id="btn_submit" value="Submit" class="button_blue">
          &nbsp;
          <input type="button" id="btn_cancel" value="Cancel" class="button_orange">
        </td>
        <td valign="middle"><div id="err_msg"></div></td>
      </tr>
    </table>
  </div>
</div>
<div class="reset"></div>
<?php include('page-footer.php'); ?>