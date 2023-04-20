<?php 
//Authatization - Acess COntrol

//Check whether the user is login or not
if(!isset($_SESSION['user'])){
    //if user isn"t login
 $_SESSION['not-login-message']="<div class='error text-center'>Please Login to access Admin Panel.</div>";
 header('location:' . SITEURL.'admin/login.php');

}
?>