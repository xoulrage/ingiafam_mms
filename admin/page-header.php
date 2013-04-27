<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  <title><?php echo CLIENTNAME; ?> - Back Office</title>

  <meta name="title" content="">
  <meta name="description" content="">

  <meta name="author" content=""> 
  <meta name="copyright" content=""> 
  <meta http-equiv="pragma" content="no-cache"> 
  
  <!--
  <link rel="shortcut icon" href="<?php echo WEBSITEPATH; ?>wp-content/themes/INGiafam-Custom/images/favicon.ico">
  -->

  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/global.css" />  
  <link rel="stylesheet" type="text/css" href="css/text.css" />
  <link rel="stylesheet" type="text/css" href="css/layout.css" />
    
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.blockUI.js"></script>

  <script type="text/javascript" src="js/date.format.js"></script>
  <script type="text/javascript" src="js/validation.js"></script>

<?php if ($require_jquery_ui_custom == true) { ?>
  <link rel="stylesheet" type="text/css" href="jquery-ui/css/smoothness/jquery-ui-1.10.2.custom.css" />
  <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.2.custom.min.js"></script>
<?php } ?>  

<?php if ($require_image_lightbox == true) { ?>
  <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.4" />
  <script type="text/javascript" src="fancybox/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php } ?>  

<?php if ($require_image_upload == true) { ?>
  <link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />
  <script type="text/javascript" src="uploadify/jquery.uploadify.min.js"></script>
<?php } ?>

<?php if ($require_editor == true) { ?>
  <script type="text/javascript" src="ckeditor/ckeditor.js"></script>  
<?php } ?>
  
  <script type="text/javascript">
  $(document).ready(function () {

    // event - top navi
    $('.nav').hover(
  
      function () {
        //show submenu  
        menuId = $(this).attr("id").slice(4, $(this).attr("id").length);
      
        if (menuId.length > 0)
        {
          $("#subnav_" + menuId).show();
        }

      }, 
    
      function () {
        //hide submenu 
        menuId = $(this).attr("id").slice(4, $(this).attr("id").length);
        if (menuId.length > 0)
        {
          $("#subnav_" + menuId).hide();
        }      
            
      });
    
  });
  </script>
  
</head>
<body>
  
  <div id="header">
    <div id="title_header"><span class="text_title_header"><a href="main.php">BACK OFFICE ADMINISTRATION</a></span></div>
    <div id="top_nav">
      
      <?php if (($_SESSION['MODULE_1'] == 1) || ($_SESSION['MODULE_2'] == 1)) { ?>      
      <div id="nav_1" class="nav">
        Membership
        <div id="subnav_1" class="subnav">
          <?php if ($_SESSION['MODULE_1'] == 1) { ?>&middot; <a href="member.php" class="text_subnav">Members</a><br /> <?php } ?>
          <?php if ($_SESSION['MODULE_2'] == 1) { ?>&middot; <a href="agency.php" class="text_subnav">Agency</a><br /> <?php } ?>    
        </div>
      </div>
      <?php } ?>

      <?php if ($_SESSION['MODULE_3'] == 1) { ?>     
      <div id="nav_2" class="nav">
        News
        <div id="subnav_2" class="subnav">
          &middot; <a href="news.php" class="text_subnav">News List</a><br />      
        </div>
      </div>
      <?php } ?>

      <?php if ($_SESSION['MODULE_4'] == 1) { ?>     
      <div id="nav_3" class="nav">
        Reports
        <div id="subnav_3" class="subnav">
          &middot; <a href="#" class="text_subnav">Report 1</a><br />
          &middot; <a href="#" class="text_subnav">Report 2</a><br />
          &middot; <a href="#" class="text_subnav">Report 3</a><br />    
        </div>
      </div>
      <?php } ?>      
      
      <div id="nav_4" class="nav">
        Others
        <div id="subnav_4" class="subnav">
          <?php if ($_SESSION['MODULE_5'] == 1) { ?>&middot; <a href="settings.php" class="text_subnav">General Settings</a><br /><?php } ?>   
          
          <?php if (($_SESSION['USERTYPE'] == 1) || ($_SESSION['USERTYPE'] == 2)) { ?>
          &middot; <a href="user.php" class="text_subnav">User Manager</a><br />   
          <?php } ?>   
          
          &middot; <a href="media-library.php" class="text_subnav">Media Library</a><br />             
        </div>
      </div>
      <div id="nav_5" class="nav">
        Profile / Log Out
        <div id="subnav_5" class="subnav">
          &middot; <a href="profile.php" class="text_subnav">Edit Profile</a><br />
          &middot; <a href="logout.php" class="text_subnav">Log Out</a><br />              
        </div>
      </div>
    </div>
  </div>

  <div id="page_content">
