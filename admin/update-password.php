<?php include('partials/menu.php'); ?>
<div class="main-content">
      <div class="wrapper">
   <h1>Change password</h1>
     <br /><br />
     <?php 
     if(isset($_GET['id']))
     {
        $id=$_GET['id'];
    }
     
     ?>
<form action="" method ="POST">
    <table class="tbl-30">
        <tr>
            <td>Old Password:</td>
            <td>
                <input type="password" name="current_password" placeholder="Current Password">
            </td>
        </tr>
        <tr>
            <td>New Password:</td>
            <td>
                <input type="password" name="new_password" placeholder="New Password">
            </td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td>
                <input type="password" name="confirm_password" placeholder="Confirm Password">
            </td>
        </tr>

        <tr>
        <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?> ">
            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
            </td>
        </tr>
            </table>
        </form>
    </div>
</div>
<?php 
//check the submit button is clilcked or not
if(isset($_POST['submit']))
{
   
    //1.Get the data from form
    $id=$_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password =md5($_POST['new_password']);
    $confirm_password =md5($_POST['confirm_password']);
    //2.Check the user with current ID and current password Exist or not
    $sql= "SELECT * FROM tbl_admin WHERE id =$id AND password ='$current_password'";
        //Execute the query
    $res= mysqli_query($conn,$sql);
    if ($res==true){
        //check the data is avaliable or not
        $count = mysqli_num_rows($res);
        if ($count ==1)
        {
            //User Exist and Password can be changed
           //Check the new password and confirm match or not
           if($new_password==$confirm_password)
           {
            //Update the password
         $sql2= "UPDATE tbl_admin SET
         password ='$new_password'
          WHERE id = $id";

         //Execute the Query
         $res2= mysqli_query($conn,$sql2);
            //checking
            if($res2==true){
                $_SESSION['change-pwd']= "<div class='success'>
                Password Changed. </div>";
                //Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
            }else{ 
                $_SESSION['change-pwd']= "<div class='error'>Failed to change
                Password . </div>";
                //Redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');

        }
         
           }
        else
        {
           //User Does not Exist, Set Message and redirect
           $_SESSION['pwd-not-match']= "<div class='error'>
           Password did not match. </div>";
           //Redirect the user
           header('location:'.SITEURL.'admin/manage-admin.php');

           }
        }
        else{
            //User does not exist and redirect the user
            $_SESSION['user-not-found'] ="<div class='error'>User Not found.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
    //3.Check the New passord and conffirm password Match or not
    //4.Change Password if all above is true
        }


?>


     <?php include('partials/footer.php'); ?>
