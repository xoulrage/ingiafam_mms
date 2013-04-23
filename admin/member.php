<?php

// constant
define(MODULEID, 1);


// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');
include_once('includes/inc-checkaccess.php');


// settings
$recperpage = RECPERPAGE;
$is_available = false;


// instantiate
$member = new member();


// fetch parameters
$p_page = sanitizeInt(trim($_REQUEST['pg']));


// set default
if (!($p_page))
{
  $p_page = 1;
}

// get list
// ********
$result = $member->getList($p_page, $recperpage);

if (count($result) > 0)
{
  $is_available = true;
}


// get total users
// ***************
$result_total = $member->getTotal() - 1;

if ($result_total < 0)
{
  $result_total = 0;
}


// check if page has not content
// *****************************
if ((!($is_available)) && ($result_total > 0))
{
  // set to previous page
  $p_page = $p_page - 1;

  // re-query list
  $result = $member->getList($p_page, $recperpage);

  if (count($result) > 0)
  {
    $is_available = true;
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

    // event - click on delete button
    $(".lnk_delete").click(function(){

      var rec_id = jQuery.trim($(this).attr("rel"));
      var objContent = $("#content_left");

      // clear
      $("#f_delete_id").val('');

      if (rec_id != '')
      {
        // assign
        $("#f_delete_id").val(rec_id);

        // initiate block ui
        block(objContent, $("#blockconfirm"));
      }

      return false;

    });

    // event - click on confirm delete button
    $("#btn_confirm").click(function(){



    });

    // event - click on cancel delete button
    $('#btn_cancel').click(function(){

      // clear
      $("#f_delete_id").val('');

      var objContent = $("#content_left");

      // initiate block ui
      unblock(objContent);

    });

    // event - click on add button
    $('#btn_add').click(function(){

      window.location.href = 'member-add.php';
      return false;

    });

  });
  </script>

    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">MEMBERS</span>
      </div>

      <div id="content">

        <input type="hidden" id="f_delete_id">

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_list">
          <tr>
            <th width="5%" align="center">#</th>
            <th>SURNAME</th>
            <th>GIVEN NAME</th>
            <th align="center">AGENT CODE</th>
            <th align="center">DATE CREATED</th>
            <th align="center">IS ACTIVE</th>
            <th width="5%" align="center">EDIT</th>
            <th width="5%" align="center">DELETE</th>
          </tr>
<?php
// ouput list
if ($is_available == true)
{
  $ctr = getLimitStart($p_page, $recperpage) + 1;
  
  //echo '<pre>'; print_r($result); echo '</pre>';

  foreach($result as $row)
  {
    $r_id = $row[0];
    $r_surname = trim($row[1]);
    $r_givenname = trim($row[2]);
    $r_agentcode = trim($row[3]);
    $r_datecreated = $row[4];
    $r_isactive = $row[5];

    $url_edit = 'member-edit.php?rid=' . $r_id . '&pg=' . $p_page;
    $edit = '<a href="' . $url_edit . '"><img src="images/icon-edit.png" title="Edit Profile"></a>';

    $delete = '<a href="#" class="lnk_delete" rel="' . $r_id . '"><img src="images/icon-delete.png" title="Delete"></a>';

    // output
    echo '<tr>' . "\n";
    echo '<td align="center">' . $ctr . '</td>' . "\n";
    echo '<td>' . $r_surname . '</td>' . "\n";
    echo '<td>' . $r_givenname . '</td>' . "\n";
    echo '<td align="center">' . $r_agentcode . '</td>' . "\n";
    echo '<td align="center">' . $r_datecreated . '</td>' . "\n";
    echo '<td align="center">' . $r_isactive . '</td>' . "\n";
    echo '<td align="center">' . $edit . '</td>' . "\n";
    echo '<td align="center">' . $delete . '</td>' . "\n";
    echo '</tr>' . "\n";

    // increment
    $ctr++;

    // clear
    $r_id = '';
    $r_surname = '';
    $r_givenname = '';
    $r_agentcode = '';
    $r_datecreated = '';
    $r_isactive = '';

    $edit = '';
    $url_edit = '';
    $delete = '';
  }
}

if ($is_available != true)
{
  // output - no available record
  echo '<tr>' . "\n";
  echo '<td colspan="8" align="center">No records found.</td>' . "\n";
  echo '</tr>' . "\n";
}

?>

        </table>

<?php
// create pagination
if ($is_available == true)
{
  echo '<br />';
  createPagination($result_total, $recperpage, $p_page, $_SERVER['PHP_SELF']);
}
?>

        <div id="blockloading" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            PROCESSING... PLEASE WAIT...
          </div>
        </div>

        <div id="blockconfirm" style="display:none;">
          <div align="center">
            CONFIRMATION:
            <br /><br />
            Are you sure you want to delete the selected record?
            <br /><br />
            <input type="button" id="btn_confirm" value="YES" class="button_blue">
            &nbsp;
            <input type="button" id="btn_cancel" value="CANCEL" class="button_orange">
          </div>
        </div>

        <div id="blocksuccess" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            RECORD DELETED...<br />
            REFRESHING... PLEASE WAIT...
          </div>
        </div>

      </div>

    </div>
    <div id="content_right">
      <div id="content_title_small">
        <span class="text_title_content_small">INSTRUCTIONS</span>
      </div>

      <div id="content">
        Click to register a new member:
        <br /><br />
        <input type="button" id="btn_add" value="ADD NEW MEMBER" class="button_blue">

      </div>

    </div>

<?php include('page-footer.php'); ?>