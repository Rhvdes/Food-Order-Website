<?php
    //Include constants.php because of the siteurl
    include('../config/constants.php');

    //1. destroy session
    session_destroy();//unset all session
    //2. redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>