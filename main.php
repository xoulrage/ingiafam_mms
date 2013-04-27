<?php
// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');
?>

<?php include('page-header.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // initialize
        $("#tabs").tabs();

        $('#btn_editpwd').click(function(){
            document.location.href = 'change-password.php';
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
        <td>&lt; MEMBERSHIP CODE &gt;</td>
        <td width="2%">&nbsp;</td>
        <td width="15%">Type:</td>
        <td>&lt; MEMBERSHIP TYPE &gt;</td>
      </tr>
      <tr>
        <td width="15%">Agent Code:</td>
        <td>XXXXX-X</td>
        <td width="2%">&nbsp;</td>
        <td width="15%">NRIC (New):</td>
        <td>XXXXXX-XX-XXXX</td>
      </tr>
      <tr>
        <td>Surname:</td>
        <td>&lt; SURNAME &gt;</td>
        <td>&nbsp;</td>
        <td>Given Name:</td>
        <td>&lt; GIVEN NAME &gt;</td>
      </tr>
      <tr>
        <td>Date of Birth:</td>
        <td>&lt; D.O.B &gt;</td>
        <td>&nbsp;</td>
        <td>Gender:</td>
        <td>&lt; GENDER &gt;</td>
      </tr>
      <tr>
        <td>Rank:</td>
        <td>&lt; RANK &gt;</td>
        <td>&nbsp;</td>
        <td>Region:</td>
        <td>&lt; REGION &gt;</td>
      </tr>
      <tr>
        <td>Agency:</td>
        <td colspan="4">&lt; AGENCY &gt;</td>
      </tr>
      <tr>
        <td valign="top">Address:</td>
        <td valign="top" colspan="4">
          &lt; ADDRESS 1 &gt; <br />
          &lt; ADDRESS 2 &gt; <br />
          &lt; ADDRESS 3 &gt; <br />
          &lt; ADDRESS 4 &gt;
        </td>
      </tr>
      <tr>
        <td>State:</td>
        <td>&lt; STATE &gt;</td>
        <td>&nbsp;</td>
        <td>Postcode:</td>
        <td>&lt; POSTCODE &gt;</td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td>&lt; PHONE &gt;</td>
        <td>&nbsp;</td>
        <td>Ext:</td>
        <td>&lt; EXTENSION &gt;</td>
      </tr>
      <tr>
        <td>Fax:</td>
        <td>&lt; FAX &gt;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Mobile:</td>
        <td>&lt; MOBILE &gt;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Email (Primary):</td>
        <td>&lt; EMAIL1 &gt;</td>
        <td>&nbsp;</td>
        <td>Email (Secondary):</td>
        <td>&lt; EMAIL2 &gt;</td>
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
