<?php include('../config/constants.php');
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order Website</title>
    <link rel="stylesheet" href="../css/admin.css"> 
</head>
<body>
    <div class="login">
        
        <h1 class="text-center">Login</h1>
        <br><br>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['not-login-message'])){
                echo $_SESSION['not-login-message'];
                unset($_SESSION['not-login-message']);
            }
        ?>
        <br><br>
        <!--Login Start-->
        <form action=""  method= "POST" class="text-center">
            Username:<br>
        <input type="text" name="username" placeholder = "Enter your name"><br><br>
            Password:<br>
        <input type="password" name="password" placeholder = "Enter your password"><br><br>
        <input type="submit" name="submit" value="Login" class="btn-primary">
</form>
        <!--Login end-->
    </div>
</body>
</html>
<?php 
//Check the submit button is clicked or not
if (isset($_POST['submit'])){
    //Process for login
    //1.Get the data from login form
    $username= mysqli_real_escape_string($conn,$_POST['username']);
    
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    //2.Sql to check if user with username and pw exists or not
    $sql= "SELECT * FROM tbl_admin WHERE username='$username'
     AND password ='$password'";
    
    //3.Execute the query
    $res= mysqli_query($conn,$sql);
   
    //4.Count row to check if user esists or not
    $count = mysqli_num_rows($res);
    if ($count==1){
        //user available and login suceess
        $_SESSION['login'] = "<div class='success'>
        Login Successful.</div>";
        $_SESSION['user'] =$username;//To check user is login or not
        //Redirect to Home page
        header('location:'.SITEURL.'admin/');
     }else{
        //user unavailable and login fail
        $_SESSION['login'] = "<div class='error text-center'>
        Login Failed.</div>";
        //Redirect to Home page
        header('location:'.SITEURL.'admin/login.php');
     }
}


?>