<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');
include_once('includes/inc-checkaccess-admin.php');


// settings
$recperpage = RECPERPAGE;
$is_available = false;


// instantiate
$user = new user();


// fetch parameters
$p_page = sanitizeInt(trim($_REQUEST['pg']));


// set default
if (!($p_page))
{
  $p_page = 1;
}


// get list
// ********
$result = $user->getList($p_page, $recperpage);

if (count($result) > 0)
{
  $is_available = true;
}


// get total users
// ***************
$result_total = $user->getTotal() - 1;
  
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
  $result = $user->getList($p_page, $recperpage);
  
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
      
      var rec_id = $("#f_delete_id").val();
      var objContent = $("#content_left");

      if (rec_id != '')
      {      
        // initiale block ui
        block(objContent, $("#blockloading"));

        $.ajax({
          type: "POST",
          url:  "control-user-delete.php",
          data: ({
            action : 'deleteuser', 
            rid : rec_id
          }),        
          cache: false,
          success: function(data){
        
            data = jQuery.trim(data);

            if (data == 'true') {

              // initiate block ui
              block(objContent, $("#blocksuccess"));

              // delay redirect by 1 second
              setTimeout(function() {
                window.location.href= '<?php echo $_SERVER['PHP_SELF'] . '?pg=' . $p_page; ?>';
              }, 1000);
                  
            } else {

              // unblock ui
              unblock(objContent);

            }
              
          }
        });

      }
      
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

      window.location.href = 'user-add.php';
      return false;
      
    });  

  });  
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">USER MANAGER</span>
      </div>
      
      <div id="content">
        
        <input type="hidden" id="f_delete_id">

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_list">
          <tr>
            <th width="5%" align="center">#</th>
            <th>USERNAME</th>
            <th>FIRSTNAME</th>
            <th align="center">USER TYPE</th>
            <th align="center">ACCOUNT STATUS</th>
            <th width="5%" align="center">EDIT</th>
            <th width="5%" align="center">CHANGE PASSWORD</th>
            <th width="5%" align="center">DELETE</th>
          </tr>

<?php 
// ouput list
if ($is_available == true)
{
  $ctr = getLimitStart($p_page, $recperpage) + 1;
  
  foreach($result as $row)
  {
    $r_user_id = $row[0];
    $r_type = trim($row[2]);
    $r_username = trim($row[3]);
    $r_firstname = trim($row[4]);
    $r_publish = $row[7];
    
    // format
    $r_type = removeSlashesFormat($r_type);
    $r_username = removeSlashesFormat($r_username);
    $r_firstname = removeSlashesFormat($r_firstname);
    
    $url_publish = 'control-user-publish.php?action=updatepublish&rid=' . $r_user_id . '&pg=' . $p_page;
    $url_edit = 'user-edit.php?rid=' . $r_user_id . '&pg=' . $p_page;
    $url_edit_pwd = 'user-edit-pwd.php?rid=' . $r_user_id . '&pg=' . $p_page;
    
    if ($r_publish == 1)
    {
      $publish = '<a href="' . $url_publish . '"><img src="images/icon-publish.png" title="Click to lock user account"></a>';
    } else {
      $publish = '<a href="' . $url_publish . '"><img src="images/icon-unpublish.png" title="Click to unlock user account"></a>';
    }
    
    $edit = '<a href="' . $url_edit . '"><img src="images/icon-edit.png" title="Edit Profile"></a>';

    $edit_pwd = '<a href="' . $url_edit_pwd . '"><img src="images/icon-edit.png" title="Change Password"></a>';    

    $delete = '<a href="#" class="lnk_delete" rel="' . $r_user_id . '"><img src="images/icon-delete.png" title="Delete"></a>';

    // output
    echo '<tr>' . "\n";
    echo '<td align="center">' . $ctr . '</td>' . "\n";
    echo '<td>' . $r_username . '</td>' . "\n";
    echo '<td>' . $r_firstname . '</td>' . "\n";
    echo '<td align="center">' . $r_type . '</td>' . "\n";
    echo '<td align="center">' . $publish . '</td>' . "\n";
    echo '<td align="center">' . $edit . '</td>' . "\n";
    echo '<td align="center">' . $edit_pwd . '</td>' . "\n";
    echo '<td align="center">' . $delete . '</td>' . "\n";
    echo '</tr>' . "\n";
    
    // increment
    $ctr++;
    
    // clear
    $r_user_id = '';
    $r_type = '';
    $r_username = '';
    $r_firstname = '';
    $r_publish = '';
    
    $url_publish = '';
    $url_edit = '';
    $url_edit_pwd = '';
    
    $active = '';
    $edit = '';
    $edit_pwd = '';
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
        Click to add a new user:
        <br /><br />
        <input type="button" id="btn_add" value="ADD NEW USER" class="button_blue">

      </div>
      
    </div>

<?php include('page-footer.php'); ?>