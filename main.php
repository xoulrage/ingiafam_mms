<?php
// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');



$member = new member();
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
    $r_Agency      = $row[13];
    $r_Rank        = $row[15];
    $r_Region      = $row[17];
    $r_address1    = removeSlashesFormat($row[18]);
    $r_address2    = removeSlashesFormat($row[19]);
    $r_address3    = removeSlashesFormat($row[20]);
    $r_address4    = removeSlashesFormat($row[21]);
    $r_postcode    = removeSlashesFormat($row[22]);
    $r_State       = $row[24];
    $r_phone       = removeSlashesFormat($row[25]);
    $r_extension   = removeSlashesFormat($row[26]);
    $r_fax         = removeSlashesFormat($row[27]);
    $r_mobile      = removeSlashesFormat($row[28]);
    $r_email1      = removeSlashesFormat($row[29]);
    $r_email2      = removeSlashesFormat($row[30]);
    $r_MemberType  = $row[33];
}

if (!(is_null($r_dateofbirth))){
   $r_dateofbirth = date_create($r_dateofbirth);
   $r_dateofbirth = date_format($r_dateofbirth,'jS F Y');
}

?>

<?php include('page-header.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // initialize
        $("#tabs").tabs();

        $('#btn_editpwd').click(function(){
            document.location.href = 'change-password.php';
        });

        $('#btn_edit').click(function(){
            document.location.href = 'edit-profile.php';
        });
    });
</script>

<div id="full">
  <div id="content_title">
    <span class="content_title">Welcome Back</span>
    &nbsp;&nbsp;<small><a href="logout.php">(Logout)</a></small>
  </div>
  <div id="content">

    <table cellpadding="3" cellspacing="0" width="100%" border="0">
      <tr>
        <td colspan="5" align="right">
          <input type="button" id="btn_edit" value="Edit Profile" class="button_blue">
          &nbsp;&nbsp;
          <input type="button" id="btn_editpwd" value="Change Password" class="button_blue">
        </td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td width="15%">Member Code:</td>
        <td><?php echo $r_memberCode; ?></td>
        <td width="2%">&nbsp;</td>
        <td width="15%">Type:</td>
        <td><?php echo $r_MemberType; ?></td>
      </tr>
      <tr>
        <td width="15%">Agent Code:</td>
        <td><?php echo $r_agentcode; ?></td>
        <td width="2%">&nbsp;</td>
        <td width="15%">NRIC (New):</td>
        <td><?php echo $r_nric; ?></td>
      </tr>
      <tr>
        <td>Surname:</td>
        <td><?php echo $r_surname; ?></td>
        <td>&nbsp;</td>
        <td>Given Name:</td>
        <td><?php echo $r_givenname; ?></td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td><?php echo $r_dateofbirth; ?></td>
        <td>&nbsp;</td>
        <td>Gender:</td>
        <td><?php echo $r_gender == 'M' ? 'Male' : 'Female'; ?></td>
      </tr>
      <tr>
        <td>Rank:</td>
        <td><?php echo $r_Rank; ?></td>
        <td>&nbsp;</td>
        <td>Region:</td>
        <td><?php echo $r_Region; ?></td>
      </tr>
      <tr>
        <td>Agency:</td>
        <td colspan="4"><?php echo $r_Agency; ?></td>
      </tr>
      <tr>
        <td valign="top">Address:</td>
        <td valign="top" colspan="4">
            <?php echo $r_address1; ?> <br />
            <?php echo $r_address2; ?> <br />
            <?php echo $r_address3; ?> <br />
            <?php echo $r_address4; ?>
        </td>
      </tr>
      <tr>
        <td>State:</td>
        <td><?php echo $r_State; ?></td>
        <td>&nbsp;</td>
        <td>Postcode:</td>
        <td><?php echo $r_postcode; ?></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td><?php echo $r_phone; ?></td>
        <td>&nbsp;</td>
        <td>Ext:</td>
        <td><?php echo $r_extension; ?></td>
      </tr>
      <tr>
        <td>Fax:</td>
        <td><?php echo $r_fax; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Mobile:</td>
        <td><?php echo $r_mobile; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Email (Primary):</td>
        <td><?php echo $r_email1; ?></td>
        <td>&nbsp;</td>
        <td>Email (Secondary):</td>
        <td><?php echo $r_email2; ?></td>
      </tr>
    </table>
    <br /><br />

    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">BILLINGS</a></li>
        <li><a href="#tabs-2">NEWS</a></li>
        <li><a href="#tabs-3">EVENT BOOKINGS</a></li>
        <li><a href="#tabs-4">PREMIUM ITEMS</a></li>
      </ul>
      <div id="tabs-1">
        <div id="content_tab">
          <div align="center">
            <br />
            <img src="images/icon-billings.png">
            <br /><br />
            <h1>COMING SOON!</h1>
            <br />
            <p>View all membership bills and payments (pending and historical) under one section.</p>
          </div>
        </div>
      </div>
      <div id="tabs-2">
        <div id="content_tab">
          <div align="center">
            <br />
            <img src="images/icon-news.png">
            <br /><br />
            <h1>COMING SOON!</h1>
            <br />
            <p>Keep yourself updated with the latest news and announcements for members only.</p>
          </div>
        </div>
      </div>
      <div id="tabs-3">
        <div id="content_tab">
          <div align="center">
            <br />
            <img src="images/icon-events.png">
            <br /><br />
            <h1>COMING SOON!</h1>
            <br />
            <p>Register for events and functions with ease via the online event registration.</p>
          </div>
        </div>
      </div>
      <div id="tabs-4">
        <div id="content_tab">
          <div align="center">
            <br />
            <img src="images/icon-premium.png">
            <br /><br />
            <h1>COMING SOON!</h1>
            <br />
            <p>Purchase special members-only premium items at attractive prices and pay via online.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="reset"></div>
<?php include('page-footer.php'); ?>
