<?php 

// constant
define(MODULEID, 5);


// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');
include_once('includes/inc-checkaccess.php');


// settings
$is_available = false;


// instantiate
$settings = new settings();


// fetch parameters


// set default


// get list
// ********
$result = $settings->getList();
  
if (count($result) > 0)
{
  $is_available = true;
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
    
    // event - click on add button
    $('#btn_add').click(function(){
     
      window.location.href = 'settings-edit.php';
      return false;
      
    });  
    
  });  
  </script>
  
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">GENERAL SETTINGS</span>
      </div>
      
      <div id="content">
        
        <input type="hidden" id="f_delete_id">
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_list">
          <tr>           
            <th width="30%">TYPE</th>
            <th>VALUE</th>
          </tr>
<?php 
// output list
if ($is_available == true)
{
  $arr_vars = array(
    'MERCHANT_NAME' => 'Merchant Name',
    'MERCHANT_EMAIL' => 'Merchant Email',
    'TAX_GOVT' => 'Government Tax Rate',
    'TAX_SERVICE' => 'Service Tax Rate'
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
      // format
      if ($arr_vars_type[$r_item] == 'p')
      {
        $r_value = number_format(($r_value * 100), 2) . '%';
      }
      
      // output
      echo '<tr>' . "\n";
      echo '<td>' . $arr_vars[$r_item] . '</td>' . "\n";
      echo '<td>' . $r_value . '</td>' . "\n";
      echo '</tr>' . "\n";      
    }
    
    // clear
    $r_item = '';
    $r_value = '';
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

        <div id="blockloading" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            PROCESSING... PLEASE WAIT...
          </div>
        </div>
 
      </div>
      
    </div>
    <div id="content_right">
      <div id="content_title_small">
        <span class="text_title_content_small">INSTRUCTIONS</span>
      </div>
      
      <div id="content">
        <input type="button" id="btn_add" value="EDIT SETTINGS" class="button_blue">

      </div>
      
    </div>

<?php include('page-footer.php'); ?>