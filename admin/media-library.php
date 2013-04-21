<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings
$require_image_upload = true;
$require_image_lightbox = true;

$fileperpage = 20;
$is_available = false;

$arr_folder = array(
 'NEWS' => 'news'
);


// instantiate
$common = new common();


// fetch parameters
$p_folder = sanitizeHtml(trim($_REQUEST['folder']));
$p_page = sanitizeInt(trim($_REQUEST['pg']));


// set default
if (!($p_folder))
{
  $p_folder = 'news';
}

if (!($p_page))
{
  $p_page = 1;
}


// get files
// *********
if ($p_folder)
{
  switch($p_folder)
  {
    case 'news':
      $folder = DIRPATH . NEWSIMAGEPATH;
      $folder_abspath = ABSPATH . NEWSIMAGEPATH;
      $filetype = 'image';
      break;
  }  
  
  $arr_files = $common->getFiles($folder);
  
  // get total files
  $total_files = count($arr_files) - 1;
  
  // get limitstart
  $limitstart = getLimitStart($p_page, $fileperpage);
}


// set options
// ***********
$options_folder = createOptions($arr_folder, $p_folder);

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

    // initialize
    // **********    
    $(".fancybox").fancybox();
    
    <?php $timestamp = time();?>
    $('#file_upload').uploadify({
      'auto'            : false,
      'swf'             : 'uploadify/uploadify.swf',
      'uploader'        : 'uploadify/uploadify-custom.php',
      'formData'        : {
      'timestamp'       : '<?php echo $timestamp;?>',
      'token'           : '<?php echo md5('unique_salt' . $timestamp);?>',
      'type'            : '<?php echo $p_folder; ?>' 
      },
      'removeCompleted' : true,
      
      <?php if ($filetype == 'image') { ?>
      'fileTypeExts'    : '*.jpg;*.gif;*.jpeg;*.png',
      'fileTypeDesc'    : 'Image Files',
      <?php } ?>
      
      <?php if ($filetype == 'doc') { ?>
      'fileTypeExts'    : '*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.ppt;*.pptx',
      'fileTypeDesc'    : 'Image Files',
      <?php } ?>
      
      'multi'           : false,
      'onUploadSuccess' : function(file, data, response) {
        // reload page
        window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?folder=' + $('#f_folder').val();
      }    
    });     
    // **********   
    
    // event - change select options
    $('#f_folder').change(function(){
      
      var objContent = $("#content_left");
      var folder_id = $(this).val();
      
      // initiate block ui
      block(objContent, $("#blockloading"));

      // delay redirect by 1 second
      setTimeout(function() {      
        window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?folder=' + folder_id;
      }, 1000);
      
    });

    // event - click on file upload button
    $("#btn_upload").click(function(){

      $('#file_upload').uploadify('upload');

    });

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
          url:  "control-media-delete.php",
          data: ({
            action : 'deletemedia',
            folder : '<?php echo $p_folder; ?>', 
            file : rec_id
          }),        
          cache: false,
          success: function(data){
        
            data = jQuery.trim(data);

            if (data == 'true') {

              // initiate block ui
              block(objContent, $("#blocksuccess"));

              // delay redirect by 1 second
              setTimeout(function() {
                window.location.href= '<?php echo $_SERVER['PHP_SELF'] . '?folder=' . $p_folder . '&pg=' . $p_page; ?>';
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
    
  });  
  </script>

    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">MEDIA LIBRARY</span>
      </div>
      
      <div id="content">

        <br />
        Select Folder:
        <select id="f_folder">
          <?php echo $options_folder; ?>
        </select>
        
        <br /><br />        

        <input type="hidden" id="f_delete_id">
        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_list">
          <tr>
            <th width="5%" align="center">#</th>            
            <th>FILE NAME</th>
            <th width="5%" align="center">VIEW</th>
            <th width="5%" align="center">DELETE</th>
          </tr>
<?php 

// output list
if (count($arr_files) > 0)
{
  $is_available = true;
  $ctr = 1;
  
  while (list($key,$value) = each($arr_files))  
  {
    if (($ctr > $limitstart) && ($ctr <= ($limitstart + $fileperpage)))
    {
      $filename = trim($value);
    
      // format
      if ($folder_abspath)
      {
        $url_view = $folder_abspath . $filename;
      }
    
      if ($url_view)
      {
        if ($filetype == 'image')
        {
          $view = '<a href="' . $url_view . '" class="fancybox" rel="gallery" title="' . sanitizeHtml($filename) . '"><img src="images/icon-preview.png" title="Click to View"></a>';        
        } else {
          $view = '<a href="' . $url_view . '" target="new"><img src="images/icon-preview.png" title="Click to View"></a>';        
        }
      }

      $delete = '<a href="#" class="lnk_delete" rel="' . sanitizeHtml($filename) . '"><img src="images/icon-delete.png" title="Delete"></a>';
    
      // output
      echo '<tr>' . "\n";
      echo '<td align="center">' . $ctr . '</td>' . "\n";
      echo '<td>' . $filename . '</td>' . "\n";
      echo '<td align="center">' . $view . '</td>' . "\n";
      echo '<td align="center">' . $delete . '</td>' . "\n";
      echo '</tr>' . "\n";

      // clear
      $filename = '';
    
      $url_view = '';
    
      $view = '';
      $delete = '';
    }
    
    // increment counter
    $ctr++;
  }
}

if ($is_available != true)
{
  // output - no available record
  echo '<tr>' . "\n";
  echo '<td colspan="4" align="center">No files found.</td>' . "\n";
  echo '</tr>' . "\n";
}

?>
        </table>

<?php 
// create pagination
if ($is_available == true)
{
  echo '<br />';
  createPagination($total_files, $fileperpage, $p_page, $_SERVER['PHP_SELF'], 'folder=' . $p_folder);
}
?>

        <div id="blockloading" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            LOADING... PLEASE WAIT...
          </div>
        </div>
        
        <div id="blockconfirm" style="display:none;">
          <div align="center">
            CONFIRMATION:
            <br /><br />
            Are you sure you want to delete the selected file?
            <br /><br />
            <input type="button" id="btn_confirm" value="YES" class="button_blue">
            &nbsp;
            <input type="button" id="btn_cancel" value="CANCEL" class="button_orange">   
          </div>
        </div>

        <div id="blocksuccess" style="display:none;">
          <div align="center">
            <img src="images/loading.gif"><br />
            FILE DELETED...<br />
            REFRESHING... PLEASE WAIT...
          </div>
        </div>

      </div>
      
    </div>
    <div id="content_right">
      
<?php if ($filetype == 'image') { ?>
  
      <div id="content_title_small">
        <span class="text_title_content_small">IMAGE FILE UPLOAD</span>
      </div>      
      <div id="content">
        Step 1: Click 'Select Files' to select the images.<br />
        Step 2: Click on 'Upload Files' to start the uplaod.
        <br /><br />
        <input id="file_upload" name="file_upload" type="file" />
        <input type="button" name="btn_upload" id="btn_upload" value="UPLOAD FILES" class="button_blue">        

        <br /><br /><br />
        
      </div>  

<?php } ?>

<?php if ($filetype == 'doc') { ?>

      <div id="content_title_small">
        <span class="text_title_content_small">DOCUMENT FILE UPLOAD</span>
      </div>      
      <div id="content">
        Step 1: Click 'Select Files' to select the documents.<br />
        Step 2: Click on 'Upload Files' to start the uplaod.
        <br /><br />
        Note: If your file is larger than <?php echo (int)(ini_get('upload_max_filesize')); ?>Mb, please use FTP to upload the file to the server. You should be uploading your files to the following destination:
        <br />
        <b>&lt;WEBSITE_ROOT&gt;/<?php echo PRODUCTDOCPATH; ?></b>
        <br /><br />
        
        <input id="file_upload" name="file_upload" type="file" />
        <input type="button" name="btn_upload" id="btn_upload" value="UPLOAD FILES" class="button_blue">        
        
      </div>

<?php } ?>

    </div>

<?php include('page-footer.php'); ?>