<?php
 include('../config/constants.php'); 
//Destroy the section
session_destroy();//Unset $_session['user']
//Redirect to Login Page
header('location:' . SITEURL.'admin/login.php');

?>