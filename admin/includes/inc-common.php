<?php 

/*
  File        : includes/inc-common.php
  Description : File containing common include files statement 
  Ver         : 1.0
  Created by  : RYC
*/

// set default timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// constant
include('inc-constant.php');

// session
include('inc-session.php');

// common functions
include('inc-formatting.php');
include('inc-functions.php');

// classes
include('class/class-admin-common.php');
include('class/class-admin-user.php');
include('class/class-admin-settings.php');
include('class/class-admin-image.php');

include('class/class-admin-member.php');
include('class/class-admin-agency.php');
include('class/class-admin-news.php');

?>