<?php 

// constant
define(MODULEID, 1);


// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');
include_once('includes/inc-checkaccess.php');


// settings
$is_available = false;


// instantiate


// fetch parameters


// set default


// get list
// ********


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