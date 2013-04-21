<?php 

/*
  File        : includes/inc-common.php
  Description : File containing common include files statement 
  Ver         : 1.0
  Created by  : RYC
*/

// set time zone
date_default_timezone_set('Asia/Kuala_Lumpur');

// constant
include('inc-constant.php');

// session
include('inc-session.php');

// common functions
include('inc-formatting.php');
include('inc-functions.php');

// classes
include('class/class-common.php');
include('class/class-member.php');
include('class/class-agency.php');

?>