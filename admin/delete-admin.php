<?php 
include('../config/constants.php');
    //1.get the ID of Admin to be deleted
     $id = $_GET['id'];
    //2.Create SQL Query to delete Admin 
    $sql ="DELETE FROM tbl_admin WHERE id=$id";
    //Execute the query
    $res = mysqli_query($conn,$sql);
    //check whether thequery executed successfully
    if($res==true)
    {
            //Success and deleted admin(create SESSION veriable todisplay message)
        $_SESSION['delete'] = "<div class = 'success'>Admin Deleted successfully</div>";
            //.Redirect to Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    } 
    else{
    //Failed
    $_SESSION['delete'] = "<div class='error'>Failed to delete Admin,Try again later.</div>";
            //.Redirect to Admin page
    header('location:'.SITEURL.'admin/manage-admin.php');


}
    //3.Redirect to Manage Admin Admin page with message(successs)
     


?>