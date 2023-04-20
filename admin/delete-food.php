<?php 
 include('../config/constants.php');
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
       //1.Get the Id and image name
       $id = $_GET['id'];
       $image_name = $_GET['image_name'];

       //2.Remove the Image if available
       if($image_name != ""){

        //Image is avaliable so Remove it
        $path = "../images/food/".$image_name;
    
        $remove = unlink($path);

        //If Fail to remove,show error mes
         if($remove==false){
        $_SESSION['upload'] = "<div class='error'>Failed to remove Food</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
        die();
        }
   }
    
       //3.Delete form from database
       $sql = "DELETE FROM tbl_food WHERE id= $id";
        //Execute the query
        $res = mysqli_query($conn,$sql);

        if($res==true){

        $_SESSION['delete'] = "<div class='success'>
        Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
        }
        else{

            //Set failed message
            $_SESSION['delete'] = "<div class='error'>
            Fail to delete Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            }
         }
       //4.Redirect the page

    else{
        $_SESSION['delete'] = "<div class='error'>
        Fail to delete Food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    ?>