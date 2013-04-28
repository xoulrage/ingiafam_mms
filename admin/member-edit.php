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
if (!($p_page)) {
  $p_page = 1;
}

// get room details
// ****************
if ($p_member_id) {
  $result = $member->getData($p_member_id);

  if (count($result) > 0) {
    $result_agency = $member->getAgency();
    $result_rank = $member->getRank();
    $result_region = $member->getRegion();
    $result_memberstatus = $member->getMemberStatus();
    $result_membertype = $member->getMemberType();
    $result_membertypestatus = $member->getMemberTypeStatus();
    
    $result_title = $common->getSalutationTitle();
    $result_countrystate = $common->getCountryState();
    
    $is_available = true;

    foreach ($result as $row) {
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
      $r_fkrankid = $row[20];      
      $r_membercode = $row[21];
      $r_agentcode = $row[22];
      $r_fkagencyid = $row[23];
      $r_fkregionid = $row[24];
      $r_fkmemberstatusid = $row[25];
      $r_fkmembertypeid = $row[26];
      $r_fkmembertypestatusid = $row[27];
      $r_dateenrolled = $row[28];
      $r_dateapproved = $row[29];
      $r_datenextrenewal = $row[30];
      $r_dateconverted = $row[31];
      $r_dateterminated = $row[32];
      $r_datelastadminedit = $row[33];
      $r_notes = $row[34];

      $dob_array = explode("-", $r_dateofbirth);
      $r_dob_day = $dob_array[2];
      $r_dob_month = $dob_array[1];
      $r_dob_year = $dob_array[0];
      
      $dateenrolled_array = explode("-", $r_dateenrolled);
      $r_dateenrolled_day = $dateenrolled_array[2];
      $r_dateenrolled_month = $dateenrolled_array[1];
      $r_dateenrolled_year = $dateenrolled_array[0];
      
      $dateapproved_array = explode("-", $r_dateapproved);
      $r_dateapproved_day = $dateapproved_array[2];
      $r_dateapproved_month = $dateapproved_array[1];
      $r_dateapproved_year = $dateapproved_array[0];
      
      $datenextrenewal_array = explode("-", $r_datenextrenewal);
      $r_datenextrenewal_day = $datenextrenewal_array[2];
      $r_datenextrenewal_month = $datenextrenewal_array[1];
      $r_datenextrenewal_year = $datenextrenewal_array[0];
      
      $dateconverted_array = explode("-", $r_dateconverted);
      $r_dateconverted_day = $dateconverted_array[2];
      $r_dateconverted_month = $dateconverted_array[1];
      $r_dateconverted_year = $dateconverted_array[0];
      
      $dateterminated_array = explode("-", $r_dateterminated);
      $r_dateterminated_day = $dateterminated_array[2];
      $r_dateterminated_month = $dateterminated_array[1];
      $r_dateterminated_year = $dateterminated_array[0];
      
      $datelastadminedit_array = explode("-", $r_datelastadminedit);
      $r_datelastadminedit_day = $datelastadminedit_array[2];
      $r_datelastadminedit_month = $datelastadminedit_array[1];
      $r_datelastadminedit_year = $datelastadminedit_array[0];
      
      // format
      $r_surname = removeSlashesFormat($r_surname);
      $r_givenname = removeSlashesFormat($r_givenname);
    }
  }
}
?>

<?php include('page-header.php'); ?>

<script type="text/javascript">
  $(document).ready(function() {

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

    // event - click on save button
    $('#btn_save').click(function() {

      // set vars
      var f_surname = jQuery.trim($("#f_surname").val());
      var f_givenname = jQuery.trim($("#f_givenname").val());
      var f_title = $("#ddlTitle :selected").val();
      var f_nric = jQuery.trim($("#f_nric").val());
      var f_phone = jQuery.trim($("#f_phone").val());
      var f_extension = jQuery.trim($("#f_extension").val());
      var f_fax = jQuery.trim($("#f_fax").val());
      var f_mobile = jQuery.trim($("#f_mobile").val());
      var f_email1 = jQuery.trim($("#f_email1").val());
      var f_email2 = jQuery.trim($("#f_email2").val());
      var f_dob_day = $("#ddldobDay :selected").val();
      var f_dob_month = $("#ddldobMonth :selected").val();
      var f_dob_year = $("#ddldobYear :selected").val();
      var f_gender = $("#ddlGender :selected").val();
      var f_unitcode = jQuery.trim($("#f_unitcode").val());
      var f_address1 = jQuery.trim($("#f_address1").val());
      var f_address2 = jQuery.trim($("#f_address2").val());
      var f_address3 = jQuery.trim($("#f_address3").val());
      var f_address4 = jQuery.trim($("#f_address4").val());
      var f_postcode = jQuery.trim($("#f_postcode").val());
      var f_countrystateid = $("#ddlCountryState :selected").val();
      var f_isagreedtoobitcontrib = ($('#f_isagreedtoobitcontrib').is(":checked")) ? 1 : 0;
      var f_membercode = jQuery.trim($("#f_membercode").val());
      var f_agentcode = jQuery.trim($("#f_agentcode").val());
      var f_agencyid = $("#ddlAgency :selected").val();
      var f_rankid = $("#ddlRank :selected").val();
      var f_regionid = $("#ddlRegion :selected").val();
      var f_memberstatusid = $("#ddlMemberStatus :selected").val();
      var f_membertypeid = $("#ddlMemberType :selected").val();
      var f_membertypestatusid = $("#ddlMemberTypeStatus :selected").val();
      var f_dateenrolled_day = $("#ddlEnrolledDay :selected").val();
      var f_dateenrolled_month = $("#ddlEnrolledMonth :selected").val();
      var f_dateenrolled_year = $("#ddlEnrolledYear :selected").val();
      var f_dateapproved_day = $("#ddlApprovedDay :selected").val();
      var f_dateapproved_month = $("#ddlApprovedMonth :selected").val();
      var f_dateapproved_year = $("#ddlApprovedYear :selected").val();
      var f_datenextrenewal_day = $("#ddlNextRenewalDay :selected").val();
      var f_datenextrenewal_month = $("#ddlNextRenewalMonth :selected").val();
      var f_datenextrenewal_year = $("#ddlNextRenewalYear :selected").val();
      var f_dateconverted_day = $("#ddlConvertedDay :selected").val();
      var f_dateconverted_month = $("#ddlConvertedMonth :selected").val();
      var f_dateconverted_year = $("#ddlConvertedYear :selected").val();
      var f_dateterminated_day = $("#ddlTerminatedDay :selected").val();
      var f_dateterminated_month = $("#ddlTerminatedMonth :selected").val();
      var f_dateterminated_year = $("#ddlTerminatedYear :selected").val();
      var f_notes = jQuery.trim($("#f_notes").val());
     

      // Initialize Array to hold Error Messages
      var ErrorMsgList = new Array();
      var iserror = false;

      // initiate block ui
      var objContent = $("#content_left");
      block(objContent, $("#blockloading"));

      /////////////////////////////////////
      // VALIDATE FORM
      /////////////////////////////////////
      if (isStringEmpty(f_surname)) {
        ErrorMsgList.push("Surname is empty.");
        iserror = true;
      }

      if (isStringEmpty(f_givenname)) {
        ErrorMsgList.push("Given name is empty.");
        iserror = true;
      }

      if (isStringEmpty(f_email1)) {
        ErrorMsgList.push("Primary email address is required.");
        iserror = true;
      }

      if (isStringEmpty(f_email2)) {
        ErrorMsgList.push("Alternate email address is required.");
        iserror = true;
      }

      if (isStringEmpty(f_unitcode)) {
        ErrorMsgList.push("Unit Code is required.");
        iserror = true;
      }

      if (isStringEmpty(f_address1)) {
        ErrorMsgList.push("Address 1 is required.");
        iserror = true;
      }

      if (isStringEmpty(f_address2)) {
        ErrorMsgList.push("Address 2 is required.");
        iserror = true;
      }

      if (isStringEmpty(f_address3)) {
        ErrorMsgList.push("Address 3 is required.");
        iserror = true;
      }

      if (isStringEmpty(f_address4)) {
        ErrorMsgList.push("Address 4 is required.");
        iserror = true;
      }

      if (isStringEmpty(f_postcode)) {
        ErrorMsgList.push("Postcode is required.");
        iserror = true;
      }
      
      if (isStringEmpty(f_membercode)) {
        ErrorMsgList.push("Member code is empty.");
        iserror = true;
      }
      
      if (isStringEmpty(f_agentcode)) {
        ErrorMsgList.push("Agent code is empty.");
        iserror = true;
      }

      if ($("#ddlTitle").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Title is not selected.");
        iserror = true;
      }
      
      if ($("#ddlGender").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Gender is not selected.");
        iserror = true;
      }

      if (($("#ddldobDay").prop("selectedIndex") == 0) ||
          ($("#ddldobMonth").prop("selectedIndex") == 0) ||
          ($("#ddldobYear").prop("selectedIndex") == 0)) {
        ErrorMsgList.push("Date of birth is incomplete.");
        iserror = true;
      }

      if ($("#ddlCountryState").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Country state is not selected.");
        iserror = true;
      }
      
      if ($("#ddlAgency").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Agency is not selected.");
        iserror = true;
      }
      
      if ($("#ddlRank").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Rank is not selected.");
        iserror = true;
      }
      
      if ($("#ddlRegion").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Region is not selected.");
        iserror = true;
      }
      
      if ($("#ddlMemberStatus").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Member status is not selected.");
        iserror = true;
      }
      
      if ($("#ddlMemberType").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Member type is not selected.");
        iserror = true;
      }
      
      if ($("#ddlMemberTypeStatus").prop("selectedIndex") == 0) {
        ErrorMsgList.push("Member type status is not selected.");
        iserror = true;
      }

      if (!isNumber(f_postcode)) {
        ErrorMsgList.push("Post code must be in a number.");
        iserror = true;
      }

      if ((countDigits(f_nric) != 12) || (!isNumber(f_nric))) {
        ErrorMsgList.push("NRIC must contains 12 digit of numbers.");
        iserror = true;
      }

      if ((countDigits(f_phone) < 8) || (countDigits(f_phone) > 10)) {
        ErrorMsgList.push("Phone must contains between 8 or 10 digit of numbers.");
        iserror = true;
      }

      if ((countDigits(f_fax) < 8) || (countDigits(f_fax) > 10)) {
        ErrorMsgList.push("Fax must contains between 8 or 10 digit of numbers.");
        iserror = true;
      }

      if (countDigits(f_mobile) != 10) {
        ErrorMsgList.push("Mobile Phone must contains 10 digit of numbers.");
        iserror = true;
      }

      if (!isNumber(f_extension)) {
        ErrorMsgList.push("Extension must be in a number.");
        iserror = true;
      }

      if (!validateEmail(f_email1)) {
        ErrorMsgList.push("Invalid primary email address.");
        iserror = true;
      }

      if (!validateEmail(f_email2)) {
        ErrorMsgList.push("Invalid alternate email address.");
        iserror = true;
      }
      /////////////////////////////////////
      // END VALIDATE FORM
      /////////////////////////////////////

      // SHOW ERROR MESSAGE
      if (iserror) {
        var ErrorMsg = "Please ensure that all required fields are complete. <br />";

        ErrorMsgList.forEach(function(entry) {
          ErrorMsg += "&bull; " + entry + "<br />";
        });

        // clear error message // show message
        $("#msg").html('');
        $("#msg").html(ErrorMsg);

        // unblock ui
        unblock(objContent);
      }
      else {
        var f_dob = formatDate(f_dob_day, f_dob_month, f_dob_year, 'mdy');
        var f_dateenrolled = formatDate(f_dateenrolled_day, f_dateenrolled_month, f_dateenrolled_year, 'mdy');
        var f_dateapproved = formatDate(f_dateapproved_day, f_dateapproved_month, f_dateapproved_year, 'mdy');
        var f_datenextrenewal = formatDate(f_datenextrenewal_day, f_datenextrenewal_month, f_datenextrenewal_year, 'mdy');
        var f_dateconverted = formatDate(f_dateconverted_day, f_dateconverted_month, f_dateconverted_year, 'mdy');
        var f_dateterminated = formatDate(f_dateterminated_day, f_dateterminated_month, f_dateterminated_year, 'mdy');
      }

      // PROCEED AJAX IF NO ERROR
      if (iserror != true) {

        // validation successful
        $.ajax({
          type: "POST",
          url: "control-member-edit.php",
          data: ({
            action: 'editmember',
            rid: '<?php echo $p_member_id; ?>',
            fsurname: f_surname,
            fgivenname: f_givenname,
            ftitle: f_title,
            fnric: f_nric,
            fphone: f_phone,
            fextension: f_extension,
            ffax: f_fax,
            fmobile: f_mobile,
            femail1: f_email1,
            femail2: f_email2,
            fdob: f_dob,
            fgender: f_gender,
            funitcode: f_unitcode,
            faddress1: f_address1,
            faddress2: f_address2,
            faddress3: f_address3,
            faddress4: f_address4,
            fpostcode: f_postcode,
            fcountrystateid: f_countrystateid,
            fisagreedtoobitcontrib: f_isagreedtoobitcontrib,
            fmembercode : f_membercode,
            fagentcode : f_agentcode,
            ffkagencyid : f_agencyid,
            ffkrankid : f_rankid,
            ffkregionid : f_regionid,
            ffkmemberstatusid : f_memberstatusid,
            ffkmembertypeid : f_membertypeid,
            ffkmembertypestatusid : f_membertypestatusid,
            fdateenrolled : f_dateenrolled,
            fdateapproved : f_dateapproved,
            fdatenextrenewal : f_datenextrenewal,
            fdateconverted : f_dateconverted,
            fdateterminated : f_dateterminated,
            fnotes: f_notes
          }),
          cache: false,
          success: function(data) {

            data = jQuery.trim(data);

            if (data == 'true') {

              // initiate block ui
              block(objContent, $("#blocksuccess"));

              // delay redirect by 1 second
              setTimeout(function() {
                window.location.href = 'member.php?pg=<?php echo $p_page; ?>';
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
    $('#btn_cancel').click(function() {

      // initiate block ui
      block($("#content_left"), $("#blockcancel"));

      window.location.href = 'member.php?pg=<?php echo $p_page; ?>';
      return false;

    });
    
    $('#ddlRank').change(function() {
      var val = $(this).val();
      
      if (val != '1')
        $('#f_isagreedtoobitcontrib').attr('disabled', 'disabled');
      else
        $('#f_isagreedtoobitcontrib').removeAttr('disabled');
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
          <td><b>Member Code: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_membercode" size="50" maxlength="20" value="<?php echo $r_membercode; ?>"></td>
        </tr>
        <tr>
          <td><b>Agent Code: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_agentcode" size="80" maxlength="250" value="<?php echo $r_agentcode; ?>"></td>
        </tr>
        <tr>
          <td width="25%"><b>Title: <span class="text_red">*</span></b></td>
          <td><select name="ddlTitle" id="ddlTitle">
                <option>Please Select</option>
                <?php foreach ($result_title as $key => $val) {
                  $strselected = ($r_nametitleid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td><b>Surname: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_surname" size="50" maxlength="20" value="<?php echo $r_surname; ?>"></td>
        </tr>
        <tr>
          <td><b>Given name: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_givenname" size="80" maxlength="250" value="<?php echo $r_givenname; ?>"></td>
        </tr>          
        <tr>
          <td><b>NRIC: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_nric" size="80" maxlength="250" value="<?php echo $r_nric; ?>" onblur="this.value = removeChar(this, '*');"></td>
        </tr>
        <tr>
          <td><b>Date of Birth: <span class="text_red">*</span></b></td>
          <td><?php echo $common->showDateControl('ddldobDay', 'ddldobMonth', 'ddldobYear', $r_dob_day, $r_dob_month, $r_dob_year); ?></td>
        </tr>
        <tr>
          <td><b>Date of Enrolled:</b></td>
          <td><?php echo $common->showDateControl('ddlEnrolledDay', 'ddlEnrolledMonth', 'ddlEnrolledYear', $r_dateenrolled_day, $r_dateenrolled_month, $r_dateenrolled_year); ?></td>
        </tr>
        <tr>
          <td><b>Date of Approved:</b></td>
          <td><?php echo $common->showDateControl('ddlApprovedDay', 'ddlApprovedMonth', 'ddlApprovedYear', $r_dateapproved_day, $r_dateapproved_month, $r_dateapproved_year); ?></td>
        </tr>
        <tr>
          <td><b>Date of Next Renewal Year:</b></td>
          <td><?php echo $common->showDateControl('ddlNextRenewalDay', 'ddlNextRenewalMonth', 'ddlNextRenewalYear', $r_datenextrenewal_day, $r_datenextrenewal_month, $r_datenextrenewal_year); ?></td>
        </tr>
        <tr>
          <td><b>Date of Converted Year:</b></td>
          <td><?php echo $common->showDateControl('ddlConvertedDay', 'ddlConvertedMonth', 'ddlConvertedYear', $r_dateconverted_day, $r_dateconverted_month, $r_dateconverted_year); ?></td>
        </tr>
        <tr>
          <td><b>Date of Terminated Year:</b></td>
          <td><?php echo $common->showDateControl('ddlTerminatedDay', 'ddlTerminatedMonth', 'ddlTerminatedYear', $r_dateterminated_day, $r_dateterminated_month, $r_dateterminated_year); ?></td>
        </tr>
        <tr>
          <td><b>Gender: <span class="text_red">*</span></b></td>
          <td><select name="ddlGender" id="ddlGender">
              <option>Please Select</option>
              <option value="M" <?php echo ($r_gender == "M") ? 'selected' : ''; ?>>Male</option>
              <option value="F" <?php echo ($r_gender == "F") ? 'selected' : ''; ?>>Female</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><b>Unit Code: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_unitcode" size="80" maxlength="250" value="<?php echo $r_unitcode; ?>"></td>
        </tr>
        <tr>
          <td><b>Address 1: <span class="text_red">*</span></b></td>
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
          <td><select name="ddlCountryState" id="ddlCountryState">
              <option>Please Select</option>
  <?php foreach ($result_countrystate as $key => $val) {
    $strselected = ($r_countrystateid === (string) $key) ? 'selected' : '';
    ?>
                <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><b>Phone: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_phone" size="50" maxlength="20" value="<?php echo $r_phone; ?>" onblur="this.value = setPhoneNumberFormat(this.value, 2);"></td>
        </tr>
        <tr>
          <td><b>Extension: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_extension" size="80" maxlength="250" value="<?php echo $r_extension; ?>"></td>
        </tr>          
        <tr>
          <td><b>Fax: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_fax" size="80" maxlength="250" value="<?php echo $r_fax; ?>" onblur="this.value = setPhoneNumberFormat(this.value, 2);"></td>
        </tr>
        <tr>
          <td><b>Mobile: <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_mobile" size="80" maxlength="250" value="<?php echo $r_mobile; ?>" onblur="this.value = setPhoneNumberFormat(this.value, 3);"></td>
        </tr>
        <tr>
          <td><b>Email (Primary): <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_email1" size="80" maxlength="250" value="<?php echo $r_email1; ?>"></td>
        </tr>
        <tr>
          <td><b>Email (Secondary): <span class="text_red">*</span></b></td>
          <td><input type="text" id="f_email2" size="80" maxlength="250" value="<?php echo $r_email2; ?>"></td>
        </tr>
        <tr>
          <td width="25%"><b>Agency: <span class="text_red">*</span></b></td>
          <td><select name="ddlAgency" id="ddlAgency">
                <option>Please Select</option>
                <?php foreach ($result_agency as $key => $val) {
                  $strselected = ($r_fkagencyid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Region: <span class="text_red">*</span></b></td>
          <td><select name="ddlRegion" id="ddlRegion">
                <option>Please Select</option>
                <?php foreach ($result_region as $key => $val) {
                  $strselected = ($r_fkregionid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Member Status: <span class="text_red">*</span></b></td>
          <td><select name="ddlMemberStatus" id="ddlMemberStatus">
                <option>Please Select</option>
                <?php foreach ($result_memberstatus as $key => $val) {
                  $strselected = ($r_fkmemberstatusid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Member Type: <span class="text_red">*</span></b></td>
          <td><select name="ddlMemberType" id="ddlMemberType">
                <option>Please Select</option>
                <?php foreach ($result_membertype as $key => $val) {
                  $strselected = ($r_fkmembertypeid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Member Type Status: <span class="text_red">*</span></b></td>
          <td><select name="ddlMemberTypeStatus" id="ddlMemberTypeStatus">
                <option>Please Select</option>
                <?php foreach ($result_membertypestatus as $key => $val) {
                  $strselected = ($r_fkmembertypestatusid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Rank: <span class="text_red">*</span></b></td>
          <td><select name="ddlRank" id="ddlRank">
                <option>Please Select</option>
                <?php foreach ($result_rank as $key => $val) {
                  $strselected = ($r_fkrankid === (string) $key) ? 'selected' : '';
                  ?>
                  <option value="<?php echo $key; ?>" <?php echo $strselected; ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
          </td>
        </tr>
        <tr>
          <td width="25%"><b>Agree to Contribution:</b></td>
          <td>
            <input type="checkbox" id="f_isagreedtoobitcontrib" <?php echo (($r_fkrankid == 1) && ($r_isagreedtoobitcontrib == 0)) ? '' : 'disabled="disabled"' ?> <?php echo $r_isagreedtoobitcontrib == 0 ? '' : 'checked="checked"' ?>>
          </td>
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