<?php

$firstLogin = isset($_SESSION['FIRSTLOGIN']) ? $_SESSION['FIRSTLOGIN'] : false;

if (!isset($_SESSION['MEMBERID']) || ($firstLogin)) {
    $url_redirect =  ABSPATH . 'login.php';
    header("Location: $url_redirect");
}