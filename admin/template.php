<?php 

// include files
include_once('includes/inc-common.php');
include_once('includes/inc-checklogin.php');


// settings


// instantiate


// fetch parameters


// set default


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  <title><?php echo CLIENTNAME; ?> - Back Office</title>

  <meta name="title" content="">
  <meta name="description" content="">
  
  <meta name="author" content="Author Name"> 
  <meta name="copyright" content="2012 by Company"> 
  <meta http-equiv="pragma" content="no-cache"> 
  
  <!--<link rel="shortcut icon" href="http://website.com/favicon.ico" />-->
  
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/global.css" />  
  <link rel="stylesheet" type="text/css" href="css/text.css" />
  <link rel="stylesheet" type="text/css" href="css/layout-temp.css" />
    
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  
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
      <div id="nav_1" class="nav">
        Products
        <div id="subnav_1" class="subnav">
          &middot; <a href="#" class="text_subnav">Brands</a><br />
          &middot; <a href="#" class="text_subnav">Categories</a><br />
          &middot; <a href="#" class="text_subnav">Products</a><br />
        </div>
      </div>
      <div id="nav_2" class="nav">
        Projects
        <div id="subnav_2" class="subnav">
          &middot; <a href="#" class="text_subnav">Manage Projects</a><br />    
        </div>
      </div>
      <div id="nav_3" class="nav">
        Settings
        <div id="subnav_3" class="subnav">
          &middot; <a href="profile-edit.php" class="text_subnav">Edit Profile</a><br />
          &middot; <a href="logout.php" class="text_subnav">Log Out</a><br />              
        </div>
      </div>
    </div>
  </div>

  <div id="page_content">
    
    <div id="content_full">
      <div id="content_title">
        <span class="text_title_content">DASHBOARD</span>
      </div>
      
      <div id="content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris laoreet vestibulum rutrum. Mauris fringilla pretium sollicitudin. Maecenas ac arcu sed leo laoreet imperdiet sed non magna. Phasellus eget odio sit amet justo lobortis adipiscing et eu metus. Ut id enim augue. Praesent non elit rhoncus felis feugiat pulvinar sit amet vitae quam. Donec condimentum ante id mauris tristique luctus. Integer id ipsum risus. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed eu interdum nisl. Suspendisse eleifend, ligula et accumsan sodales, leo tellus viverra leo, in semper urna tellus a arcu. Nulla erat nisi, elementum nec elementum sit amet, sagittis condimentum nibh. Vivamus sed odio sed velit ornare blandit ut non lorem.
      </div>  
        
    </div>
    <div class="reset" style="height:15px;"></div>
    
    <div id="content_left">
      <div id="content_title">
        <span class="text_title_content">EDIT YOUR PROFILE</span>
      </div>
      
      <div id="content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu adipiscing turpis. Aenean ut elit diam, ac semper arcu. Maecenas mattis elementum pharetra. Cras at justo sem, euismod elementum lacus. Suspendisse consequat, mauris sit amet eleifend ornare, ante nulla placerat dolor, ac placerat turpis risus sed ligula. Cras aliquam nulla et metus dignissim ultricies. Proin eu nunc sit amet lectus gravida suscipit a nec odio.
      </div>
      
    </div>
    <div id="content_right">
      <div id="content_title_small">
        <span class="text_title_content_small">INSTRUCTIONS</span>
      </div>
      
      <div id="content">
        In felis dolor, dictum eu feugiat id, rhoncus et magna. Nullam ornare laoreet lacus, quis ullamcorper libero vulputate hendrerit. Curabitur tristique pulvinar nunc, a venenatis lectus euismod nec. Suspendisse sit amet lorem nec est aliquam egestas. Sed malesuada tortor sit amet lectus ultricies tincidunt. Proin vitae tempor urna. Morbi mauris orci, adipiscing et aliquam quis, ultrices at elit. Maecenas pellentesque vulputate magna in accumsan. Praesent magna orci, molestie quis semper eget, facilisis non mi.
      </div>
      
    </div>
    
  </div>
  <div class="reset"></div>

  <div id="footer">
    <div id="copyright">
      <span class="text_footer">Copyright &copy; <?php echo date('Y'); ?> <?php echo VENDORNAME; ?>. All rights reserved.</span>
    </div>
  </div>

</body>
</html>